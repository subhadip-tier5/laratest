<?php namespace Ecomtracker\Api\Http\Controllers\Keyword;

use Ecomtracker\Keyword\Http\Requests\Competitor\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Competitor\DestroyRequest;
use Ecomtracker\Keyword\Http\Requests\Competitor\StoreRequest;
use Ecomtracker\Keyword\Http\Requests\Competitor\UpdateRequest;


class CompetitorController extends \Ecomtracker\Keyword\Http\Controllers\CompetitorController
{
    /**
     * Return the User Model Data
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/competitors",
     *     description="Returns a keyword competitors collection",
     *     operationId="api1.keyword.competitors.show",
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


    public function show(ShowRequest $request, $keyword_id = null)
    {
        return parent::show($request,$keyword_id);
    }

}