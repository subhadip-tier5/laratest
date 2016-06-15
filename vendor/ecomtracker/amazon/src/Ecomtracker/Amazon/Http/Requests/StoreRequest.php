<?php namespace Ecomtracker\Amazon\Http\Requests;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class StoreRequest extends Request
{
    use Permissible;

    public function rules()
    {
        return [];


    }

}