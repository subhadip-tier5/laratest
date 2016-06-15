<?php namespace Ecomtracker\Keyword\Http\Controllers;

use App\Http\Controllers\Controller;
use Ecomtracker\Keyword\Http\Requests\Related\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Related\UpdateRequest;
use Ecomtracker\Keyword\Models\Keyword;

class RelatedController extends Controller
{

    public function show(ShowRequest $request, $keyword_id = null)
    {

        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();

        return $keywordCollection->related();
        
    }


    public function update(UpdateRequest $request, $keyword_id = null)
    {
        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();

        foreach($keywordCollection as $keyword)
        {
            $keyword->updateRelated($request->has('limit') ? $request->get('limit') : 1,$request->has('force') ? $request->get('force') : 0);
        }


        return $keywordCollection->related();

    }
}