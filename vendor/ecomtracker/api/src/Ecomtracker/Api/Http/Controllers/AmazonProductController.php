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

class AmazonProductController extends \Ecomtracker\Amazon\Http\Controllers\AmazonProductController
{
    /**
     * Returns a Amazon Product
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/AmazonProduct/{id}",
     *     description="Returns a Amazon Product ",
     *     operationId="api1.amazonproduct.show",
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
     *         description="Success. Returning AmazonProduct model <a target=_blank href='./../swagger-samples/AmazonProduct.json'>Sample Response</a>",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     *
     *
     *
     *
     */


    public function show(ShowRequest $request, $id = null)
    {

        return parent::show($request,$id);
    }


    /**
     * Create amazon product
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/AmazonProduct",
     *     description="Create amazon product ",
     *     operationId="api1.amazonproduct.store",
     *     produces={"application/json"},
     *     tags={"amazon"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="title",
     *          in="formData",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="asin",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Amazon ASIN number or full Amazon Product URL",
     *      ),
     *     @SWG\Parameter(
     *          name="marketplace",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Amazon Domain (one of: de, com, co.uk, ca, fr, co.jp, it, cn, es, in, com.br) ",
     *      ),
     *      @SWG\Parameter(
     *          name="show_on_dashboard_flag",
     *          in="formData",
     *          type="boolean",
     *          required=true,
     *          description="Show this product on member dashboard or not",
     *      ),
     *      @SWG\Parameter(
     *          name="is_tracking_enabled",
     *          in="formData",
     *          type="boolean",
     *          required=false,
     *          description="Change product tracking state. ",
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Error saving the product",
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
     * Update a amazon product record
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Put(
     *     path="/api1/AmazonProduct/{id}",
     *     description="Update a keyword object",
     *     operationId="api1.amazonproduct.update",
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
     *          name="title",
     *          in="formData",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="show_on_dashboard_flag",
     *          in="formData",
     *          type="boolean",
     *          required=true,
     *          description="Show this product on member dashboard or not",
     *      ),
     *      @SWG\Parameter(
     *          name="is_tracking_enabled",
     *          in="formData",
     *          type="boolean",
     *          required=false,
     *          description="Change product tracking state. ",
     *      ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="Success.",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Error saving the product",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not Found",
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
     * Destroy amazon product record
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Delete(
     *     path="/api1/AmazonProduct/{id}",
     *     description="Destroy amazon product object",
     *     operationId="api1.amazonproduct.destroy",
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
     *         response=500,
     *         description="Error deleting the product",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not Found",
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
     * Get amazon product's keywords collection
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/AmazonProduct/{id}/AmazonKeywords",
     *     description="Get amazon product's keywords collection",
     *     operationId="api1.amazonproduct.amazonkeywords",
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
     *         description="Success. Returning AmazonKeywords array <a target=_blank href='./../swagger-samples/AmazonKeywords.json'>Sample Response</a>",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */

    public function AmazonKeywords(ShowRequest $request,$id = null)
    {
        return parent::AmazonKeywords($request,$id);


    }


    /**
     * Get amazon product's history collection
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/AmazonProduct/{id}/history",
     *     description="Get amazon product's history collection",
     *     operationId="api1.amazonproduct.history",
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
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success. Returning AmazonProductHistory array <a target=_blank href='./../swagger-samples/AmazonProductHistory.json'>Sample Response</a>",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */

    public function history(ShowRequest $request,$id = null)
    {
        //return \Ecomtracker\Tracking\Http\Controllers\TrackingController::GetAmazonProductHistory($request,$id);
        return parent::history($request,$id);

    }




