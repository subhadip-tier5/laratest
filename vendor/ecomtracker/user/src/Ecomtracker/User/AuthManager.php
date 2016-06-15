<?php namespace Ecomtracker\User;

use Ecomtracker\User\Auth as GuardContract;

class AuthManager extends \Illuminate\Auth\AuthManager
{

    public function createEloquentDriver()
    {
        $provider = $this->createEloquentProvider();
        return new Auth($provider, $this->app['session.store']);
    }



}