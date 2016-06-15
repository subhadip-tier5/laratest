<?php namespace Ecomtracker\Admin\Http\Requests\Login;

use Illuminate\Foundation\Http\FormRequest as Request;
use Ecomtracker\User\Traits\Permissible;

class PostRequest extends Request
{
    
    public function authorize()
    {
        return true;
    }
    
    
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }
    
    
}