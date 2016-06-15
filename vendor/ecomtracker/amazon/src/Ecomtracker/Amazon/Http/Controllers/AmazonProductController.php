<?php namespace Ecomtracker\Amazon\Http\Controllers;


use Ecomtracker\Amazon\Http\Requests\ShowRequest;
use Ecomtracker\Amazon\Http\Requests\DestroyRequest;
use Ecomtracker\Amazon\Http\Requests\StoreRequest;
use Ecomtracker\Amazon\Http\Requests\UpdateRequest;

use Ecomtracker\Source\Models\Source;
use Ecomtracker\Keyword\Models\Keyword as ParentKeyword;
use Ecomtracker\Product\Models\Product as ParentProduct;

use Ecomtracker\Amazon\Models\Keyword as AmazonKeyword;
use Ecomtracker\Amazon\Models\Product as AmazonProduct;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Ecomtracker\Tracking\AmazonService;
use Ecomtracker\Tracking\Exceptions\TrackingException as TrackingException;
class AmazonProductController extends Controller
{

    public function show(ShowRequest $request, $id = null)
    {
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();
        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $model = $logined_user->AmazonProducts()->where('id','=',$id)->firstOrFail();
        return $model;

    }

    public function store(StoreRequest $request)
    {

        // for async front-end

        ignore_user_abort(true);
        set_time_limit(3600);


        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $logined_user = \Ecomtracker\User\Models\User::Logined()->first();

        $product = AmazonProduct::getModel()->fill($request->all());
        $product->user_id = $logined_user->id;



        // checking if URL is posted instead of ASIN
        $asin=$request->input('asin');

        if (filter_var($asin, FILTER_VALIDATE_URL)) {
            $regexp=preg_match('/(?:dp|o|gp|-)(\/product)?\/(B[0-9]{2}[0-9A-Z]{7}|[0-9]{9}(?:X|[0-9]))/',$asin,$matches);

            $product->asin=$matches[2];
        }



        /*

        $product = ParentProduct::getModel()->fill($request->all());

        $Source=Source::where('source',AmazonProduct::class)->get()->first();
        $product->source_id=$Source->id;
        */
        $product->save();


        $Source = Source::where('source', AmazonProduct::class)->get()->first();
        $data = array(
            'source_model_id' => $product->id,
            'source_id' => $Source->id,
            'user_id' => $logined_user->id,
        );
        $ParentProduct = ParentProduct::create($data);
        $ParentProduct->user_id=$logined_user->id;
        $ParentProduct->save();

        $product->entity_id = $ParentProduct->id;
        $product->source_id = $Source->id;
        $product->is_tracking_enabled = ($request->input('is_tracking_enabled')!="")?$request->input('is_tracking_enabled'):"1";


        // check count of product and add to dashboard for first 4

        $count_dashboard=$logined_user->AmazonProducts()->count();
        if ($count_dashboard<=4)
        {
            $product->show_on_dashboard_flag='1';
        }



        $product->save();






        // add product copy to superuser
        $res_copy_product=\Ecomtracker\Tracking\TrackingService::CopyProductToSuperuser($product);


        // copy previous product history from superuser
        $res_copy_history=\Ecomtracker\Tracking\TrackingService::CopyProductHistoryFromSuperuser($product);


        // tracking amazon product immediatelly

        //$product->GetAndTrackAmazonInfo();


        // copy previous product history from superuser
        $res_first_track=\Ecomtracker\Tracking\TrackingService::AmazonProductFirstTrack($product);


        return $product;



    }

    public function update(UpdateRequest $request, $id = null)
    {
        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();

        $product = $logined_user->AmazonProducts()->where('id', '=', $id)->firstOrFail();

        
        $result = ['status' => 'success', 'code' => '200'];
        $product->title=$request->input('title');

        if($product->show_on_dashboard_flag == 1)
            $product->show_on_dashboard_flag=0;
        else
            $product->show_on_dashboard_flag=1;
        
        //$product->fill($request->all());





        $product->save();
        return response()->json(compact('result'));

    }

    public function destroy(DestroyRequest $request, $id = null)
    {
        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();

        $product = $logined_user->AmazonProducts()->where('id', '=', $id)->firstOrFail();

        if ($product )
        {
            $product->delete();

            $result = ['status' => 'success', 'code' => '200','action' => 'destroy', 'id' => $id];
        }



        //return response()->json(compact('result'));
        return $result ;
    }



    public function AmazonKeywords(ShowRequest $request,$id = null)
    {
        try
        {
            //$logined_user=\JWTAuth::parseToken()->authenticate();
            $logined_user=\Ecomtracker\User\Models\User::Logined()->first();
            $product=$logined_user->AmazonProducts()->where('id', '=', $id)->first();
            $keywords=$product->AmazonKeywords;
        }
        catch (\Exception $ex)
        {
            $keywords= [];
        }

        return $keywords;

    }

