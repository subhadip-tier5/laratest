<?php namespace Ecomtracker\Keyword\Models\Objects\Keyword\Collections;

use Carbon\Carbon;
use Ecomtracker\Keyword\Models\Collections\DistributionCollection;
use Ecomtracker\Keyword\Models\Collections\ResultCollection;
use Ecomtracker\Keyword\Models\Collections\TrendCollection;
use Ecomtracker\Keyword\Models\Objects\Keyword\TrendData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class OrganicDataCollection extends Collection
{
    public function distribution()
    {

        $distributionCollection = new DistributionCollection();

        foreach ($this as $item) {
            if (is_object($item)) {
                foreach ($item->getEntity()->distribution as $dist) {
                    $distributionCollection->add($dist);
                }
            }


        }
        return $distributionCollection;
    }

    public function results()
    {
        $resultCollection = new ResultCollection();

        foreach ($this as $item) {
            if (is_object($item)) {
                foreach ($item->results as $result) {
                    $resultCollection->add($result);
                }
            }

        }
        return $resultCollection;
    }


    public function trend()
    {
        $trendCollection = new TrendCollection();

        foreach ($this as $item) {
            if (is_object($item)) {
                $first_item = $item->getEntity();
                $first_item->date = Carbon::now();
                $trendCollection->addByDate($first_item, 'organic');
            }
        }


        //@todo AJW! This piece needs to be worked out, it should return archived data related to the keyword entity itself.
        //for example , if we record every 30 days, when that data is recorded, the old data should be put into an archive
        //The first value for the collection should be the current entity
        return $trendCollection;
    }


}