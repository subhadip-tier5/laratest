<?php namespace Ecomtracker\Api\Http\Controllers\Product\Keywords;

use Ecomtracker\Product\Http\Requests\Keywords\Positions\ShowRequest;

class PositionsController extends \Ecomtracker\Product\Http\Controllers\Keywords\PositionsController
{

    /**
     * Authenticate against the system
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/product/{id}/keywords/positions",
     *     description="Returns a positions collection based on the provided product id for all of the keywords tracked by product",
     *     operationId="api1.product.keywords.positions",
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
     *          in="formData",
     *          type="string",
     *          description="the field to use for the operation",
     *          required=false,
     *      ),
     *      @SWG\Parameter(
     *          name="operation",
     *          in="formData",
     *          type="string",
     *          description="sum|avg|sort",
     *          required=false,
     *      ),
     *      @SWG\Parameter(
     *          name="dir",
     *          in="formData",
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



    public function show(ShowRequest $request)
    {
        return parent::post($request);
    } 
}