<?php namespace Ecomtracker\Keyword\Models\Collections;

use Ecomtracker\Keyword\Models\Keyword;
use Ecomtracker\Keyword\Models\Objects\Keyword\Collections\OrganicDataCollection;
use Ecomtracker\Keyword\Models\Objects\Keyword\Collections\PaidDataCollection;
use Ecomtracker\Semrush\Models\Collections\DomainCollection;
use Illuminate\Database\Eloquent\Collection;

class KeywordCollection extends Collection
{
    public function combineLikeValues()
    {
        //Collection to hold new items created from the current collection
        $newKeywordCollection = new KeywordCollection();

        //foreach keyword source collection of keywords
        foreach($this as $sourceCollection)
        {
            if (is_object($sourceCollection)) {

                $item = $sourceCollection;

                //foreach of the items found in that collection

                //If the collection already contains a keyword with a matching value
                if ($newKeywordCollection->keyBy('value')->has($item->value)) {
                    $existingKeyword = $newKeywordCollection->keyBy('value')->get($item->value);

                    //Merge the values from the item to that item
                    $existingKeyword->mergeData($item->toArray());
                    //@todo AJW! we need to also set the children('sources") to the data

                } else {
                    //If the collection does not contain a keyword with matching value
                    $keyword = new Keyword();
                    $keyword->value = $item->value;
                    $keyword->setData($item->toArray());

                    $newKeywordCollection->add($keyword);

                }
            } else {
                foreach ($sourceCollection as $item) {
                    dd($item->toArray());
                    //foreach of the items found in that collection

                    //If the collection already contains a keyword with a matching value
                    if ($newKeywordCollection->keyBy('value')->has($item->value)) {
                        $existingKeyword = $newKeywordCollection->keyBy('value')->get($item->value);

                        //Merge the values from the item to that item
                        $existingKeyword->mergeData($item->toArray());
                        //@todo AJW! we need to also set the children('sources") to the data

                    } else {
                        //If the collection does not contain a keyword with matching value
                        $keyword = new Keyword();
                        $keyword->value = $item->value;
                        $keyword->setData($item->toArray());

                        $newKeywordCollection->add($keyword);

                    }
                }
            }
        }

        return $newKeywordCollection;
    }


    public function organic()
    {
        $organicCollection = new OrganicDataCollection();
        $organic = [];
        foreach ($this as $keyword) {
            if ($keyword->source) {
                $organicCollection->add($keyword->source->getOrganicData());
            }else{
                $organicCollection->add($keyword->getOrganicData(true,10));
            }
        }

        return $organicCollection;
    }

    public function paid()
    {
        $paidCollection = new PaidDataCollection();
        $paid = [];
        foreach ($this as $keyword) {
            if ($keyword->source) {
                $paidCollection->add($keyword->source->getPaidData());
            }else{
                $paidCollection->add($keyword->getPaidData(true,10));
            }

        }

        return $paidCollection;
    }


    public function results()
    {
        $resultsCollection = new ResultCollection();
        foreach($this as $keyword)
        {
            $keyword->updateOrganic();
            if ($keyword->results) {

                foreach ($keyword->results as $result) {
                    $resultsCollection->add($result);
                }
            }
        }

        return $resultsCollection;

    }


    public function competitors()
    {
        $competitors = [];
        foreach ($this as $keyword) {
            if ($keyword->source) {
                try {
                    $competitors[$keyword->source_id] = $keyword->source->competitors;
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }else{

                try {
                    $competitors[$keyword->source_id] = $keyword->competitors;
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        }

        //Create a new collection from the various sourced keywords
        $relatedCollection = new DomainCollection();
        foreach ($competitors as $source => $values) {
            $collection[] = $values;

            $relatedCollection = $relatedCollection->add($values);
        }

        return $relatedCollection;
    }



    public function relatedFullsearch()
    {
        //Create a new collection from the various sourced keywords
        $relatedCollection = new KeywordCollection();

        foreach ($this as $keyword) {
            if ($keyword->source) {

                if (count($keyword->source->relatedFullsearch) > 0) {
                    foreach ($keyword->source->relatedFullsearch as $item) {
                        $relatedCollection->add($item);

                    }
                }

            }
        }

        return $relatedCollection;


    }


    public function related()
    {

        $related = [];
        foreach ($this as $keyword) {
            if ($keyword->source) {
                try {
                    $related[$keyword->source_id] = $keyword->source->related;

                } catch (\Exception $e) {

                }
            }
        }


        //Create a new collection from the various sourced keywords
        $relatedCollection = new KeywordCollection();
        foreach ($related as $source => $values) {
            $collection[] = $values;

            $relatedCollection = $relatedCollection->add($values);
        }

        return $relatedCollection;


    }


}