    public function history(ShowRequest $request,$id = null)
    {
        $date_from=$request->input('date_from');
        $date_to=$request->input('date_to');
        $limit=$request->input('limit');


        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();

        $ProductHistory = $logined_user->AmazonProducts()->where('id', '=', $id)->first()->history();
        if ( $date_from)
        {
            $ProductHistory->where('created_at','>=',$date_from);
        }
        if ( $date_to)
        {
            $ProductHistory->where('created_at','<=',$date_to);
        }
        if ( $limit)
        {
            $ProductHistory->take($limit);
        }
        $ProductHistory->orderBy('id', 'desc');

        $ProductHistory_col=$ProductHistory->get();

        return response()->json($ProductHistory_col);

    }


    public function reviews(ShowRequest $request,$id = null)
    {
        $date_from=$request->input('date_from');
        $date_to=$request->input('date_to');
        $limit=$request->input('limit');

        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();
        $ProductReviews = $logined_user->AmazonProducts()->where('id','=',$id)->first()->reviews();
        if ( $date_from)
        {
            $ProductReviews->where('created_at','>=',$date_from);
        }
        if ( $date_to)
        {
            $ProductReviews->where('created_at','<=',$date_to);
        }
        if ( $limit)
        {
            $ProductReviews->take($limit);
        }
        $ProductReviews->orderBy('id', 'desc');

        $ProductReviews_col=$ProductReviews->get();

        return response()->json($ProductReviews_col);

    }




    public function OnPageInfo(ShowRequest $request,$id = null)
    {
        try
        {
        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();


            /*
             * check membership permissions
             */

            if (isset($logined_user) && $logined_user->membershipplan && $logined_user->membershipplan->flag_onpage_analyzer=='0' )
            {
                throw new \Ecomtracker\Membership\Exceptions\Membershipexception("Your membership plan is not allowing this");
            }


        $keywords=$request->input('keywords');

        $Product = $logined_user->AmazonProducts()->where('id','=',$id)->first();

        $info=AmazonService::OnPageInfo($Product,$keywords);
        }

        catch (\Ecomtracker\Membership\Exceptions\Membershipexception $ex)
        {
            abort(402, 'Your membership plan is not allowing this');

        }
        catch (\Exception $ex)
        {
            throw new TrackingException("Error getting amazon productstats");

        }

        return response()->json($info);

    }

    public function AmazonProducts(ShowRequest $request)
    {

        $filter_marketplace=$request->input('filter_marketplace');

        $include_stats=$request->input('include_stats');

        $filter_show_on_dashboard_flag=$request->input('filter_show_on_dashboard_flag');

        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();




        $AmazonProducts = $logined_user->AmazonProducts();
        if ( $filter_marketplace)
        {
            $AmazonProducts->where('marketplace','=',$filter_marketplace);
        }
        if ( $filter_show_on_dashboard_flag)
        {
            $AmazonProducts->where('show_on_dashboard_flag','=',$filter_show_on_dashboard_flag);
        }
        $AmazonProducts=$AmazonProducts->get();


        if ( $include_stats)
        {
            $AmazonProducts->each(function ($item, $key) {
                $LastTrackedStats=\Ecomtracker\Tracking\AmazonService::LastTrackedStats($item);
                $item['LastTrackedStats']=$LastTrackedStats;
            });
        }

        return response()->json($AmazonProducts);

    }


    public function LastTrackedStats(ShowRequest $request,$id = null)
    {
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();
        $Product = $logined_user->AmazonProducts()->where('id','=',$id)->firstOrFail();
        $response=\Ecomtracker\Tracking\AmazonService::LastTrackedStats($Product);

        return response()->json($response);
    }


    public function TopKeyword(ShowRequest $request,$id = null)
    {
        $include_stats=$request->input('include_7_days_history');

        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();
        $Product = $logined_user->AmazonProducts()->where('id','=',$id)->firstOrFail();


        $top_keyword=$Product->AmazonKeywords()->get()->first();
        foreach ($Product->AmazonKeywords as $AmazonKeyword) {
            $last_td = $AmazonKeyword->history()->get()->first();
            $last_td_current = $top_keyword->history()->get()->first();
            if ($top_keyword && $last_td && $last_td_current && $last_td->parsed_data->product_position < $last_td_current->parsed_data->product_position)
            {
                $top_keyword=$AmazonKeyword;
            }

           // print_r($last_td->parsed_data);

        }

        $response=['top_amazon_keyword'=>$top_keyword?$top_keyword:""];
        if ($include_stats && $top_keyword)
        {

            $date = \Carbon\Carbon::now('PST');
            $date->subDays(7);


            $response['last_7_days_history']=$top_keyword->history()->where('created_at','>=',$date )->get();


        }


        return response()->json($response);
    }


}