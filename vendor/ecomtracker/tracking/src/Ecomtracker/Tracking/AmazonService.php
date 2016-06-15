<?php
namespace Ecomtracker\Tracking;


use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\Operations\CartCreate;
use ApaiIO\Operations\CartClear;
use ApaiIO\Operations\CartAdd;
use ApaiIO\Operations\Search;
use ApaiIO\Operations\SimilarityLookup;

use ApaiIO\ApaiIO;

use Symfony\Component\DomCrawler\Crawler;
//use Ecomtracker\Tracking\Models\ProductReview;
use Config;

use Ecomtracker\Tracking\ApaioXmlToArrayObject as ApaioXmlToArrayObject;
use Ecomtracker\Tracking\Exceptions\TrackingException as TrackingException;


use Ecomtracker\Amazon\Models\Product\Review as ProductReview;

class AmazonService
{

    public $conf;

    public static function setConf($marketplace, $level=0)
    {
        $amz_credentials_config=Config::get('amazon.credentials');

        $random_credentials=$amz_credentials_config[array_rand($amz_credentials_config)];


        $amz_country_codes=Config::get('amazon.country_codes');

        $country=$marketplace;


        //
        // uncomment this if need more fail-safe code. all invlid countries will be forwarded to default one then
        //$country=@in_array($country,$amz_country_codes)?$country:Config::get('amazon.country_code_default');
        //echo "\n".$country."=========".$marketplace."\n";




        $conf = new GenericConfiguration();
        $conf
            ->setCountry($country)
            ->setAccessKey($random_credentials['AWS_API_KEY'])
            ->setSecretKey($random_credentials['AWS_API_SECRET_KEY'])
            ->setAssociateTag($random_credentials['AWS_ASSOCIATE_TAG'])
            //->setRequest('\ApaiIO\Request\Soap\Request')
            ->setResponseTransformer(ApaioXmlToArrayObject::class)
            //->setResponseTransformer('\ApaiIO\ResponseTransformer\ObjectToArray')
            ;



        // checking credentials with additional test api call
        //$conf->setSecretKey('fake');
        $apaiIO = new ApaiIO($conf);
        $lookup = new Lookup();
        $lookup->setItemId('testapi');
        $lookup->setResponseGroup(array('Large','OfferFull')); // More detailed information
        $formattedResponse = $apaiIO->runOperation($lookup);

        if (isset($formattedResponse['Error']) and $level<=15)   // change recurse limit here if need
        {
            /*
            print_r($formattedResponse);
            echo "Error ($level): ";
            echo  $formattedResponse['Error']['Code'];
            echo " Trying next one.";
            */
            return ( self::setConf($marketplace,$level+1) );
        }
        elseif (isset($formattedResponse['Error']) and $level>15) // change recurse limit here if need
        {
            throw new TrackingException("Max number of connection attempts ( 15 ) reached");
        }
        else
        {

            return ($conf);
        }



        //$this->conf=$conf;


    }

    public static function itemSearch($keyword, $SearchIndex="All", $domain, $page)
    {
        $conf=self::setConf($domain);
        $apaiIO = new ApaiIO($conf);

        $search = new Search();
        $search->setCategory($SearchIndex);
        $search->setKeywords($keyword);
        $search->setPage($page);


        $formattedResponse = $apaiIO->runOperation($search);
        return($formattedResponse);

    }


    public static function itemLookup($asin,$marketplace)
    {
        $conf=self::setConf($marketplace);
        $apaiIO = new ApaiIO($conf);
        $lookup = new Lookup();
        $lookup->setItemId($asin);
        $lookup->setResponseGroup(array('Large','OfferFull')); // More detailed information

        $formattedResponse = $apaiIO->runOperation($lookup);
        return $formattedResponse;

    }

    public static function SimilarityLookup($asin,$marketplace)
    {
        $conf=self::setConf($marketplace);
        $apaiIO = new ApaiIO($conf);
        $lookup = new SimilarityLookup();
        $lookup->setItemId($asin);
        $lookup->setResponseGroup(array('Small')); // More detailed information

        $formattedResponse = $apaiIO->runOperation($lookup);
        return $formattedResponse;

    }

