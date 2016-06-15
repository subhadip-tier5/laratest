<?php namespace Ecomtracker\Semrush\Models\Keyword;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    
    protected $table = 'semrush_keyword_ads';

    protected $fillable = [
        'keyword_id',
        'domain',
        'type',
        'date',
        'position',
        'purchased_clicks',
        'estimated_budget',
        'advertiser_total_ads',
        'url',
        'title',
        'description',
        'visible_url'
    ];
    
    
    public function getDates()
    {
        return ['created_at', 'updated_at', 'date'];
    }



    public function setDnAttribute($value = null)
    {
        $this->domain = $value;
        return $this;

    }

    public function setDtAttribute($value = null)
    {
        $this->date = $value;

    }

    public function setPoAttribute($value = null)
    {
        $this->position = $value;
    }

    public function setUrAttribute($value = null)
    {
        $this->url = $value;
        return $this;
    }

    public function setTtAttribute($value = null)
    {
        $this->title = $value;
        return $this;

    }
    public function setDsAttribute($value = null)
    {
        $this->description = $value;
        return $this;
    }

    public function setVuAttribute($value = null)
    {
        $this->visible_url = $value;
        return $this;
    }

    public function setAtAttribute($value = null)
    {
        $this->purchased_clicks = $value;
        return $this;

    }

    public function setAcAttribute($value = null)
    {
        $this->estimated_budget = $value;
        return $this;
    }

    public function setAdAttribute($value = null)
    {
        $this->advertiser_total_ads = $value;
        return $this;
    }



//    public function findOrCreate($conditions, $data = null)
//    {
//        //Find existing based on conditions
//        $model = $this->getModel();
//        
//        foreach($conditions as $condition)
//        {
//            if(isset($condition[1]) && isset($condition[2]) && isset($condition[3]))
//            {
//                if($condition[1] == 'w')
//                {
//                    //@
//                    dd($condition);
//                }
//
//            $model = $model->where($condition[0],$condition[1],$condition[1]);
//            }
//        }
//
//        $model = $model->first();
//
//        //If existing return that model
//
//
//        if (isset($data) && isset($model)) {
//            foreach ($data as $k => $v) {
//                $model->{$k} = $v;
//            }
//            $model->save();
//        }
//
//        if($model) return $model;
//
//
//        $model = $this->getModel();
//        //If we passed data set it to the found model and save
//        if (isset($data) && isset($model)) {
//            foreach ($data as $k => $v) {
//                $model->{$k} = $v;
//            }
//            $model->save();
//        }
//
//        return $model;
//    }
    
    
}