<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Http\Requests;
use App\Customer;

class CustomersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Customer $customer){
//        abort(404);
//        abort(403, 'Unauthorized action.');
//        Log::info('testing for customer section');
        $customers = $customer->all();
//        echo test('tttttt');
//        dd($customers);
        return view('customers', compact('customers'));
    }
    
    public function show(Customer $customer, $id){
        $customer = $customer->find($id);
        return view('customer', compact('customer'));
    }
}
