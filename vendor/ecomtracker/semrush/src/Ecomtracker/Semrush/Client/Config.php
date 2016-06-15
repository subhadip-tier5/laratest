<?php namespace Ecomtracker\Semrush\Client;

class Config extends \Illuminate\Config\Repository
{
    /**
     * Config constructor.
     * @param $key api key for accessing SEMrush
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }


}