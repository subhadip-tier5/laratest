<?php namespace Ecomtracker\Semrush\Client;


use Ecomtracker\Semrush\Client\Domain\Type;

class Domain extends Client
{
    public $domain;
    public $database;
    public $display_date;


    /**
     * @description provides live or historical data on a domain's keyword rankings in both organic and paid search in all regional databases
     * @external https://www.semrush.com/api-analytics/#domain_ranks
     * @param string $domain
     * @param string $database
     * @param null $display_date
     * @param null $export_columns
     */
    public function getDomainRanks($domain, $display_date = null, $database = "us", $export_columns = null)
    {
        $options = [
            'domain' => $domain,
            'database' => $database,

        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_DOMAIN_RANKS, ['domain' => $domain] + $options);

    }

    /**
     * @description provides live or historical data on domain's keyword rankings in both organic and paid search in a chosen regional database
     * @external https://www.semrush.com/api-analytics/#domain_ranks
     * @param string $domain
     * @param string $database
     * @param null $display_date
     * @param null $export_columns
     */
    public function getDomainRank($domain, $display_date = null, $database = "us", $display_date = null, $export_columns = null)
    {
        $options = [
            'domain' => $domain,
            'database' => $database,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_DOMAIN_RANK, ['domain' => $domain] + $options);

    }


    /**
     * @description lists the most popular domains ranked by traffic originating from Google's top 20 organic search results
     * @external https://www.semrush.com/api-analytics/#rank_difference
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $display_date
     * @param null|string $export_columns
     * @param null|string $display_sort
     */
    public function getRankDifference($domain, $display_limit = 1, $database = 'us', $display_offset = null, $export_escape = 1, $export_decode = 1, $display_date = null, $export_columns = null, $display_sort = null)
    {

        $options = [
            'domain' => $domain,
            'display_limit' => $display_limit,
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_RANK_DIFFERENCE, ['domain' => $domain] + $options);

    }


    /**
     * @description lists the most popular domains ranked by traffic originating from google's top 20 organic search results
     * @external https://www.semrush.com/api-analytics/#rank
     * @param string $type
     * @param string $database
     * @param null $display_limit
     * @param null $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null $display_date
     * @param null $export_columns
     */
    public function getRank($domain, $database = "us", $display_limit = 1, $display_offset = null, $export_escape = 1, $export_decode = 0, $display_date = null, $export_columns = null)
    {
        $options = [
            'domain' => $domain,
            'display_limit' => $display_limit,
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_RANK, ['domain' => $domain] + $options);
    }


    /**
     * @description lists keywords that bring users to a domain via Google's top 20 organic search results.
     * @external https://www.semrush.com/api-analytics/#domain_organic
     * @param string $type
     * @param string $key
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null $display_date
     * @param null $export_columns
     */
    public function getDomainOrganic($domain, $display_limit = 5, $display_date = null, $database = "us", $display_offset = null, $export_escape = 1, $export_decode = 0, $export_columns = null)
    {
        $options = [
            'domain' => $domain,
            'display_limit' => $display_limit,
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_DOMAIN_ORGANIC, ['domain' => $domain] + $options);

    }


    /**
     * @description lists keywords that bring users to a domain via Google's paid search results.
     * @external https://www.semrush.com/api-analytics/#domain_adwords
     * @param string $type
     * @param string $key
     * @param string $domain
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $display_date
     * @param null|string $export_columns
     * @param null|string $display_sort
     * @param null|string $display_positions
     * @param null|string $display_filter
     */
    public function getDomainAdwords($domain, $display_limit = 2, $display_date = null, $database = "us", $display_offset = null, $export_escape = 1, $export_decode = 0, $export_columns = null, $display_sort = null, $display_positions = null, $display_filter = null)
    {
        $options = [
            'domain' => $domain,
            'display_limit' => $display_limit,
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_DOMAIN_ADWORDS, ['domain' => $domain] + $options);
    }


    /**
     * @description shows unique ad copies SEMrush noticed when the domain ranked in Google's paid search results for keywords from semrush's databases
     * @external https://www.semrush.com/api-analytics/#domain_adwords_unique
     * @param string $key
     * @param string $domain
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $export_columns
     * @param null|string $display_filter
     */
    public function getDomainAdwordsUnique($domain, $display_limit = 1, $database = "us", $display_offset = null, $export_escape = 1, $export_decode = 0, $export_columns = null, $display_filter = null)
    {
        $options = [
            'domain' => $domain,
            'display_limit' => $display_limit,
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_DOMAIN_ADWORDS_UNIQUE, ['domain' => $domain] + $options);

    }

    /**
     * @description
     * @external https://www.semrush.com/api-analytics/#domain_organic_organic
     * @param string $domain
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $display_date
     * @param null|string $export_columns
     * @param null|string $display_sort
     */
    public function getDomainOrganicOrganic($domain, $display_limit = 5, $display_offset = null, $database = "us", $export_escape = 1, $export_decode = 0, $display_date = null, $export_columns = null, $display_sort = null)
    {
        $options = [
            'display_limit' => $display_limit,
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_DOMAIN_ORGANIC_ORGANIC, ['domain' => $domain] + $options);

    }


