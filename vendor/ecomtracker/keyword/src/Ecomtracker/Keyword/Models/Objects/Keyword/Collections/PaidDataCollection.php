<?php namespace Ecomtracker\Keyword\Models\Objects\Keyword\Collections;

use Ecomtracker\Keyword\Models\Collections\DistributionCollection;
use Ecomtracker\Keyword\Models\Collections\ResultCollection;
use Ecomtracker\Keyword\Models\Collections\TrendCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class PaidDataCollection extends Collection
{

    public function distribution()
    {

        $distributionCollection = new DistributionCollection();

        if ($this->count() > 0) {
            foreach ($this as $item) {
                if (is_object($item)) {
                    foreach ($item->getEntity()->distribution as $dist) {
                        $distributionCollection->add($dist);
                    }
                }            }
        }
        return $distributionCollection;
    }


    public function results()
    {
        $resultCollection = new ResultCollection();


        if ($this->count() > 0) {

            foreach ($this as $item) {
                if (is_object($item)) {
                    foreach ($item->getEntity()->ads as $result) {
                        $resultCollection->add($result);

                    }
                }
            }
        }

        return $resultCollection;
    }


    public function trend()
    {
        $trendCollection = new TrendCollection();
        if ($this->count() > 0) {
            foreach ($this as $item) {
                if (is_object($item)) {
                    foreach ($item->getEntity()->ads as $dist) {
                        $trendCollection->addByDate($dist, 'paid', $item->value);
                    }
                }
            }
        }

        return $trendCollection;
    }


}