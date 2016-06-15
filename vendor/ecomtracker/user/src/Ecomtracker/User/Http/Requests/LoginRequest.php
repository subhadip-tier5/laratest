<?php namespace Ecomtracker\User\Http\Requests;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class LoginRequest extends Request
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }

}