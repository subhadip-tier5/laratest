<?php namespace Ecomtracker\Api\Http\Controllers;

use EcomTracker\Exceptions\ApiException;
use Ecomtracker\Source\Http\Requests\IndexRequest;

/**
 * Class SourceController
 *
 * @package Ecomtracker\Api\Http\Controllers
 */

class SourceController extends \Ecomtracker\Source\Http\Controllers\SourceController
{
    /**
     * Return Source Model Collection
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/source",
     *     description="Returns source collection",
     *     operationId="api1.soruce.index",
     *     produces={"application/json"},
     *     tags={"source"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */


    public function index(IndexRequest $request, $source_id = null)
    {
        return parent::index($request,$source_id);
    }
    
    
  




}