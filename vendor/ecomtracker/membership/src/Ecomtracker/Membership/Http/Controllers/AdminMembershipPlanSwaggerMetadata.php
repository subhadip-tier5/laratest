<?php



    /**
     * Return all MembershipPlans List
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/admin/MembershipPlan",
     *     description="Return all MembershipPlans List",
     *     operationId="api1.AdminMembershipPlan.index",
     *     produces={"application/json"},
     *     tags={"admin"},
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
     * Return the MembershipPlan Model Data
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/admin/MembershipPlan/{id}",
     *     description="Returns a MembershipPlan object",
     *     operationId="api1.AdminMembershipPlan.show",
     *     produces={"application/json"},
     *     tags={"admin"},
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
     *          description="MembershipPlan ID",
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
     * Store a MembershipPlan record
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/admin/MembershipPlan",
     *     description="Create a MembershipPlan object",
     *     operationId="api1.AdminMembershipPlan.store",
     *     produces={"application/json"},
     *     tags={"admin"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="nmi_plan_id",
     *          in="formData",
     *          type="string",
     *          required=false,
     *          description="NMI Plan Key"
     *      ),
     *      @SWG\Parameter(
     *          name="title",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Plane Name"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_products",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total Products Allowed  ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_keywords",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total Keywords Allowed ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_super_urls",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total SuperURLs Allowed ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_email_reports",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total Email Reports Allowed ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_negative_reviews",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total Negative Reviews Allowed ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_active_tracking_products",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total Active Tracking Products Allowed ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="flag_onpage_analyzer",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="boolean value"
     *      ),
     *      @SWG\Parameter(
     *          name="flag_onpage_analyzer",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="boolean value"
     *      ),
     *      @SWG\Parameter(
     *          name="flag_asin_api",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="boolean value"
     *      ),
     *      @SWG\Parameter(
     *          name="description",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="HTML description"
     *      ),
     *      @SWG\Parameter(
     *          name="additional_data",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="custom Json data"
     *      ),
     *      @SWG\Parameter(
     *          name="is_selectable",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="boolean value"
     *      ),
     *      @SWG\Parameter(
     *          name="is_locked",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="boolean value"
     *      ),
     *      @SWG\Parameter(
     *          name="recurring_price",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="dolar amount eg. '35.99'"
     *      ),
     *      @SWG\Parameter(
     *          name="recurring_period_days",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="integer number of recurring period in  days"
     *      ),
     *      @SWG\Parameter(
     *          name="trial_days",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="integer number of trial period in days"
     *      ),

     *
     *
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
     * Update a MembershipPlan record
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Put(
     *     path="/api1/admin/MembershipPlan/{id}",
     *     description="Update a MembershipPlan object",
     *     operationId="api1.AdminMembershipPlan.update",
     *     produces={"application/json"},
     *     tags={"admin"},
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
     *          description="MembershipPlan ID",
     *      ),
     *      @SWG\Parameter(
     *          name="nmi_plan_id",
     *          in="formData",
     *          type="string",
     *          required=false,
     *          description="NMI Plan Key"
     *      ),
     *      @SWG\Parameter(
     *          name="title",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Plane Name"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_products",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total Products Allowed  ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_keywords",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total Keywords Allowed ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_super_urls",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total SuperURLs Allowed ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_email_reports",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total Email Reports Allowed ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_negative_reviews",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total Negative Reviews Allowed ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="limit_active_tracking_products",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="Total Active Tracking Products Allowed ( integer value or 'unlimited'  )"
     *      ),
     *      @SWG\Parameter(
     *          name="flag_onpage_analyzer",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="boolean value"
     *      ),
     *      @SWG\Parameter(
     *          name="flag_onpage_analyzer",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="boolean value"
     *      ),
     *      @SWG\Parameter(
     *          name="flag_asin_api",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="boolean value"
     *      ),
     *      @SWG\Parameter(
     *          name="description",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="HTML description"
     *      ),
     *      @SWG\Parameter(
     *          name="additional_data",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="custom Json data"
     *      ),
     *      @SWG\Parameter(
     *          name="is_selectable",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="boolean value"
     *      ),
     *      @SWG\Parameter(
     *          name="is_locked",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="boolean value"
     *      ),
     *      @SWG\Parameter(
     *          name="recurring_price",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="dolar amount eg. '35.99'"
     *      ),
     *      @SWG\Parameter(
     *          name="recurring_period_days",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="integer number of recurring period in  days"
     *      ),
     *      @SWG\Parameter(
     *          name="trial_days",
     *          in="formData",
     *          type="string",
     *          required=true,
     *          description="integer number of trial period in days"
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
     * Destroy a MembershipPlan record
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Delete(
     *     path="/api1/admin/MembershipPlan/{id}",
     *     description="Destroy a MembershipPlan record",
     *     operationId="api1.AdminMembershipPlan.destroy",
     *     produces={"application/json"},
     *     tags={"admin"},
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


