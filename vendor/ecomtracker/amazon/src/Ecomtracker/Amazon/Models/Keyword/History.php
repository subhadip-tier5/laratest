<?php namespace Ecomtracker\Amazon\Models\Keyword;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'amazon_keyword_history';

    protected $fillable = [
        'parsed_data',
        'amazon_keyword_id',
    ];

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity(\Ecomtracker\Keyword\Models\Keyword $entity)
    {
        $this->entity = $entity;
        return $this;
    }



    public function setParsedDataAttribute($value)
    {
        //$this->attributes['parsed_data'] = serialize($value);
        $this->attributes['parsed_data'] = json_encode($value);
    }

    public function getParsedDataAttribute($value)
    {
        //return @unserialize($value);
        return json_decode($value);
    }



    public function AmazonProduct()
    {
        // return Amazon Product relation

        return $this->belongsTo('Ecomtracker\Amazon\Models\Keyword','amazon_keyword_id','id');
    }
}