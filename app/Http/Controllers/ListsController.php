<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test_list;
use App\Http\Requests;

class ListsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $lists = Test_list::all();
//        echo '<pre>';
//        print_r($lists);
//        dd($lists);
        return view('lists', compact('lists'));
    }
    
    public function show($slug){
//        dd($slug);
        $list = Test_list::where('slug', $slug)->get();
      // dd($list->toArray());
        return view('list', compact('list'));
    }

    public function update($slug, Request $request){
//        dd($slug);
        Test_list::where('slug', $slug)->update(array('title' => $request->input('title')));
        return redirect('lists');
    }
}
