<?php namespace Ecomtracker\Source\Http\Requests;


use Ecomtracker\User\Traits\Permissible;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    use Permissible;


    public function rules()
    {
        return [];
    }
    
}