    public static function getProductData($asin,$marketplace)
    {





        $conf=self::setConf($marketplace);
        $country=$marketplace;
        $country=str_replace("webservices.amazon.","",$country);
        $amz_country_codes=Config::get('amazon.country_codes');
        $country=@in_array($country,$amz_country_codes)?$country:Config::get('amazon.country_code_default');
        $apaiIO = new ApaiIO($conf);
        $lookup = new Lookup();
        $lookup->setItemId($asin);
        $lookup->setResponseGroup(array('Large','OfferFull')); // More detailed information

        $formattedResponse = $apaiIO->runOperation($lookup);

        //print_r($formattedResponse);

        if (isset($formattedResponse['Items']['Item']['ASIN']))
        {
            $return=AmazonService::parseAmazonData($formattedResponse);



            // calculate availability by using CarteCreate and CartClear amazon calls


            $resCartCreate=self::createCart($conf,$formattedResponse['Items']['Item']['ASIN']);
            //echo "resCartCreate response:";
            //print_r($resCartCreate);

            if ( isset($resCartCreate['Cart']['CartItems']['CartItem']['Quantity']) )
            {
                $return['InStock']=$resCartCreate['Cart']['CartItems']['CartItem']['Quantity'];
                $resCartClear=self::clearCart($conf,$resCartCreate['Cart']['CartId'],$resCartCreate['Cart']['HMAC']);
            }
            else
            {
                $return['InStock']=0;
            }


            //echo "resCartClear response:";
            //print_r($resCartClear);

            // Add HTML data

            //$ch = curl_init();



            $url="http://www.amazon.".$country."/gp/cart/desktop/ajax-mini-detail.html/ref=added_item_1?ie=UTF8&asin=".$asin."";
            $html_result1=self::loadHtmlPage($url,'www.amazon.'.$country);

            /*
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $html_result1 = curl_exec($ch);
            */



            $crawler = new Crawler($html_result1);

            try {
                $return['BuyBoxPrice']= $crawler->filter('.a-size-medium.a-color-price.sc-price')->text();
            }
            catch (\InvalidArgumentException  $e) {}



            $url="http://www.amazon.".$country."/gp/customer-reviews/widgets/average-customer-review/popover/ref=dpx_acr_pop_?contextId=dpx&asin=".$asin."";

            $html_result2=self::loadHtmlPage($url,'www.amazon.'.$country);


            //echo $html_result2;exit();
            //curl_setopt($ch, CURLOPT_URL, $url);
            //$html_result2 = curl_exec($ch);

            $crawler = new Crawler($html_result2);

            try {
                $return['NumOfReviews']= $crawler->filter('.a-section.a-spacing-none.a-text-center .a-size-small.a-link-emphasis')->text();
                $return['NumOfReviews']=preg_replace("/[^0-9.]/", "", $return['NumOfReviews']);
            }
            catch (\Exception $e) {}
            try {
                $return['Rating']= $crawler->filter('.a-size-base.a-color-secondary')->text();
                $return['Rating']=str_replace('out of 5 stars','', ($return['Rating']) );
                $return['Rating']=trim($return['Rating']);


            }
            catch (\Exception $e) {}

            //curl_close($ch);


            //return ['parsed_data'=>$return, 'raw_data'=>['amazon'=>$formattedResponse , 'html1'=>$html_result1 , 'html2'=>$html_result2 ]];
            return $return;

        }
        else
        {

            throw new TrackingException("Error fetching Amazon Product Data. Amazon Error Message: ".$formattedResponse['Items']['Request']['Errors']['Error']['Message']);
            //return false;
        }



    }


