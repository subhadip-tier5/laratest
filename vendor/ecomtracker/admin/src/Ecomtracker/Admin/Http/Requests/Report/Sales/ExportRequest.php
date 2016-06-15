<?php namespace Ecomtracker\Admin\Http\Requests\Report\Sales;


use Ecomtracker\User\Traits\Permissible;
use Illuminate\Http\Request;

class ExportRequest extends Request
{
    use Permissible;
    
    
    public function rules()
    {
        return [];
    }
    
    
}