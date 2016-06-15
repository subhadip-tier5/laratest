<?php namespace Ecomtracker\Keyword\Http\Controllers;

use Ecomtracker\Keyword\Http\Requests\Search\ShowRequest;
use Ecomtracker\Keyword\Models\Keyword;
use App\Http\Controllers\Controller;


class SearchController extends Controller
{


    /**
     * @description returns keywords and related keywords based on a piece of a keyword or a phrase
     * @param ShowRequest $request
     * @param null $keyword_id
     * @return mixed
     */
    public function show(ShowRequest $request)
    {
        $keywords = Keyword::where('value','LIKE','%'.$request->get('q').'%')->get();
        return $keywords->combineLikeValues();

    }





}