<?php namespace Ecomtracker\User\Http\Requests\Register;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class PostRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
        //@todo ajw! these need to be defined.

    }

}