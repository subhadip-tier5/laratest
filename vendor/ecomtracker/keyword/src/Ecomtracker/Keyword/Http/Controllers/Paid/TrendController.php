<?php namespace Ecomtracker\Keyword\Http\Controllers\Paid;

use App\Http\Controllers\Controller;
use Ecomtracker\Keyword\Http\Requests\Paid\Trend\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Paid\Trend\UpdateRequest;
use Ecomtracker\Keyword\Models\Keyword;

class TrendController extends Controller
{

    public function show(ShowRequest $request, $keyword_id = null)
    {
        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();
        $trendCollection = $keywordCollection->paid()->trend()->keyBy('date');

        return $trendCollection;
    }


    public function update(UpdateRequest $request, $keyword_id = null)
    {

        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();

        foreach($keywordCollection as $keyword)
        {
            $keyword->updatePaidTrend($request->has('limit') ? $request->get('limit') : 1,$request->has('force') ? $request->get('force') : 0);
        }

        $trendCollection = $keywordCollection->paid()->trend()->keyBy('date');

        return $trendCollection;

    }

    
    
    
}