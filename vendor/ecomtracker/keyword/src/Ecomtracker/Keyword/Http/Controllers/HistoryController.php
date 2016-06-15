<?php namespace Ecomtracker\Keyword\Http\Controllers;

use Ecomtracker\Keyword\Http\Requests\History\ShowRequest;
use Ecomtracker\Keyword\Models\Keyword;
use App\Http\Controllers\Controller;


class HistoryController extends Controller
{
    public function show(ShowRequest $request, $id = null)
    {
        $keyword = Keyword::where('id','=',$id)->firstOrFail();

        $history = $keyword->history;
        

        $user = Keyword::where('id','=',$id)->firstOrFail();
        return $user;

    }
}