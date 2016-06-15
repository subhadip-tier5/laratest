<?php




/**
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Post(
 *     path="/api1/GetAmazonProductInfo",
 *     description="Get Amazon Product data Instantly (from Amazon API) ",
 *     operationId="api1.tracking.GetAmazonProductInfo",
 *     produces={"application/json"},
 *     tags={"tracking"},
 *      @SWG\Parameter(
 *          name="token",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *
 *      @SWG\Parameter(
 *          name="asin",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Amazon ASIN number or full Amazon Product URL",
 *      ),
 *
 *      @SWG\Parameter(
 *          name="marketplace",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Amazon domain e.g. 'com' , '.ca' , 'co.uk' etc ",
 *      ),
 *
 *     @SWG\Response(
 *         response=200,
 *         description="Success. Returning AmazonProductInfo data <a target=_blank href='./../swagger-samples/AmazonProductInfo.json'>Sample Response</a>",
 *
 *     ),
 *     @SWG\Response(
 *         response=401,
 *         description="Unauthorized",
 *     ),
 *     @SWG\Response(
 *         response=404,
 *         description="TrackingException Error",
 *     )
 * )
 */
 
 
 


/**
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Get(
 *     path="/api1/GetAmazonKeywordInfo/{id}",
 *     description="Get Amazon Keyword info (from Amazon API)  ",
 *     operationId="api1.tracking.GetAmazonKeywordInfo",
 *     produces={"application/json"},
 *     tags={"tracking"},
 *      @SWG\Parameter(
 *          name="token",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="id",
 *          in="path",
 *          type="integer",
 *          required=true,
 *          description="Amazon Keyword DB Id",
 *      ),
 *
 *     @SWG\Response(
 *         response=200,
 *         description="Success. Returning AmazonKeywordInfo data <a target=_blank href='./../swagger-samples/AmazonKeywordInfo.json'>Sample Response</a>",
 *
 *     ),
 *     @SWG\Response(
 *         response=401,
 *         description="Unauthorized",
 *     ),
 *     @SWG\Response(
 *         response=404,
 *         description="Amazon Keyword not Found",
 *     ),
 *      @SWG\Response(
 *         response=500,
 *         description="TrackingException Error",
 *     )
 * )
 */





/**
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Post(
 *     path="/api1/GetAmazonKeywordSuggestions",
 *     description="Get Amazon Keyword Suggestions (from Amazon web search crawler) ",
 *     operationId="api1.tracking.GetAmazonKeywordSuggestions",
 *     produces={"application/json"},
 *     tags={"tracking"},
 *      @SWG\Parameter(
 *          name="token",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *
 *      @SWG\Parameter(
 *          name="value",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Amazon keyword value",
 *      ),
 *
 *      @SWG\Parameter(
 *          name="marketplace",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Amazon domain e.g. 'com' , '.ca' , 'co.uk' etc ",
 *      ),
 *
 *     @SWG\Response(
 *         response=200,
 *         description="Success. Returning AmazonKeywordSuggestions model <a target=_blank href='./../swagger-samples/AmazonKeywordSuggestions.json'>Sample Response</a>",
 *
 *     ),
 *     @SWG\Response(
 *         response=401,
 *         description="Unauthorized",
 *     ),
 *     @SWG\Response(
 *         response=500,
 *         description="TrackingException Error",
 *     )
 * )
 */





/**
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Post(
 *     path="/api1/GetAmazonProductSimilarItems",
 *     description="Get Amazon Product Similar Items  (suggestions, from Amazon API) ",
 *     operationId="api1.tracking.GetAmazonProductSimilarItems",
 *     produces={"application/json"},
 *     tags={"tracking"},
 *      @SWG\Parameter(
 *          name="token",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *
 *      @SWG\Parameter(
 *          name="asin",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Amazon ASIN number",
 *      ),
 *
 *      @SWG\Parameter(
 *          name="marketplace",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Amazon domain e.g. 'com' , '.ca' , 'co.uk' etc ",
 *      ),
 *
 *     @SWG\Response(
 *         response=200,
 *         description="Success. Returning AmazonProductSimilarItems model <a target=_blank href='./../swagger-samples/AmazonProductSimilarItems.json'>Sample Response</a>",
 *
 *     ),
 *     @SWG\Response(
 *         response=401,
 *         description="Unauthorized",
 *     ),
 *     @SWG\Response(
 *         response=500,
 *         description="TrackingException Error",
 *     )
 * )
 */


/**
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Get(
 *     path="/api1/GetAmazonCountries",
 *     description="Get Amazon Available Countries array ",
 *     operationId="api1.tracking.GetAmazonCountries",
 *     produces={"application/json"},
 *     tags={"tracking"},
 *      @SWG\Parameter(
 *          name="token",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *
 *     @SWG\Response(
 *         response=200,
 *         description="Success. Returning GetAmazonCountries array data <a target=_blank href='./../swagger-samples/GetAmazonCountries.json'>Sample Response</a>",
 *
 *     ),
 *     @SWG\Response(
 *         response=401,
 *         description="Unauthorized",
 *     ),
 *      @SWG\Response(
 *         response=500,
 *         description="TrackingException Error",
 *     )
 * )
 */