<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Http\Requests;
use App\Customer;

class CustomerController extends Controller
{
    //
    public function index(){
//        abort(404);
//        abort(403, 'Unauthorized action.');
        Log::info('testing for customer section');
        $customers = Customer::all();
//        dd($customers);
        return view('customers', compact('customers'));
    }
}
