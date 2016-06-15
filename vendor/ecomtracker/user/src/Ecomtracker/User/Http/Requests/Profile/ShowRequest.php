<?php namespace Ecomtracker\User\Http\Requests\Profile;

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