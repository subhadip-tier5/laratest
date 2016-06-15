<?php namespace Ecomtracker\Keyword\Models\Collections;

use Ecomtracker\Keyword\Models\Keyword;
use Ecomtracker\Keyword\Models\Objects\Keyword\Collections\OrganicDataCollection;
use Ecomtracker\Keyword\Models\Objects\Keyword\Collections\PaidDataCollection;
use Ecomtracker\Keyword\Models\Objects\Keyword\TrendData;
use Ecomtracker\Semrush\Models\Collections\DomainCollection;
use Illuminate\Database\Eloquent\Collection;

class TrendCollection extends Collection
{
    public function addByDate($item, $type = 'paid', $phrase = null)
    {
        $collection = $this->keyBy('date');

        if ($type == 'paid') {
            if (!$collection->has($item->date->year . '-' . $item->date->month)) {
                $trend = new TrendData();
                $trend->date = $item->date->year . '-' . $item->date->month;
                $trend->phrase = $phrase;
                $trend->ads = 1;
                $this->add($trend);

            } else {
                $existing = $collection->get($item->date->year . '-' . $item->date->month);
                $existing->ads += 1;
            }
        } elseif ($type == 'organic') {
            if (!$collection->has($item->date->year . '-' . $item->date->month)) {

                $trend = new TrendData();
                $trend->phrase = $item->value;
                $trend->date = $item->date->year . '-' . $item->date->month;
                $trend->search_volume = $item->getSearchVolume();
                $trend->cpc = $item->getCpc();
                $trend->competition = $item->getCompetition();
                $trend->number_of_results = $item->getNumberOfResults();
                $trend->difficulty_index = $item->getDifficultyIndex();
                $this->add($trend);

            } else {
                $existing = $collection->get($item->date->year . '-' . $item->date->month);
                $existing->ads += 1;
                $existing->date = $item->date->year . '-' . $item->date->month;
                $existing->search_volume = $item->getSearchVolume();
                $existing->cpc = $item->getCpc();
                $existing->competition = $item->getCompetition();
                $existing->number_of_results = $item->getNumberOfResults();
                $existing->difficulty_index = $item->getDifficultyIndex();
            }


        }
    }



    
}