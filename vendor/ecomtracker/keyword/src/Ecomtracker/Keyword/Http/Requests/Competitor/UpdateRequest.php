<?php namespace Ecomtracker\Keyword\Http\Requests\Competitor;

use App\Http\Requests\Request;
use Ecomtracker\User\Traits\Permissible;

class UpdateRequest extends Request
{
    use Permissible;

    public function rules()
    {
        return [
            'value' => 'required',
            'source_id' => 'required' //@todo ajw! tie to source
        ];
        //@todo ajw! these need to be defined.

    }

}