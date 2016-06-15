<?php namespace Ecomtracker\User;

use Illuminate\Auth\Guard;
use Ecomtracker\User\Models\User\Guest;

class Auth extends Guard
{

    public function user()
    {
        //@todo ajw! this should also fire up the JWT-AUTH
        if(!$user = parent::user())
        {
            $user = new Guest();
        }
        return $user;
    }


}

