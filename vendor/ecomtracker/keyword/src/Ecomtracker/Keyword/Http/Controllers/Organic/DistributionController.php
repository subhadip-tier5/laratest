<?php namespace Ecomtracker\Keyword\Http\Controllers\Organic;

use App\Http\Controllers\Controller;
use Ecomtracker\Keyword\Http\Requests\Organic\Distribution\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Organic\Distribution\UpdateRequest;
use Ecomtracker\Keyword\Models\Keyword;

class DistributionController extends Controller
{

    public function show(ShowRequest $request, $keyword_id = null)
    {
        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();
        $organic = $keywordCollection->organic();
        
        //dd($organic);
        $distributionCollection = $organic->distribution();

        return $distributionCollection;
    }


    public function update(UpdateRequest $request, $keyword_id = null)
    {

        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();

        foreach($keywordCollection as $keyword)
        {
            $keyword->updateOrganic($request->has('limit') ? $request->get('limit') : 1,$request->has('force') ? $request->get('force') : 0);
        }

        $distributionCollection = $keywordCollection->organic()->distribution();
        return $distributionCollection;

    }

    
    
    
}