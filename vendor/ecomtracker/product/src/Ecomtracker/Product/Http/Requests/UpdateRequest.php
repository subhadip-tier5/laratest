<?php namespace Ecomtracker\Product\Http\Requests;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class UpdateRequest extends Request
{
    use Permissible;

    public function rules()
    {
        return [];
        //@todo ajw! these need to be defined.

    }

}