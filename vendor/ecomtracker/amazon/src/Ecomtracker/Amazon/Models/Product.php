<?php namespace Ecomtracker\Amazon\Models;

use Ecomtracker\Source\Models\SourceModel;
use Illuminate\Database\Eloquent\Model;

//class Product extends SourceModel
class Product extends Model
{
    protected $table = 'amazon_products';
    protected $entity;

    protected $fillable = [
        'title',
        'source_id',
        'entity_id',
        'user_id',
        'asin',
        'marketplace',
        'status',
        'is_tracking_enabled',
        'is_asin',
        'last_processed_at',
        'show_on_dashboard_flag'
    ];

    const STATUS_TRACKED = 'tracked';
    const STATUS_ERROR = 'error';
    const STATUS_PENDING = 'pending';


    public function entity()
    {
        return $this->hasOne('Ecomtracker\Product\Models\Product','id','entity_id');
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity(Model $entity)
    {
        $this->entity = $entity;
        return $this;
    }



    public function history()
    {
        // return Amazon Tracking Data history

        return $this->hasMany('Ecomtracker\Amazon\Models\Product\History','product_id','id');
            //->orderBy("id","ASC");
    }


    public function AmazonKeywords()
    {
        // return Amazon Tracking Data history

        return $this->hasMany('Ecomtracker\Amazon\Models\Keyword','amazon_product_id','id');
    }


    public function reviews()
    {
        // return Amazon Tracking Data history

        return $this->hasMany('Ecomtracker\Amazon\Models\Product\Review','amazon_product_id','id');
    }

    /*
    public function fill(array $attributes)
    {
        $return = parent::fill($attributes);
        return $return;
    }
    */
    public function delete()
    {
        $this->entity()->delete();

        $this->AmazonKeywords->each(function ($item){$item->delete();});
        $this->history->each(function ($item){$item->delete();});

        $this->reviews->each(function ($item){$item->delete();});


        return parent::delete();

    }





    public function update(array $attributes = [])
    {
        return parent::update($attributes);

    }

    public function save(array $options = [])
    {
        /*
         TODO: need to figure out with entity model

        */
        $return = parent::save($options);
        /*
        if($this->getEntity())
        {
            $return = parent::save($options);
            $this->entity_id = $this->getEntity()->id;
            $this->getEntity()->source_model_id = $this->id;

            return $return;
        }
        */

    }


    /**
     * Track Amazon Product and Save to History.
     *
     * @param array $options  Optional
     * @return array  tracked data
     */

    public function GetAndTrackAmazonInfo($options=[])
    {

        if ($this->is_tracking_enabled) {


            $this->status=self::STATUS_PENDING;
            $this->save();

            try {

                $asin = $this->asin;
                $marketplace = $this->marketplace;
                $product_data = $this->getAmazonInfo();

                $this->trackAmazonInfo($product_data);


            }
            catch (\Exception $er)
            {

                $this->status=self::STATUS_ERROR;
                $this->save();
                return $er;
            }
        }


    }


    /**
     * Get Amazon Product Data.
     *
     * @param array $options  Optional
     * @return array  tracked data
     */

    public function getAmazonInfo($options=[])
    {
        try {
        $asin = $this->asin;
        $marketplace = $this->marketplace;
        $product_data = \Ecomtracker\Tracking\AmazonService::getProductData($asin, $marketplace);
        return $product_data;
        }
        catch (\Exception $er)
        {
            return $er;
        }
    }


    /**
     * Track Amazon Product Data.
     *
     * @param array $TrackedData  
     * @return ProductHistoryModel  ProductHistoryModel model
     */

    public function trackAmazonInfo(array $TrackedData)
    {
        try {
            if ($this->is_tracking_enabled) {


            $ProductHistoryModel = new \Ecomtracker\Amazon\Models\Product\History;
            $ProductHistoryModel->asin = $this->asin;
            $ProductHistoryModel->marketplace = $this->marketplace;
            $ProductHistoryModel->product_id = $this->id;
            $ProductHistoryModel->parsed_data = $TrackedData;
            $ProductHistoryModel->save();

            $this->status=self::STATUS_TRACKED;
            $this->last_processed_at=date("Y-m-d H:i:s");
            $this->save();

            return $ProductHistoryModel;
            }
        }
        catch (\Exception $er)
        {
            return $er;
        }
    }


    /**
     * Get Last Tracker Amazon Product Data.
     *

     * @return ProductHistoryModel  ProductHistoryModel model
     */

    public function getLastTrackedProductInfo()
    {
        return $this->history()->orderby('id','desc')->first();
    }



    public function getPrevTrackedProductInfo($date=false){

        if ($date)
        {
            return $this->history()->where('created_at','<=',$date)->orderby('id','asc')->get()->last();
        }
        else
        {
            return $this->history()->orderby('id','desc')->get()->skip(1)->first();
        }

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


}