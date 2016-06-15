<?php namespace Ecomtracker\Semrush\Models;

use Ecomtracker\Keyword\Models\Objects\Keyword\DistributionData;
use Ecomtracker\Keyword\Models\Objects\Keyword\Organic;
use Ecomtracker\Keyword\Models\Objects\Keyword\OrganicData;
use Ecomtracker\Keyword\Models\Objects\Keyword\PaidData;
use Ecomtracker\Semrush\Models\Collections\KeywordCollection;
use Ecomtracker\Semrush\Models\Keyword\Ad;
use Ecomtracker\Semrush\Models\Keyword\Distribution;
use Ecomtracker\Semrush\Models\Keyword\Result;
use Ecomtracker\Source\Models\SourceModel;
use Ecomtracker\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Pivotal\Survey\Models\Relations\RelatedRelation;

class Keyword extends SourceModel
{

    protected $table = 'semrush_keywords';
    protected $entity;

    protected $fillable = ['value'];


    public function getSearchVolume()
    {
        return $this->search_volume;
    }


    public function getCpc()
    {
        return $this->cpc;
    }


    public function getCompetition()
    {
        return $this->competition;
    }

    public function getNumberOfResults()
    {
        return $this->number_of_results;
    }


    public function getDifficultyIndex()
    {
        return $this->difficulty_index;
    }


    public function getClient()
    {
        if (!isset($this->client)) return \App::make('semrush.keyword.client');
    }


    public function updateOrganicResults($limit = 1, $force = false, $display_date = null)
    {
        try {
            $this->buildPhraseOrganic($this->getClient(), $limit, $force, $display_date);
            $this->save();
        } catch (\Exception $e) {
            \Log::error('Exception in Ecomtracker\Semrush\Models\Keyword updateOrganicResults' . $e->getMessage());
        }

        return $this;


    }

    public function updatePaidResults($limit = 1, $force = false)
    {
        try {
            $this->buildPhraseAdwordsHistorical($this->getClient(), $limit);
        } catch (\Exception $e) {
            \Log::error('Exception in Ecomtracker\Semrush\Models\Keyword updatePaidResults buildPhraseAdwords' . $e->getMessage());
        }

        return $this;


    }


    public function updatePaid($update = false, $limit = 1)
    {
        try {
            $this->buildThis($this->getClient());
            $this->save();
        } catch (\Exception $e) {
            \Log::error('Exception in Ecomtracker\Semrush\Models\Keyword updatePaid buildThis' . $e->getMessage());
        }

        try {
            $this->buildKdi($this->getClient());
            $this->save();
        } catch (\Exception $e) {
            \Log::error('Exception in Ecomtracker\Semrush\Models\Keyword updatePaid buildKdi ' . $e->getMessage());
        }

        try {
            $this->buildAdwordsResults($this->getClient(), $limit);
        } catch (\Exception $e) {
            \Log::error('Exception in Ecomtracker\Semrush\Models\Keyword updatePaid buildAdwordsResults ' . $e->getMessage());
        }

        return $this;
    }


    public function updatePaidTrend($limit = 1, $force = false)
    {
        $this->buildPhraseAdwordsHistorical($this->getClient(), $limit, $force);
        return $this;
    }


    public function updateOrganicTrend($limit = 1, $force = false)
    {
        //@todo AJW! buildThis needs to be refactored so that it also checks todays data against the current date
        //If the dates are a month apart then archive the old data and insert the new
        $this->buildThis($this->getClient());
        return $this;
    }


    public function updatePaidDistribution($limit = 1, $force = false)
    {
        $this->buildPhraseAll($this->getClient(), $limit);
        return $this;
    }

    public function getPaidData()
    {
        $data = new PaidData();
        $data->setEntity($this);
        $results = $this->results()->where('type', '=', 'adwords')->get();
        $data->setResults($results);
        $data->setData($this->toArray());
        return $data;
    }


    public function updateOrganic($update = false, $limit = 1, $display_date = null)
    {
        try {
            $this->buildThis($this->getClient());
            $this->save();
        } catch (\Exception $e) {
            \Log::error('Exception in Ecomtracker\Semrush\Models\Keyword updateOrganic buildThis' . $e->getMessage());
        }

        try {
            $this->buildKdi($this->getClient());
            $this->save();
        } catch (\Exception $e) {
            \Log::error('Exception in Ecomtracker\Semrush\Models\Keyword updateOrganic buildKdi ' . $e->getMessage());
        }

        try {
            $this->updateOrganicResults($limit, $force, $display_date);
        } catch (\Exception $e) {
            \Log::error('Exception in Ecomtracker\Semrush\Models\Keyword updateOrganic buildOrganicResults ' . $e->getMessage());
        }

        return $this;
    }


