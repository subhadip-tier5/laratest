<?php namespace Ecomtracker\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Ecomtracker\User\Http\Requests\Venue\ShowRequest;
use Ecomtracker\User\Models\User;

class VenueController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

  
    public function show(ShowRequest $request, $user_id = null)
    {
        $user = User::where('id','=',$user_id)->firstOrFail();

        return $user->venues;
        
    }






}