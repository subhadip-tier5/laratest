<?php namespace Ecomtracker\Domain\Models\Collections;

use Ecomtracker\Domain\Models\Domain;
use Illuminate\Database\Eloquent\Collection;

class DomainCollection extends Collection
{
    public function combineLikeValues()
    {
        //Collection to hold new items created from the current collection
        $newDomainCollection = new DomainCollection();

        //foreach keyword source collection of keywords
        foreach($this as $sourceCollection)
        {
            foreach($sourceCollection as $item)
            {
                //foreach of the items found in that collection

                //If the collection already contains a keyword with a matching value
                if($newDomainCollection->keyBy('value')->has($item->value))
                {
                    $existingDomain = $newDomainCollection->keyBy('value')->get($item->value);

                    //Merge the values from the item to that item
                    $existingDomain->mergeData($item->toArray());
                    //@todo AJW! we need to also set the children('sources") to the data

                }else{
                    //If the collection does not contain a keyword with matching value
                    $domain = new Domain();
                    $domain->value = $item->value;
                    $domain->setData($item->toArray());

                    $newDomainCollection->add($domain);
                }
            }
        }
        
        return $newDomainCollection;
    }  


}