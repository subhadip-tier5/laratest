<?php namespace Ecomtracker\User\Http\Requests\Password;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class ResetRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

}