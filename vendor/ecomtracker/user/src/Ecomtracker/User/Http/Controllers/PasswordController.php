<?php namespace Ecomtracker\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use App\Http\Controllers\Controller;
use Ecomtracker\User\Http\Requests\Password\ResetRequest;
use Ecomtracker\User\Http\Requests\Password\ForgotRequest;
use Ecomtracker\User\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    use ResetsPasswords;


    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function postEmail(ForgotRequest $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case \Password::RESET_LINK_SENT:
                //Do nothing if the email was sent
                return response(null,200);


            case Password::INVALID_USER:
                return response(null,500);
        }
    }
      


    public function postReset(ResetRequest $request)
    {
        $this->redirectPath = '';

        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = \Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        dd($response);
        switch ($response) {
            case \Password::PASSWORD_RESET:
                return response(null,200);

            default:
                return response(null,500);
        }    
    }



    public function getReset(Request $request, $token = null)
    {
        //@todo AJW! This should be handled by angular
        $data = [
            'token' => $token
        ];
        return response()->view('pages.password.reset',$data);
        
    }





}