<?php  namespace Ecomtracker\Tracking;


/*
 *
 * Keyword package from Darlington
 * get keyword position, suggestions etc...
 *
 */


use Ecomtracker\Tracking\AmazonService;

//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

//require_once('simple_html_dom.php');

class TUtil
{



    static public function getSupportedCountries()
    {
        $arr = [];

        $arr['us']['amazon'] = 'www.amazon.com';
        $arr['us']['amazonautocomplete'] = '1';
        $arr['us']['amazoncompletiondomain'] = 'amazon.com';
        $arr['us']['domain'] = 'com';
        $arr['com'] = $arr['us'];

        $arr['uk']['amazon'] = 'www.amazon.co.uk';
        $arr['uk']['amazonautocomplete'] = '3';
        $arr['uk']['amazoncompletiondomain'] = 'amazon.co.uk';
        $arr['uk']['domain'] = 'co.uk';


        $arr['ca']['amazon'] = 'www.amazon.ca';
        $arr['ca']['amazonautocomplete'] = '7';
        $arr['ca']['amazoncompletiondomain'] = 'amazon.com';
        $arr['ca']['domain'] = 'ca';


        $arr['cn']['amazon'] = 'www.amazon.cn';
        $arr['cn']['amazonautocomplete'] = '3240';
        $arr['cn']['amazoncompletiondomain'] = 'amazon.cn';
        $arr['cn']['domain'] = 'cn';

        $arr['uk']['amazon'] = 'www.amazon.com.br';
        $arr['uk']['amazonautocomplete'] = '526970';
        $arr['uk']['amazoncompletiondomain'] = 'amazon.com';
        $arr['uk']['domain'] = 'com.br';

        $arr['fr']['amazon'] = 'www.amazon.fr';
        $arr['fr']['amazonautocomplete'] = '5';
        $arr['fr']['amazoncompletiondomain'] = 'amazon.co.uk';
        $arr['fr']['domain'] = 'fr';


        $arr['de']['amazon'] = 'www.amazon.de';
        $arr['de']['amazonautocomplete'] = '4';
        $arr['de']['amazoncompletiondomain'] = 'amazon.co.uk';
        $arr['de']['domain'] = 'de';

        $arr['it']['amazon'] = 'www.amazon.it';
        $arr['it']['amazonautocomplete'] = '35691';
        $arr['it']['amazoncompletiondomain'] = 'amazon.co.uk';
        $arr['it']['domain'] = 'it';

        $arr['in']['amazon'] = 'www.amazon.in';
        $arr['in']['amazonautocomplete'] = '44571';
        $arr['in']['amazoncompletiondomain'] = 'amazon.co.uk';
        $arr['in']['domain'] = 'in';

        $arr['es']['amazon'] = 'www.amazon.es';
        $arr['es']['amazonautocomplete'] = '44551';
        $arr['es']['amazoncompletiondomain'] = 'www.amazon.co.uk';
        $arr['es']['domain'] = 'es';

        $arr['jp']['amazon'] = 'www.amazon.co.jp';
        $arr['jp']['amazonautocomplete'] = '6';
        $arr['jp']['amazoncompletiondomain'] = 'amazon.co.jp';
        $arr['jp']['domain'] = 'co.jp';

        return $arr;
    }

    /*
     * USABLE ENDPOINT
     * get all supported countries
    */
    static public function getCountries()
    {
        $arr = TUtil::getSupportedCountries();

        $ret = [];
        foreach($arr as $key=>$val)
        {
            $ret[] = $key;
        }

        $ret = array_unique($ret);

        return $ret;
    }

    static public  function getDomainByCountry($domain, $country)
    {
        $arr = TUtil::getSupportedCountries();
        return $arr[$country][$domain];
    }

    static public function getAmazonTitle($code, $source, $country)
    {
        if ($source == 'amazon')
            $amazonLink = $code;
        if ($source == 'asin')
            $amazonLink = 'http://'.TUtil::getDomainByCountry('amazon', $country).'/gp/product/'.$code;
        if ($source == 'upc')
            $amazonLink = 'http://'.TUtil::getDomainByCountry('amazon', $country).'/s/?field-keywords='.$code;

        $amazonHTML = file_get_html($amazonLink);

        if ($source == 'asin' || $source == 'amazon')
        {
            foreach($amazonHTML->find('#productTitle') as $element)
                return $element->innertext();
        }

        if ($source == 'upc')
        {
            foreach($amazonHTML->find('#s-results-list-atf a.s-access-detail-page') as $element)
                return TUtil::getAmazonTitle($element->href, 'amazon', $country);
        }
    }


    static public function explodeKeywords($title)
    {
        $title = preg_replace('/[^\p{Latin} ]/u', '', $title);
        $temp = explode(' ', $title);

        $return = [];
        for($x=0; $x<count($temp); $x++)
        {
            if (strlen($temp[$x]) > 0)
            {
                $return[] = $temp[$x];
            }
        }

        return $return;
    }

