<?php namespace Ecomtracker\Semrush\Client;


class Publisher extends Client
{


    /**
     * @description lists display ads that have appeared on a publisher's website
     * @external https://www.semrush.com/api-analytics/#publisher_text_ads
     * @param string $key
     * @param string $domain
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $export_columns
     * @param null|string $display_sort
     * @param null|string $device_type
     * @param null|string $display_filter
     */
    public function getPublisherTextAds($key, $domain, $display_limit = null, $display_offset = null, $export_escape = 1, $export_decode = 1, $export_columns = null, $display_sort = null, $device_type = null, $display_filter = null)
    {
        $type = 'publisher_text_ads';
        $action = 'report';
        $export = 'api';
    }


    /**
     * @description lists publisher's websites where an advertiser's display ads have appeared
     * @external https://www.semrush.com/api-analytics/#publisher_advertisers
     * @param $key
     * @param $domain
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param nullstring $export_columns
     * @param null|string $display_sort
     * @param null|string $device_type
     * @param null|string $display_filter
     */
    public function getPublisherAdvertisers($key, $domain, $display_limit = null, $display_offset = null, $export_escape = 1, $export_decode = 1, $export_columns = null, $display_sort = null, $device_type = null, $display_filter = null)
    {
        $type = 'publisher_advertisers';
        $action = 'report';
        $export = 'api';
     }


    /**
     * @description lists display ads of a queried advertiser's website
     * @external https://www.semrush.com/api-analytics/#advertiser_text_ads
     * @param string $key
     * @param string $domain
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $export_columns
     * @param null|string $display_sort
     * @param null|string $device_type
     * @param null|string $display_filter
     */
    public function getAdvertiserTextAds($key, $domain, $display_limit = null, $display_offset = null, $export_escape = 1, $export_decode = 1, $export_columns = null, $display_sort = null, $device_type = null, $display_filter = null)
    {
        $type ='advertiser_text_ads';
        $action = 'report';
        $export = 'api';
    }


    /**
     * @description lists URLs of a domain's landing pages promoted via display ads.
     * @external https://www.semrush.com/api-analytics/#advertiser_landings
     * @param string $key
     * @param string $domain
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $export_columns
     * @param null|string $display_sort
     * @param null|string $device_type
     * @param null|string $display_filter
     */
    public function getAdvertiserLandings($key, $domain, $display_limit = null, $display_offset = null, $export_escape = 1, $export_decode = 1, $export_columns = null, $display_sort = null, $device_type = null, $display_filter = null)
    {
        $type ='advertiser_landings';
        $action = 'report';
        $export = 'api';
    }

    /**
     * @description lists the display ads of a given advertiser that have appeared on a particular publisher's website
     * @external https://www.semrush.com/api-analytics/#advertiser_publisher_text_ads
     * @param string $key
     * @param string $domain
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $export_columns
     * @param null|string $display_sort
     * @param null|string $device_type
     * @param null|string $display_filter
     */
    public function getAdvertiserPublisherTextAds($key, $domain, $display_limit = null, $display_offset = null, $export_escape = 1, $export_decode = 1, $export_columns = null, $display_sort = null, $device_type = null, $display_filter = null)
    {
        $type = 'advertiser_publisher_text_ads';
        $action = 'report';
        $export = 'api';

    }

    /**
     * @description lists advertisers ranked by the total number of display ads noticed by SEMrush.
     * @external https://www.semrush.com/api-analytics/#advertiser_rank
     * @param string $key
     * @param string $domain
     * @param int $export_escape
     * @param null|string $export_columns
     * @param null|string $device_type
     */
    public function getAdvertiserRank($key, $domain, $export_escape = 1, $export_columns = null, $device_type = null)
    {
        $type = 'advertiser_rank';
        $action = 'report';
        $export = 'api';
    }

    /**
     * @description lists publishers ranked by the total number of display ads noticed by SEMrush.
     * @external https://www.semrush.com/api-analytics/#publisher_rank
     * @param string $key
     * @param string $domain
     * @param int $export_escape
     * @param null|string $export_columns
     * @param null|string $device_type
     */
    public function getPublisherRank($key, $domain, $export_escape = 1,$export_columns = null, $device_type = null)
    {
        $type = 'publisher_rank';
        $action = 'report';
        $export = 'api';

    }



}