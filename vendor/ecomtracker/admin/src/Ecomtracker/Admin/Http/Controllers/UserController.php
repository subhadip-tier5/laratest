<?php namespace Ecomtracker\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Ecomtracker\Admin\Http\Requests\User\IndexRequest;
use Ecomtracker\Admin\Http\Requests\User\ShowRequest;
use Ecomtracker\Admin\Http\Requests\User\CreateRequest;
use Ecomtracker\Admin\Http\Requests\User\StoreRequest;
use Ecomtracker\Admin\Http\Requests\User\UpdateRequest;
use Ecomtracker\Admin\Http\Requests\User\UpdatePasswordRequest;
use Ecomtracker\Admin\Http\Requests\User\UpdateCardRequest;
use Ecomtracker\Admin\Http\Requests\User\DestroyRequest;
use Ecomtracker\Admin\Http\Requests\User\LoginAsRequest;
use Ecomtracker\User\Models\User;
use Illuminate\Contracts\Auth\Guard;


class UserController extends Controller
{
    public function __construct(User $user, Guard $auth)
    {
        $this->user = $user;
        $this->auth = $auth;
    }


    public function index(IndexRequest $request)
    {
        $perPage = 10;
        $currentPage = 1;

        $request->setSearchableModel('user', $this->user);

        $query = $request->result($request);

        if (is_null($query)) $query = $this->user->newQuery();

        $data = array(
            'customers' => $query->paginate($perPage)
        );
        return response()->view('admin::pages.user.index', $data);

    }


    public function loginAs(LoginAsRequest $request,$user_id = null)
    {
        $this->auth->loginUsingId($user_id);
        return redirect('/');
    
    }


    public function show(ShowRequest $request)
    {

    }

    public function create(CreateRequest $request)
    {

    }

    public function store(StoreRequest $request)
    {

    }

    public function update(UpdateRequest $request, $user_id = null)
    {
        try{
            $user = User::where('id','=',$user_id)->firstOrFail();
        }catch(\Exception $e)
        {
            return redirect()->back()->withErrors('No user found');
        }

        $parameters = array_filter($request->only(
            'full_name',
            'telephone',
            'street1',
            'email',
            'city',
            'website',
            'state',
            'postal',
            'country'
        ));


        foreach($parameters as $k => $v)
        {
            $user->{$k} = $v;
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors('Error when saving user: ' . $e->getMessage());
        }

        \Session::flash('flash_message','User Updated'); //<--FLASH MESSAGE

        return redirect()->back();

    }
    
    public function updatePassword(UpdatePasswordRequest $request, $user_id = null)
    {
        try{
        $user = User::where('id','=',$user_id)->firstOrFail();
        }catch(\Exception $e)
        {
            return redirect()->back()->withErrors('No user found');
        }

        $user->password = \Hash::make($request->get('password'));
        try {
            $user->save();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error when saving user: ' . $e->getMessage());
        }

        \Session::flash('flash_message','Password Updated'); //<--FLASH MESSAGE

        return redirect()->back();     
        
    }
    
    public function updateCard(UpdateCardRequest $request, $user_id = null)
    {

        
        try{
            $user = User::where('id','=',$user_id)->firstOrFail();
        }catch(\Exception $e)
        {
            return redirect()->back()->withErrors('No user found');
        }

        $values = array_filter($request->only('card_number','card_expiry','card_cvv'));

        foreach($values as $k => $v)
        {
            $user->{$k} = $v;
        }

        $user->save();
    }
    
    

    public function destroy(DestroyRequest $request)
    {

    }


}