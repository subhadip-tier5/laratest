<?php namespace Ecomtracker\Api\Http\Controllers\Keyword;

use Ecomtracker\Keyword\Http\Requests\Paid\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Paid\UpdateRequest;

class PaidController extends \Ecomtracker\Keyword\Http\Controllers\PaidController
{
    /**
     * Return the Collection of related keywords
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/paid",
     *     description="Returns an object representing paid (adwords) values",
     *     operationId="api1.keyword.paid.show",
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
        $results = parent::show($request, $id);
        return $results;
    }





    /**
     * Return the User Model Data
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/paid/update",
     *     description="Updates paid related data and returns its data object",
     *     operationId="api1.keyword.paid.update",
     *     produces={"application/json"},
     *     tags={"keyword"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          in="query",
     *          type="integer",
     *          required=false,
     *      ),
     *      @SWG\Parameter(
     *          name="force",
     *          in="query",
     *          type="integer",
     *          required=false,
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


    public function update(UpdateRequest $request, $keyword_id = null)
    {
        return parent::update($request,$keyword_id);
    }
    
    
    

}