<?php namespace Ecomtracker\Admin\Http\Requests\User;


use Ecomtracker\User\Traits\Permissible;
use Illuminate\Foundation\Http\FormRequest as Request;

class UpdateCardRequest extends Request
{
    use Permissible;
    
    public function rules()
    {
        return [];
    }
    
    
}