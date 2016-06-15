<?php namespace Ecomtracker\Semrush\Models\Keyword;

use Ecomtracker\Semrush\Models\Collections\DistributionCollection;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{    
    protected $table = 'semrush_keyword_distribution';  

    
    
    public function setDbAttribute($value = null)
    {
        $this->database = $value;
        return $this;
    }

    public function setPhAttribute($value = null)
    {
        $this->phrase = $value;
        return $this;
    }

    public function setNqAttribute($value = null)
    {
        $this->search_volume = $value;
        return $this;
    }

    public function setCpAttribute($value = null)
    {
        $this->cpc = $value;
        return $this;
    }


    public function setCoAttribute($value = null)
    {
        $this->competition = $value;
        return $this;
    }
    
    
    public function newCollection(array $models = [])
    {
        return new DistributionCollection($models);        
    }
    
    
}



