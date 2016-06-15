<?php namespace Ecomtracker\Semrush\Models\Keyword;

use Ecomtracker\Semrush\Models\Domain;
use Ecomtracker\Semrush\Models\Keyword;
use Ecomtracker\Source\Models\Source;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'semrush_keyword_results';
    protected $fillable = ['position','domain','type','url','date'];
    
    public function keyword()
    {
        return $this->hasOne('Ecomtracker\Semrush\Models\Keyword','id','keyword_id');
    }


    public function setDnAttribute($value = null)
    {
        $this->domain = $value;

    }

    public function setPhAttribute($value)
    {
        $data = [
            'value' => $value,
            'source_id' => Source::where('source','=','Ecomtracker\Semrush\Models\Keyword')->first()->id
        ];
        $this->keyword_id = Keyword::getModel()->findOrCreate(['value',$value],$data)->id;
        return $this;
    }

    public function setPpAttribute($value = null)
    {
        //This value returned for previous position
        $this->previous_position = $value;
        return $this;
        //@todo ajw! do something with this
    }

    public function setPoAttribute($value = null)
    {
        $this->position = $value;
        return $this;
    }


    public function setPdAttribute($value = null)
    {
        $this->position_difference = $value;
        return $this;
    }

    public function setNqAttribute($value = null)
    {
        //@todo ajw!! after saving a result, we need to check and see if its keyword is dirty, if it is we need to save
        $this->search_volume = $value;
        return $this;
    }

    public function setCpAttribute($value = null)
    {
        $this->cost_per_click = $value;
        return $this;
    }

    public function setUrAttribute($value = null)
    {
        $this->url = $value;
        return $this;
    }

    public function setTrAttribute($value = null)
    {
        $this->traffic_percentage = $value;
    }

    public function setTcAttribute($value = null)
    {
        $this->traffic_cost_percentage = $value;

    }

    public function setCoAttribute($value = null)
    {
        $this->keyword->competition = $value;
    }


    public function setTdAttribute($value = null)
    {
        
    }


    public function setNrAttribute($value = null)
    {
        $this->number_of_results = $value;
    }

    public function setVuAttribute($value = null)
    {
        $this->url = $value;

    }

    public function getDomainAttribute($value = null)
    {
        if(isset($this->domain_id))
        {
            return $this->hasOne('Ecomtracker\Semrush\Models\Domain','id','domain_id')->first();
        }

        return $value;
    } 
}