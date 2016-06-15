<?php namespace Ecomtracker\Source\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = 'sources';


    public function keywords()
    {
        return $this->hasMany('Ecomtracker\Keyword\Models\Keyword','source_id','id');
    }





}