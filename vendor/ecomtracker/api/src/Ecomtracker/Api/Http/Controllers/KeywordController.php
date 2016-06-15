<?php namespace Ecomtracker\Api\Http\Controllers;

use EcomTracker\Exceptions\ApiException;
use Ecomtracker\Keyword\Http\Requests\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\DestroyRequest;
use Ecomtracker\Keyword\Http\Requests\StoreRequest;
use Ecomtracker\Keyword\Http\Requests\UpdateRequest;


/**
 * Class KeywordController
 *
 * @package Ecomtracker\Api\Http\Controllers
 */

class KeywordController extends \Ecomtracker\Keyword\Http\Controllers\KeywordController
{
    /**
     * Return the User Model Data
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}",
     *     description="Returns a keyword object",
     *     operationId="api1.keyword.show",
     *     produces={"application/json"},
     *     tags={"keyword"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="number",
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


    public function show(ShowRequest $request, $id = null)
    {
        return parent::show($request,$id);
    }


    /**
     * Store a keyword record
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/keyword",
     *     description="Create a keyword object",
     *     operationId="api1.keyword.store",
     *     produces={"application/json"},
     *     tags={"keyword"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="value",
     *          in="formData",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="amazon_product_id",
     *          in="formData",
     *          type="string",
     *          required=false,
     *      ),
     *      @SWG\Parameter(
     *          name="amazon_marketplace",
     *          in="formData",
     *          type="string",
     *          required=false,
     *      ),
     *      @SWG\Parameter(
     *          name="source_id",
     *          in="formData",
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

    public function store(StoreRequest $request)
    {
        return parent::store($request);
    }



    /**
     * Update a keyword record
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Put(
     *     path="/api1/keyword/{id}",
     *     description="Update a keyword object",
     *     operationId="api1.keyword.update",
     *     produces={"application/json"},
     *     tags={"keyword"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="number",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="value",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="source_id",
     *          in="formData",
     *          type="number",
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

    public function update(UpdateRequest $request, $id = null)
    {
        return parent::update($request,$id);
    }



    /**
     * Destroy a keyword record
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Delete(
     *     path="/api1/keyword/{id}",
     *     description="Destroy a user object",
     *     operationId="api1.keyword.destroy",
     *     produces={"application/json"},
     *     tags={"keyword"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="number",
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



    public function destroy(DestroyRequest $request, $id = null)
    {
        try{
            $response = parent::destroy($request,$id);
        }catch(ApiException $e)
        {


        }


    }





}