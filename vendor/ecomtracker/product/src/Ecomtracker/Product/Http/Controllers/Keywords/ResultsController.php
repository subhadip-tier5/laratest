<?php namespace Ecomtracker\Product\Http\Controllers\Keywords;

use Ecomtracker\Keyword\Models\Keyword;
use Ecomtracker\Product\Http\Requests\Keywords\Results\ShowRequest;
use Ecomtracker\Product\Models\Product;
use App\Http\Controllers\Controller;


class ResultsController extends Controller
{

    public function show(ShowRequest $request, $id = null)
    {
        $amazonProduct = \Ecomtracker\Amazon\Models\Product::where('id','=',$id)->firstOrFail();
        $amazonProduct->AmazonKeywords;




        //@todo JAKE! please return a collection of keywords based on the product $id and set that collection to the keywordCollection value
        $keywordCollection = Keyword::all();
        $results = $keywordCollection->results();

        if($request->has('operation'))
        {
            $operation = $request->get('operation');

            if($operation == 'sum') {
                $return = $results->sum($request->get('operation_field'));
                return $return;
            } elseif ($operation == 'avg') {
                $return = $results->avg($request->get('operation_field'));
                return $return;

            } elseif ($operation == 'sort') {
                $direction = $request->has('dir') ? $request->get('dir') : 'desc';

                if($direction == 'desc')
                {
                    $return = $results->sortBy($request->get('operation_field'));
                }else{
                    $return = $results->sortByDesc($request->get('operation_field'));
                }
                return $return;
                
            }else{
                abort('500','Invalid Operation');
            }
        }else{
            return $results;
        }
    }



}