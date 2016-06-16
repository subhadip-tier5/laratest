<?php

namespace Ecomtracker\Membership\Models;

use Illuminate\Database\Eloquent\Model;
use Ecomtracker\User\Models\User as User;

/**
 * MemebrshipPlan Model
 */
class NMITransaction extends Model
{
    protected $table = 'nmi_transactions';


    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'nmi_transaction_id',
        'amount',
        'success',
        'user_id',
        'data',
        'action_type',
        'transaction_date',

    ];




    /**
     *  Relations
     */




    public function user()
    {

        return $this->belongsTo('User','user_id','id');

    }



    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }

    public function getDataAttribute($value)
    {
        //return @unserialize($value);
        return json_decode($value);
    }







}
