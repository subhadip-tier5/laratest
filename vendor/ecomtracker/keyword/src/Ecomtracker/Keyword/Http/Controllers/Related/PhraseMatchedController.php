<?php namespace Ecomtracker\Keyword\Http\Controllers\Related;

use Ecomtracker\Keyword\Http\Requests\Related\PhraseMatched\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Related\PhraseMatched\UpdateRequest;
use App\Http\Controllers\Controller;
use Ecomtracker\Keyword\Models\Keyword;

class PhraseMatchedController extends Controller
{

    public function show(ShowRequest $request, $keyword_id = null)
    {
        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();

        $relatedFullsearchCollection = $keywordCollection->relatedFullsearch();

        return $relatedFullsearchCollection;
    }


    public function update(UpdateRequest $request, $keyword_id = null)
    {
        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();

        foreach($keywordCollection as $keyword)
        {
            $keyword->updateRelatedPhraseMatched($request->has('limit') ? $request->get('limit') : 1,$request->has('force') ? $request->get('force') : 0);
        }

        $relatedFullsearchCollection = $keywordCollection->relatedFullsearch();

        return $relatedFullsearchCollection;

    }




}