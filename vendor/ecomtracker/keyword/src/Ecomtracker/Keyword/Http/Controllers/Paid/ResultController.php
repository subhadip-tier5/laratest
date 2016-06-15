<?php namespace Ecomtracker\Keyword\Http\Controllers\Paid;

use App\Http\Controllers\Controller;
use Ecomtracker\Keyword\Http\Requests\Paid\Result\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Paid\Result\UpdateRequest;
use Ecomtracker\Keyword\Models\Keyword;

class ResultController extends Controller
{

    public function show(ShowRequest $request, $keyword_id = null)
    {
        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();
        $paid = $keywordCollection->paid();

        $resultCollection = $keywordCollection->paid()->results();

        return $resultCollection;
    }


    public function update(UpdateRequest $request, $keyword_id = null)
    {

        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();

        foreach($keywordCollection as $keyword)
        {
            $keyword->updatePaidResults($request->has('limit') ? $request->get('limit') : 1,$request->has('force') ? $request->get('force') : 0);
        }

        $resultCollection = $keywordCollection->paid()->results();
        return $resultCollection;

    }

    
    
    
}