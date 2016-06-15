<?php namespace Ecomtracker\Keyword\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'keyword_history';

    protected $fillable = [
        'keyword'
    ];

    public function subscriptions()
    {
        //@todo ajw! needs to be worked out
    }

    public function source()
    {
        return $this->hasOne('Ecomtracker\Source\Models\Source','id','source_id');
    }


    public function history()
    {
        return $this->hasMany('Ecomtracker\Keyword\Models\History','keyword_id','id');
    }





}