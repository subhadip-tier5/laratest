<?php namespace Ecomtracker\Semrush\Client;


class Backlink extends Client
{
    /**
     * @description provides a summary of backlinks, including their type, referrring domains and IP addresses for a domain, root domain, or URL.
     * @external https://www.semrush.com/api-analytics/#backlinks_overview
     * @param string $key
     * @param string $target
     * @param string $target_type
     */
    public function getBacklinksOverview($key, $target, $target_type = "domain")
    {
        $type = 'backlinks_overview';

    }

    /**
     * @description lists backlinks for a domain, root domain or URL
     * @external https://www.semrush.com/api-analytics/#backlinks
     * @param string $key
     * @param string $target
     * @param string $target_type
     * @param null|int $display_offset
     * @param null|int $export_columns
     * @param null|string $display_sort
     * @param null|string $display_filter
     */
    public function getBacklinks($key, $target, $target_type = "domain", $display_offset = null, $export_columns = null, $display_sort = null, $display_filter = null)
    {
        $type = 'backlinks';
    }

    /**
     * @description lists domains pointing to the queried domain, root domain, or URL.
     * @external https://www.semrush.com/api-analytics/#backlinks_overview
     * @param string|$key
     * @param string|$target
     * @param string $target_type
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param null|string $export_columns
     * @param null|string $display_sort
     * @param null|string $display_filter
     */
    public function getBacklinksRefdomains($key, $target, $target_type = "domain", $display_limit = null, $display_offset = null, $export_columns = null, $display_sort = null, $display_filter = null)
    {
        $type = 'backlinks_refdomains';
    }

    /**
     * @description lists IP addresses where backlinks to a domain, root domain, or URL are coming from.
     * @external https://www.semrush.com/api-analytics/#backlinks_refips
     * @param string $key
     * @param string $target
     * @param string $target_type
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param null|string $export_columns
     * @param null|string $display_sort
     */
    public function getBacklinksRefips($key, $target, $target_type = "domain", $display_limit = null, $display_offset = null, $export_columns = null, $display_sort = null)
    {
        $type = 'backlinks_refips';
    }

    /**
     * @description shows referring domain distributions depending on their top-level domain type
     * @external https://www.semrush.com/api-analytics/#backlinks_tld
     * @param string $key
     * @param string $target
     * @param string $target_type
     * @param null|string $export_columns
     * @param null|string $display_sort
     */
    public function getBacklinksTld($key, $target, $target_type = "domain", $export_columns = null, $display_sort = null)
    {
        $type = 'backlinks_tld';
    }

    /**
     * @description shows referring domain distributions by country(an IP address defines a country).
     * @external https://www.semrush.com/api-analytics/#backlinks_geo
     * @param string $key
     * @param string $target
     * @param string $target_type
     * @param null|string $export_columns
     * @param null|string $display_sort
     */
    public function getBacklinksGeo($key, $target, $target_type = "domain", $export_columns = null, $display_sort = null)
    {
        $type = 'backlinks_geo';
    }

    /**
     * @description lists anchor texts used in backlinks leading to the queried domain, root domain, or URL. It also includes the number of backlinks and referring domains per anchor
     * @external https://www.semrush.com/api-analytics/#backlinks_anchors
     * @param string $key
     * @param string $target
     * @param string $target_type
     * @param null|string $export_columns
     * @param null|string $display_sort
     */
    public function getBacklinksAnchors($key, $target, $target_type = "domain", $export_columns = null, $display_sort = null)
    {
        $type = 'backlinks_anchors';
    }

    /**
     * @description shows indexed pages of the queried domain
     * @external https://www.semrush.com/api-analytics/#backlinks_pages
     * @param string $key
     * @param string $target
     * @param string $target_type
     * @param null|string $export_columns
     * @param null|string $display_sort
     */
    public function getBacklinksPages($key, $target, $target_type = "domain", $export_columns = null, $display_sort = null)
    {
        $type = 'backlinks_pages';
    }

}