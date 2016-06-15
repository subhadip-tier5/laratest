<?php namespace Ecomtracker\Venue\Http\Requests\Config;

use App\Http\Requests\Request;
use Ecomtracker\User\Models\User;
use Ecomtracker\User\Traits\Permissible;
use Ecomtracker\Venue\Models\Venue;

class ShowRequest extends Request
{
    //@todo AJW! the permissions need to be worked out related to this
    use Permissible;

    public function rules()
    {
        return [];
    }

    public function denies(User $user)
    {
        //@todo AJW! this may need refinement to restrict admin users from doing some things
        if($user->isAdmin()) return false;

        //If we dont have a venue id deny access
        if(!isset($this->venue))
        {
            return true;
        }

        try{
            $venueModel = Venue::where('id','=',$this->venue)->firstOrFail();
        }catch(\Exception $e)
        {
            //Couldn't load a model based on the id provided
            return true;
        }

        //If the user trying to update the record is not the record owner
        if(!$venueModel->user || $venueModel->user->id != $user->id)
        {
            return true;
        }

        return false;

    }

}