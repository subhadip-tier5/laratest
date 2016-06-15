<?php namespace Ecomtracker\User\Http\Requests\Password;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class ForgotRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

}