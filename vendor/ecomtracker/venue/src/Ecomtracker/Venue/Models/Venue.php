<?php namespace Ecomtracker\Venue\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $table = 'venues';

    protected $fillable = [
        'value',
        'user_id',
        'source_id',
        'source_model_id'
    ];


    public function user()
    {
        return $this->hasOne('Ecomtracker\User\Models\User','id','user_id');
    }

    public function configuration()
    {
        return $this->hasOne('Ecomtracker\Venue\Models\Config','venue_id','id');
    }
    

    


    
}