    public static function parseAmazonData($array_data){

        $return_data=array();
        $return_data['ASIN']=@$array_data['Items']['Item']['ASIN'];
        $return_data['ParentASIN']=@$array_data['Items']['Item']['ASIN'];
        $return_data['DetailPageURL']=@$array_data['Items']['Item']['DetailPageURL'];
        $return_data['Title']=@$array_data['Items']['Item']['ItemAttributes']['Title'];
        $return_data['Image']=@$array_data['Items']['Item']['MediumImage']['URL'];
        $return_data['Brand']=@$array_data['Items']['Item']['ItemAttributes']['Brand'];

        $return_data['ListPrice']=@$array_data['Items']['Item']['ItemAttributes']['ListPrice']['FormattedPrice'];
        $return_data['LowestNewPrice']=@$array_data['Items']['Item']['OfferSummary']['LowestNewPrice']['FormattedPrice'];
        $return_data['LowestUsedPrice']=@$array_data['Items']['Item']['OfferSummary']['LowestUsedPrice']['FormattedPrice'];
        $return_data['LowestRefurbishedPrice']=@$array_data['Items']['Item']['LowestRefurbishedPrice']['FormattedPrice'];   // Item LowestRefurbishedPrice>FormattedPrice

        $return_data['TotalNew']=@$array_data['Items']['Item']['OfferSummary']['TotalNew'];
        $return_data['TotalUsed']=@$array_data['Items']['Item']['OfferSummary']['TotalUsed'];
        $return_data['TotalRefurbished']=@$array_data['Items']['Item']['OfferSummary']['TotalRefurbished'];

        /*
        $browsernode_arr=array();
        if (count(@$array_data['Items']['Item']['BrowseNodes']['BrowseNode']))
        {

            foreach (@$array_data['Items']['Item']['BrowseNodes']['BrowseNode'] as $browsernode)
            {
                $browsernode_arr[]=@$browsernode['Name'];

            }
        }
        $return_data['BrowseNode']=@$browsernode_arr;


        $return_data['BrowseNodes']=@$array_data['Items']['Item']['BrowseNodes'];
        */

        $return_data['SalesRank']=@$array_data['Items']['Item']['SalesRank'];
        $return_data['SellerName']=@$array_data['Items']['Item']['Offers']['Offer']['Merchant']['Name'];
        $return_data['IsBuyBoxFBA']=@$array_data['Items']['Item']['Offers']['OfferListing']['IsEligibleForSuperSaverShipping']==1?"1":"";
        $return_data['isBuyBoxFBM']=@$array_data['Items']['Item']['Offers']['OfferListing']['IsEligibleForSuperSaverShipping']!=1?"1":"";
        $return_data['IsBuyBoxAMZ']=@$array_data['Items']['Item']['Offers']['Offer']['Merchant']['Name']=='Amazon'?"1":"";
        $return_data['Author']=@$array_data['Items']['Item']['Offers']['Offer']['ItemAttributes']['Author'];
        $return_data['Binding']=@$array_data['Items']['Item']['Offers']['Offer']['ItemAttributes']['Binding'];
        $return_data['Format']=@$array_data['Items']['Item']['Offers']['Offer']['ItemAttributes']['Format'];
        $return_data['IsAdultProduct']=@$array_data['Items']['Item']['Offers']['Offer']['ItemAttributes']['IsAdultProduct'];
        $return_data['Language']=@$array_data['Items']['Item']['ItemAttributes']['Languages']['Language']['Name'];
        $return_data['NumberOfPages']=@$array_data['Items']['Item']['ItemAttributes']['NumberOfPages'];
        $return_data['ProductGroup']=@$array_data['Items']['Item']['ItemAttributes']['ProductGroup'];
        $return_data['PublicationDate']=@$array_data['Items']['Item']['ItemAttributes']['PublicationDate'];
        $return_data['ReleaseDate']=@$array_data['Items']['Item']['ItemAttributes']['ReleaseDate'];
        $return_data['EditorialReview']=@$array_data['Items']['Item']['EditorialReview']['Source'];
        $return_data['SimilarProduct']=@$array_data['Items']['Item']['EditorialReviews']['SimilarProducts']['SimilarProduct'];
        $return_data['UPC']=@$array_data['Items']['Item']['ItemAttributes']['UPC'];
        $return_data['EAN']=@$array_data['Items']['Item']['ItemAttributes']['EAN'];
        $return_data['Warranty']=@$array_data['Items']['Item']['ItemAttributes']['Warranty'];
        $return_data['Studio']=@$array_data['Items']['Item']['ItemAttributes']['Studio'];
        $return_data['Size']=@$array_data['Items']['Item']['ItemAttributes']['Size'];
        $return_data['Manufacturer']=@$array_data['Items']['Item']['ItemAttributes']['Manufacturer'];
        $return_data['Model']=@$array_data['Items']['Item']['ItemAttributes']['Model'];
        $return_data['MPN']=@$array_data['Items']['Item']['ItemAttributes']['MPN'];
        $return_data['PartNumber']=@$array_data['Items']['Item']['ItemAttributes']['PartNumber'];
        $return_data['NumberOfItems']=@$array_data['Items']['Item']['ItemAttributes']['NumberOfItems'];
        $return_data['PackageQuantity']=@$array_data['Items']['Item']['ItemAttributes']['PackageQuantity'];
        $return_data['PackageDimensions']=@$array_data['Items']['Item']['ItemAttributes']['PackageDimensions'];   // Item PackageDimensions
        $return_data['BulletPoints']=@$array_data['Items']['Item']['ItemAttributes']['Feature'];   // Item PackageDimensions
        $return_data['ImageSets']=@$array_data['Items']['Item']['ImageSets'];
        $return_data['Description']=@$array_data['Items']['Item']['EditorialReviews']['EditorialReview']['Content'];   // Item PackageDimensions





        return  $return_data;
    }

