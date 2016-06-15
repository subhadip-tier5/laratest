<?php namespace Ecomtracker\Api\Http\Responses\Keyword\Organic;

use Ecomtracker\Api\Http\Responses\DistributionResponseTrait;
use Ecomtracker\Api\Http\Responses\TrendResponseTrait;
use Illuminate\Http\JsonResponse;

class TrendResponse extends JsonResponse
{
    use TrendResponseTrait;
    
    public function getData($assoc = false, $depth = 512)
    {
        return $this->data;

    }


}