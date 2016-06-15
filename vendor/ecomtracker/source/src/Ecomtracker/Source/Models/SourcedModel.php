<?php namespace Ecomtracker\Source\Models;

use Illuminate\Database\Eloquent\Model;

class SourcedModel extends Model
{
    protected $source;

    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function syncToSource($sourceModel = null)
    {
        

        if(isset($sourceModel))
        {
            $source = $sourceModel;

            $this->source_model_id = $source->id;
            $this->source_id = $source->source_id;
            $this->value = $source->value;
        }
        

        return $this;
    }


    public function sourceConfig()
    {
        return $this->hasOne('Ecomtracker\Source\Models\Source','id','source_id');
    }


    public function source()
    {
        if(isset($this->source_model_id))
        {
            return $this->hasOne($this->sourceConfig->source,'id','source_model_id');
        }

        return $this->hasOne($this->sourceConfig->source,'entity_id','id');
    }


    public function findOrCreate($condition, $data = null)
    {

        //Find existing based on conditions
        $model = $this->getModel();

        //filter the model foreach of the conditions
        foreach($condition as $condition)
        {
            $model = $model->where($condition[0],'=',$condition[1]);
        }

        $model = $model->first();


        //If existing return that model

        if (isset($data) && isset($model) && $model != null) {
            foreach ($data as $k => $v) {
                $model->{$k} = $v;
            }
            $model->save();
        }


        if($model && $model != null) return $model;


        $model = $this->getModel();
        //If we passed data set it to the found model and save
        if (isset($data) && isset($model)) {
            foreach ($data as $k => $v) {
                $model->{$k} = $v;
            }
            $model->save();
        }

        return $model;
    }



    
    
}