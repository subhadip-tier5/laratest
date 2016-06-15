<?php namespace Ecomtracker\Keyword\Http\Controllers;

use App\Http\Controllers\Controller;
use Ecomtracker\Keyword\Http\Requests\Paid\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Paid\UpdateRequest;
use Ecomtracker\Keyword\Models\Keyword;

class PaidController extends Controller
{

    public function show(ShowRequest $request, $keyword_id = null)
    {
        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();
        $paid = $keywordCollection->paid();

        return $paid;
    }


    public function update(UpdateRequest $request, $keyword_id = null)
    {

        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();

        foreach($keywordCollection as $keyword)
        {
            $keyword->updatePaid($request->has('limit') ? $request->get('limit') : 1,$request->has('force') ? $request->get('force') : 0);
        }
        $organic = $keywordCollection->paid();

        return $organic;

    }

    
    
    
}