<?php Ecomtracker\Semrush\Client\Cache;

use SerialiseRequest;
use Ecomtracker\Semrush\Client\Request;
use Ecomtracker\Semrush\Client\Result;

class MemoryCache implements CacheInterface {

    use SerialiseRequest;

    /**
     * @var Result
     */
    protected $cache = [];

    /**
     * Save the result for a given request
     *
     * @param Request $request
     * @param Result $result
     * @return mixed
     */
    public function cache(Request $request, Result $result)
    {
        $key = $this->serialise($request);
        $this->cache[$key] = $result;
    }

    /**
     * Fetch the result for a given request
     *
     * @param Request $request
     * @return Result|null
     */
    public function fetch(Request $request)
    {
        $key = $this->serialise($request);
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }
    }
}