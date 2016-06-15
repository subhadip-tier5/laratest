<?php namespace Ecomtracker\User\Http\Controllers;



use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use Ecomtracker\User\Http\Requests\LoginRequest;
use Ecomtracker\User\Http\Requests\LogoutRequest;

class AuthController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function post(LoginRequest $request)
    {
        $isAuthed = \Auth::user();

        $result = ['status' => 'success'];
        
        $now = new \DateTime();
        $expiration = $now->add(new \DateInterval('P0Y0DT0H30M'))->getTimestamp();

        $credentials = $request->only('email', 'password');
        $options = [
            'exp' => $expiration
        ];



        try {
            // verify the credentials and create a token for the user
            if (!$token = \JWTAuth::attempt($credentials,$options)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        if ($isAuthed = false) {
            if ($this->auth->attempt($credentials, 1)) {
                $result = ['status' => 'success'];
            } else {
                $result = ['status' => 'failure', 'code' => '401'];
            }
        }
        return response()->json(compact('token', 'result'));
    }


    public function logout(LogoutRequest $request)
    {
        try {
            $this->auth->logout();
            $result = ['status' => 'success'];
        } catch(\Exception $e) {
            return response($e->getMessage(),500);
        }

        return response()->json(compact('result'));
    }
}