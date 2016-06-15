<?php namespace Ecomtracker\Amazon\Models\Product;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'amazon_product_history';

    protected $fillable = [
        'asin',
        'marketplace',
        'parsed_data',
        'product_id',
    ];

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity(\Ecomtracker\Product\Models\Product $entity)
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

        return $this->belongsTo('Ecomtracker\Amazon\Models\Product','product_id','id');
    }


}