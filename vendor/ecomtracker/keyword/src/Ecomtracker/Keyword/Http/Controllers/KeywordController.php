<?php namespace Ecomtracker\Keyword\Http\Controllers;

use Ecomtracker\Keyword\Http\Requests\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\DestroyRequest;
use Ecomtracker\Keyword\Http\Requests\StoreRequest;
use Ecomtracker\Keyword\Http\Requests\UpdateRequest;
use Ecomtracker\Keyword\Models\Keyword;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;


class KeywordController extends Controller
{

    public function show(ShowRequest $request, $id = null)
    {
        $user = Keyword::where('id','=',$id)->firstOrFail();
        return $user;

    }

    public function store(StoreRequest $request)
    {
        //@todo ajw! define this
        // $keyword = Keyword::getModel()->fill($request->all());
        // $keyword->save();
        // return $keyword;
         $keywords_array=json_decode($request->input('value'));

        $result_added=[];
        foreach ((array) $keywords_array as $keyword_item)
        {

            $keyword = Keyword::getModel()->fill($request->all());
            $keyword->value=$keyword_item->value;
            $keyword->source_id=2;
            //$keyword->source_model_id=$keyword_item->source_model_id;
            $keyword->save();
            $result_added[]=$keyword;
        }
        return response()->json($result_added);
    }

    public function update(UpdateRequest $request, $id = null)
    {
        //@todo ajw! this needs to be error checking
        $keyword = Keyword::where('id', '=', $id)->firstOrFail();
        $result = ['status' => 'success', 'code' => '200'];
        $keyword->fill($request->all());

        $keyword->save();
        return response()->json(compact('result'));

    }

    public function destroy(DestroyRequest $request, $id = null)
    {
            Keyword::destroy($id);
            $result = ['status' => 'success', 'code' => '200','action' => 'destroy', 'id' => $id];
            return response()->json(compact('result'));

    }






}