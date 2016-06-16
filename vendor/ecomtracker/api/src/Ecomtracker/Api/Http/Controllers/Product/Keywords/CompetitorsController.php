<?php namespace Ecomtracker\Api\Http\Controllers\Product\Keywords;

use Ecomtracker\Product\Http\Requests\Keywords\Competitors\ShowRequest;

class CompetitorsController extends \Ecomtracker\Product\Http\Controllers\Keywords\CompetitorsController
{

    /**
     * Authenticate against the system
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/product/{id}/keywords/competitors",
     *     description="Returns a collection of domains that are competitors for the collection of keywords related to the product",
     *     operationId="api1.product.keywords.competitors",
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
     *          type="number",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="operation_field",
     *          in="query",
     *          type="string",
     *          description="the field to use for the operation",
     *          required=false,
     *      ),
     *      @SWG\Parameter(
     *          name="operation",
     *          in="query",
     *          type="string",
     *          description="sum|avg|sort",
     *          required=false,
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
        return parent::show($request, $product_id);
    } 
}