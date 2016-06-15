<?php namespace Ecomtracker\User\Http\Controllers;

use Ecomtracker\Api\Exceptions\DestroyException;
use Ecomtracker\User\Http\Requests\ShowRequest;
use Ecomtracker\User\Http\Requests\DestroyRequest;
use Ecomtracker\User\Http\Requests\StoreRequest;
use Ecomtracker\User\Http\Requests\UpdateRequest;
use Ecomtracker\User\Models\User;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;


class UserController extends Controller
{

    public function show(ShowRequest $request)
    {
        if($request->has('id'))
        {
            try{
                $user = User::getModel()->where('id', '=', $request->get('id'))->firstOrFail();
            }catch(\Exception $e)
            {
                \Log::error('Could not find a user with a matching id:'. $request->get('id'));
                $result = ['status' => 'success', 'code' => '500'];
                return response()->json(compact('result'));

            }
        }else{

            $user = \JWTAuth::parseToken()->authenticate();

        }

        return $user;

    }

    public function update(UpdateRequest $request)
    {


        if ($request->has('id')) {
            try {
                $user = User::getModel()->where('id', '=', $request->get('id'))->firstOrFail();
            } catch (\Exception $e) {
                \Log::info('UserController update error: '.$e->getMessage());
            }
        } else {

            $user = \JWTAuth::parseToken()->authenticate();

        }

        

        if (isset($user)) {
            $user->fill($request->all());

            if ($request->has('password')) $user->password = \Hash::make($request->get('password'));

            try{
                $user->save();
                $result = ['status' => 'success', 'code' => '200'];
            }catch(\Exception $e)
            {
                $result = ['status' => 'failure', 'code' => '500','message' => $e->getMessage()];
            }          
            
            
            
        }
        return response()->json(compact('result'));
    }

}