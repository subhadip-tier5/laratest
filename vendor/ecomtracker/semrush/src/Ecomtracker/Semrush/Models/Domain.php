<?php namespace Ecomtracker\Semrush\Models;

use Ecomtracker\Semrush\Models\Collections\DomainCollection;
use Ecomtracker\Semrush\Models\Collections\KeywordCollection;
use Ecomtracker\Semrush\Models\Keyword\Ad;
use Ecomtracker\Semrush\Models\Keyword\Result;
use Ecomtracker\Source\Models\SourceModel;
use Illuminate\Database\Eloquent\Model;


class Domain extends SourceModel
{
    protected $table = 'semrush_domains';
    
    
    protected $fillable = [
        'source_id',
        'value',
        'entity_id',
    ];


    public function isBuilt()
    {
        return null != $this->build_date;
    }


    public function buildRankDifference(\Ecomtracker\Semrush\Client\Domain $client, $limit = null)
    {

    }

    public function buildRank(\Ecomtracker\Semrush\Client\Domain $client,$limit = null)
    {

    }

    public function buildDomainAdwordsUnique(\Ecomtracker\Semrush\Client\Domain $client, $limit = null)
    {

    }


    public function buildDomainOrganicOrganic(\Ecomtracker\Semrush\Client\Domain $client, $limit = null , $data = null)
    {


    }

    public function buildDomainAdwordsAdwords(\Ecomtracker\Semrush\Client\Domain $client, $limit = null ,$date = null)
    {

    }

    public function buildAdwordsHistorical(\Ecomtracker\Semrush\Client\Domain $client, $limit)
    {

    }


    public function buildDomainDomains(\Ecomtracker\Semrush\Client\Domain $client,$limit = null)
    {

    }


    public function buildDomainShopping(\Ecomtracker\Semrush\Client\Domain $client,$limit = null)
    {

    }

    public function buildDomainShoppingUnique(\Ecomtracker\Semrush\Client\Domain $client,$limit = null)
    {

    }

    public function buildDomainShoppingShopping(\Ecomtracker\Semrush\Client\Domain $client, $limit = null)
    {

    }


    public function setDnAttribute($value = null)
    {
        $this->value = $value;
    }

    public function setRkAttribute($value = null)
    {
        $this->rank = $value;

    }

    public function setOrAttribute($value = null)
    {
        $this->organic_keywords = $value;
    }

    public function setOtAttribute($value = null)
    {
        $this->organic_traffic = $value;

    }

    public function setOcAttribute($value = null)
    {
        $this->organic_cost = $value;

    }

    public function setAdAttribute($value = null)
    {
        $this->adwords_keywords = $value;

    }

    public function setAtAttribute($value = null)
    {
        $this->adwords_traffic = $value;
    }

    public function setAcAttribute($value = null)
    {
        $this->adwords_cost = $value;
    }

    public function buildDomainRanks(\Ecomtracker\Semrush\Client\Domain $client, $display_date = null)
    {
        \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainRanks '. $this->value);
        
        //@todo ajw! this requires debugging and also may require a display date to be set
        $start_time = time();
        while(true) {
            if ((time() - $start_time) > 20) {
                \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainRanks timeout: '. $this->value);
                return $this; // timeout
            }
            $semrush_domain_ranks = $client->getDomainRanks($this->value,$display_date);
        }

        if(isset($semrush_domain_ranks))
        {
            \Log::info('Ecomtracker\Semrush\Models\Domain client returned results');
            foreach($semrush_domain_ranks->getRows() as $k => $item) {
                foreach ($item->getData() as $k => $v) {
                    $lower_key = strtolower($k);
                    $this->{$lower_key} = $v;
                }
            }
            \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainRanks Domain Values: '. print_r($this->toArray(), true));


        }

        return $this;

    }