    static public function getTitleCombinations($title)
    {
        $title = trim($title);

        $temp = TUtil::explodeKeywords($title);
        $return = [];
        $lenght = count($temp);
        for ($x=0; $x<$lenght; $x++)
        {
            $return[] = implode(' ', $temp);
            array_pop($temp);
        }

        $temp = TUtil::explodeKeywords($title);
        $lenght = count($temp);
        for ($x=0; $x<$lenght; $x++)
        {
            array_shift($temp);
            $return[] = implode(' ', $temp);
        }

        $temp = TUtil::explodeKeywords($title);
        $lenght = count($temp);
        for ($x=0; $x<$lenght; $x++)
        {
            array_shift($temp);
            array_pop($temp);
            $return[] = implode(' ', $temp);
        }

        $temp = TUtil::explodeKeywords($title);
        $lenght = count($temp);
        for ($x=0; $x<$lenght; $x++)
        {
            array_shift($temp);
            array_shift($temp);
            array_pop($temp);
            $return[] = implode(' ', $temp);
        }

        $temp = TUtil::explodeKeywords($title);
        $lenght = count($temp);
        for ($x=0; $x<$lenght; $x++)
        {
            array_shift($temp);
            array_pop($temp);
            array_pop($temp);
            $return[] = implode(' ', $temp);
        }

        $return = array_unique($return);


        usort($return,'self::lensort');

        return $return;
    }

    static public function getAmazonKeywords($title, $country){
        if (strlen($title) <= 3)
            return;

        $url = 'http://completion.'.TUtil::getDomainByCountry('amazoncompletiondomain', $country).'/search/complete?method=completion&mkt='.TUtil::getDomainByCountry('amazonautocomplete', $country).'&search-alias=aps&q='.urlencode($title);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);


        $result = json_decode($res->getBody());



        $temp = [];
        foreach ($result[1] as $key=>$val){
            $temp['source'][] = $result[0];
            $temp['keyword'][] = $val;
            @$temp['category'][] = $result[2][0]->nodes[$key]->name;
        }

        if (isset($temp['keyword'])&& $temp['keyword'])
            return $temp;
    }


    /**
     * USABLE ENDPOINT
     * Returns sugestion of keywords based on product title
     */
    static public function getSugestedKeywords($title, $country) {
        $arr = TUtil::getTitleCombinations($title);

        $sourceAmazon = [];
        $keywordsAmazon = [];
        $categoryAmazon = [];
        foreach($arr as $key=>$val)
        {

            $tempKW = TUtil::getAmazonKeywords($val, $country);

            if ($tempKW)
            {
                $keywordsAmazon = array_merge($keywordsAmazon, $tempKW['keyword']);
            }

        }

        $keywordsAmazon = array_unique($keywordsAmazon);

        return $keywordsAmazon;
    }

    /**
     * USABLE ENDPOINT
     * Returns product search rank on keyword
     */
    static public function getProductPositionOnKeyword($asin, $keyword, $country, $page=1, $productPosition=1, $totalResults=0) {
        try {
            //require_once("AmazonAPI/amazon_api_class.php");
            //$obj = new AmazonProductAPI();
            //$result = $obj->getItemByKeyword($keyword, "All", TUtil::getDomainByCountry('domain', $country), $page);

            $result=AmazonService::itemSearch($keyword,"All",TUtil::getDomainByCountry('domain', $country),$page);


            //$totalPages = (int)$result->Items->TotalPages;
            $totalPages = (int)$result['Items']['TotalPages'];
            if ($totalResults == 0)
            {
                //$totalResults = (int)$result->Items->TotalResults;
                $totalResults = (int)$result['Items']['TotalResults'];
            }


            //foreach ($result->Items->Item as $key=>$value)
            foreach ($result['Items']['Item']as $key=>$value)
            {
                //$currentAsin = (string)$value->ASIN;
                $currentAsin = (string)$value['ASIN'];
                if ($asin == $currentAsin) {
                    return array(
                        'keyword' => $keyword,
                        'total_results' => $totalResults,
                        'product_position' => $productPosition
                    );
                }
                $productPosition++;
            }

            if (($page < $totalPages) && ($page < 5)) {
                return TUtil::getProductPositionOnKeyword($asin, $keyword, $country, ++$page, $productPosition, $totalResults);
            } else {
                return array(
                    'keyword' => $keyword,
                    'total_results' => $totalResults,
                    'product_position' => '>50'
                );
            }
        } catch (\Exception $e) {
            return array(
                'keyword' => $keyword,
                'total_results' => 'false',
                'product_position' => 'false'
            );
        }
    }



    static public function lensort($a,$b){
        return strlen($b)-strlen($a);
    }

}


?>