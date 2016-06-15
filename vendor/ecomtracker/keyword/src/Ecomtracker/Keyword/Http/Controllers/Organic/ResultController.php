<?php namespace Ecomtracker\Keyword\Http\Controllers\Organic;

use App\Http\Controllers\Controller;
use Ecomtracker\Keyword\Http\Requests\Organic\Result\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Organic\Result\UpdateRequest;
use Ecomtracker\Keyword\Models\Keyword;

class ResultController extends Controller
{

    public function show(ShowRequest $request, $keyword_id = null)
    {
        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();
        $organic = $keywordCollection->organic();
        
        $resultCollection = $organic->results();

        return $resultCollection;
    }


    public function update(UpdateRequest $request, $keyword_id = null)
    {

        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();

        foreach($keywordCollection as $keyword)
        {
            $keyword->updateOrganicResults($request->has('limit') ? $request->get('limit') : 1,$request->has('force') ? $request->get('force') : 0);
        }

        $resultCollection = $keywordCollection->organic()->results();
        return $resultCollection;

    }

    
    
    
}