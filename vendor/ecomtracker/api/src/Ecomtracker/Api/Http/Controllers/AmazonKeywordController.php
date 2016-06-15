<?php namespace Ecomtracker\Api\Http\Controllers;

use EcomTracker\Exceptions\ApiException;

use Ecomtracker\Amazon\Http\Requests\ShowRequest;
use Ecomtracker\Amazon\Http\Requests\DestroyRequest;
use Ecomtracker\Amazon\Http\Requests\StoreRequest;
use Ecomtracker\Amazon\Http\Requests\UpdateRequest;


use App\Http\Requests;
/**
 * Class AmazonProductController
 *
 * @package Ecomtracker\Api\Http\Controllers
 */

class AmazonKeywordController extends \Ecomtracker\Amazon\Http\Controllers\AmazonKeywordController
{
    /**
     * Returns a AmazonKeyword
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/AmazonKeyword/{id}",
     *     description="Returns a Amazon Product ",
     *     operationId="api1.amazonkeyword.show",
     *     produces={"application/json"},
     *     tags={"amazon"},
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
     *         description="Success. Returning AmazonKeyword model <a target=_blank href='../../swagger-samples/AmazonKeyword.json'>Sample Response</a>",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Keyword Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */


    public function show(ShowRequest $request, $id = null)
    {
        return parent::show($request,$id);
    }


    /**
     * Create AmazonKeyword
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/AmazonKeyword",
     *     description="Create amazon product ",
     *     operationId="api1.amazonkeyword.store",
     *     produces={"application/json"},
     *     tags={"amazon"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="amazon_product_id",
     *          in="formData",
     *          type="integer",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="value",
     *          in="formData",
     *          type="string",
     *          required=true,
     *      ),
     *     @SWG\Parameter(
     *          name="marketplace",
     *          in="formData",
     *          type="string",
     *          required=true,
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not Found",
     *     ),
     *     @SWG\Response(
     *         response=402,
     *         description="Membership Limit Exceed Exception",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */

    public function store(StoreRequest $request)
    {
        return parent::store($request);
    }



    /**
     * Update  AmazonKeyword
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Put(
     *     path="/api1/AmazonKeyword/{id}",
     *     description="Update a keyword object",
     *     operationId="api1.amazonkeyword.update",
     *     produces={"application/json"},
     *     tags={"amazon"},
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
     *          name="value",
     *          in="formData",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="marketplace",
     *          in="formData",
     *          type="string",
     *          required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Keyword Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */

    public function update(UpdateRequest  $request, $id = null)
    {
        return parent::update($request,$id);
    }



    /**
     * Destroy AmazonKeyword
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Delete(
     *     path="/api1/AmazonKeyword/{id}",
     *     description="Destroy amazon product object",
     *     operationId="api1.amazonkeyword.destroy",
     *     produces={"application/json"},
     *     tags={"amazon"},
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
     *         response=404,
     *         description="Keyword Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */



    public function destroy(DestroyRequest $request, $id = null)
    {
        return parent::destroy($request,$id);


    }

    /**
     * Get amazon keyword's history collection
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/AmazonKeyword/{id}/history",
     *     description="Get amazon keyword's history collection",
     *     operationId="api1.amazonkeyword.history",
     *     produces={"application/json"},
     *     tags={"amazon"},
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
     *          name="date_from",
     *          in="path",
     *          type="string",
     *          required=false,
     *          description="Filter From Date (`YYYY-MM-DD HH:MM:SS`)",
     *      ),
     *      @SWG\Parameter(
     *          name="date_to",
     *          in="path",
     *          type="string",
     *          required=false,
     *          description="Filter To Date (`YYYY-MM-DD HH:MM:SS`)",
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          in="path",
     *          type="integer",
     *          required=false,
     *          description="Limit number of results",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success. Returning AmazonKeywordsHistory array <a target=_blank href='./../swagger-samples/AmazonKeywordsHistory.json'>Sample Response</a>",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Keyword Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */

    public function history(ShowRequest $request,$id = null)
    {
        return parent::history($request,$id);



    }







    /**
     * Create AmazonKeywords
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/AddAmazonKeywords",
     *     description="Create amazon product ",
     *     operationId="api1.AddAmazonKeywords",
     *     produces={"application/json"},
     *     tags={"amazon"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="amazon_product_id",
     *          in="formData",
     *          type="integer",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="keywords_array",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Json array of keywords to add. Sample: [{'value':'keywordvalue1','marketplace':'com'},{'value':'keywordvalue','marketplace':'de'}, ...]"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not Found",
     *     ),
     *     @SWG\Response(
     *         response=402,
     *         description="Membership Limit Exceed Exception",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */

    public function AddAmazonKeywords(StoreRequest $request)
    {
        return parent::AddAmazonKeywords($request);
    }



}