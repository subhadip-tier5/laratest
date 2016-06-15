<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use WithoutMiddleware;


    public function testLogin()
    {
        $faker = Faker\Factory::create();

        $user_details = [
            'password' => \Hash::make('password'),
            'email' => $faker->email,
        ];

        $user = \Ecomtracker\User\Models\User::create($user_details);

        $login_details = [
            'password' => 'password',
            'email' => $user_details['email'],
        ];

        $response = $this->action('POST', '\Ecomtracker\Api\Http\Controllers\User\AuthController@post', $login_details);

        $content = json_decode($response->getContent());

        $this->assertEquals('success',$content->result->status);

        //@todo ajw! this should also assert that the user is logged in in terms of session / JWT

        //Delete that model
        if (isset($user->id)) {
            \Ecomtracker\User\Models\User::destroy($user->id);
        }

    }


    public function testUpdate()
    {
        $faker = Faker\Factory::create();

        $user_details = [
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'email' => $faker->email,
        ];

        //Create the new user
        $user = \Ecomtracker\User\Models\User::create($user_details);
        $this->seeInDatabase('users', ['id' => $user->id]);
        $user_details['email'] = 'test@test.com';
        $user_details['id'] = $user->id;

        //Update
        $response = $this->action('PUT', '\Ecomtracker\Api\Http\Controllers\UserController@update', $user->id, $user_details);

        //@todo ajw! assert that the confirmed value on this record has changed to 0
        $this->seeInDatabase('users', ['id' => $user->id, 'email' => $user_details['email']]);

        \Ecomtracker\User\Models\User::destroy($user->id);
    }

    public function testStore()
    {
        $faker = Faker\Factory::create();

        $user_details = [
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'email' => $faker->email,
            'confirmed' => 1,
            '_token' => \Session::token()
        ];

        $response = $this->action('POST', '\Ecomtracker\Api\Http\Controllers\UserController@store', $user_details);

        $content = json_decode($response->getContent());
        $this->assertInternalType("int", $content->id);
        $this->seeInDatabase('users', ['id' => $content->id]);

        //Delete that model
        if (isset($content->id)) {
            \Ecomtracker\User\Models\User::destroy($content->id);
        }
    }


    public function testDestroy()
    {
        $faker = Faker\Factory::create();

        $user_details = [
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'email' => $faker->email,
        ];

        //Create the new user
        $user = \Ecomtracker\User\Models\User::create($user_details);
        $this->seeInDatabase('users', ['id' => $user->id]);


        //Update
        $response = $this->action('DELETE', '\Ecomtracker\Api\Http\Controllers\UserController@destroy', $user->id);

        $this->notSeeInDatabase('users', ['id' => $user->id]);
        //Delete Model
        \Ecomtracker\User\Models\User::destroy($user->id);
    }


}