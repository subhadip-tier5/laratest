<?php namespace Ecomtracker\Api\Http\Controllers;

use EcomTracker\Exceptions\ApiException;
use Ecomtracker\User\Http\Requests\ShowRequest;
use Ecomtracker\User\Http\Requests\DestroyRequest;
use Ecomtracker\User\Http\Requests\StoreRequest;
use Ecomtracker\User\Http\Requests\UpdateRequest;


/**
 * Class UserController
 *
 * @package Ecomtracker\Api\Http\Controllers
 */

class UserController extends \Ecomtracker\User\Http\Controllers\UserController
{
    /**
     * Return the User Model Data
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/user",
     *     description="Returns a user object",
     *     operationId="api1.user.show",
     *     produces={"application/json"},
     *     tags={"user"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="query",
     *          type="number",
     *          required=false,
     *          description="Optional field"
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



    /**
     * Update a user record
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Put(
     *     path="/api1/user",
     *     description="Create a user object",
     *     operationId="api1.user.update",
     *     produces={"application/json"},
     *     tags={"user"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="formData",
     *          type="number",
     *          required=false,
     *          description="Optional field"
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="street1",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="street2",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="city",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="state",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="postal",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="country",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="firstname",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="lastname",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="phone",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="profession",
     *          in="formData",
     *          type="string",
     *      ),
     *      @SWG\Parameter(
     *          name="company",
     *          in="formData",
     *          type="string",
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

    public function update(UpdateRequest $request)
    {
        return parent::update($request);
    }



   





}