<?php

class UserTest extends \PHPUnit_Framework_TestCase
{

    public function testLogin()
    {
        $login_data = [
            'email' => 'admin@test.com',
            'password' => 'password',
        ];
        $this->client->request('POST', '\Ecomtracker\User\Controllers\LoginController@login',$login_data);




    }
}