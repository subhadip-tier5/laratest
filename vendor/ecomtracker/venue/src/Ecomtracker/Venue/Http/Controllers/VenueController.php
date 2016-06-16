<?php namespace Ecomtracker\Venue\Http\Controllers;

use Ecomtracker\User\Models\User;
use Ecomtracker\Venue\Http\Requests\ShowRequest;
use Ecomtracker\Venue\Http\Requests\DestroyRequest;
use Ecomtracker\Venue\Http\Requests\StoreRequest;
use Ecomtracker\Venue\Http\Requests\UpdateRequest;
use Ecomtracker\Venue\Models\Venue;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;


class VenueController extends Controller
{

    public function show(ShowRequest $request, $id = null)
    {
        $venue = Venue::where('id', '=', $id)->firstOrFail();
        return $venue;

    }

    public function store(StoreRequest $request)
    {
        $user = User::Logined()->first();

        if (!$user->isAdmin()) {

            $venue = Venue::getModel()->fill($request->all());
            $venue->user_id = $user->id;
            $venue->save();

        } else {
            //If we are an admin accept the user
            $venue = Venue::getModel()->fill($request->all());
            $venue->user_id = $user->id;
            if (!$request->has('user_id')) {
                $venue->user_id = $user->id;
            }
            $venue->save();


        }
        return $venue;


    }

    public function update(UpdateRequest $request, $id = null)
    {
        //@todo ajw! this needs to be error checking
        $venue = Venue::where('id', '=', $id)->firstOrFail();
        $result = ['status' => 'success', 'code' => '200'];
        $venue->fill($request->all());

        $venue->save();
        return response()->json(compact('result'));

    }

    public function destroy(DestroyRequest $request, $id = null)
    {
        Venue::destroy($id);
        $result = ['status' => 'success', 'code' => '200', 'action' => 'destroy', 'id' => $id];
        return response()->json(compact('result'));

    }


}