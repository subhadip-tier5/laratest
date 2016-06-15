<?php namespace Ecomtracker\Keyword\Http\Controllers\Paid;

use App\Http\Controllers\Controller;
use Ecomtracker\Keyword\Http\Requests\Paid\Distribution\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Paid\Distribution\UpdateRequest;
use Ecomtracker\Keyword\Models\Keyword;

class DistributionController extends Controller
{

    public function show(ShowRequest $request, $keyword_id = null)
    {
        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();
        $paid = $keywordCollection->paid();
        $distribution = $paid->distribution();

        return $distribution;
    }


    public function update(UpdateRequest $request, $keyword_id = null)
    {

        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();

        foreach($keywordCollection as $keyword)
        {
            $keyword->updatePaidDistribution($request->has('limit') ? $request->get('limit') : 1,$request->has('force') ? $request->get('force') : 0);
        }


        $distributionCollection = $keywordCollection->paid()->distribution();

        return $distributionCollection;

    }

    
    
    
}