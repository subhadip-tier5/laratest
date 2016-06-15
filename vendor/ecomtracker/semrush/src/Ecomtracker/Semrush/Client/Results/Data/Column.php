<?php namespace Ecomtracker\Semrush\Client\Results\Data;

use Ecomtracker\Semrush\Client\ConstantTrait;

class Column
{
    use ConstantTrait;


    const COLUMN_ADWORDS_CHANGE_COUNT = "Am";
    const COLUMN_ADWORDS_CHANGE_TRAFFIC = "Bm";
    const COLUMN_ADWORDS_CHANGE_TRAFFIC_PRICE = "Cm";
    const COLUMN_COMPETITION_LEVEL = "Cr";
    const COLUMN_KEYWORD_COVERAGE = "Cv";
    const COLUMN_REPORT_HAS_HISTORICAL_DATA = "Hs";
    const COLUMN_IP_ADDRESS = "Ip";
    const COLUMN_API_UNITS_PER_LINE = "Lc";
    const COLUMN_LINES_REQUESTED_FOR_REPORT = "Li";
    const COLUMN_COMMON_KEYWORDS = "Np";
    const COLUMN_REQUESTED_DISPLAY_OFFSET = "Of";
    const COLUMN_ORGANIC_COUNT_CHANGE = "Om";
    const COLUMN_COMPARISON_ORGANIC_1_POSITION = "P0";
    const COLUMN_COMPARISON_ORGANIC_2_POSITION = "P1";
    const COLUMN_COMPARISON_ORGANIC_3_POSITION = "P2";
    const COLUMN_COMPARISON_ORGANIC_4_POSITION = "P4";
    const COLUMN_PRODUCT_LISTING_TITLE = "Pr";
    const COLUMN_SEMRUSH_RATING = "Rh";
    const COLUMN_REPORT_TYPE = "Rt";
    const COLUMN_ADWORDS_SITE_KEYWORDS = "Sh";
    const COLUMN_ORGANIC_CHANGE_TRAFFIC = "Tm";
    const COLUMN_TIMESTAMP = "Ts";
    const COLUMN_ORGANIC_CHANGE_TRAFFIC_COST = "Um";
    const COLUMN_ADWORDS_ADS_COUNT = "ads_count";
    const COLUMN_ADWORDS_ADS_COUNT_ALLTIME = "ads_overall";
    const COLUMN_ADWORDS_ADVERTISERS_COUNT = "advertisers_count";
    const COLUMN_ADWORDS_ADVERTISERS_COUNT_ALLTIME = "advertisers_overall";

    const COLUMN_OVERVIEW_ADWORDS_BUDGET = "Ac";
    const COLUMN_OVERVIEW_ADWORDS_KEYWORDS = "Ad";
    const COLUMN_OVERVIEW_ADWORDS_TRAFFIC = "At";
    const COLUMN_OVERVIEW_DATABASE = "Db";
    const COLUMN_OVERVIEW_DOMAIN = "Dn";
    const COLUMN_OVERVIEW_ORGANIC_BUDGET = "Oc";
    const COLUMN_OVERVIEW_ORGANIC_KEYWORDS = "Or";
    const COLUMN_OVERVIEW_ORGANIC_TRAFFIC = "Ot";
    const COLUMN_OVERVIEW_SEMRUSH_RATING = "Rk";
    const COLUMN_OVERVIEW_DATE = "Dt";
    const COLUMN_DOMAIN_KEYWORD = "Ph";
    const COLUMN_DOMAIN_KEYWORD_ORGANIC_POSITION = "Po";
    const COLUMN_DOMAIN_KEYWORD_PREVIOUS_ORGANIC_POSITION = "Pp";
    const COLUMN_KEYWORD_AVERAGE_QUERIES = "Nq";
    const COLUMN_KEYWORD_AVERAGE_CLICK_PRICE = "Cp";
    const COLUMN_DOMAIN_KEYWORD_TRAFFIC_PERCENTAGE = "Tr";
    const COLUMN_KEYWORD_ESTIMATED_PRICE = "Tc";
    const COLUMN_KEYWORD_DIFFICULTY_INDEX = "Kd";
    const COLUMN_KEYWORD_COMPETITIVE_AD_DENSITY = "Co";
    const COLUMN_KEYWORD_ORGANIC_NUMBER_OF_RESULTS = "Nr";
    const COLUMN_KEYWORD_INTEREST = "Td";
    const COLUMN_DOMAIN_KEYWORD_AD_TITLE = "Tt";
    const COLUMN_DOMAIN_KEYWORD_AD_TEXT = "Ds";
    const COLUMN_DOMAIN_KEYWORD_VISIBLE_URL = "Vu";
    const COLUMN_DOMAIN_KEYWORD_TARGET_URL = "Ur";
    const COLUMN_DOMAIN_KEYWORD_NUMBER = "Pc";
    const COLUMN_DOMAIN_KEYWORD_POSITION_DIFFERENCE = "Pd";
    const COLUMN_DOMAIN_ADWORD_POSITION = "Ab";

    /**
     * Get all the possible columns
     *
     * @return string[]
     */
    public static function getColumns()
    {
        return self::getConstants();
    }

    /**
     * Check if the given code is a valid column code
     *
     * @param string $code
     * @return bool
     */
    public static function isValidColumn($code)
    {
        return in_array($code, self::getColumns());
    }
}