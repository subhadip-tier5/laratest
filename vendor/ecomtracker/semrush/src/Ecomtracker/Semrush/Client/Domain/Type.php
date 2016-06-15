<?php namespace Ecomtracker\Semrush\Client\Domain;

use Ecomtracker\Semrush\Client\ConstantTrait;

class Type
{
    use ConstantTrait;

    const TYPE_DOMAIN_RANKS = "domain_ranks";
    const TYPE_DOMAIN_RANK = "domain_rank";
    const TYPE_RANK_DIFFERENCE = "rank_difference";
    const TYPE_RANK = "rank";
    const TYPE_DOMAIN_ORGANIC = "domain_organic";
    const TYPE_DOMAIN_ADWORDS = "domain_adwords";
    const TYPE_DOMAIN_ADWORDS_UNIQUE = "domain_adwords_unique";
    const TYPE_DOMAIN_ORGANIC_ORGANIC = "domain_organic_organic";
    const TYPE_DOMAIN_ADWORDS_ADWORDS = "domain_adwords_adwords";
    const TYPE_DOMAIN_ADWORDS_HISTORICAL = "domain_adwords_historical";
    const TYPE_DOMAIN_DOMAINS = "domain_domains";
    const TYPE_DOMAIN_SHOPPING = "domain_shopping";
    const TYPE_DOMAIN_SHOPPING_UNIQUE = "domain_shopping_unique";
    const TYPE_DOMAIN_SHOPPING_SHOPPING = "domain_shopping_shopping";

    /**
     * Get all the possible columns
     *
     * @return string[]
     */
    public static function getTypes()
    {
        return self::getConstants();
    }
}