<?php namespace Ecomtracker\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Ecomtracker\Admin\Http\Requests\Login\PostRequest;
use Illuminate\Auth\Guard;


class LoginController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }



    public function get()
    {

        if($this->auth->user()->isAdmin())
        {
            return redirect()->route('admin.dashboard');
        }


        return response()->view('admin::pages.login.get');
    }
    
    public function post(PostRequest $request)
    {
        $isAuthed = \Auth::user();

        $result = ['status' => 'success'];

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, 1)) {
            $result = ['status' => 'success'];
            return redirect()->intended(\URL::route('admin.dashboard', [], false));
        } else {
            return redirect()->back('admin.login');
        }
    }

}