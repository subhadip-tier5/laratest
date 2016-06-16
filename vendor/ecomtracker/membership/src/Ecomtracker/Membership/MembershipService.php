<?php namespace Ecomtracker\Membership;

use Ecomtracker\Membership\Models\MembershipPlan;
use Ecomtracker\User\Models\User;
use Ecomtracker\Membership\NMI\Api as NMIApi;
use Ecomtracker\Membership\Exceptions\Membershipexception ;
class MembershipService
{


    public static function countProducts(User $User)
    {
        $count=\Ecomtracker\Amazon\Models\Product::LoginedUser($User->id)->count();
        return ($count);
    }

    public static function countTrackingProducts(User $User)
    {
        $count=\Ecomtracker\Amazon\Models\Product::LoginedUser($User->id)->where('is_tracking_enabled','=','1')->count();
        return ($count);
    }

    public static function AsinFlag(User $User)
    {
        return ($User->MembershipPlan->flag_asin_api);
    }



    public static function countKeywords(User $User)
    {
        $count=\Ecomtracker\Amazon\Models\Keyword::LoginedUser($User->id)->count();
        return ($count);
    }


    public static function countNegativeReviews(User $User)
    {
        $count=\Ecomtracker\Amazon\Models\Product\Review::LoginedUser($User->id)->count();
        return ($count);
    }


    public static function countEmailReports(User $User)
    {
        $count=\Ecomtracker\Tracking\Models\EmailReport::LoginedUser($User->id)->count();
        return ($count);
    }
}