<?php

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/AvailableMembershipPlans",
     *     description="Returns available membership plans, based on user's settings and models counts",
     *     operationId="api1.membeship.AvailableMembershipPlans",
     *     produces={"application/json"},
     *     tags={"membership"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
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
     *         response=500,
     *         description="MembershipException Error",
     *     )
     * )
     */


/**
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Get(
 *     path="/api1/GetCurrentMembershipPlan",
 *     description="Returns current membership plan information, based on user's settings and models counts",
 *     operationId="api1.membeship.GetCurrentMembershipPlan",
 *     produces={"application/json"},
 *     tags={"membership"},
 *      @SWG\Parameter(
 *          name="token",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *
 *     @SWG\Response(
 *         response=200,
 *         description="Success. Sample response: <a target=_blank href='./../swagger-samples/GetCurrentMembershipPlan.json'>Sample Response</a>"
 *     ),
 *     @SWG\Response(
 *         response=401,
 *         description="Unauthorized",
 *     ),
 *     @SWG\Response(
 *         response=404,
 *         description="Membership Not Set",
 *     )
 * )
 */





/**
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Get(
 *     path="/api1/MembershipPlan/{id}",
 *     description="Returns  membership plan information by Id",
 *     operationId="api1.membeship.MembershipPlan",
 *     produces={"application/json"},
 *     tags={"membership"},
 *      @SWG\Parameter(
 *          name="token",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *
 *      @SWG\Parameter(
 *          name="id",
 *          in="path",
 *          type="string",
 *          required=true,
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
 *         response=404,
 *         description="Membership Not Set",
 *     )
 * )
 */




/**
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Post(
 *     path="/api1/ChangePlan",
 *     description="Change current  membership plan ",
 *     operationId="api1.membeship.MembershipPlan",
 *     produces={"application/json"},
 *     tags={"membership"},
 *      @SWG\Parameter(
 *          name="token",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *
 *      @SWG\Parameter(
 *          name="id",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="ID of new Membership Plan",
 *      ),
 *
 *      @SWG\Parameter(
 *          name="method",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="'immediatelly' or 'at_the_end' of billing cycle ",
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
 *         response=404,
 *         description="MembershipException Error",
 *     ),
 *     @SWG\Response(
 *         response=500,
 *         description="NMI Error",
 *     )
 * )
 */




/**
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Get(
 *     path="/api1/CancelCurrentMembershipPlan",
 *     description="Cancel current membership plan and set account to 'pending'  ",
 *     operationId="api1.membeship.CancelCurrentMembershipPlan",
 *     produces={"application/json"},
 *     tags={"membership"},
 *      @SWG\Parameter(
 *          name="token",
 *          in="query",
 *          type="string",
 *          required=true,
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
 *     ),
 *     @SWG\Response(
 *         response=500,
 *         description="Membership Not Canceled",
 *     )
 * )
 */




/**
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Post(
 *     path="/api1/ChangeCCData",
 *     description="Change current  Credit Card information on NMI customer vault records ",
 *     operationId="api1.membeship.ChangeCCData",
 *     produces={"application/json"},
 *     tags={"membership"},
 *      @SWG\Parameter(
 *          name="token",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *
 *
 *      @SWG\Parameter(
 *          name="first_name",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="billing first_name",
 *      ),
 *      @SWG\Parameter(
 *          name="last_name",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="billing last_name",
 *      ),
 *      @SWG\Parameter(
 *          name="address1",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="billing address1",
 *      ),
 *      @SWG\Parameter(
 *          name="country",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="billing country code",
 *      ),
 *      @SWG\Parameter(
 *          name="city",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="billing city",
 *      ),
 *      @SWG\Parameter(
 *          name="state",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="billing state",
 *      ),
 *      @SWG\Parameter(
 *          name="zip",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="billing zip",
 *      ),
 *      @SWG\Parameter(
 *          name="ccnumber",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Credit Card Number",
 *      ),
 *      @SWG\Parameter(
 *          name="ccexp_month",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Credit Card Expire Month (MM with leading zeros)",
 *      ),
 *      @SWG\Parameter(
 *          name="ccexp_year",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Credit Card Expire Year (YY with leading zeros)",
 *      ),
 *      @SWG\Parameter(
 *          name="cvv",
 *          in="formData",
 *          type="string",
 *          required=true,
 *          description="Credit Card CVV code)",
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
 *     ),
 *     @SWG\Response(
 *         response=500,
 *         description="CC data not updated",
 *     )
 * )
 */





/**
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @SWG\Post(
 *     path="/api1/NMITransactions",
 *     description="Get NMITransactions collection",
 *     operationId="api1.membeship.NMITransactions",
 *     produces={"application/json"},
 *     tags={"membership"},
 *      @SWG\Parameter(
 *          name="token",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *
 *
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
 *         response=404,
 *         description="MembershipException Error",
 *     )
 * )
 */