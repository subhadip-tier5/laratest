<?php Ecomtracker\Semrush\Client\Cache;


use Ecomtracker\Semrush\Client\Request;
use Ecomtracker\Semrush\Client\Result;

interface CacheInterface {

    /**
     * Save the result for a given request
     *
     * @param Request $request
     * @param Result $result
     * @return mixed
     */
    public function cache(Request $request, Result $result);

    /**
     * Fetch the result for a given request
     *
     * @param Request $request
     * @return Result|null
     */
    public function fetch(Request $request);

} 