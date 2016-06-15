<?php namespace Ecomtracker\Api\Http\Controllers\User;

use Ecomtracker\User\Http\Requests\Register\PostRequest;

class RegisterController extends \Ecomtracker\User\Http\Controllers\RegisterController
{

    /**
     * Authenticate against the system
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/user/register",
     *     description="Register a new user",
     *     operationId="api.user.register.post",
     *     produces={"application/json"},
     *     tags={"user"},
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
     *      @SWG\Parameter(
     *          name="asi_licence_code",
     *          in="formData",
     *          type="string",
     *          description="ASInpector licence code for ASI users.   Use 'TEST_licence_code' for testing "
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success. Sample response:
     *              {
                        'status': 'success',
                        'response': {
                        'email': 'admin445@localhost',
                        'street1': '{{street1}}',
                        'street2': '{{street2}}',
                        'firstname': '{{firstname}}',
                        'lastname': '{{lastname}}',
                        'city': '{{city}}',
                        'state': '{{state}}',
                        'postal': '{{postal}}',
                        'country': '{{country}}',
                        'asi_licence_code': 'TEST_licence_code',
                        'membership_plan_id': 1,
                        'updated_at': '2016-05-05 19:27:22',
                        'created_at': '2016-05-05 19:27:22',
                        'id': 9
                        }
                    }
     *     "
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Error. Sample responses:
     *     {
     *       'status': 'error',
     *       'response': 'incorrect_licence_code'
     *     }
     *
     *     {
     *       'status': 'error',
     *       'response': 'licence_code_already_used'
     *     }
     *     
     *     {
     *       'status': 'error',
     *       'response': 'email_already_used'
     *     }
     *
     *                      "
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */
    public function post(PostRequest $request)
    {



        try{
            $res=parent::post($request);
            $result = ['status' => 'success', 'response' => $res];
            return response($result,200);

        } catch (\Exception $e)
        {

            $result = ['status' => 'error', 'response' => $e->getMessage()];

            return response($result,500);
        }

    }





}