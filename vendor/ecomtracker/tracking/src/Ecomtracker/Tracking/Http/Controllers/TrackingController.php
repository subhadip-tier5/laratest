<?php

namespace Ecomtracker\Tracking\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Ecomtracker\Membership\Models\MembershipPlan;
use Ecomtracker\User\Models\User;
use Tymon\JWTAuth\JWTAuth;
use Ecomtracker\Tracking\AmazonService as AmazonService;
use Ecomtracker\Tracking\Exceptions\TrackingException as TrackingException;


use Ecomtracker\Amazon\Models\Keyword as AmazonKeyword;

use Ecomtracker\Tracking\TUtil;

class TrackingController extends Controller
{




    /**
     * Track Amazon Product.
     *
     * @param Request $request
     * @return array  tracked data
     */
    public static function GetAmazonProductInfo(Request $request)
    {

        $asin=$request->input('asin');
        $marketplace=$request->input('marketplace');



        if (filter_var($asin, FILTER_VALIDATE_URL)) {
            $regexp=preg_match('/(?:dp|o|gp|-)(\/product)?\/(B[0-9]{2}[0-9A-Z]{7}|[0-9]{9}(?:X|[0-9]))/',$asin,$matches);

            $asin=$matches[2];
        }



        $product_data=AmazonService::getProductData($asin,$marketplace);



        return response()->json($product_data);
    }



    /**
     * Get Amazon Product History.
     *
     * @param Request $request
     * @param Integer $id
     * @return array  history tracked data
     */
    public static function GetAmazonProductHistory(Request $request,$id)
    {

        $date_from=$request->input('date_from');
        $date_to=$request->input('date_to');



        $ProductHistory=\Ecomtracker\Amazon\Models\Product::LoginedUser()->where('id','=',$id)->first()->history();
        if ( $date_from)
        {
            $ProductHistory->where('created_at','>=',$date_from);
        }
        if ( $date_to)
        {
            $ProductHistory->where('created_at','<=',$date_to);
        }
        $ProductHistory_col=$ProductHistory->get();


        return response()->json($ProductHistory_col);
    }



    /**
     * Get Amazon Keyword Info.
     *
     * @param Request $request
     * @param Integer $id
     * @return array  keyword data
     */
    public static function GetAmazonKeywordInfo(Request $request,$id)
    {


        $keyword=AmazonKeyword::LoginedUser()->where('id','=',$id)->first();
        $keyword_data=$keyword->getAmazonInfo();


        return response()->json($keyword_data);
    }


    /**
     * Get Amazon Keyword Suggestions.
     *
     * @param Request $request
     * @return array  keyword data
     */

    /**
     * Track Amazon Product.
     *
     * @param Request $request
     * @return array  tracked data
     */
    public static function GetAmazonKeywordSuggestions(Request $request)
    {
        $value=$request->input('value');
        $marketplace=$request->input('marketplace');

        $ProductCountry = "com";
        $supported_countries = TUtil::getSupportedCountries();
        foreach ((array)$supported_countries as $key => $country) {
            if ($country['amazon'] == $marketplace) {
                $ProductCountry = $key;
            }
        }
        try {

            $res = TUtil::getSugestedKeywords($value, $ProductCountry);



        } catch (\Exception $ex) {
            $res = false;
        }


        return response()->json($res);
    }



    /**
     * Track Amazon Related Product Items.
     *
     * @param Request $request
     * @return array  tracked data
     */
    public static function GetAmazonProductSimilarItems(Request $request)
    {

        $asin=$request->input('asin');
        $marketplace=$request->input('marketplace');



        $product_data=AmazonService::SimilarityLookup($asin,$marketplace);
        //print_r($product_data);
        $ret_data=[];
        if (isset($product_data['Items']['Item']))
        {
            foreach( (array) $product_data['Items']['Item'] as $item)
            {
                $ret_data[]=[
                    'asin'=>$item['ASIN'],
                    'title'=>$item['ItemAttributes']['Title'],

                ];
            }

        }



        return response()->json($ret_data);
    }



    /**
     * Get Amazon Available Countries
     *
     * @param Request $request
     * @return array  tracked data
     */
    public static function GetAmazonCountries(Request $request)
    {

        $supported_countries = $amz_credentials_config=\Config::get('amazon.country_codes');


        return response()->json($supported_countries);
    }


}

