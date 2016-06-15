<?php namespace Ecomtracker\Api\Http\Controllers;


use App\Http\Controllers\Controller;
use Ecomtracker\Keyword\Models\Keyword;
use Ecomtracker\User\Models\User;
use Ecomtracker\Venue\Models\Venue;

class TestController extends Controller
{

    public function index()
    {
        $keyword = \Ecomtracker\Semrush\Models\Keyword::where('id','=','41')->first();

        $keyword->buildPhraseRelated($keyword->getClient(),1);           
        
    }
    
}