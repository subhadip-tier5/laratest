<?php namespace Ecomtracker\Api\Http\Controllers\Keyword\Paid;
use Ecomtracker\Keyword\Http\Requests\Paid\Result\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Paid\Result\UpdateRequest;

class ResultController extends \Ecomtracker\Keyword\Http\Controllers\Paid\ResultController
{
    /**
     * Return the Collection of related distribution objects related to the keyword
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/paid/results",
     *     description="Returns an object representing paid results values",
     *     operationId="api1.keyword.paid.results.show",
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
     * Update keyword paid distribution data and return it
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/paid/results/update",
     *     description="Updates and returns an object representing paid results values",
     *     operationId="api1.keyword.paid.results.update",
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


    public function update(UpdateRequest $request, $id = null)
    {
        $results = parent::update($request, $id);
        return $results;
    }





}