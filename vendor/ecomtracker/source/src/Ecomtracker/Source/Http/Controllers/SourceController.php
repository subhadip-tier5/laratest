<?php namespace Ecomtracker\Source\Http\Controllers;

use App\Http\Controllers\Controller;
use Ecomtracker\Source\Http\Requests\IndexRequest;
use Ecomtracker\Source\Models\Source;

class SourceController extends Controller
{
    public function index(IndexRequest $request)
    {
        $sourceCollection = Source::all();
        return $sourceCollection;
        
    }
    
    
    
    
}