    public function getPaidDistributionData()
    {
        $data = new DistributionData();
        $data->setEntity($this);
        $results = $this->results()->where('type', '=', 'organic')->get();
        $data->setResults($results);
        $data->setData($this->toArray());
        return $data;
    }


    public function getOrganicData($update = false, $limit = 1)
    {
        $data = new OrganicData();
        $data->setEntity($this);
        $results = $this->results()->where('type', '=', 'organic')->get();
        $data->setResults($results);
        $data->setData($this->toArray());
        return $data;
    }


    public function save(array $options = [])
    {
        if ($this->getEntity()) {
            $this->entity_id = $this->getEntity()->id;
        }
        return parent::save($options);
    }


    public function getValueAttribute($value = null, $override = false)
    {
        if (isset($value)) {
            return $value;
        }
        if ($this->getEntity()) {
            return $this->getEntity()->value;
        }
        return null;
    }


    public function setPhAttribute($value = null)
    {
        $this->value = $value;
    }

    public function setNqAttribute($value = null)
    {
        $this->search_volume = $value;
    }

    public function setCpAttribute($value = null)
    {
        $this->cpc = $value;
    }

    public function setCoAttribute($value = null)
    {
        $this->competition = $value;
    }

    public function setNrAttribute($value = null)
    {
        $this->number_of_results = $value;
    }

    public function setKdAttribute($value = null)
    {
        $this->difficulty_index = $value;
    }

    public function isBuilt()
    {
        return null != $this->build_date;
    }


    //RELATIONS


    public function distribution()
    {
        return $this->hasMany('Ecomtracker\Semrush\Models\Keyword\Distribution', 'semrush_keyword_id', 'id');
    }


    public function competitors()
    {
        return $this->belongsToMany('Ecomtracker\Semrush\Models\Domain', 'semrush_keyword_results', 'keyword_id', 'domain_id');
    }


    public function updateRelated($limit = 1, $force = false)
    {

//        if(!count($this->related) > 0 || $force == true)
//        {
        $this->buildRelated($this->getClient(), $limit);
//        }

        return $this;
    }

    public function updateRelatedPhraseMatched($limit = 1, $force = false)
    {
        $this->buildPhraseFullsearch($this->getClient(), $limit);
        return $this;
    }

    public function buildRelated(\Ecomtracker\Semrush\Client\Keyword $client = null, $limit = 1)
    {
        if (!isset($client)) $client = $this->getClient();
        $this->buildPhraseRelated($client, $limit);
        $this->buildPhraseFullsearch($client, $limit);

    }

    public function buildPhraseRelated(\Ecomtracker\Semrush\Client\Keyword $client, $limit = 1, $force = false, $display_date = null)
    {
        $display_offset = 0;


        //Check if we already have related keywords if so skip the api call and just return the data unless force is true
        if($force == false)
        {
            $related_count = 0;
            //If we already have related keywords count that meets or exceeds the limit
            $related_count += $this->related->count();
            $display_offset += $this->related->count();

            if($related_count >= $limit)
            {
                return $this;
            }else{
                $limit = $limit - $display_offset;
            }

        }

        
        $semrush_phrase_related = $client->getPhraseRelated($this->value, $limit);

        if (\Config::get('semrush.calls.logging') == true) {

            $call = Call::getModel();
            $call->name = 'phrase_related';
            $call->lines = count($semrush_phrase_related->getRows());
            $call->is_historic = $display_date == null ? 0 : 1;
            $call->user_id = User::getModel()->logined()->first()->id;
            $call->data = serialize($semrush_phrase_related);
            $call->save();
        }

        $related = [];
        foreach ($semrush_phrase_related->getRows() as $items) {
            $keyword = new Keyword();
            foreach ($items->getData() as $k => $v) {
                $lower_key = strtolower($k);
                $keyword->{$lower_key} = $v;
            }

            $keyword->source_id = $this->source_id;
            $keyword->build_date = new \DateTime('now');
            $keyword->database = 'us';


            //Created a Semrush_Keyword
            $model = $keyword->findOrCreate(['value', $keyword->value], $keyword->toArray());

            array_push($related, $model->id);

            $model->relatedInverse()->sync([$this->id]);
            $model->related()->sync([$this->id]);
        }

        return $this;


    }


