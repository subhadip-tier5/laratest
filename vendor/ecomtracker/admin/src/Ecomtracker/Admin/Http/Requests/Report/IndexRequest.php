<?php namespace Ecomtracker\Admin\Http\Requests\Report;


use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class IndexRequest extends Request
{
    use Permissible;
    
    
    public function rules()
    {
        return [];
    }
    
    
}