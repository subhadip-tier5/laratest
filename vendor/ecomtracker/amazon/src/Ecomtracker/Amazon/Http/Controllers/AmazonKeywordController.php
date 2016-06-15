<?php namespace Ecomtracker\Amazon\Http\Controllers;

use Ecomtracker\Amazon\Http\Requests\ShowRequest;
use Ecomtracker\Amazon\Http\Requests\DestroyRequest;
use Ecomtracker\Amazon\Http\Requests\StoreRequest;
use Ecomtracker\Amazon\Http\Requests\UpdateRequest;
use Ecomtracker\Keyword\Models\Keyword as ParentKeyword;
use Ecomtracker\Product\Models\Product as ParentProduct;

use Ecomtracker\Amazon\Models\Keyword as AmazonKeyword;
use Ecomtracker\Amazon\Models\Product as AmazonProduct;
use Ecomtracker\Source\Models\Source;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;


class AmazonKeywordController extends Controller
{

    public function show(ShowRequest $request, $id = null)
    {
        $user = AmazonKeyword::LoginedUser()->where('id','=',$id)->firstOrFail();
        return $user;

    }

    public function store(StoreRequest $request)
    {
        $keyword = AmazonKeyword::getModel()->fill($request->all());
        $Source=Source::where('source',AmazonKeyword::class)->get()->first();
        $keyword->source_id=$Source->id;
        $keyword->save();

        // tracking amazon keyword immediatelly

        $keyword->GetAndTrackAmazonInfo();

        return $keyword;
    }

    public function update(UpdateRequest $request, $id = null)
    {
        $keyword = AmazonKeyword::LoginedUser()->where('id', '=', $id)->firstOrFail();
        $result = ['status' => 'success', 'code' => '200'];
        $keyword->fill($request->all());

        $keyword->save();
        return response()->json(compact('result'));

    }

    public function destroy(DestroyRequest $request, $id = null)
    {
        AmazonKeyword::LoginedUser()->where('id', '=', $id)->firstOrFail()->delete();
        $result = ['status' => 'success', 'code' => '200','action' => 'destroy', 'id' => $id];
        return response()->json(compact('result'));

    }

    public function history(ShowRequest $request,$id = null)
    {

            $date_from=$request->input('date_from');
            $date_to=$request->input('date_to');
            $limit=$request->input('limit');

            $KeywordHistory = AmazonKeyword::LoginedUser()->where('id','=',$id)->first()->history();
            if ( $date_from)
            {
                $KeywordHistory->where('created_at','>=',$date_from);
            }
            if ( $date_to)
            {
                $KeywordHistory->where('created_at','<=',$date_to);
            }
            if ( $limit)
            {
                $KeywordHistory->take($limit);
            }
            $KeywordHistory->orderBy('id', 'desc');
            $KeywordHistory_col=$KeywordHistory->get();

            return response()->json($KeywordHistory_col);



    }


    public function AddAmazonKeywords(StoreRequest $request)
    {

        // for async front-end

        ignore_user_abort(true);
        set_time_limit(3600);

        $keywords_array=json_decode($request->input('keywords_array'));

        $result_added=[];
        foreach ((array) $keywords_array as $keyword_item)
        {

            $keyword = AmazonKeyword::getModel()->fill($request->all());
            $keyword->value=$keyword_item->value;
            $keyword->marketplace=$keyword_item->marketplace;


            $Source=Source::where('source',AmazonKeyword::class)->get()->first();
            $keyword->source_id=$Source->id;
            $keyword->save();

            // tracking amazon keyword immediatelly

            $keyword->GetAndTrackAmazonInfo();
            $result_added[]=$keyword;
        }
        return response()->json($result_added);

    }

}