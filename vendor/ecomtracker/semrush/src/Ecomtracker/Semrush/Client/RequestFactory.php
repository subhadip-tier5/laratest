<?php namespace Ecomtracker\Semrush\Client;

class RequestFactory
{
    /**
     * Get a request
     *
     * @param string $type
     * @param array $options
     * @return Request
     */
    public function create($type, $options)
    {
        return new Request($type, $options);
    }
}