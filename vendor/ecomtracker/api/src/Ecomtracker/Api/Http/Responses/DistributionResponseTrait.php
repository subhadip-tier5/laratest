<?php namespace Ecomtracker\Api\Http\Responses;

use Illuminate\Database\Eloquent\Collection;

trait DistributionResponseTrait
{
    protected $map;
    protected $items = [];


    /**
     * @description sets the map array to the object
     * @param array $map
     * @return $this
     */
    public function map(array $map = [])
    {
        $this->map = $map;
        return $this;
    }


    public function consumeCollection(Collection $collection)
    {
        $newData = [];
        if(isset($this->map['key']))
        {
            if (isset($collection->first()->{$this->map['key']})) {
                $newData['key'] = $collection->first()->{$this->map['key']};
            }
        }


        //Values
        if(isset($this->map['values']))
        {
            $newData['values'] = [];


            foreach($collection as $item)
            {
                $newItem = [];

                foreach($this->map['values'] as $k => $v)
                {
                    array_push($newItem,$item->{$v});
                }

                array_push($newData['values'],$newItem);
            }
        }



        $this->data = json_encode($newData);
    }
}