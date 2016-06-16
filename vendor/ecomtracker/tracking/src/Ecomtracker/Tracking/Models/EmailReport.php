<?php namespace Ecomtracker\Tracking\Models;


use Illuminate\Database\Eloquent\Model;
use Ecomtracker\Tracking\TUtil;

class EmailReport extends Model
{
    protected $table = 'email_reports';
    protected $entity;

    protected $fillable = [
        'title',
        'to_email',
        'from_name',
        'frequency',
        'next_send_date',
        'data',  // json
    ];



    public function user()
    {

        return $this->belongsTo('Ecomtracker\User\Models\User','user_id','id');
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


    public function scopeLoginedUser($query,$user_id=false)
    {

        if (!$user_id)
        {
            $logined_user=\Ecomtracker\User\Models\User::Logined()->first();
            $user_id=$logined_user->id;
        }
        /*
         * TODO use relation to parent product here
         */

        return $query->where('user_id', '=', $user_id);

    }


    public function getFrequencyOptions( $keyValue = null)
    {
        $arr=[''=>'Never',
            'daily'=>'Daily',
            'weekly'=>'Weekly',
            'monthly'=>'Monthly',];
        return $arr;
    }

    public static function getPrevDateByFreq($next_send_date,$frequency)
    {
        return self::getOffsetDate($next_send_date,$frequency,"-");
    }

    public static function getNextDateByFreq($next_send_date,$frequency)
    {

        return self::getOffsetDate($next_send_date,$frequency,"+");
    }

    public static function getOffsetDate($next_send_date,$frequency,$offset_sign)
    {
        switch ($frequency)
        {
            case "weekly":
                $prev_date=date("Y-m-d H:i:s",strtotime( $next_send_date .$offset_sign."7 days"));
                break;
            case "monthly":
                $prev_date=date("Y-m-d H:i:s",strtotime( $next_send_date .$offset_sign."1 month"));
                break;
            default:
                $prev_date=date("Y-m-d H:i:s",strtotime( $next_send_date .$offset_sign."1 day"));
        }

        return $prev_date;
    }



    
}