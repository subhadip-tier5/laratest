<?php namespace Ecomtracker\Tracking;

use Ecomtracker\Product\Models\Product as ParentProduct;
use Ecomtracker\Amazon\Models\Product as AmazonProduct;
//use Ecomtracker\Tracker\Models\EmailReport;
use Ecomtracker\User\Models\User;
use Ecomtracker\Tracking\AmazonService;
//use Psy\Exception\ErrorException;
use Mail;
use Ecomtracker\Tracking\Console\Commands\Tracker as Tracker;

use \Ecomtracker\Tracking\Models\EmailReport;

class TrackingService
    {


    public static function TrackOne($asin,$marketplace){

        echo "\nTracking Product ASIN ".($asin);

        try {

            $products_parsed=array();
            // find all other products with the same ASIN and Marketplace and track them
            $products=AmazonProduct::where('asin',$asin )
                        ->where('marketplace',$marketplace )
                        ->where('is_tracking_enabled','1' );

            // update status of all grouped products
            $products->update(['status'=>AmazonProduct::STATUS_PENDING]);
            $products_col=$products->get();

            try{
                $info=AmazonService::getProductData($asin,$marketplace);
                $products_col->each(function($product) use (&$products_parsed, $info)
                {
                    echo "\nupdating product ".$product->id;
                    $product->trackAmazonInfo($info);
                    $products_parsed[]=$product->toArray();


                    // tracking reviews

                        AmazonService::trackProductReviews($product);



                    // tracking amazon keywords
                    $product_keywords=$product->AmazonKeywords;
                    $product_keywords->each(function($AmazonKeyword)
                    {
                        echo "\n  Trackign keyword ID ".$AmazonKeyword->id;
                        $AmazonKeyword->GetAndTrackAmazonInfo();
                    });



                });
            }
            catch (\Exception $er)
            {
                $products->update(['status'=>AmazonProduct::STATUS_ERROR]);
            }






            return $products_parsed;
        }
        catch (\Exception $er)
        {
            echo $er->getMessage();
        }



    }

    public static function TrackAll($options=[]){


        $products_parsed=array();

        $today_date=date("Y-m-d 00:00:01");

        $products=AmazonProduct::where('status','!=',AmazonProduct::STATUS_PENDING )
            ->where('last_processed_at','<',$today_date)  // getting only products, which weren't tracked today
            ->groupBy(['asin','marketplace']);

        $products=$products->get();
        $products->each(function($product) use (&$products_parsed,$today_date ) {


            // checking if the product is not tracking by another process
            if ($product->status!=AmazonProduct::STATUS_PENDING &&  $product->last_processed_at<$today_date)
            {
                $parsed_products = self::TrackOne($product->asin, $product->marketplace);
            }

            $products_parsed=array_merge($products_parsed,$products_parsed);

        });


        // processing reports
        self::ProcessEmailReports();

        return $products_parsed;


    }


    /*
     *      Email Reports functions
     *
     */


    public static function ProcessEmailReports()
    {

        $cur_date=date("Y-m-d");
        // getting all users with products
        $EmailReports=EmailReport::whereHas('user',function($query)
        {
            /*
             *  enable this if need to have some global option in user profile
             */
            //$query->where("email_notification", "=", '1');
        }

        )->where('frequency','!=','')
            ->where('next_send_date','<=',$cur_date )->get();
        foreach ($EmailReports as $EmailReport) {

            $res_ereport=self::ProcessEmailReport($EmailReport);


        }

    }


    public static function ProcessEmailReport(\Ecomtracker\Tracking\Models\EmailReport $EmailReport, $preview_mode=false)
    {

        $User=User::find($EmailReport->user_id);

        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln("User: " . $User->id);
        $output->writeln("Email Report: " . $EmailReport->id);

        $user_email_data = [];
        $user_email_data['User'] = $User->toArray();

        // getting user's

        //print_r($EmailReport->data);


        $selected_products_arr=json_decode(json_encode($EmailReport->data->selected_products), true);
        $selected_product_ids=array_keys($selected_products_arr);

        $user_products = $User->AmazonProducts()
            ->whereIn('id',  isset($selected_product_ids)?$selected_product_ids:[] )
            ->where('status', '=', AmazonProduct::STATUS_TRACKED)
            ->where('is_tracking_enabled', '=', 1 )->get();
        $user_email_data['Products'] = $user_products;

        $user_email_data['PreviousTrackedDate']=EmailReport::getPrevDateByFreq($EmailReport->next_send_date,$EmailReport->frequency);

        foreach (  $user_email_data['Products']  as &$Product )
        {

            $last_td=$Product->getLastTrackedProductInfo();
            $Product->TrackedData=$last_td->toArray();
            $prev_td=$Product->getPrevTrackedProductInfo($user_email_data['PreviousTrackedDate']);
            if (!$prev_td)
            {
                $prev_td=$last_td;
            }
            $Product->PreviousTrackedData=$prev_td->toArray();

            /*
             *  Getting selected keywords
             */
            $selected_keyword_ids=$selected_products_arr[$Product->id];

            $selected_keywords = $Product->AmazonKeywords()
                ->whereIn('id',  isset($selected_keyword_ids)?$selected_keyword_ids:[] )
                ->get();

            $Product->selected_keywords=$selected_keywords;
            foreach (   $Product->selected_keywords  as &$selected_keyword )
            {
                $k_last_td=$selected_keyword->getLastTrackedKeywordInfo();
                if ($k_last_td)
                {
                    $selected_keyword->TrackedData=$k_last_td->toArray();
                    $k_prev_td=$selected_keyword->getPrevTrackedKeywordInfo($user_email_data['PreviousTrackedDate']);
                    if (!$k_prev_td)
                    {
                        $k_prev_td=$k_last_td;
                    }
                    $selected_keyword->PreviousTrackedData=$k_prev_td->toArray();
                }

            }



            // attaching product reviews
            $Product->NegativeReviews=$Product->reviews()->where('created_at','>',$user_email_data['PreviousTrackedDate'])->get()->toArray();


        }





        if ($preview_mode===false && count($user_products) > 0)
        {
            self::SendEmail($user_email_data,$EmailReport);
            // updating next_send_date
            $EmailReport->next_send_date=EmailReport::getNextDateByFreq($EmailReport->next_send_date,$EmailReport->frequency);
            $EmailReport->save();

            return ($EmailReport);

        }

        if ($preview_mode=="HTML")
        {
            $email_preview= view('tracking::EmailReportRemplate2',$user_email_data) ;
            return $email_preview;
            //return ['html_preview'=>(string)$email_preview];
        }
        elseif ($preview_mode=="JSON")
        {
            return $user_email_data;

        }



    }




    public static function SendEmail($user_email_data,$EmailReport){


        $vars=$user_email_data;

        $res_send=Mail::send('tracking::EmailReportRemplate', $vars, function($message) use ($user_email_data,$EmailReport) {

            //$message->from('no-reply@example.com', 'October');
            $message->from($user_email_data['User']['email'], $user_email_data['User']['firstname']." ".$user_email_data['User']['lastname']);
            $message->to($EmailReport->to_email,$EmailReport->to_email);
            $message->subject($EmailReport->title.' - EcomTracker Email Report!');
        });






        return $res_send;

    }



    public static function getSuperuser(){
        $SuperUser=\Ecomtracker\User\Models\User::where('is_superuser','=','1')->first();


        if (!$SuperUser)
        {
            Artisan::call( 'db:seed', [
                    '--class' => 'TrackingSuperuserSeeder',
                    '--force' => true ]
            );

        }



        return $SuperUser;
    }



    public static function CopyProductToSuperuser(AmazonProduct $Product)
    {
        $SuperUser=self::getSuperuser();

        $AmazonProduct=$SuperUser->AmazonProducts()->firstOrNew(['asin' => $Product->asin,
                                                            'marketplace' => $Product->marketplace
                                                            ]);
        $AmazonProduct->title=$Product->title;
        $AmazonProduct->is_tracking_enabled=1;
        $AmazonProduct->user_id=$SuperUser->id;
        $AmazonProduct->title="SuperUser COPY";
        $AmazonProduct->save();

        return ($AmazonProduct);
    }


    public static function CopyProductHistoryFromSuperuser(AmazonProduct $Product)
    {
        $date_from=\Carbon\Carbon::now()->subDay(7);
        $SuperUser=self::getSuperuser();
        $ProductHistory=$SuperUser->AmazonProducts()
                        ->where('asin','=',$Product->asin)
                        ->where('marketplace','=',$Product->marketplace)
                        ->first()
                        ->history()->where('created_at','>=',$date_from)->get();
        foreach ($ProductHistory as $ProductHistory_item)
        {
            //echo "duplicating history ID: ".$ProductHistory_item->id;
            $History=$ProductHistory_item->replicate();
            $History->product_id=$Product->id;
            $History->save();
        }

    }


    public static function AmazonProductFirstTrack(AmazonProduct $Product)
    {
        $date_from=\Carbon\Carbon::now()->subDay(1);
        $date_now=\Carbon\Carbon::now();
        $SuperUser=self::getSuperuser();
        $lastProductHistory=$SuperUser->AmazonProducts()
            ->where('asin','=',$Product->asin)
            ->where('marketplace','=',$Product->marketplace)
            ->first()
            ->history()->where('created_at','>=',$date_from)->get()->last();

        if ($lastProductHistory)
        {
            // fill product from history
            $History=$lastProductHistory->replicate();
            $History->product_id=$Product->id;
            $History->created_at=$date_now;
            $History->save();
            $Product->status=$Product::STATUS_TRACKED;
            $Product->last_processed_at=$date_now;
            $Product->save();
        }
        else
        {
            $Product->GetAndTrackAmazonInfo();
        }



    }


    }