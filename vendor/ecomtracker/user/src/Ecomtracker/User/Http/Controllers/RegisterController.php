<?php namespace Ecomtracker\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Ecomtracker\User\Http\Requests\Register\PostRequest;
use Ecomtracker\User\Models\Role;
use Ecomtracker\User\Models\User;

class RegisterController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function post(PostRequest $request)
    {
        //Gather Input
        $input = $request->only(
            'email',
            'password',
            'street1',
            'street2',
            'firstname',
            'lastname',
            'city',
            'state',
            'postal',
            'country',
            'asi_licence_code'
            
        );

        //Generate random confirmation code
        $confirmation_code = str_random(30);

        //Create user
        $user=User::create([
            'email' => $input['email'],
            'password' => \Hash::make($input['password']),
            'confirmation_code' => $confirmation_code,
            'street1' => $input['street1'],
            'street2' => $input['street2'],
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'city' => $input['city'],
            'state' => $input['state'],
            'postal' => $input['postal'],
            'country' => $input['country'],
            'asi_licence_code' => $input['asi_licence_code']
        ]);

        $role = Role::where('key','=','member')->first();
        $user->roles()->attach($role->id);


        return $user;
    }






}