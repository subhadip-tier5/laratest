<?php namespace Ecomtracker\Api\Http\Controllers\Keyword;

use Ecomtracker\Keyword\Http\Requests\Related\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Related\UpdateRequest;

class RelatedController extends \Ecomtracker\Keyword\Http\Controllers\RelatedController
{
    /**
     * Return the Collection of related keywords
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/related",
     *     description="Returns a keyword history collection",
     *     operationId="api1.keyword.history.show",
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


    /**
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/related/update",
     *     description="Updates related keywords to the keyword topic",
     *     operationId="api1.keyword.related.update",
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


    public function update(UpdateRequest $request, $keyword_id = null)
    {
        return parent::update($request,$keyword_id);
    }
    
    
    

}