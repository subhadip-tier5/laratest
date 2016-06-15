<?php namespace Ecomtracker\Keyword\Models;

use Ecomtracker\Keyword\Models\Collections\KeywordCollection;
use Ecomtracker\Keyword\Models\Collections\ResultCollection;
use Ecomtracker\Keyword\Models\Relations\EmptyResults;
use Ecomtracker\Source\Models\SourcedModel;

class Keyword extends SourcedModel
{
    protected $table = 'keywords';

    protected $fillable = [
        'value',
        'source_id',
        'source_model_id'
    ];

    public function getOrganicData()
    {
     if($source = $this->source()->first())
     {
         return $source->getOrganicData();
     }

        return null;

    }

    public function updateRelatedPhraseMatched($limit = 1, $force = false)
    {
        if ($source = $this->source()->first()) {
            $source->updateRelatedPhraseMatched($limit,$source);
        }

        return $this;
    }


    public function updateOrganicResults($limit = 1, $force = false)
    {

        if ($source = $this->source()->first()) {
            $source->updateOrganicResults($limit, $force);
        }

        return $this;
    }

    /**
     * Updates
     * @return $this
     */
    public function updatePaidResults($limit = 1, $force = false)
    {
        if ($source = $this->source()->first()) {
            $source->updatePaidResults($limit, $force);
        }

        return $this;
    }


    public function updateOrganic($limit = 1, $force = false)
    {
        if ($source = $this->source()->first()) {
            $source->updateOrganic($limit,$force);
        }

        return $this;
    }
    
    public function updatePaid($limit = 1, $force = false)
    {
        if ($source = $this->source()->first()) {
            $source->updatePaid($limit,$force);
        }
        return $this;
    }


    public function updatePaidTrend($limit = 1, $force = false)
    {
        
        if($source = $this->source()->first())
        {
            $source->updatePaidTrend($limit, $force);
        }
        return $this;
    }


    public function updateOrganicTrend($limit = 1, $force = false)
    {

        if($source = $this->source()->first())
        {
            $source->updateOrganicTrend($limit, $force);
        }
        return $this;
    }




    public function updatePaidDistribution($limit = 1, $force = false)
    {
        if($source = $this->source()->first())
        {
            $source->updatePaidDistribution($limit, $force);
        }
        return $this;
    }




    public function updateRelated($limit = 1, $force = false)
    {
        if ($source = $this->source()->first()) {
            $source->updateRelated($limit, $force);
        }
        return $this;
    }
    
    
    public function buildRelated($limit = 1, $force = false)
    {
        $this->source()->buildRelated($limit, $force);
        return $this;
    }


    public function results()
    {
        if($source = $this->source()->first())
        {
            return $this->source()->first()->results();
        }else{

            $relation = new EmptyResults($this->query(),$this);
            $collection = new ResultCollection();
            $relation->setCollection($collection);
            return $relation;
        }

    }

    
    
    public function related()
    {
        if($source = $this->source()->first())
        {
            return $this->source()->related();
        }else{
            return $this->HasMany('');
        }
        
    }


    public function subscriptions()
    {
        //@todo ajw! needs to be worked out
    }
    
    
    public function newCollection(array $models = array())
    {
        return new KeywordCollection($models);
    }
    

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