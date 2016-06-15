<?php

namespace Ecomtracker\Membership\Models;

use Illuminate\Database\Eloquent\Model;
use Ecomtracker\User\Models\User as User;

/**
 * MemebrshipPlan Model
 */
class MembershipPlan extends Model
{
    protected $table = 'membership_plans';


    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'nmi_plan_id',
        'title',
        'limit_products',
        'limit_keywords',
        'limit_super_urls',
        'limit_email_reports',
        'limit_negative_reviews',
        'limit_active_tracking_products',
        'flag_onpage_analyzer',
        'flag_asin_api',
        'description',
        'additional_data',
        'is_selectable',
        'is_locked',
        'recurring_price',
        'recurring_period_days',
        'trial_days',

    ];




    /**
     *  Relations
     */




    public function users()
    {

        return $this->hasMany('User','membership_plan_id','id');

    }





    /*
     * TODO: refactor for new models & relations
     */
    /**
     * Check if specified Membership Plan is available for the user.
     *
     * @param  User $User
     * @return bool
     */
    public static function isAllowedForMember(User $User)
    {
        // getting user counts
        /*
        $total_products=$User->Products->count();
        $total_active_products=$User->Products()->where('is_tracking_enabled','=','1')->count();
        $total_keywords=Keyword::whereHas(
            'product',  function ($query) use ($User) {
            $query->applyLogined($User->id);
        })->count();


        $total_super_urls=SuperURL::whereHas(
            'product',  function ($query) use ($User) {
            $query->applyLogined($User->id);
        })->count();
        $total_email_reports=$User->EmailReports->count();
        $total_reviews=ProductReview::whereHas(
            'product',  function ($query) use ($User) {
            $query->applyLogined($User->id);
        })->count();

        if ($total_products<=$this->limit_products &&
            $total_active_products<=$this->limit_active_tracking_products &&
            $total_keywords<=$this->limit_keywords &&
            $total_super_urls<=$this->limit_super_urls &&
            $total_email_reports<=$this->limit_email_reports &&
            $total_reviews<=$this->limit_negative_reviews
        )
        {
            return true;

        }
        else
        {
            return false;
        }
        */

        return true;

    }





}
