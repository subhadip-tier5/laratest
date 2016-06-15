<?php namespace Ecomtracker\User\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Ecomtracker\Membership\Models\MemebrshipPlan as MemebrshipPlan;


class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'confirmed',
        'email',
        'password',
        'street1',
        'street2',
        'firstname',
        'lastname',
        'city',
        'state',
        'postal',
        'country',
        'phone',
        'profession',
        'company',
        'asi_licence_code'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function setFullNameAttribute($value = null)
    {
        $arr = explode(' ',trim($value));
        $this->firstname = $arr[0];
        unset($arr[0]);
        $this->lastname = implode(' ',$arr);
        return $this;
    }


    public function getStatusAttribute()
    {
        //@todo AJW! this needs to do more
        return 'active';
    }
    
    public function getSubscriptionLevelAttribute()
    {
        //@todo AJW! this needs to do more
        return '1';
    }
    

    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
    
    
    
    public function getProfileAttribute()
    {
        //@todo ajw! this should return an object representing the profile only functionality related to user
        return $this;
    }


    public function roles()
    {
        return $this->belongsToMany('Ecomtracker\User\Models\Role','role_users');
    }
    

    public function isAdmin()
    {
        if($roles = $this->roles->keyby('key'))
        {
            return $roles->has('admin');
        }

        return false;
    }

    public function isGuest()
    {
        return false; //@todo ajw! this needs refinement
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }



    /**
     * Scope a query to only include logined user.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLogined($query)
    {
        $logined_user = \JWTAuth::parseToken()->authenticate();
        return $query->where('id', $logined_user->id);
    }


    /**
     * Relation To User's Membership Plan
     *
     * @return MembershipPlan
     */
    public function membershipplan()
    {
        return $this->belongsTo('Ecomtracker\Membership\Models\MembershipPlan','membership_plan_id','id');

    }

    /**
     * Relation To parent products
     *
     * @return MembershipPlan
     */
    public function products()
    {
        return $this->hasMany('Ecomtracker\Product\Models\Product','user_id','id');

    }
    
    public function venues()
    {
        return $this->hasMany('Ecomtracker\Venue\Models\Venue','user_id','id');
    }



    /**
     * Direct Relation To AmazonProduct
     *
     * @return MembershipPlan
     */
    public function AmazonProducts()
    {
        return $this->hasMany('Ecomtracker\Amazon\Models\Product','user_id','id');

    }



    /**
     * Direct Relation To EmailReports
     *
     * @return EmailReports
     */
    public function EmailReports()
    {

        return $this->hasMany('Ecomtracker\Tracking\Models\EmailReport','user_id','id');

    }


    /**
     * Direct Relation To RepricerAmazonProduct
     *
     * @return MembershipPlan
     */
    public function RepricerAmazonProducts()
    {
        return $this->hasMany('Ecomtracker\RepricerProducts\Models\RepricerAmazonProduct','user_id','id');

    }

    public function setNmiActionsAttribute($value)
    {
        $this->attributes['nmi_actions'] = json_encode($value);
    }

    public function getNmiActionsAttribute($value)
    {
        //return @unserialize($value);
        return json_decode($value);
    }


    /**
     * Direct Relation To NMITransactions
     *
     * @return MembershipPlan
     */
    public function NMITransactions()
    {
        return $this->hasMany('Ecomtracker\Membership\Models\NMITransaction','user_id','id');

    }
}
