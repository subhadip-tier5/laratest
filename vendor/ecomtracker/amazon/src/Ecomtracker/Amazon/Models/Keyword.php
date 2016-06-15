<?php namespace Ecomtracker\Amazon\Models;

use Ecomtracker\Amazon\Models\Collection\KeywordCollection;
use Ecomtracker\Keyword\Models\Objects\Keyword\OrganicData;
use Ecomtracker\Keyword\Models\Objects\Keyword\PaidData;
use Ecomtracker\Source\Models\Source;
use Ecomtracker\Source\Models\SourceModel;
use Illuminate\Database\Eloquent\Model;
use Ecomtracker\Tracking\TUtil;

class Keyword extends SourceModel
{
    protected $table = 'amazon_keywords';
    protected $entity;

    protected $fillable = [
        'value',
        'marketplace',
        'amazon_product_id',
        'source_id',
    ];

    /**
     * @description find sibling that
     */
    private function semrushSibling()
    {
        return $this->hasOne('Ecomtracker\Keyword\Models\Keyword','value','value')->where('source_id','=',Source::where('source','=','Ecomtracker\Semrush\Models\Keyword')->first()->id);

    }


    public function getOrganicData($update = false, $limit = 1)
    {
        \Log::info('getting amazon organic data');
        if($sibling = $this->semrushSibling()->first())
        {
            if($siblingSource = $sibling->source()->first())
            {
                if ($update = true) {
                    $siblingSource->updateOrganic($limit);
                }
                return $siblingSource->getOrganicData();
            }
        }

        return new OrganicData();

    }

    public function updateOrganicData($limit = 1, $force = false)
    {
        //@todo AJW! this should be grabbing the sibling that has a semrush source and returning its getOrganicData method
        \Log::info('getting amazon organic data');
    }

    public function updateOrganic($limit = 1, $force = false)
    {
        //@todo AJW! this should be grabbing the sibling that has a semrush source and returning its getOrganicData method
        \Log::info('getting amazon organic data');
    }

    public function updateOrganicResults($limit = 1, $force = false)
    {
        \Log::info('getting amazon organic data');
    }

    public function updateOrganicTrend($limit = 1, $force = false)
    {
        \Log::info('getting amazon organic data');
    }

    public function updateRelatedPhraseMatched($limit = 1, $force = false)
    {
        \Log::info('getting amazon organic data');
    }

    /**
     * Updates
     * @return $this
     */
    
    public function getPaidData($update = false, $limit = 1)
    {
        \Log::info('getting amazon paid data');
        if($sibling = $this->semrushSibling()->first())
        {
            if($siblingSource = $sibling->source()->first())
            {
                if ($update = true) {
                    $siblingSource->updatePaid($limit);
                }
                return $siblingSource->getPaidData();
            }
        }

        return new PaidData();

    }

    public function updatePaidResults($limit = 1, $force = false)
    {
        \Log::info('getting amazon paid data');
    }
    
    public function updatePaid($limit = 1, $force = false)
    {
        \Log::info('getting amazon paid data');
    }

    public function updatePaidTrend($limit = 1, $force = false)
    {
        \Log::info('getting amazon organic data');
    }

    public function updatePaidDistribution($limit = 1, $force = false)
    {
        \Log::info('getting amazon organic data');
    }

    public function updateRelated($limit = 1, $force = false)
    {
        \Log::info('getting amazon organic data');
    }
    
    public function buildRelated($limit = 1, $force = false)
    {
        \Log::info('getting amazon organic data');
    }
        

    public function delete()
    {
        $this->entity()->delete();
        $this->history->each(function ($item){$item->delete();});

        //$this->delete();

        return parent::delete();

    }

    public function results()
    {
        return $this->belongsToMany('Ecomtracker\Amazon\Models\Keyword','amazon_keywords_related','keyword_id','related_id');
    }


    
    public function related()
    {
        return $this->belongsToMany('Ecomtracker\Amazon\Models\Keyword','amazon_keywords_related','keyword_id','related_id');
    }
    
    
    public function newCollection(array $models = array())
    {
        return new KeywordCollection($models);
    }


    public function AmazonProduct()
    {
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




    public function history()
    {
        // return Amazon Tracking Data history

        return $this->hasMany('Ecomtracker\Amazon\Models\Keyword\History','amazon_keyword_id','id');
    }





    /**
     * Track Amazon Keyword and Save to History.
     *
     * @param array $options  Optional
     * @return array  tracked data
     */

    public function GetAndTrackAmazonInfo($options=[])
    {

        try {
            $keyword_data = $this->getAmazonInfo();
            $this->trackAmazonInfo($keyword_data);
        }
        catch (\Exception $er)
        {
            return $er;
        }



    }


    
    /**
     * Get Amazon Keyword Data.
     *
     * @param array $options  Optional
     * @return array  tracked data
     */
    
    public function getAmazonInfo($options=[])
    {

        $product = $this->AmazonProduct;

        $keyword=$this;
        $ProductCountry = "com";
        $supported_countries = TUtil::getSupportedCountries();
        foreach ((array)$supported_countries as $key => $country) {
            if ($country['amazon'] == $this->marketplace) {
                $ProductCountry = $key;
            }
        }
        try {
            //error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
            //error_reporting(E_ALL & ~E_NOTICE);  // for using Darlington's class, which may produce Notice errors
            $keyword_info = TUtil::getProductPositionOnKeyword($product->asin, $keyword->value, $ProductCountry, 1, 1, 0);


        } catch (\Exception $ex) {
            $keyword_info = false;
        }

        return $keyword_info;



    }



    /**
     * Track Amazon Keyword Data.
     *
     * @param array $TrackedData
     * @return ProductHistoryModel  ProductHistoryModel model
     */

    public function trackAmazonInfo(array $TrackedData)
    {
        try {
            $KeywordHistoryModel = new \Ecomtracker\Amazon\Models\Keyword\History;
            $KeywordHistoryModel->amazon_keyword_id = $this->id;
            $KeywordHistoryModel->parsed_data = $TrackedData;
            $KeywordHistoryModel->save();

            return $KeywordHistoryModel;

        }
        catch (\Exception $er)
        {
            return $er;
        }
    }





    public function getLastTrackedKeywordInfo()
    {
        return $this->history()->orderby('id','desc')->take(1)->first();
    }



    public function getPrevTrackedKeywordInfo($date=false){

        if ($date)
        {
            return $this->history()->where('created_at','<=',$date)->orderby('id','asc')->get()->last();
        }
        else
        {
            return $this->history()->orderby('id','desc')->get()->skip(1)->first();
        }

    }


    
}