    /*
     * Function copied from Darlington's JS
     * @return array

    */


    public static function calculateSales($SalesRank, $Price, $Rating,$marketplace){


        //var_dump ($SalesRank, $Price, $Rating,$marketplace);

        $Price= preg_replace('/[^\d,\.]/', '', $Price);
        $Price=floatval($Price);
        if (!isset($Rating) || $Rating == '0.0')
            {
            $Rating = '46';
            }


        $Factor = (1200*$Rating)/50;

        $EstimatedSales = (100000/$SalesRank)*30; //30 days
        $EstimatedSales = ($EstimatedSales*$Factor)/100;

        $EstimatedSales = $EstimatedSales*0.42; //reduce

        if ($marketplace != 'www.amazon.com')
            $EstimatedSales = $EstimatedSales*0.26; //reduce


        if ($marketplace == 'www.amazon.de' || $marketplace == 'www.amazon.fr')
            $EstimatedSales = $EstimatedSales*0.51; //reduce


        if ($SalesRank < 2000)
            $EstimatedSales = $EstimatedSales*0.85;

        if ($SalesRank < 1000)
            $EstimatedSales = $EstimatedSales*0.83;

        if ($SalesRank < 500)
            $EstimatedSales = $EstimatedSales*0.61;

        if ($SalesRank < 300)
            $EstimatedSales = $EstimatedSales*0.44;

        if ($SalesRank < 100)
            $EstimatedSales = $EstimatedSales*0.35;

        if ($SalesRank < 50)
            $EstimatedSales = $EstimatedSales*0.35;


        if ($SalesRank < 20)
            $EstimatedSales = $EstimatedSales*0.44;

        if ($SalesRank < 10)
            $EstimatedSales = $EstimatedSales*0.34;

        if ($SalesRank > 27000)
            $EstimatedSales = $EstimatedSales*1.15;

        if ($SalesRank > 50000)
            $EstimatedSales = $EstimatedSales*1.65;



        $EstimatedRevenue = 0.00;

        if (is_numeric($EstimatedSales))
        {

            if ($EstimatedSales < 1 && $EstimatedSales>0)
                {
                 $denominator = 1/$EstimatedSales;
                $denominator = intval($denominator);
                if ($denominator == 1)
                    $denominator++;

                $FinalEstimatedSales = '1 each '.intval($denominator).' months';
                }
            else
                {
                $EstimatedSales = intval($EstimatedSales);
                $FinalEstimatedSales = $EstimatedSales;
                }

            if (isset($Price))
                {
                $EstimatedRevenue = $EstimatedSales*$Price;
                $FinalEstimatedRevenue = $EstimatedRevenue;
                }
        }

        return ['FinalEstimatedRevenue'=>$FinalEstimatedRevenue,
                'FinalEstimatedSales'=>$FinalEstimatedSales];


    }



