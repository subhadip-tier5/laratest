<?php namespace Ecomtracker\Api\Http\Controllers\Product;

use Ecomtracker\Product\Http\Requests\Keywords\ShowRequest;

class KeywordsController extends \Ecomtracker\Product\Http\Controllers\KeywordsController
{

    /**
     * Authenticate against the system
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/product/{id}/keywords",
     *     description="Returns a keyword collection based on the provided product id",
     *     operationId="api1.product.keywords",
     *     produces={"application/json"},
     *     tags={"product"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="operation_field",
     *          in="query",
     *          type="string",
     *          description="The field to use for the operation",
     *          required=false,
     *      ),
     *      @SWG\Parameter(
     *          name="operation",
     *          in="query",
     *          type="string",
     *          description="sum|avg|sort",
     *          required=false
     *      ),
     *      @SWG\Parameter(
     *          name="dir",
     *          in="query",
     *          type="string",
     *          description="Direction to sort asc|desc",
     *          required=false,
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */



    public function show(ShowRequest $request, $product_id = null)
    {
        return parent::show($request,$product_id);
    } 
}