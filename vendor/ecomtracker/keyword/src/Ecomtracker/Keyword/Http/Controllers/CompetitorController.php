<?php namespace Ecomtracker\Keyword\Http\Controllers;

use Ecomtracker\Keyword\Http\Requests\Competitor\ShowRequest;
use Ecomtracker\Keyword\Http\Requests\Competitor\DestroyRequest;
use Ecomtracker\Keyword\Http\Requests\Competitor\StoreRequest;
use Ecomtracker\Keyword\Http\Requests\Competitor\UpdateRequest;
use Ecomtracker\Keyword\Models\Keyword;
use App\Http\Controllers\Controller;


class CompetitorController extends Controller
{


    /**
     * @description returns a collection of competitors based on the keyword
     * @param ShowRequest $request
     * @param null $keyword_id
     * @return mixed
     */
    public function show(ShowRequest $request, $keyword_id = null)
    {

        $keyword = Keyword::where('id','=',$keyword_id)->firstOrFail();
        $keywordCollection = Keyword::where('value','=',$keyword->value)->get();
       
        
        return $keywordCollection->competitors()->combineLikeValues();
        

        

    }





}