    /**
     * Get amazon product's reviews collection
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/AmazonProduct/{id}/reviews",
     *     description="Get amazon product's reviews collection",
     *     operationId="api1.amazonproduct.reviews",
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
     *          in="formData",
     *          type="string",
     *          required=false,
     *          description="Filter From Date (`YYYY-MM-DD HH:MM:SS`)",
     *      ),
     *      @SWG\Parameter(
     *          name="date_to",
     *          in="formData",
     *          type="string",
     *          required=false,
     *          description="Filter To Date (`YYYY-MM-DD HH:MM:SS`)",
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          in="formData",
     *          type="integer",
     *          required=false,
     *          description="Limit number of results",
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success. Returning AmazonProductReviews array <a target=_blank href='./../swagger-samples/AmazonProductReviews.json'>Sample Response</a>",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */

    public function reviews(ShowRequest $request,$id = null)
    {

        return parent::reviews($request,$id);

    }



    /**
     * Get amazon product's OnPageInfo data
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/AmazonProduct/{id}/OnPageInfo",
     *     description="Get amazon product's OnPageInfo data",
     *     operationId="api1.amazonproduct.OnPageInfo",
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
     *          name="keywords",
     *          in="formData",
     *          type="string",
     *          required=false,
     *          description="keywords to analyze, separated by comma",
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success. Returning AmazonProductOnPageInfo array <a target=_blank href='./../swagger-samples/AmazonProductOnPageInfo.json'>Sample Response</a>",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @SWG\Response(
     *         response=402,
     *         description="Membership Limit Exceed Exception",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="TrackingException ",
     *     )
     * )
     */

    public function OnPageInfo(ShowRequest $request,$id = null)
    {

        return parent::OnPageInfo($request,$id);

    }



    /**
     * Get all amazon productss
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/AmazonProducts",
     *     description="Get all amazon productss ",
     *     operationId="api1.amazonproduct.AmazonProducts",
     *     produces={"application/json"},
     *     tags={"amazon"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="filter_marketplace",
     *          in="formData",
     *          type="string",
     *          required=false,
     *          description="Amazon Country Code to filter",
     *      ),
     *      @SWG\Parameter(
     *          name="include_stats",
     *          in="formData",
     *          type="string",
     *          required=false,
     *          description="put `1` - to include LastTrackedStats in each product",
     *      ),
     *      @SWG\Parameter(
     *          name="filter_show_on_dashboard_flag",
     *          in="formData",
     *          type="boolean",
     *          required=true,
     *          description="Show this product on member dashboard or not",
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success. Returning AmazonProducts array <a target=_blank href='./../swagger-samples/AmazonProducts.json'>Sample Response</a>",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="ErrorException",
     *     )
     * )
     */

    public function AmazonProducts(ShowRequest $request)
    {

        return parent::AmazonProducts($request);

    }






    /**
     * Get amazon product's OnPageInfo data
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/AmazonProduct/{id}/LastTrackedStats",
     *     description="Get amazon product's LastTrackedStats data (for products page listings)",
     *     operationId="api1.amazonproduct.LastTrackedStats",
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
     *          description="AmazonProduct ID"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success. Returning array of stats data <a target=_blank href='./../swagger-samples/LastTrackedStats.json'>Sample Response</a>",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="TrackingException ",
     *     )
     * )
     */

    public function LastTrackedStats(ShowRequest $request,$id = null)
    {

        return parent::LastTrackedStats($request,$id);

    }





    /**
     * Get amazon product's TopKeyword data
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/AmazonProduct/{id}/TopKeyword",
     *     description="Get amazon product's TopKeyword data ",
     *     operationId="api1.amazonproduct.TopKeyword",
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
     *          description="AmazonProduct ID"
     *      ),
     *      @SWG\Parameter(
     *          name="include_7_days_history",
     *          in="path",
     *          type="boolean",
     *          required=false,
     *          description="'1' or '0' to include last 7 days history into response"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success. Returning array of stats data <a target=_blank href='./../swagger-samples/TopKeyword.json'>Sample Response</a>",
     *
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product Not Found",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="TrackingException ",
     *     )
     * )
     */

    public function TopKeyword(ShowRequest $request,$id = null)
    {

        return parent::TopKeyword($request,$id);

    }



}