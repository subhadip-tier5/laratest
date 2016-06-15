<?php namespace Ecomtracker\Keyword\Models\Objects\Keyword;

use Illuminate\Database\Eloquent\Model;

class PaidData extends Model
{
    protected $entity;
    
    protected $visible = [
        'value',
        'database',
        'search_volume',
        'cpc',
        'competition',
        'number_of_results',
        'difficulty_index',
        'results',
    ];

    
    public function results()
    {
        return $this->results;
    }
    
    public function setResults($results)
    {
        $this->results = $results;
        return $this;
        
    }

    public function setData($data = array())
    {
        foreach($data as $k => $v)
        {
            $this->{$k} = $v;
        }
        return $this;
    }
    
    public function setEntity($entity = null)
    {
        $this->entity = $entity;
        return $this;
    }
    
    public function getEntity()
    {
        return $this->entity;
    }
    
    



    
    
}