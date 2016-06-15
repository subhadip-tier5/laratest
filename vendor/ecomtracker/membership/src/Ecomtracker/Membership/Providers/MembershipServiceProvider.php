<?php

namespace Ecomtracker\Membership\Providers;

use Illuminate\Support\ServiceProvider;

use Ecomtracker\User\Auth;

use Ecomtracker\Membership\Exceptions\Membershipexception;

class MembershipServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {


        /*
         * checking if running migrations
         */
        if (\App::runningInConsole())
        {

            $commands = \Request::server('argv', null);
            if ( isset($commands[1]) && ( $commands[1]=="migrate" or  $commands[1]=="migrate:reset" or $commands[1]=="migrate:refresh"   ) )
            {
                //echo "Migration runs";
                return false;  // brake the boot() running
            }
            //exit();
        }







        $packageDir = realpath(__DIR__.'/..');


        $this->publishes([
            __DIR__.'/../Migrations' => $this->app->databasePath().'/migrations'
        ], 'migrations');



        $this->publishes([
            __DIR__.'/../Seeds' => $this->app->databasePath().'/seeds'
        ], 'seeds');


        include $packageDir.'/Http/routes.php';



        // membership limits

        try {

            $logined_user=\Ecomtracker\User\Models\User::Logined()->first();


        }
        catch (\Exception $ex)
        {

        }


        if (isset($logined_user) && $logined_user->membershipplan  )
        {


            // check model limits upon creating
            // ====== $AmazonProduct ======
            \Ecomtracker\Amazon\Models\Product::creating(function ($AmazonProduct) use ($logined_user) {

                // checking how much amazon products we have
                //$count_current=\Ecomtracker\Amazon\Models\Product::LoginedUser($logined_user->id)->count();
                $count_current=\Ecomtracker\Membership\MembershipService::countProducts($logined_user);
                $limit=$logined_user->MembershipPlan->limit_products;
                //$flag_asin_api=$logined_user->MembershipPlan->flag_asin_api;
                $flag_asin_api=\Ecomtracker\Membership\MembershipService::AsinFlag($logined_user);

                //echo "count_current"; print_r($count_current);
                //echo "limit"; print_r($limit);

                if ( !$AmazonProduct->id and $AmazonProduct->is_asin &&  !$flag_asin_api) {
                    abort(402, 'Your membership plan is not allowing ASIN API');
                    throw new Membershipexception('Your membership plan is not allowing ASIN API');
                    return false;
                }

                if ( !$AmazonProduct->id and $count_current>=$limit and $limit!='unlimited') {
                    abort(402, 'You\'ve Reached Max Allowed Products of '.$limit.'. Upgrade Your Membership Plan.');
                    throw new Membershipexception('You\'ve Reached Max Allowed Products of '.$limit.'. Upgrade Your Membership Plan.');
                    return false;
                }

                $limit_active_tracking_products=$logined_user->MembershipPlan->limit_active_tracking_products;
                //$count_active=\Ecomtracker\Amazon\Models\Product::LoginedUser($logined_user->id)->where('is_tracking_enabled','=','1')->count();
                $count_active=\Ecomtracker\Membership\MembershipService::countTrackingProducts($logined_user);

                if ($AmazonProduct->is_tracking_enabled and  $count_active>=$limit_active_tracking_products and $limit_active_tracking_products!='unlimited') {
                    abort(402, 'You\'ve Reached Max Allowed Active Products of '.$limit.'. Upgrade Your Membership Plan.');
                    throw new Membershipexception('You\'ve Reached Max Allowed Active Products of '.$limit.'. Upgrade Your Membership Plan.');
                    return false;
                }


            });


            // ====== AmazonKeyword ======
            \Ecomtracker\Amazon\Models\Keyword::creating(function ($AmazonKeyword) use ($logined_user) {

                // checking how much amazon keywords we have
                //$count_current=\Ecomtracker\Amazon\Models\Keyword::LoginedUser($logined_user->id)->count();
                $count_current=\Ecomtracker\Membership\MembershipService::countKeywords($logined_user);
                $limit=$logined_user->MembershipPlan->limit_keywords;

                if ( $count_current>=$limit and $limit!='unlimited') {
                    abort(402, 'You\'ve Reached Max Allowed Keywords ('.$count_current.'/'.$limit.'). Upgrade Your Membership Plan .');
                    throw new Membershipexception('You\'ve Reached Max Allowed Keywords ('.$count_current.'/'.$limit.'). Upgrade Your Membership Plan .');
                    return false;
                }

            });



            // ====== NegativeReviews ======
            \Ecomtracker\Amazon\Models\Product\Review::creating(function ($Review) use ($logined_user) {

                // checking how much amazon keywords we have
                //$count_current=\Ecomtracker\Amazon\Models\Product\Review::LoginedUser($logined_user->id)->count();
                $count_current=\Ecomtracker\Membership\MembershipService::countNegativeReviews($logined_user);
                $limit=$logined_user->MembershipPlan->limit_negative_reviews;


                if ( $count_current>=$limit and $limit!='unlimited') {
                    abort(402, 'You\'ve Reached Max Allowed Amazon Reviews ('.$count_current.'/'.$limit.'). Upgrade Your Membership Plan .');
                    throw new Membershipexception('You\'ve Reached Max Allowed Amazon Reviews ('.$count_current.'/'.$limit.'). Upgrade Your Membership Plan .');
                    return false;
                }



            });


            // ====== EmailReports ======

            \Ecomtracker\Tracking\Models\EmailReport::creating(function ($EmailReport) use ($logined_user) {

                // checking how much EmailReports we have

                $count_current=\Ecomtracker\Membership\MembershipService::countEmailReports($logined_user);
                $limit=$logined_user->MembershipPlan->limit_email_reports;


                if ( $count_current>=$limit and $limit!='unlimited') {
                    abort(402, 'You\'ve Reached Max Allowed Email Reports ('.$count_current.'/'.$limit.'). Upgrade Your Membership Plan .');

                    //throw new Membershipexception('You\'ve Reached Allowed Email Reports ('.$count_current.'/'.$limit.'). Upgrade Your Membership Plan .');
                    return false;
                }



            });




        }
        else
        {
            // no membership plan assigned, work as unlimited
        }






