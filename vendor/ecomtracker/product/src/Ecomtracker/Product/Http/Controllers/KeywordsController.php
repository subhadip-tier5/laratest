<?php namespace Ecomtracker\Product\Http\Controllers;

use Ecomtracker\Product\Http\Requests\Keywords\ShowRequest;
use Ecomtracker\Product\Models\Product;
use App\Http\Controllers\Controller;


class KeywordsController extends Controller
{

    public function show(ShowRequest $request, $product_id = null)
    {

        //@todo AJW! this is a really crappy way to do this, we should be able to call $product->keywords, not specify that we only want amazon
        //This will cause issues as soon as we incorporate another marketplace. However with the way that amazon's package is setup this isn't possible
        try{
            $product = Product::where('id','=',$product_id)->firstOrFail();
            $amazonProduct = \Ecomtracker\Amazon\Models\Product::where('id','=',$product->source_key)->firstOrFail();
            $keywords = $amazonProduct->AmazonKeywords;

            $keywords = $keywords->organic();


        }catch(\Exception $e)
        {
            dd($e->getMessage());
        }

        //Operations sum|avg|sort
        if($request->has('operation') && $request->has('operation_field'))
        {
            $operation = $request->get('operation');
            $operation_field = $request->get('operation_field');

            if($operation == 'sum')
            {
                $keywords = $keywords->sum($operation_field);

            }elseif($operation == 'avg')
            {
                $keywords = $keywords->avg($operation_field);

            }elseif($operation == 'sort')
            {
                if($request->has('dir'))
                {
                    $sort_direction = $request->get('dir');
                    if($sort_direction == 'asc')
                    {
                        $keywords = $keywords->sortBy($operation_field);
                    }else{
                        $keywords = $keywords->sortByDesc($operation_field);
                    }
                }else{
                    $keywords = $keywords->sortBy($operation_field);

                }


            }else{
                //Do something else if the operation is set but the value is not in this list
            }

            return $keywords;


        }















        dd($keywords->organic());
        
        
        dd($keywords);

        foreach($keywords as $keyword)
        {
            dd($keyword->toArray());
        }



        $user = Product::where('id','=',$id)->firstOrFail();
        return $user;

    }
}