    public function buildDomainRank(\Ecomtracker\Semrush\Client\Domain $client, $display_date = null)
    {
        \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainRank:' .$this->value );

        $start_time = time();

        while(true) {
            if ((time() - $start_time) > 20) {
                \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainRank timeout: '. $this->value);
                return $this; // timeout, function took longer than 300 seconds
            }
            $semrush_domain_rank = $client->getDomainRank($this->value);
        }

        if(isset($semrush_domain_rank))
        {
            \Log::info('Ecomtracker\Semrush\Models\Domain client returned results');
            foreach($semrush_domain_rank->getRows() as $k => $item) {
                foreach ($item->getData() as $k => $v) {
                    $lower_key = strtolower($k);
                    $this->{$lower_key} = $v;
                }
            }
            \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainRank Domain Values: '. print_r($this->toArray(), true));


        }
        return $this;
    }

    public function buildDomainAdwords(\Ecomtracker\Semrush\Client\Domain $client, $display_date = null)
    {
        \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainAdwords:' .$this->value );
        $start_time = time();


        \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainAdwords: getDomainAdwords' .$this->value );
        $semrush_domain_adwords = $client->getDomainAdwords($this->value);


        if (isset($semrush_domain_adwords)) {


            foreach ($semrush_domain_adwords->getRows() as $items) {
                $result = new Result();
                foreach ($items->getData() as $k => $v) {

                    $lower_key = strtolower($k);
                    $result->{$lower_key} = $v;
                }

                $result->type = 'adwords';
                $result->domain_id = $this->id;
                $result->domain = $this->value;

                \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainAdwords Result:' . print_r($result->toArray(), true));

                try {
                    \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainAdwords Result Save');
                    $result->save();
                } catch (\Exception $e) {
                    \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainAdwords Result Save Exception' . $e->getMessage());
                }

            }
        }
    }


    public function buildDomainOrganic(\Ecomtracker\Semrush\Client\Domain $client, $display_date = null)
    {
        \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainOrganic:' .$this->value );
        $semrush_domain_organic = $client->getDomainOrganic($this->value);
        $i = 1;
        foreach ($semrush_domain_organic->getRows() as $items) {
            $result = new Result();
            foreach ($items->getData() as $k => $v) {

                $lower_key = strtolower($k);
                $result->{$lower_key} = $v;
            }
            $result->type = 'organic';
            $result->domain_id = $this->id;
            $result->domain = $this->value;

            \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainOrganic Result:'. print_r($result->toArray(), true));
            try {
                \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainOrganic Result Save');
                $result->save();
            } catch (\Exception $e) {
                \Log::info('Ecomtracker\Semrush\Models\Domain buildDomainOrganic Result Save Exception' . $e->getMessage());
            }

        }
    }

    public function build(\Ecomtracker\Semrush\Client\Domain $client)
    {
        \Log::info('Ecomtracker\Semrush\Models\Domain build:' .$this->value );


        //PHRASE THIS
        //@todo ajw! this is total trash but its a quick way to itterate over the collection
        if (!$this->isBuilt()) {

            \Log::info('Ecomtracker\Semrush\Models\Domain build is not built' .$this->value );

            $this->buildDomainRank($client);
            $this->buildDomainAdwords($client);
            $this->buildDomainOrganic($client);

//            $this->buildDomainAdwords($client);
//            $this->buildDomainAdwordsAdwords($client);
//            $this->buildDomainAdwordsUnique($client);
//            $this->buildDomainDomains($client);
//            $this->buildDomainOrganic($client);
//            $this->buildDomainOrganicOrganic($client);

//            $this->buildDomainRanks($client);
//            $this->buildDomainShopping($client);
//            $this->buildDomainShoppingShopping($client);
//            $this->buildDomainShoppingUnique($client);

            $this->build_date = new \DateTime('now');
            $this->save();
        }
    }


    public function findOrCreate($condition, $data = null)
    {
        return parent::findOrCreate($condition, $data);
    }

    public function newCollection(Array $models = array())
    {
        return new DomainCollection($models);
    }
    
    
    
}