    public static function getBBSeller($seller_name,$IsBuyBoxFBA){
        $sellerNameDisplay = 'AMZ';
        $tempSeller = explode($seller_name,'.');


        if ($tempSeller[0] != 'Amazon')
                {

                    if ($IsBuyBoxFBA == '1')
                    {
                        $sellerNameDisplay = 'FBA';


                    }
                    else
                    {
                        $sellerNameDisplay = 'FBM';

                    }
                }
        return $sellerNameDisplay;

    }



    public static function createCart($conf,$asin='')
    {
        //$conf->setResponseTransformer('\Intelliclick\Tracker\Classes\ApaioXmlToArrayObject2');
        $apaiIO = new ApaiIO($conf);
        $cartCreate = new CartCreate();
        if ($asin)
            {
                $cartCreate->addItem($asin,999);


                }
        $formattedResponse = $apaiIO->runOperation($cartCreate);
        return $formattedResponse;


    }


    public static function clearCart($conf,$cart_id,$hmac)
    {

        $apaiIO = new ApaiIO ($conf);
        $CartClear  = new CartClear ();
        $CartClear ->setCartId($cart_id);
        $CartClear ->setHMAC($hmac);
        $formattedResponse = $apaiIO->runOperation($CartClear);
        return $formattedResponse;

    }









    public static function trackProductReviews(\Ecomtracker\Amazon\Models\Product $Product)
    {
        try
        {

            $reviews = self::getProductReviews($Product);

            if (isset($reviews['data']) && isset($reviews['data']['0']) )
            {
                $last_review=$reviews['data'][0];

                $reviews['data']=array_reverse($reviews['data']);

                foreach ( (array)$reviews['data'] as $key=>$review_item)
                {
                    if (floatval($review_item['stars'])<4   )  // change this to add only negative reviews
                    {
                        try {


                            $Review = new ProductReview();
                            $Review->fill($review_item);
                            $Review->amazon_product_id = $Product->id;
                            $Review->save();
                        }
                        catch (\Ecomtracker\Membership\Exceptions\Membershipexception $ex)
                        {
                            // send some notification to user (email)
                        }
                    }
                    else
                    {
                        unset($reviews['data'][$key]);
                    }

                }

                $Product->last_tracked_review_date=$last_review['date'];
                $Product->last_tracked_review_id=$last_review['review_id'];
                $Product->save();

                return $reviews['data'];
            }
            else
            {
                return false;
            }
        }
        catch (\Exception $ex)
        {
            return false;
        }



    }



    public static function getProductReviews(\Ecomtracker\Amazon\Models\Product $Product, $pageNumber=1)
    {

        $last_td=$Product->getLastTrackedProductInfo();
        $DetailPageURL=$last_td->parsed_data->DetailPageURL;
        $asin=$last_td->asin;
        $res_match = preg_match('/^(.*)\/dp\/.*$/', $DetailPageURL, $matches);

        $clean_url = $matches[1];

        $reviews_url=  $clean_url."/product-reviews/".$asin."/ref=cm_cr_pr_viewopt_srt?ie=UTF8&showViewpoints=1&sortBy=recent&filterByStar=all_stars&pageNumber=";

        $limitdate=$Product->last_tracked_review_date?$Product->last_tracked_review_date:$Product->created_at;
        $limitreviewid=$Product->last_tracked_review_id;


        //$reviews_list=self::getProductReviewsFromUrl($reviews_url,$pageNumber,$limitdate,$limitreviewid);
        $reviews_list=self::getProductReviewsFromUrl($reviews_url,$pageNumber,'January 14, 2016',$limitreviewid);
        //var_dump ($reviews_list);

        return $reviews_list;

    }


