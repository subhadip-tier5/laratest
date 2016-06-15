<?php namespace Ecomtracker\Api\Http\Controllers\Keyword\Related;

use Ecomtracker\Keyword\Http\Requests\Related\PhraseMatched\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Related\PhraseMatched\UpdateRequest;

class PhraseMatchedController extends \Ecomtracker\Keyword\Http\Controllers\Related\PhraseMatchedController
{
    /**
     * Returns a collection of keywords related by phrase match
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/related/phrase",
     *     description="keywords index of related keywords for phrase matched results",
     *     operationId="api1.keyword.related.phrase.show",
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
     * Updates Phrase Matched Keywords
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/keyword/{id}/related/phrase/update",
     *     description="Updates keywords index of related keywords for phrase matched results",
     *     operationId="api1.keyword.related.phrase.update",
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