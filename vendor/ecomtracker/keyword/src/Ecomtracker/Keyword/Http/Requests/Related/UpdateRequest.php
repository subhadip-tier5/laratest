<?php namespace Ecomtracker\Keyword\Http\Requests\Related;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class UpdateRequest extends Request
{
    use Permissible;

    public function rules()
    {
        return [];
    }

}