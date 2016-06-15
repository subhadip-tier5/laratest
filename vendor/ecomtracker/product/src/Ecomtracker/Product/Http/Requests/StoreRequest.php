<?php namespace Ecomtracker\Product\Http\Requests;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class StoreRequest extends Request
{
    use Permissible;


    public function rules()
    {
        return [
            'source_key' => 'required',
            'source_id' => 'required'
        ];
        //@todo ajw! these need to be defined.

    }

}