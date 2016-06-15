<?php namespace Ecomtracker\Api\Http\Controllers\User;

use Ecomtracker\User\Http\Requests\LoginRequest;
use Ecomtracker\User\Http\Requests\LogoutRequest;

class AuthController extends \Ecomtracker\User\Http\Controllers\AuthController
{

    /**
     * Authenticate against the system
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/auth",
     *     description="Returns JWT auth token and authenticates user",
     *     operationId="api1.auth",
     *     produces={"application/json"},
     *     tags={"auth"},
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



    public function post(LoginRequest $request)
    {
        return parent::post($request);
    }


    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/logout",
     *     description="Logout the currently logged in user",
     *     operationId="api1.logout",
     *     produces={"application/json"},
     *     tags={"auth"},
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
    public function logout(LogoutRequest $request)
    {
        return parent::logout($request);
    }





}