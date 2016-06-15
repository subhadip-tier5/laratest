<?php namespace Ecomtracker\User\Http\Requests;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class DestroyRequest extends Request
{
    use Permissible;

    public function rules()
    {
        return [];
        //@todo ajw! these need to be defined.

    }

}