            // ====== User Registration - assign default membership plan ======
            \Ecomtracker\User\Models\User::creating(function ($User) {








                //checking if email is already in use
                $count_check_existing_email=\Ecomtracker\User\Models\User::where('email','=',$User->email)->count();
                if($count_check_existing_email>=1)
                {
                    abort(500, 'email_already_used');
                    return false;
                }

                // skip if iser is admin

                if ($User->isAdmin())
                {
                    return true;
                }


                // checking licence code

                //checking if this licence is not used already
                $count_check_existing=\Ecomtracker\User\Models\User::where('asi_licence_code','=',$User->asi_licence_code)->count();
                if($User->asi_licence_code!='TEST_licence_code' and ( $count_check_existing>=1 or $User->asi_licence_code=='TEST_licence_code_already_used' ) )
                {
                    abort(500, 'licence_code_already_used');
                    return false;
                }




                $url = 'http://licence.asinspector.com/ecomtracker/check_licence.php?asi_licence='.$User->asi_licence_code;

                $client = new \GuzzleHttp\Client();
                $res = $client->request('GET', $url);
                $licence_check = json_decode($res->getBody());

                if ($User->asi_licence_code=='TEST_licence_code' or ($licence_check->error=="" && $licence_check->licence ))
                {

                    /* getting default membership plan
                     *  TODO: need to change this on production
                     */
                    $DefaultPlan=\Ecomtracker\Membership\Models\MembershipPlan::orderBy('id','asc')->first();
                    $User->membership_plan_id=$DefaultPlan->id;
                    return true;


                }
                else
                {
                    abort(500, 'incorrect_licence_code');
                    return false;
                }



            });





    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            \Ecomtracker\Membership\Console\Commands\NMISync::class
        ]);
        $this->commands([
            \Ecomtracker\Membership\Console\Commands\ProcessMembershipChanges::class
        ]);
    }
}
