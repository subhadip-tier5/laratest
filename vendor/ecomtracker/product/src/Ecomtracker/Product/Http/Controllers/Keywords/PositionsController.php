<?php namespace Ecomtracker\Product\Http\Controllers\Keywords;

use Ecomtracker\Product\Http\Requests\Keywords\Positions\ShowRequest;
use Ecomtracker\Product\Models\Product;
use App\Http\Controllers\Controller;


class PositionsController extends Controller
{

    public function show(ShowRequest $request, $id = null)
    {
        $user = Product::where('id','=',$id)->firstOrFail();
        return $user;

    }



    
}