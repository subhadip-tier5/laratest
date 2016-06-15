<?php namespace Ecomtracker\Amazon\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'amazon_product_reviews';

    protected $fillable = [
        'review_id',
        'stars',
        'author',
        'author_url',
        'date',
        'text'
    ];





    public function AmazonProduct()
    {
        // return Amazon Product relation

        return $this->belongsTo('Ecomtracker\Amazon\Models\Product','amazon_product_id','id');
    }




    public function scopeLoginedUser($query,$user_id=false)
    {
        if (!$user_id)
        {
            $logined_user=\Ecomtracker\User\Models\User::Logined()->first();
            $user_id=$logined_user->id;
        }
        return $query->whereHas('AmazonProduct', function ($query) use ($user_id) {
            $query->where('user_id', '=', $user_id);

        });
    }

}