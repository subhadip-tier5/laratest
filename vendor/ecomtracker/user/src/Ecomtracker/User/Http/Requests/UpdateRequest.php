<?php namespace Ecomtracker\User\Http\Requests;

use App\Http\Requests\Request;
use Ecomtracker\User\Models\User;
use Ecomtracker\User\Traits\Permissible;

class UpdateRequest extends Request
{
    use Permissible;

    public function rules()
    {
        return [];
        //@todo ajw! these need to be defined.

    }


    public function denies(User $user)
    {
        if ($user->isAdmin()) return false;

        if ($this->has('id')) {
            try {
                $userModel = User::getModel()->where('id', '=', $this->get('id'))->firstOrFail();
            } catch (\Exception $e) {
                \Log::error('User ' . $user->id . ' not authorized to update user: ' . $this->get('id'));
                //Couldn't load a model based on the id provided
                return true;
            }

            //Deny if user is trying to modify a user other than themselves
            if ($userModel->id != $user->id) {
                
                \Log::error('User ' . $user->id . ' not authorized to update user: ' . $this->get('id'));
                return true;
            }
        }
        return false;

    }

}