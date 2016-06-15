<?php namespace Ecomtracker\User\Http\Requests;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class LogoutRequest extends Request
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [];
    }

}