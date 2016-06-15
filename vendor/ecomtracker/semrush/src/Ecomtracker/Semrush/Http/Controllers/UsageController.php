<?php namespace Ecomtracker\Semrush\Http\Controllers;

use Ecomtracker\Semrush\Models\Call;
use Illuminate\Routing\Controller;

class UsageController extends Controller
{

    public function index()
    {
        $calls = Call::all();
        $total_cost = $calls->sum('total_cost');

        if(\Input::has('flush') && \Input::get('flush') == 1)
        {
            Call::truncate();
        }
        
        dd($total_cost);
    }
}