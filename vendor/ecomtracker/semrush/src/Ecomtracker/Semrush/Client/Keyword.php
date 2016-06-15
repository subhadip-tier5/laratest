<?php namespace Ecomtracker\Semrush\Client;


use Ecomtracker\Semrush\Client\Keyword\Type;

class Keyword extends Client
{

    /**
     * @description This report provides a summary of a keyword, including its volume, CPC, competition, and the number of results in all regional databases.
     * @external https://www.semrush.com/api-analytics/#phrase_all
     * @param string $phrase
     * @param string $database
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $export_columns
     * @param null|string $display_sort
     * @param null|string $display_filter
     */
    public function getPhraseAll($phrase, $database = null, $export_escape = 1, $export_decode = 0, $export_columns = null, $display_sort = null, $display_filter = null)
    {
        //@todo ajw! change display limit to slightly higher number
        $type = 'phrase_all';
        //@todo ajw! change display limit to slightly higher number
        $options = [
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
            'export_columns' => $export_columns,
        ];
        return $this->makeRequest(Type::TYPE_PHRASE_ALL, ['phrase' => $phrase] + $options);


    }

    /**
     * @description provides a summary of a keyword, including its volume, CPC, competition, and the number of results in a chosen regional database.
     * @external https://www.semrush.com/api-analytics/#phrase_this
     * @param string $phrase
     * @param string $database
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $display_date
     * @param null|string $export_columns
     */
    public function getPhraseThis($phrase, $database = "us", $export_escape = 1, $export_decode = 0, $display_date = null, $export_columns = null)
    {
        //@todo ajw! change display limit to slightly higher number
        $options = [
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,

            'export_columns' => $export_columns,
        ];
        if (isset($display_date)) $options['display_date'] = $display_date;

        return $this->makeRequest(Type::TYPE_PHRASE_THIS, ['phrase' => $phrase] + $options);
    }


    /**
     * @description lists domains that are ranking in Google's top 20 organic search results with a requested keyword
     * @external https://www.semrush.com/api-analytics/#phrase_organic
     * @param string|null $phrase
     * @param string|null $database
     * @param null|int $display_limit
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $display_date
     * @param null|string $export_columns
     */
    public function getPhraseOrganic($phrase, $display_limit = 1, $display_date = null, $database = "us", $export_escape = 1, $export_decode = 0, $export_columns = null)
    {
        //@todo ajw! change display limit to slightly higher number

        $options = [
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
            'export_columns' => $export_columns,
        ];

        if (isset($display_limit)) $options['display_limit'] = $display_limit;
        if (isset($display_date)) $options['display_date'] = $display_date;


        return $this->makeRequest(Type::TYPE_PHRASE_ORGANIC, ['phrase' => $phrase] + $options);

    }


    /**
     * @description lists domains that are ranking in Google's paid search results with a requested keyword
     * @external https://www.semrush.com/api-analytics/#phrase_adwords
     * @param string $phrase
     * @param string $database
     * @param null|int $display_limit
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $display_date
     * @param null|string $export_columns
     */
    public function getPhraseAdwords($phrase, $display_limit = 1, $database = "us", $export_escape = 1, $export_decode = 0, $display_date = null, $export_columns = null)
    {
        //@todo ajw! change display limit to slightly higher number
        $options = [
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
            'export_columns' => $export_columns,
        ];

        if (isset($display_limit)) $options['display_limit'] = $display_limit;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_PHRASE_ADWORDS, ['phrase' => $phrase] + $options);


    }


    /**
     * @description provides an extended list of related keywords, synonyms and variations relevant to a queried term in a chosen database.
     * @external https://www.semrush.com/api-analytics/#phrase_related
     * @param string $phrase
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $display_date
     * @param null|string $export_columns
     * @param null|string $display_sort
     * @param null|string $display_filter
     */
    public function getPhraseRelated($phrase, $display_limit = 1, $display_offset = null, $database = "us", $export_escape = 1, $export_decode = 0, $display_date = null, $export_columns = null, $display_sort = null, $display_filter = null)
    {
        //@todo ajw! change display limit to slightly higher number
        $options = [
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_limit)) $options['display_limit'] = $display_limit;
        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;
        return $this->makeRequest(Type::TYPE_PHRASE_RELATED, ['phrase' => $phrase] + $options);

    }


    /**
     * @description shows domains that have bid on a requested keyword in the last 12 months and their positions in paid search results
     * @external https://www.semrush.com/api-analytics/#phrase_adwords_historical
     * @param string $phrase
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $export_columns
     */
    public function getPhraseAdwordsHistorical($phrase, $display_limit = 1, $display_offset = null, $database = "us", $export_escape = 1, $export_decode = 0, $export_columns = null)
    {
        //@todo ajw! change display limit to slightly higher number
        $options = [
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
            'export_columns' => $export_columns,
            'display_limit' => $display_limit,
        ];


        return $this->makeRequest(Type::TYPE_PHRASE_ADWORDS_HISTORICAL, ['phrase' => $phrase] + $options);


    }


    /**
     * @description offers a list of phrase matches and alternate search queries, including particular keywords or keyword expressions
     * @external https://www.semrush.com/api-analytics/#phrase_fullsearch
     * @param string $phrase
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $export_columns
     * @param null|string $display_sort
     * @param null|string $display_filter
     */
    public function getPhraseFullsearch($phrase, $display_limit = 1, $display_offset = null, $display_sort = null, $display_filter = null, $database = "us", $export_escape = 1, $export_decode = 0, $export_columns = null)
    {
        //@todo ajw! change display limit to slightly higher number
        $options = [
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($export_columns)) $options['export_columns'] = $export_columns;
        if (isset($display_limit)) $options['display_limit'] = $display_limit;
        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        return $this->makeRequest(Type::TYPE_PHRASE_FULLSEARCH, ['phrase' => $phrase] + $options);
    }

    /**
     * @description provides keyword difficulty, an index that helps to estimate how difficult it would be to seize competitor's positions in organic search within the Google's top 20 with an indicated search term.
     * @external https://www.semrush.com/api-analytics/#phrase_kdi
     * @param $key
     * @param $phrase
     * @param string $database
     * @param int $export_escape
     * @param null $export_columns
     */
    public function getPhraseKdi($phrase, $database = "us", $export_escape = 1, $export_columns = null)
    {
        $type = 'phrase_kdi';
        $options = [
            'database' => $database,
            'export_escape' => $export_escape,
            'export_columns' => $export_columns,
        ];

        return $this->makeRequest(Type::TYPE_PHRASE_KDI, ['phrase' => $phrase] + $options);
    }


}