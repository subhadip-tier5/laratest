<?php namespace Ecomtracker\Domain\Models;



use Ecomtracker\Source\Models\SourcedModel;
use Illuminate\Database\Eloquent\Model;

class Domain extends SourcedModel
{
    protected $table = 'domains';
    
    protected $fillable = [
        'value',
        'source_id',
        'source_model_id',
    ];


    public function setData($array = [])
    {
        $this->data = json_encode($array);
        return $this;
    }


    public function getData()
    {
        return json_decode($this->data);
    }

    public function mergeData($array = [])
    {
        if($this->getData())
        {
            $existing_data = $this->getData();

        }

        //If we didn't have existing data just set the data
        if(!isset($existing_data))
        {
            $this->setData($array);
            return $this;

        }

        //Otherwise we apend each value to the data array and set the data
        foreach($array as $k => $v)
        {
            $existing_data->{$k} = $v;
        }

        $this->setData($existing_data);
        return $this;


    }

}