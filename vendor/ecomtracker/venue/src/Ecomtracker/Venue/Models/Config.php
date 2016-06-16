<?php namespace Ecomtracker\Venue\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'venue_configurations';

    protected $fillable = [
        'venue_id',
        'data'
    ];


    public function venue()
    {
        return $this->hasOne('Ecomtracker\Venue\Models\Config','id','venue_id');
    }

}