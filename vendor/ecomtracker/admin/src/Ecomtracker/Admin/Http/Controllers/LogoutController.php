<?php namespace Ecomtracker\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Ecomtracker\Admin\Http\Requests\Login\PostRequest;
use Illuminate\Auth\Guard;


class LogoutController extends Controller
{

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function get()
    {
        $this->auth->logout();
        return redirect()->route('admin.login');

    }

}