    public static function getProductReviewsFromUrl($url,$pageNumber,$limitdate,$limitreviewid )
    {

        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.$pageNumber);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $html_result1 = curl_exec($ch);
        */

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url.$pageNumber, [
                                                            'headers' => [
                                                                'User-Agent' => self::getRandomUserAgentString(),
                                                                'Accept'=>'',
                                                                'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                                                                'Connection'=>'keep-alive',
                                                                'Cache-Control'=>'max-age=0',

                                                            ]
                                                        ]);
        $html_result1 = (string)$res->getBody();


        //echo ($html_result1);
        $crawler = new Crawler($html_result1);
        $pointer_reached=false;

        $return=['data'=>[] ];
        $return['data']= $crawler->filter('#cm_cr-review_list .review')->each(function (Crawler $node, $i) use ($limitdate,$limitreviewid,&$pointer_reached)  {

            $id=$node->attr('id');
            $stars=$node->filter('.review-rating')->text();
            $stars=str_replace(' out of 5 stars','', $stars );
            $date=$node->filter('.review-date')->text();
            $date=str_replace('on ','', $date );
            $author=$node->filter('.author')->text();
            $author_url=$node->filter('.author')->attr('href');
            $text=$node->filter('.review-data .review-text')->html();



            if ($limitreviewid==$id or strtotime($date)<strtotime($limitdate))
            {
                $pointer_reached=true;
            }

            //if (!$pointer_reached && floatval($stars)<4)  // getting only negative with ratine <4
            if (!$pointer_reached )  // getting only negative with ratine <4
            {
                return ['i'=>$i,'review_id'=>$id, 'stars'=>$stars, 'author'=>$author,'author_url'=>$author_url, 'date'=>$date,'text'=>$text];
            }
            else
            {
                //continue;
            }

        });

        // removing empty elements
        $return['data']=array_filter($return['data']);


        // check if $limitdate reached
        $last_review=end($return['data']);


        if ($pointer_reached)
        {
            $return['final_page']=$pageNumber;
        }
        else
        {
            // trying next page
            if ($pageNumber<=3)
            {
                $date_recurs=self::getProductReviewsFromUrl($url,$pageNumber+1,$limitdate,$limitreviewid);
                $return['data']=array_merge($return['data'], $date_recurs['data'] );
                @$return['final_page']=$date_recurs['final_page'];
            }

        }



        return $return;



    }













    public static function OnPageInfo(\Ecomtracker\Amazon\Models\Product $Product,$keywords=[])
    {
        $last_td=$Product->getLastTrackedProductInfo();

        $analize_results=[];
        $total_marks=0;

        /*
         *   $BulletPoints
         */
        $BulletPoints=$last_td->parsed_data->BulletPoints;
        $analize_results['BulletPoints']=[
            'recomended'=>'5+',
            'current'=>count($BulletPoints),
            'content'=>$BulletPoints,
            'success'=>(count($BulletPoints)>=5)?true:false

        ];



        /*
         *   NumOfReviews
         */
        $NumOfReviews=$last_td->parsed_data->NumOfReviews;
        $analize_results['NumOfReviews']=[
            'recomended'=>'15+',
            'current'=>$NumOfReviews,
            'success'=>($NumOfReviews>=15)?true:false

        ];

        /*
         *   Rating
         */
        $Rating=$last_td->parsed_data->Rating;
        $analize_results['Rating']=[
            'recomended'=>'4+',
            'current'=>$Rating,
            'success'=>($Rating>=4)?true:false

        ];

        /*
         *   TotalImages
         */

        $images_lowres=[];
        $images_hires=[];
        foreach ($last_td->parsed_data->ImageSets->ImageSet as $ImageSet)
        {

            if ($ImageSet->{'@attributes'}->Category=="variant")
            {
                $images_lowres[]=$ImageSet;
                if ($ImageSet->LargeImage->URL)
                {
                    $images_hires[]=$ImageSet;
                }
            }

        }


        $analize_results['TotalImages']=[
            'recomended'=>'6+',
            'current'=>count($images_lowres),
            'content'=>($images_lowres),
            'success'=>(count($images_lowres)>=6)?true:false

        ];

        /*
         *   HiResImages
         */

        $analize_results['HiResImages']=[
            'recomended'=>'2+',
            'current'=>count($images_hires),
            'content'=>($images_hires),
            'success'=>(count($images_hires)>=2)?true:false

        ];



        /*
         *   CharsInDescription
         */
        $Description=$last_td->parsed_data->Description;
        $analize_results['CharsInDescription']=[
            'recomended'=>'1000+',
            'current'=>strlen($Description),
            'content'=>($Description),
            'success'=>(strlen($Description)>=1000)?true:false

        ];


        /*
         *   Keywords
         */
        $Title=$last_td->parsed_data->Title;
        $keywords_parsed=[];
        if ($keywords!='')
        { $keywords_array=explode(',',$keywords); }
        else
        { $keywords_array=[]; }
        foreach (  (array) $keywords_array as $keyword)
        {
            //  test in buletpoints
            $found_in_bulletpoints=false;
            $found_in_description=false;
            $found_in_title=false;
            foreach ($BulletPoints as $BulletPoint)
            {


                if (strpos(strtolower( $BulletPoint), strtolower($keyword)  )!==false )
                {
                    $found_in_bulletpoints=true;
                }

            }

            if (strpos(strtolower( $Description), strtolower($keyword)  )!==false )
            {
                $found_in_description=true;
            }


            if (strpos(strtolower( $Title), strtolower($keyword)  )!==false )
            {
                $found_in_title=true;
            }


            $keywords_parsed[]=[
                'keyword'=>$keyword,
                'found_in_bulletpoints'=>$found_in_bulletpoints?true:false,
                'found_in_description'=>$found_in_description?true:false,
                'found_in_title'=>$found_in_title,
            ];


        }


        $analize_results['keywords']=$keywords_parsed;

        $analize_results['totalmarks']= ($analize_results['BulletPoints']['success']?1:0)
                                        + ($analize_results['NumOfReviews']['success']?1:0)
                                        + ($analize_results['Rating']['success']?1:0)
                                        + ($analize_results['TotalImages']['success']?1:0)
                                        + ($analize_results['HiResImages']['success']?1:0)
                                        + ($analize_results['CharsInDescription']['success']?1:0) ;


        return $analize_results;
        //return [];

    }



    public static function LastTrackedStats(\Ecomtracker\Amazon\Models\Product $Product,$options=[])
    {
        $response=[];
        $last_td=$Product->getLastTrackedProductInfo();


        $prev_td=$Product->history()->orderby('id','DESC')->skip(1)->first();

        $first_td=$Product->history->first();
        if(!$prev_td)
        {
            $prev_td=$first_td;
        }


        try
        {
            $total_sold=intval($first_td->parsed_data->InStock) - intval($last_td->parsed_data->InStock);
            $total_sold_prev=intval($first_td->parsed_data->InStock) - intval($prev_td->parsed_data->InStock);

            $total_days=round( (strtotime($last_td->created_at) - strtotime($first_td->created_at))/86400 );
            $total_days_prev=round( (strtotime($prev_td->created_at) - strtotime($first_td->created_at))/86400 );

            $average_price=round(
                ( floatval(str_replace("\$", "", $last_td->parsed_data->ListPrice)) + floatval(str_replace("\$", "", $first_td->parsed_data->ListPrice))
                ) /2 ,2 );
            $average_price_prev=round(
                ( floatval(str_replace("\$", "", $prev_td->parsed_data->ListPrice)) + floatval(str_replace("\$", "", $first_td->parsed_data->ListPrice))
                ) /2 ,2 );

            $revenue=$average_price*$total_sold;
            $revenue_prev=$average_price_prev*$total_sold;

        }
        catch(\Exception $ex)
        {
            $total_sold="n/a";
            $total_sold_prev="n/a";

            $total_days="n/a";
            $total_days_prev="n/a";

            $average_price="n/a";
            $average_price_prev="n/a";

            $revenue="n/a";
            $revenue_prev="n/a";
        }




        try
        {
            $average_rank=round(
                ( floatval( $last_td->parsed_data->Rating) + floatval( $first_td->parsed_data->Rating)
                ) /2 ,2 );
            $average_rank_prev=round(
                ( floatval( $prev_td->parsed_data->Rating) + floatval( $first_td->parsed_data->Rating)
                ) /2 ,2 );
        }
        catch(\Exception $ex)
        {
            $average_rank="n/a";
            $average_rank_prev="n/a";
        }



        $response['sales_stats']=[
            'total_sold'=>$total_sold,
            'total_sold_prev'=>$total_sold_prev,
            'total_sold_change'=>$total_sold-$total_sold_prev,
            'total_days_tracking'=>$total_days,
            'average_price'=>'$'.$average_price,
            'average_price_prev'=>'$'.$average_price_prev,
            'average_price_change'=>$average_price-$average_price_prev,
            'total_revenue'=>'$'.$revenue,
            'total_revenue_prev'=>'$'.$revenue_prev,
            'total_revenue_change'=>$revenue-$revenue_prev,
            'average_sales_per_day'=>($total_days>0?round($total_sold/$total_days,2):""),
            'average_sales_per_day_prev'=>($total_days_prev>0?round($total_sold_prev/$total_days_prev,2):""),
            'average_sales_per_day_change'=>($total_days>0?round($total_sold/$total_days,2):"")-($total_days_prev>0?round($total_sold_prev/$total_days_prev,2):""),
            'average_revenue_per_day'=>($total_days>0?'$'.round( ($total_sold/$total_days)*$average_price,2):""),
            'average_revenue_per_day_prev'=>($total_days_prev>0?'$'.round( ($total_sold_prev/$total_days_prev)*$average_price_prev,2):""),
            'average_revenue_per_day_change'=>($total_days>0?'$'.round( ($total_sold/$total_days)*$average_price,2):"")-($total_days_prev>0?'$'.round( ($total_sold_prev/$total_days_prev)*$average_price_prev,2):""),
            'average_rank'=>$average_rank,
            'average_rank_prev'=>$average_rank_prev,
            'average_rank_change'=>$average_rank-$average_rank_prev,


        ];

        $response['last_tracked_data']=$last_td;
        return $response;
    }



    public static function getRandomUserAgentString()
    {

        $rand_v1=rand(999, 9999);
        $rand_v2=rand(1, 99);
        $rand_v3=rand(1, 999);
        return 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/'.$rand_v3.'.'.$rand_v3.' (KHTML, like Gecko) Chrome/50.0.'.$rand_v1.'.94 Safari/'.$rand_v3.'.'.$rand_v3.'';
    }

    public static function loadHtmlPage($url,$host,$recurs_level=1)
    {


        $client = new \GuzzleHttp\Client();


        $res = $client->request('GET', $url,[
            'headers' => [
                'User-Agent' => self::getRandomUserAgentString(),
                'Accept'=>'',
                'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Connection'=>'keep-alive',
                'Host'=>$host,
                'Cache-Control'=>'max-age=0',

            ]
        ]);


        $html_result1 = (string)$res->getBody();




        // check for captcha
        $crawler = new Crawler($html_result1);
        try {
            $check_captcha = $crawler->filter('form #captchacharacters')->attr('id');;

            // captcha found rerying
            if ($recurs_level<=10)
            {
                //echo 'retrying...';
                return self::loadHtmlPage($url,$host,$recurs_level+1);
            }
            else
            {
                return  $html_result1;

            }
        }
        catch (\Exception $ex)
        {
            return  $html_result1;
        }



        //return  $html_result1;
    }


}





