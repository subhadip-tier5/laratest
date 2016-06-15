<?php namespace Ecomtracker\Semrush\Client;

class Url extends Client
{

    /**
     * @description lists keywords that bring users to a URL via google's top 20 organic search results
     * @external https://www.semrush.com/api-analytics/#url_organic
     * @param $key
     * @param $url
     * @param string $database
     * @param null $display_limit
     * @param null $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null $display_date
     * @param null $export_columns
     */
   public function getUrlOrganic($key, $url, $database = "us", $display_limit = null, $display_offset = null, $export_escape = 1, $export_decode = 1, $display_date = null,$export_columns = null)
   {
    $type = 'url_organic';

   }

    /**
     * @description lists keywords that bring users to a URL via Google's paid search results.
     * @external https://www.semrush.com/api-analytics/#url_adwords
     * @param string $key
     * @param string $url
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $display_date
     * @param null|string $export_columns
     */
    public function getUrlAdwords($key, $url, $database = "us", $display_limit = null, $display_offset = null, $export_escape = 1, $export_decode = 1, $display_date = null,$export_columns = null)
    {
        $type = 'url_adwords';

    }







}