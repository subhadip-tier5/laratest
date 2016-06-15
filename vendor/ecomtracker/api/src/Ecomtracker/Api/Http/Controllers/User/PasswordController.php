<?php namespace Ecomtracker\Api\Http\Controllers\User;

use Ecomtracker\User\Http\Requests\Password\ResetRequest;
use Ecomtracker\User\Http\Requests\Password\ForgotRequest;

class PasswordController extends \Ecomtracker\User\Http\Controllers\PasswordController
{

    /**
     * Send an email to the user to reset their password
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/user/password/forgot",
     *     description="Sends user an email with instructions on resetting their password",
     *     operationId="api.user.password.forgot",
     *     produces={"application/json"},
     *     tags={"password"},
     *      @SWG\Parameter(
     *          name="email",
     *          in="formData",
     *          type="string",
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Failure",
     *     )
     * )
     */
    public function forgot(ForgotRequest $request)
    {
        try{
            return parent::postEmail($request);
        } catch (\Exception $e)
        {
            return response('Error in sending forgot password email '. $e->getMessage(),500);
        }  
    }
    
    
    

    /**
     * Authenticate against the system
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/user/password/reset",
     *     description="Resets user password based on a reset token matching with email address and password",
     *     operationId="api.user.password.reset.post",
     *     produces={"application/json"},
     *     tags={"password"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="formData",
     *          type="string",
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
     *          name="password_confirmation",
     *          in="formData",
     *          type="string",
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Failure",
     *     )
     * )
     */
    public function postReset(ResetRequest $request)
    {
        return parent::postReset($request);
    }





}