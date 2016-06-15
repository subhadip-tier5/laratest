<?php namespace Ecomtracker\Api\Http\Controllers\Keyword;

use Ecomtracker\Keyword\Http\Requests\Search\ShowRequest;

class SearchController extends \Ecomtracker\Keyword\Http\Controllers\SearchController
{
    /**
     * Return the User Model Data
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/search/keyword",
     *     description="Returns a collection of keywords that already exist that relate to the query string",
     *     operationId="api1.keyword.search.show",
     *     produces={"application/json"},
     *     tags={"keyword"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="q",
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


    public function show(ShowRequest $request)
    {
        return parent::show($request);
    }

}