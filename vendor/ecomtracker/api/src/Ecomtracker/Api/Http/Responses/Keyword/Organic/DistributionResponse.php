<?php namespace Ecomtracker\Api\Http\Responses\Keyword\Organic;

use Ecomtracker\Api\Http\Responses\DistributionResponseTrait;
use Illuminate\Http\JsonResponse;

class DistributionResponse extends JsonResponse
{
    use DistributionResponseTrait;
    
    public function getData($assoc = false, $depth = 512)
    {

        return $this->data;

    }


}