    /**
     * @description list a domain's competitors in paid search results
     * @external https://www.semrush.com/api-analytics/#domain_organic_organic
     * @param string $key
     * @param string $domain
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $display_date
     * @param null|string $export_columns
     * @param null|string $display_sort
     * @param string $type
     */
    public function getDomainAdwordsAdwords($domain, $display_limit = 1, $database = "us", $display_offset = null, $export_escape = 1, $export_decode = 0, $display_date = null, $export_columns = null, $display_sort = null)
    {
        $options = [
            'domain' => $domain,
            'display_limit' => $display_limit,
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_DOMAIN_ADWORDS_ADWORDS, ['domain' => $domain] + $options);

    }


    /**
     * @description shows keywords a domain has bid on in the last 12 months and its positions in paid search results
     * @external https://www.semrush.com/api-analytics/#domain_adwords_historical
     * @param string $type
     * @param string $key
     * @param string $domain
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $export_columns
     * @param null|string $display_sort
     * @param null|string $display_filter
     */
    public function getAdwordsHistorical($domain, $display_limit = 1, $database = "us", $display_offset = null, $export_escape = 1, $export_decode = 0, $export_columns = null, $display_sort = null, $display_filter = null)
    {
        $options = [
            'domain' => $domain,
            'display_limit' => $display_limit,
            'database' => $database,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_DOMAIN_ADWORDS_HISTORICAL, ['domain' => $domain] + $options);

    }


    /**
     * @description allows users to compare up to five domains by common keywords, unique keywords, all keywords, or search terms that are unique to that first domain.
     * @external https://www.semrush.com/api-analytics/#domain_adwords_historical
     * @param string $key
     * @param string $domains
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null| string $display_date
     * @param null| string $export_columns
     * @param null|string $display_sort
     * @param null|string $display_filter
     */
    public function getDomainDomains($domains, $display_limit = 1, $database = "us", $display_offset = null, $export_escape = 1, $export_decode = 0, $display_date = null, $export_columns = null, $display_sort = null, $display_filter = null)
    {
        $options = [
            'domain' => $domains,
            'display_limit' => $display_limit,
            'database' => $database,
            'display_limit' => $display_limit,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_DOMAIN_DOMAINS, ['domains' => $domains] + $options);

    }


    /**
     * @description lists keywords that trigger a domain's product listing ads to appear in Google's paid search results.
     * @external https://www.semrush.com/api-analytics/#domain_shopping
     * @param string $key
     * @param string $domain
     * @param string $database
     * @param null $display_limit
     * @param null $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null $export_columns
     * @param null $display_sort
     * @param null $display_filter
     */
    public function getDomainShopping($key, $domain, $database = "us", $display_limit = 1, $display_offset = null, $export_escape = 1, $export_decode = 0, $export_columns = null, $display_sort = null, $display_filter = null)
    {
        $options = [
            'domain' => $domain,
            'display_limit' => $display_limit,
            'database' => $database,
            'display_limit' => $display_limit,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_DOMAIN_SHOPPING, ['domain' => $domain] + $options);

    }


    /**
     * @description shows product listing ad copies SEMrush noticed when the domain ranked in Google's paid search results for keywords from our databases
     * @external https://www.semrush.com/api-analytics/#domain_shopping_unique
     * @param string $key
     * @param string $domain
     * @param string $database
     * @param null|int $display_limit
     * @param null|int $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null|string $export_columns
     * @param null|string $display_filter
     */
    public function getDomainShoppingUnique($domain, $display_limit = 1, $database = "us", $display_offset = null, $export_escape = 1, $export_decode = 0, $export_columns = null, $display_filter = null)
    {
        $options = [
            'domain' => $domain,
            'display_limit' => $display_limit,
            'database' => $database,
            'display_limit' => $display_limit,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;
        return $this->makeRequest(Type::TYPE_DOMAIN_SHOPPING_UNIQUE, ['domain' => $domain] + $options);
    }


    /**
     * @description lists domains a queried domain is competing against in google's paid search results with product listing ads
     * @external https://www.semrush.com/api-analytics/#domain_shopping_shopping
     * @param $key
     * @param $domain
     * @param string $database
     * @param null $display_limit
     * @param null $display_offset
     * @param int $export_escape
     * @param int $export_decode
     * @param null $display_sort
     * @param null $display_filter
     */
    public function getDomainShoppingShopping($domain, $display_limit = 1, $database = "us", $display_offset = null, $export_escape = 1, $export_decode = 0, $display_sort = null, $display_filter = null)
    {
        $options = [
            'domain' => $domain,
            'display_limit' => $display_limit,
            'database' => $database,
            'display_limit' => $display_limit,
            'export_escape' => $export_escape,
            'export_decode' => $export_decode,
        ];

        if (isset($display_offset)) $options['display_offset'] = $display_offset;
        if (isset($display_date)) $options['display_date'] = $display_date;
        if (isset($display_sort)) $options['display_sort'] = $display_sort;
        if (isset($display_filter)) $options['display_filter'] = $display_filter;
        if (isset($export_columns)) $options['export_columns'] = $export_columns;

        return $this->makeRequest(Type::TYPE_DOMAIN_SHOPPING_SHOPPING, ['domain' => $domain] + $options);

    }


}