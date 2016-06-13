<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test_list as Testlist;
use App\Http\Requests;

class ListsController extends Controller
{
    //
    public function index(){
        $lists = Testlist::all();
//        echo '<pre>';
//        print_r($lists);
//        dd($lists);
        return view('lists', compact('lists'));
    }
    
    public function update($slug, Request $request){
//        dd($slug);
        Testlist::where('slug', $slug)->update(array('title' => $request->input('title')));
        return redirect('lists');
    }
}
