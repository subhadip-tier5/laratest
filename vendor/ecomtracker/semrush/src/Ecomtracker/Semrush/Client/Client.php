<?php namespace Ecomtracker\Semrush\Client;

use GuzzleHttp\Client as GuzzleClient;
class Client
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var ResponseParser
     */
    protected $responseParser;

    /**
     * @var UrlBuilder
     */
    protected $urlBuilder;

    /**
     * @var GuzzleClient
     */
    protected $guzzle;

    /**
     * @var CacheInterface
     */
    protected $cache;


    /**
     * Construct a client with API key
     *
     * @param string $apiKey
     * @param RequestFactory $requestFactory
     * @param ResultFactory $resultFactory
     * @param ResponseParser $responseParser
     * @param UrlBuilder $urlBuilder
     * @param GuzzleClient $guzzle
     */
    public function __construct($apiKey, RequestFactory $requestFactory, ResultFactory $resultFactory, ResponseParser $responseParser, UrlBuilder $urlBuilder, GuzzleClient $guzzle)
    {
        $this->apiKey = $apiKey;
        $this->requestFactory = $requestFactory;
        $this->resultFactory = $resultFactory;
        $this->responseParser = $responseParser;
        $this->urlBuilder = $urlBuilder;
        $this->guzzle = $guzzle;
    }

    /**
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }



    /**
     * Make the request
     *
     * @param string $type
     * @param array $options
     * @return ApiResult
     */
    protected function makeRequest($type, $options)
    {
        $request = $this->requestFactory->create($type, ['key' => $this->apiKey] + $options);

        // Attempt load from cache
        if (isset($this->cache)) {
            $result = $this->cache->fetch($request);
        }

        // Make request if not in cache
        if (!isset($result)) {
            $rawResponse = $this->makeHttpRequest($request);
            $formattedResponse = $this->responseParser->parseResult($request, $rawResponse);
            $result = $this->resultFactory->create($formattedResponse);

        }

        // Save to cache
        if (isset($this->cache)) {
            $this->cache->cache($request, $result);
        }

        return $result;
    }

    /**
     * Use guzzle to make request to API
     *
     * @param Request $request
     * @return string
     */
    protected function makeHttpRequest($request)
    {
        $url = $this->urlBuilder->build($request);
        $guzzleResponse = $this->guzzle->request('GET', $url, []);
        return $guzzleResponse->getBody();
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
    
    
    
}