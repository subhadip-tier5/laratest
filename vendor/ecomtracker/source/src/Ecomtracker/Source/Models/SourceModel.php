<?php namespace Ecomtracker\Source\Models;

use Illuminate\Database\Eloquent\Model;

class SourceModel extends Model
{
    protected $entity;
    

    public function setEntity(Model $entity)
    {
        $this->entity = $entity;
        $this->entity_id = $entity->id;
        return $this;
    }

    public function getEntity()
    {
        if(isset($this->entity))
        {
            return $this->entity;
        }

        return null;
    }

    public function sourceConfig()
    {
        return $this->hasOne('Ecomtracker\Source\Models\Source','id','source_id');
    }


    public function entity()
    {
        if(isset($this->entity_id) && $this->entity_id != 0)
        {
        return $this->hasOne($this->sourceConfig->entity,'id','entity_id')->where('source_id','=',$this->source_id);
        }else{
            return $this->hasOne($this->sourceConfig->entity,'source_model_id','=',$this->id)->where('source_id','=',$this->source_id);
        }
    }
    

    public function syncToEntity()
    {
        if($this->getEntity())
        {
            $this->entity_id = $this->getEntity()->id;
            $this->source_id = $this->getEntity()->source_id;
            $this->value = $this->getEntity()->value;
        }
    }

    public function findOrCreate($condition, $data = null)
    {
        //Find existing based on conditions
        $model = $this->getModel()->where($condition[0],'=',$condition[1])->first();
        //If existing return that model

        if (isset($data) && isset($model)) {
            foreach ($data as $k => $v) {
                $model->{$k} = $v;
            }
            $model->save();
        }

        if($model) return $model;


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