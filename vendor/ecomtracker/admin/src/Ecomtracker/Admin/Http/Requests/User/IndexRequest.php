<?php namespace Ecomtracker\Admin\Http\Requests\User;


use Ecomtracker\User\Traits\Permissible;
use Gitscripts\Search\Searchable;
use Illuminate\Foundation\Http\FormRequest as Request;

class IndexRequest extends Request
{
    use Permissible;
    use Searchable;
    
    public function rules()
    {
        return [];
    }
    
    
}