    public function buildPhraseFullsearch(\Ecomtracker\Semrush\Client\Keyword $client, $limit = 1, $force = false)
    {
        $display_offset = 0;


        //Check if we already have related keywords if so skip the api call and just return the data unless force is true
        if($force == false)
        {
            $related_count = 0;
            //If we already have related keywords count that meets or exceeds the limit
            $related_count += $this->relatedFullsearch->count();
            $display_offset += $this->relatedFullsearch->count();

            if($related_count >= $limit)
            {
                return $this;
            }else{
                $limit = $limit - $display_offset;
            }

        }


        $semrush_phrase_fullsearch = $client->getPhraseFullsearch($this->value, (int) $limit, $display_offset);

        if (\Config::get('semrush.calls.logging') == true) {

            $call = Call::getModel();
            $call->name = 'phrase_fullsearch';
            $call->lines = count($semrush_phrase_fullsearch->getRows());
            $call->is_historic = 0;
            $call->user_id = User::getModel()->logined()->first()->id;
            $call->data = serialize($semrush_phrase_fullsearch);
            $call->save();
        }


        $related = [];
        foreach ($semrush_phrase_fullsearch->getRows() as $items) {
            $keyword = new Keyword();
            foreach ($items->getData() as $k => $v) {
                $lower_key = strtolower($k);
                $keyword->{$lower_key} = $v;
            }

            $keyword->source_id = $this->source_id;
            $keyword->build_date = new \DateTime('now');
            $keyword->database = 'us';


            //Created a Semrush_Keyword
            $model = $keyword->findOrCreate(['value', $keyword->value], $keyword->toArray());


            $model->relatedFullsearchInverse()->sync([$this->id]);
            $model->relatedFullsearch()->sync([$this->id]);
        }

        return $this;


    }


    public function relatedFullsearchInverse()
    {
        return $this->belongsToMany('Ecomtracker\Semrush\Models\Keyword', 'semrush_keywords_related_fullsearch', 'related_id', 'keyword_id');

    }


    public function relatedFullsearch()
    {
        return $this->belongsToMany('Ecomtracker\Semrush\Models\Keyword', 'semrush_keywords_related_fullsearch', 'keyword_id', 'related_id');

    }

    public function relatedInverse()
    {
        return $this->belongsToMany('Ecomtracker\Semrush\Models\Keyword', 'semrush_keywords_related', 'related_id', 'keyword_id');
    }


    public function related()
    {
        return $this->belongsToMany('Ecomtracker\Semrush\Models\Keyword', 'semrush_keywords_related', 'keyword_id', 'related_id');
    }

    public function results()
    {
        return $this->hasMany('Ecomtracker\Semrush\Models\Keyword\Result', 'keyword_id', 'id');
    }

    public function ads()
    {
        return $this->hasMany('Ecomtracker\Semrush\Models\Keyword\Ad', 'keyword_id', 'id');
    }


    //CONSTRUCTION

    public function buildPhraseAll(\Ecomtracker\Semrush\Client\Keyword $client = null, $limit = 1, $force = false)
    {
        //If we have existing data for today dont do anything

        //Get a collection of distribution objects that were created within the last day
        $existing_daily = $this->distribution->filter(function ($item) {

            //Return if the distribution created_at was within a day of now
            return time() - (60 * 60 * 24) < strtotime($item->created_at);
        });

        //Check if we already have related keywords if so skip the api call and just return the data unless force is true
        if($force == false)
        {
            $related_count = 0;
            //If we already have related keywords count that meets or exceeds the limit
            $related_count += $existing_daily->count();

            if($related_count >= $limit)
            {
                return $this;
            }
        }
        
        
        
        

        //If we dont have an existing daily collection
        if (count($existing_daily) == 0) {
            $semrush_phrase_all = $client->getPhraseAll($this->value);

            if (\Config::get('semrush.calls.logging') == true) {

                $call = Call::getModel();
                $call->name = 'phrase_all';
                $call->lines = count($semrush_phrase_all->getRows());
                $call->is_historic = 0;
                $call->user_id = User::getModel()->logined()->first()->id;
                $call->data = serialize($semrush_phrase_all);
                $call->save();
            }


            //@todo AJW! this needs to be finished
            foreach ($semrush_phrase_all as $item) {
                $distribution = Distribution::getModel();
                foreach ($item->getData() as $k => $v) {
                    $distribution->{$k} = $v;

                }
                //Set related keyword id to this id
                $distribution->semrush_keyword_id = $this->id;

                $distribution->save();

            }

        }
        return $this;
    }


