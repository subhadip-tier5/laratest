<?php namespace Ecomtracker\Admin\Http\Requests\Dashboard;


use Ecomtracker\User\Traits\Permissible;
use Illuminate\Http\Request;

class ShowRequest extends Request
{
    use Permissible;
    
    
    public function rules()
    {
        return [];
    }
    
    
}