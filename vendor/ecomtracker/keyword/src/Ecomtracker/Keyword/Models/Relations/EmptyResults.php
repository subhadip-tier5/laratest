<?php namespace Ecomtracker\Keyword\Models\Relations;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;

class EmptyResults extends Relation
{

    protected $collection;

    public function setCollection(Collection $collection)
    {
        $this->collection = $collection;
    }
    public function getResults()
    {
        return $this->collection;
    }
    

    /**
     * Set the constraints for an eager load of the relation.
     *
     * @param  array  $models
     * @return void
     */

    public function addEagerConstraints(array $models)
    {
        
    }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @param  array   $models
     * @param  \Illuminate\Database\Eloquent\Collection  $results
     * @param  string  $relation
     * @return array
     */
    public function match(array $models, Collection $results, $relation)
    {
        
    }


    /**
     * Initialize the relation on a set of models.
     *
     * @param  array   $models
     * @param  string  $relation
     * @return array
     */
    public function initRelation(array $models, $relation)
    {
        
    }



    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints()
    {
        
    }
    
   }