    public function buildThis(\Ecomtracker\Semrush\Client\Keyword $client, $display_date = null, $force = false)
    {

        $display_offset = 0;


        //Check if we already have related keywords if so skip the api call and just return the data unless force is true
        if ($force == false) {

            if (isset($this->search_volume) && $this->search_volume != null) {
                return $this;
            }

        }



        //phrase_this
        $semrush_phrase_this = $client->getPhraseThis($this->value);
        if (\Config::get('semrush.calls.logging') == true) {

            $call = Call::getModel();
            $call->name = 'phrase_this';
            $call->lines = count($semrush_phrase_this->getRows());
            $call->is_historic = $display_date == null ? 0 : 1;
            $call->user_id = User::getModel()->logined()->first()->id;
            $call->data = serialize($semrush_phrase_this);
            $call->save();
        }


        foreach ($semrush_phrase_this->getRows() as $k => $item) {
            foreach ($item->getData() as $k => $v) {
                $lower_key = strtolower($k);

                $this->{$lower_key} = $v;
            }
        }
        return $this;

    }

    public function buildPhraseOrganic(\Ecomtracker\Semrush\Client\Keyword $client, $limit = 1, $force = false, $display_date = null)
    {

        $existing_daily = $this->results->filter(function ($item) {

            //Return if the distribution created_at was within a day of now
            return time() - (60 * 60 * 24) < strtotime($item->created_at);
        });


        //Check if we already have related keywords if so skip the api call and just return the data unless force is true
        if($force == false)
        {
            $related_count = 0;
            //If we already have related keywords count that meets or exceeds the limit
            $related_count += $existing_daily->count();

            if($related_count >= $limit)
            {
                return $this;
            }
        }



        //phrase_organic
        //returns organic search results
        $semrush_phrase_organic = $client->getPhraseOrganic($this->value, (int) $limit);

        if (\Config::get('semrush.calls.logging') == true) {

            $call = Call::getModel();
            $call->name = 'phrase_organic';
            $call->lines = count($semrush_phrase_organic->getRows());
            $call->is_historic = $display_date == null ? 0 : 1;
            $call->user_id = User::getModel()->logined()->first()->id;
            $call->data = serialize($semrush_phrase_organic);
            $call->save();
        }


        $i = 1;
        foreach ($semrush_phrase_organic->getRows() as $items) {
            $result = new Result();
            $data = $items->getData();

            foreach ($items->getData() as $k => $v) {
                $lower_key = strtolower($k);
                $result->{$lower_key} = $v;
            }

            $result->date = new \DateTime('now');

            $result->position = (int)$i;
            $result->type = 'organic';
            $result->keyword_id = $this->id;

            $result->save();
            $i++;
        }
    }


    public function buildAdwordsResults(\Ecomtracker\Semrush\Client\Keyword $client, $limit = 1, $force = false , $display_date = null )
    {

        $existing_daily = $this->ads->filter(function ($item) {

            //Return if the distribution created_at was within a day of now
            return time() - (60 * 60 * 24) < strtotime($item->created_at);
        });
        

        //Check if we already have related keywords if so skip the api call and just return the data unless force is true
        if($force == false)
        {
            $related_count = 0;
            //If we already have related keywords count that meets or exceeds the limit
            $related_count += $existing_daily->count();

            if($related_count >= $limit)
            {
                return $this;
            }
        }
        

        //phrase_adwords
        //returns organic search results
        $semrush_phrase_adwords = $client->getPhraseAdwords($this->value, $limit);

        if (\Config::get('semrush.calls.logging') == true) {

            $call = Call::getModel();
            $call->name = 'phrase_adwords';
            $call->lines = count($semrush_phrase_adwords->getRows());
            $call->is_historic = $display_date == null ? 0 : 1;
            $call->user_id = User::getModel()->logined()->first()->id;
            $call->data = serialize($semrush_phrase_adwords);
            $call->save();
        }


        $i = 1;
        foreach ($semrush_phrase_adwords->getRows() as $item) {

            $result = new Result();
            foreach ($item->getData() as $k => $v) {
                $lower_key = strtolower($k);
                $result->{$lower_key} = $v;
            }

            $result->position = (int)$i;
            $result->type = 'adwords';
            $result->keyword_id = $this->id;


            $result->save();
            $i++;
        }

    }

