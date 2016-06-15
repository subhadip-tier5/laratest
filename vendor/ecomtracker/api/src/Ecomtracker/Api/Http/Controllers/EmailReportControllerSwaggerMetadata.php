<?php



/**
 * Return all EmailReports List
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Get(
 *     path="/api1/EmailReports",
 *     description="Return all EmailReports List",
 *     operationId="api1.AdminMembershipPlan.index",
 *     produces={"application/json"},
 *     tags={"EmailReports"},
 *      @SWG\Parameter(
 *          name="token",
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


/**
 * Return the EmailReports Model Data
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Get(
 *     path="/api1/EmailReport/{id}",
 *     description="Returns a EmailReport object",
 *     operationId="api1.EmailReport.show",
 *     produces={"application/json"},
 *     tags={"EmailReports"},
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
 *          description="EmailReport ID",
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



/**
 * Store a EmailReport record
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Post(
 *     path="/api1/EmailReport",
 *     description="Create a EmailReport object",
 *     operationId="api1.EmailReport.store",
 *     produces={"application/json"},
 *     tags={"EmailReports"},
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
 *          required=false,
 *          description="title"
 *      ),
 *      @SWG\Parameter(
 *          name="to_email",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="to_email"
 *      ),
 *      @SWG\Parameter(
 *          name="from_name",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="from_name"
 *      ),
 *      @SWG\Parameter(
 *          name="frequency",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="frequency ( 'none', 'daily', 'weekly', 'monthly' )"
 *      ),
 *      @SWG\Parameter(
 *          name="next_send_date",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="when to send next report. Datetime ( YYYY-MM-DD)"
 *      ),
 *      @SWG\Parameter(
 *          name="data",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Json report options data (selected products and their keywords to include into report)
 *           sample:  {'selected_products':{'&lt;amazon_product_id>':[&lt;amazon_keyword_id1>,&lt;amazon_keyword_id2>,&lt;amazon_keyword_id3>],'&lt;amazon_product_id>':[&lt;amazon_keyword_id6>,&lt;amazon_keyword_id9>]}}     "
 *      ),
 *
 *     @SWG\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @SWG\Response(
 *         response=401,
 *         description="Unauthorized",
 *     ),
 *     @SWG\Response(
 *         response=402,
 *         description="Membership Limit Exceed Exception",
 *     )
 * )
 */




/**
 * Update a EmailReport record
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Put(
 *     path="/api1/EmailReport/{id}",
 *     description="Update a EmailReport object",
 *     operationId="api1.EmailReport.update",
 *     produces={"application/json"},
 *     tags={"EmailReports"},
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
 *          description="EmailReport ID",
 *      ),
 *      @SWG\Parameter(
 *          name="title",
 *          in="formData",
 *          type="string",
 *          required=false,
 *          description="title"
 *      ),
 *      @SWG\Parameter(
 *          name="to_email",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="to_email"
 *      ),
 *      @SWG\Parameter(
 *          name="from_name",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="from_name"
 *      ),
 *      @SWG\Parameter(
 *          name="frequency",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="frequency ( 'none', 'daily', 'weekly', 'monthly' )"
 *      ),
 *      @SWG\Parameter(
 *          name="next_send_date",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="when to send next report. Datetime ( YYYY-MM-DD)"
 *      ),
 *      @SWG\Parameter(
 *          name="data",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Json report options data (selected products and their keywords to include into report)
 *              sample:  {'selected_products':{'&lt;amazon_product_id>':[&lt;amazon_keyword_id1>,&lt;amazon_keyword_id2>,&lt;amazon_keyword_id3>],'&lt;amazon_product_id>':[&lt;amazon_keyword_id6>,&lt;amazon_keyword_id9>]}}
 *              "
 *      ),
 *
 *     @SWG\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @SWG\Response(
 *         response=401,
 *         description="Unauthorized",
 *     ),
 *     @SWG\Response(
 *         response=402,
 *         description="Membership Limit Exceed Exception",
 *     )
 * )
 */




/**
 * Destroy a EmailReport record
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Delete(
 *     path="/api1/EmailReport/{id}",
 *     description="Destroy a EmailReport record",
 *     operationId="api1.EmailReport.destroy",
 *     produces={"application/json"},
 *     tags={"EmailReports"},
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


/**
 * Preview EmailReport
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Post(
 *     path="/api1/PreviewEmailReport",
 *     description="Preview Email Report in JSON or HTML, by submitted input values",
 *     operationId="api1.PreviewEmailReport",
 *     produces={"application/json"},
 *     tags={"EmailReports"},
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
 *          required=false,
 *          description="title"
 *      ),
 *      @SWG\Parameter(
 *          name="to_email",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="to_email"
 *      ),
 *      @SWG\Parameter(
 *          name="from_name",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="from_name"
 *      ),
 *      @SWG\Parameter(
 *          name="frequency",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="frequency ( 'none', 'daily', 'weekly', 'monthly' )"
 *      ),
 *      @SWG\Parameter(
 *          name="next_send_date",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="when to send next report. Datetime ( YYYY-MM-DD)"
 *      ),
 *      @SWG\Parameter(
 *          name="data",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Json report options data (selected products and their keywords to include into report)
 *           sample:  {'selected_products':{'&lt;amazon_product_id>':[&lt;amazon_keyword_id1>,&lt;amazon_keyword_id2>,&lt;amazon_keyword_id3>],'&lt;amazon_product_id>':[&lt;amazon_keyword_id6>,&lt;amazon_keyword_id9>]}}     "
 *      ),
 *      @SWG\Parameter(
 *          name="format",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="one of the allowed return formats ( 'JSON', 'HTML')"
 *      ),
 *     @SWG\Response(
 *         response=200,
 *         description="Success",
 *          description="Success. Returning HTML email or JSON data like this <a target=_blank href='./../swagger-samples/PreviewEmailReport.json'>Sample JSON Response</a>",
 *     ),
 *     @SWG\Response(
 *         response=401,
 *         description="Unauthorized",
 *     ),
 *     @SWG\Response(
 *         response=402,
 *         description="Membership Limit Exceed Exception",
 *     )
 * )
 */