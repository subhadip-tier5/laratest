<?php namespace Ecomtracker\Semrush\Client\Keyword;

use Ecomtracker\Semrush\Client\ConstantTrait;

class Type
{
    use ConstantTrait;

    const TYPE_PHRASE_THIS = "phrase_this";
    const TYPE_PHRASE_ALL = "phrase_all";
    const TYPE_PHRASE_ORGANIC = "phrase_organic";
    const TYPE_PHRASE_ADWORDS = "phrase_adwords";
    const TYPE_PHRASE_RELATED = "phrase_related";
    const TYPE_PHRASE_ADWORDS_HISTORICAL = "phrase_adwords_historical";
    const TYPE_PHRASE_FULLSEARCH = "phrase_fullsearch";
    const TYPE_PHRASE_KDI = "phrase_kdi";


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