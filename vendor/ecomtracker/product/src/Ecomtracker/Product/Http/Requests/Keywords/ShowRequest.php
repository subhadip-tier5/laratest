<?php namespace Ecomtracker\Product\Http\Requests\Keywords;

use App\Http\Requests\Request;
use Ecomtracker\User\Models\User;
use Ecomtracker\User\Traits\Permissible;

class ShowRequest extends Request
{
    use Permissible;


    public function rules()
    {
        return [];
    }
    
    
    public function denies(User $user)
    {
        return false;
        //@todo JAKE! please fill this in to return true if the user is not permitted to retrieve data from $this->product (id)
    }
}