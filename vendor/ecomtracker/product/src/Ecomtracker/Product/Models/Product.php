<?php namespace Ecomtracker\Product\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'value',
        'source_id',
        'source_key',
        'data'
    ];

}