    public function parseDate($date)
    {
        $year = substr($date, 0, 4);
        $month = substr($date, 4, 2);
        $day = substr($date, 6, 2);


        $date = new \DateTime($year . '-' . $month . '-' . $day);

        return $date;

    }


    public function buildPhraseAdwordsHistorical(\Ecomtracker\Semrush\Client\Keyword $client = null, $limit_per_month = 1, $force)
    {
        $display_offset = 0;

        //Check if we already have related ads, if so do if we have enough from each date to meet the limit, offset by existing and query for the missing count
        if($force == false)
        {
            $related_count = 0;
            //If we already have related keywords count that meets or exceeds the limit
            $related_count += $this->ads->count();
            $display_offset += $this->ads->count();

            if($related_count >= (int) $limit_per_month * 12)
            {
                return $this;
            }else{
                $limit_per_month = $limit_per_month - $display_offset;
            }

        }

        $semrush_phrase_adwords_historical = $client->getPhraseAdwordsHistorical($this->value, $limit_per_month);


        if (\Config::get('semrush.calls.logging') == true) {

            $call = Call::getModel();
            $call->name = 'phrase_adwords_historical';
            $call->lines = count($semrush_phrase_adwords_historical->getRows());
            $call->is_historic = 0;
            $call->user_id = User::getModel()->logined()->first()->id;
            $call->data = serialize($semrush_phrase_adwords_historical);
            $call->save();
        }




        //foreach of the results
        foreach ($semrush_phrase_adwords_historical->getRows() as $row) {
            $ad = Ad::getModel();
            $data = $row->getData();
            //See if this ad already exists
            $existing = $ad->getModel()->where('domain', '=', $row->getData())->where('date', '=', $this->parseDate($data['Dt']))->where('url', '=', $data['Ur'])->first();

            if (!is_null($existing)) {
                $ad = $existing;
            }


            foreach ($data as $k => $v) {
                $ad->{$k} = $v;
            }

            $ad->date = $this->parseDate($data['Dt']);
            $ad->type = 'adwords';
            $ad->keyword_id = $this->id;


            try {
                $ad->save();
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }
    }


    public function buildKdi(\Ecomtracker\Semrush\Client\Keyword $client, $force = false)
    {
        //Check if we already have related ads, if so do if we have enough from each date to meet the limit, offset by existing and query for the missing count
        if($force == false)
        {
            if(isset($this->difficulty_index) && $this->difficulty_index != null)
            {
                return $this;
            }
        }



        $semrush_phrase_kdi = $client->getPhraseKdi($this->value);

        if (\Config::get('semrush.calls.logging') == true) {

            $call = Call::getModel();
            $call->name = 'phrase_kdi';
            $call->lines = count($semrush_phrase_kdi->getRows());
            $call->is_historic = 0;
            $call->user_id = User::getModel()->logined()->first()->id;
            $call->data = serialize($semrush_phrase_kdi);
            $call->save();
        }


        //phrase_this
        foreach ($semrush_phrase_kdi->getRows() as $k => $item) {
            foreach ($item->getData() as $k => $v) {
                $lower_key = strtolower($k);
                $this->{$lower_key} = $v;
            }
        }
        return $this;

    }


    public function build(\Ecomtracker\Semrush\Client\Keyword $client)
    {
        //PHRASE THIS
        //@todo ajw! this is total trash but its a quick way to itterate over the collection
        if (!$this->isBuilt()) {
            $this->buildThis($client);
            $this->build_date = new \DateTime('now');
            $this->save();
        }
    }


    public function findOrCreate($condition, $data = null)
    {
        //Find existing based on conditions
        $model = $this->getModel()->where($condition[0], '=', $condition[1])->first();
        //If existing return that model

        if (isset($data) && isset($model)) {
            foreach ($data as $k => $v) {
                $model->{$k} = $v;
            }
            $model->save();

        }

        if ($model) return $model;


        $model = $this->getModel();
        //If we passed data set it to the found model and save
        if (isset($data) && isset($model)) {
            foreach ($data as $k => $v) {
                $model->{$k} = $v;
            }
            $model->save();
        }

        return $model;
    }


    public function newCollection(array $models = [])
    {
        return new KeywordCollection($models);


    }


}