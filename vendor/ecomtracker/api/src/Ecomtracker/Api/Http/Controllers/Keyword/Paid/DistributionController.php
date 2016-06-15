<?php namespace Ecomtracker\Api\Http\Controllers\Keyword\Paid;

use Ecomtracker\Api\Http\Responses\Keyword\Organic\DistributionResponse;
use Ecomtracker\Keyword\Http\Requests\Paid\Distribution\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Paid\Distribution\UpdateRequest;

class DistributionController extends \Ecomtracker\Keyword\Http\Controllers\Paid\DistributionController
{
    /**
     * Return the Collection of related distribution objects related to the keyword
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/paid/distribution",
     *     description="Returns an object representing paid distribution(adwords) values",
     *     operationId="api1.keyword.paid.distribution.show",
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

        $response = new DistributionResponse();


        $map = [
            'key' => 'phrase',
            'values' => [
                'database',
                'search_volume',
            ]
        ];

        $response->map($map);
        $response->consumeCollection($results);

        return $response->getData();
    }



    /**
     * Update keyword paid distribution data and return it
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/paid/distribution/update",
     *     description="Updates and returns an object representing paid distribution(adwords) values",
     *     operationId="api1.keyword.paid.distribution.update",
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
        //If we have results format the response

        $response = new DistributionResponse();


        $map = [
            'key' => 'phrase',
            'values' => [
                'database',
                'search_volume',
            ]
        ];

        $response->map($map);
        $response->consumeCollection($results);


        return $response->getData();
    }





}