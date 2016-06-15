<?php namespace Ecomtracker\Api\Http\Controllers\Keyword\Paid;

use Ecomtracker\Api\Http\Responses\Keyword\Paid\TrendResponse;
use Ecomtracker\Keyword\Http\Requests\Paid\Trend\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Paid\Trend\UpdateRequest;

class TrendController extends \Ecomtracker\Keyword\Http\Controllers\Paid\TrendController
{
    /**
     * Return the Collection of related distribution objects related to the keyword
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/paid/trend",
     *     description="Returns an object representing paid ad trend count over a period of time",
     *     operationId="api1.keyword.paid.trend.show",
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

        $response = new TrendResponse();

        $map = [
            'key' => 'phrase',
            'values' => [
                'date',
                'search_volume',
            ]
        ];

        $response->map($map);
        $response->consumeCollection($results);

        return $response->getData();
    }



    /**
     * Update keyword paid trend data and return it
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/paid/trend/update",
     *     description="Updates and returns an object representing paid distribution(adwords) trend values",
     *     operationId="api1.keyword.paid.trend.update",
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

        $response = new TrendResponse();

        $map = [
            'key' => 'phrase',
            'values' => [
                'date',
                'ads',
            ]
        ];

        $response->map($map);
        $response->consumeCollection($results);

        return $response->getData();
    }





}