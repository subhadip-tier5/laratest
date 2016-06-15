<?php namespace Ecomtracker\Admin\Http\Requests\Login;


use Ecomtracker\User\Traits\Permissible;
use Illuminate\Foundation\Http\FormRequest as Request;

class GetRequest extends Request
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