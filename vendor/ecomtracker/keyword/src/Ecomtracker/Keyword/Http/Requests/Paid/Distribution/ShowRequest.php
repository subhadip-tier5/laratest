<?php namespace Ecomtracker\Keyword\Http\Requests\Paid\Distribution;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class ShowRequest extends Request
{
    use Permissible;

    public function rules()
    {
        return [];
    }

}