<?php namespace Ecomtracker\Product\Http\Controllers;

use Ecomtracker\Product\Http\Requests\ShowRequest;
use Ecomtracker\Product\Http\Requests\DestroyRequest;
use Ecomtracker\Product\Http\Requests\StoreRequest;
use Ecomtracker\Product\Http\Requests\UpdateRequest;
use Ecomtracker\Product\Models\Product;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{

    public function show(ShowRequest $request, $id = null)
    {
        $user = Product::where('id','=',$id)->firstOrFail();
        return $user;

    }

    public function store(StoreRequest $request)
    {
        //@todo ajw! define this more
        $product = Product::getModel()->fill($request->all());
        $product->save();
        return $product;
    }

    public function update(UpdateRequest $request, $id = null)
    {
        //@todo ajw! this needs to be error checking
        $product = Product::where('id', '=', $id)->firstOrFail();
        $result = ['status' => 'success', 'code' => '200'];
        $product->fill($request->all());

        $product->save();
        return response()->json(compact('result'));

    }

    public function destroy(DestroyRequest $request, $id = null)
    {
            Product::destroy($id);
            $result = ['status' => 'success', 'code' => '200','action' => 'destroy', 'id' => $id];
            return response()->json(compact('result'));

    }






}