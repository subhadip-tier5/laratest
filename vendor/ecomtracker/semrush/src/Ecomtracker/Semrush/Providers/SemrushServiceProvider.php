<?php namespace Ecomtracker\Semrush\Providers;

use Ecomtracker\Source\Models\Source;
use \Illuminate\Contracts\Events\Dispatcher;
use Ecomtracker\Semrush\Client\Backlink;
use Ecomtracker\Semrush\Client\Config;
use Ecomtracker\Semrush\Client\Domain;
use Ecomtracker\Semrush\Client\Keyword;
use Ecomtracker\Semrush\Client\Publisher;
use Ecomtracker\Semrush\Client\RequestFactory;
use Ecomtracker\Semrush\Client\ResponseParser;
use Ecomtracker\Semrush\Client\ResultFactory;
use Ecomtracker\Semrush\Client\RowFactory;
use Ecomtracker\Semrush\Client\Url;
use Ecomtracker\Semrush\Client\UrlBuilder;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class SemrushServiceProvider extends ServiceProvider
{
    public function boot(Dispatcher $events)
    {
        $packageDir = realpath(__DIR__ . '/..');
        include $packageDir.'/Http/routes.php';

        $this->publishes([
            __DIR__.'/../../../../config/semrush.php' => config_path('semrush.php'),
        ]);

        $this->bootAmazonKeywordListener($events);
        $this->bootKeywordListener($events);
        $this->bootDomainListener($events);
        $this->bootKeywordResultListner($events);

    }

    public function bootAmazonKeywordListener($events)
    {
        $events->listen('eloquent.saved: Ecomtracker\Amazon\Models\Keyword', function($model){

            try{
            $client = \App::make('semrush.keyword.client');

            $newKeyword = \Ecomtracker\Semrush\Models\Keyword::getModel();

//            $newKeyword = \Ecomtracker\Keyword\Models\Keyword::getModel();
            $newKeyword->source_id = Source::where('source','=','Ecomtracker\Semrush\Models\Keyword')->first()->id;
            $newKeyword->value = $model->value;
            $newKeyword->save();
            }catch(\Exception $e)
            {
                \Log::info('Amazon to Semrush Keyword is duplicated: '. $e->getMessage());
            }
        });


    }    
    

    public function bootKeywordListener($events)
    {
        $events->listen('eloquent.saved: Ecomtracker\Semrush\Models\Keyword', function($model){
            $client = \App::make('semrush.keyword.client');
//            $model->build($client);
        });


    }
    
    public function bootDomainListener($events)
    {
        $events->listen('eloquent.saved: Ecomtracker\Semrush\Models\Domain', function($model){
            $client = \App::make('semrush.domain.client');
            $model->build($client);
        });
        
    }
    
    
    

    public function bootKeywordResultListner($events)
    {
        $events->listen('eloquent.saved: Ecomtracker\Semrush\Models\Keyword\Result', function ($model) {

            $domain = $model->domain;
            //If no domain create the domain
            if (!$domain) {
                $domain_data = [
                    'value' => $model->domain,
                    'source_id' => Source::where('source', '=', 'Ecomtracker\Semrush\Models\Domain')->first()->id,

                ];


                $domain = \Ecomtracker\Semrush\Models\Domain::getModel()->fill($domain_data);
                $domain->save();
            }

        });


    }



    public function registerConfig()
    {
        $this->app->singleton('semrush.config', function ($app) {

            $config = new \Ecomtracker\Semrush\Client\Config(\Config::get('semrush'));
            return $config;
        });
    }

    public function registerHttpClient()
    {
        $this->app->singleton('http.client', function ($app) {
            return new Client();
        });
    }


    public function registerClientRequestFactory()
    {
        $this->app->singleton('semrush.client.requestFactory', function ($app){
            $requestFactory = new RequestFactory();
            return $requestFactory;
        });
    }


    public function registerClientRowFactory()
    {
        $this->app->singleton('semrush.client.rowFactory',function($app){
            $rowFactory = new RowFactory();
            return $rowFactory;
        });
    }
    
    
    public function registerClientResultFactory()
    {
        $this->app->singleton('semrush.client.resultFactory', function ($app){
            $rowFactory = \App::make('semrush.client.rowFactory');
            $resultFactory = new ResultFactory($rowFactory);
            return $resultFactory;
        });
        
    }

    public function registerResponseParser()
    {
        $this->app->singleton('semrush.client.responseParser', function ($app){
            $responseParser = new ResponseParser();
            return $responseParser;
        });

    }

    public function registerUrlBuilder()
    {
        $this->app->singleton('semrush.client.urlBuilder', function ($app){
            $urlBuilder = new UrlBuilder();
            return $urlBuilder;
        });

    }

    
    public function registerKeywordClient()
    {
        $this->app->singleton('semrush.keyword.client', function ($app) {
            $key = $app->make('semrush.config')->get('key');

            $requestFactory = \App::make('semrush.client.requestFactory');
            $resultFactory = \App::make('semrush.client.resultFactory');
            $responseParser = \App::make('semrush.client.responseParser');
            $urlBuilder = \App::make('semrush.client.urlBuilder');
            $httpClient = \App::make('http.client');


            $keyword = new Keyword($key, $requestFactory, $resultFactory, $responseParser, $urlBuilder, $httpClient);

            return $keyword;
        });
        
    }
    
    public function registerBacklinkClient()
    {

        $this->app->singleton('semrush.backlink.client', function ($app) {
            $key = $app->make('semrush.config')->get('key');

            $requestFactory = \App::make('semrush.client.requestFactory');
            $resultFactory = \App::make('semrush.client.resultFactory');
            $responseParser = \App::make('semrush.client.responseParser');
            $urlBuilder = \App::make('semrush.client.urlBuilder');
            $httpClient = \App::make('http.client');
            $backlink = new Backlink($key, $requestFactory, $resultFactory, $responseParser, $urlBuilder, $httpClient);
            return $backlink;
        });


    }
    
    public function registerDomainClient()
    {

        $this->app->singleton('semrush.domain.client', function ($app) {
            $key = $app->make('semrush.config')->get('key');

            $requestFactory = \App::make('semrush.client.requestFactory');
            $resultFactory = \App::make('semrush.client.resultFactory');
            $responseParser = \App::make('semrush.client.responseParser');
            $urlBuilder = \App::make('semrush.client.urlBuilder');
            $httpClient = \App::make('http.client');
            $domain = new Domain($key, $requestFactory, $resultFactory, $responseParser, $urlBuilder, $httpClient);
            return $domain;
        });       
        
    
    }
    public function registerPublisherClient()
    {
        $this->app->singleton('semrush.backlink.client', function ($app) {
            $key = $app->make('semrush.config')->get('key');

            $requestFactory = \App::make('semrush.client.requestFactory');
            $resultFactory = \App::make('semrush.client.resultFactory');
            $responseParser = \App::make('semrush.client.responseParser');
            $urlBuilder = \App::make('semrush.client.urlBuilder');
            $httpClient = \App::make('http.client');
            $publisher = new Publisher($key, $requestFactory, $resultFactory, $responseParser, $urlBuilder, $httpClient);
            return $publisher;
        });
    }
    
    public function registerUrlClient()
    {
        $this->app->singleton('semrush.url.client', function ($app) {
            $key = $app->make('semrush.config')->get('key');
            $requestFactory = \App::make('semrush.client.requestFactory');
            $resultFactory = \App::make('semrush.client.resultFactory');
            $responseParser = \App::make('semrush.client.responseParser');
            $urlBuilder = \App::make('semrush.client.urlBuilder');
            $httpClient = \App::make('http.client');
            $url = new Url($key, $requestFactory, $resultFactory, $responseParser, $urlBuilder, $httpClient);
            return $url;
        });
    }

    
    
    public function register()
    {
        $this->registerConfig();
        $this->registerClientRequestFactory();
        $this->registerClientRowFactory();      
        $this->registerClientResultFactory();        
        $this->registerResponseParser();
        $this->registerUrlBuilder();
        $this->registerHttpClient();
        $this->registerKeywordClient();
        $this->registerBacklinkClient();
        $this->registerDomainClient();
        $this->registerPublisherClient();
        $this->registerUrlClient();
        
        //Console Commands
        $this->commands([
            \Ecomtracker\Semrush\Console\Commands\Domain\Build::class,
            \Ecomtracker\Semrush\Console\Commands\Keyword\Build::class,
            \Ecomtracker\Semrush\Console\Commands\Keyword\BuildDistribution::class,
            \Ecomtracker\Semrush\Console\Commands\Keyword\BuildResults::class,
            \Ecomtracker\Semrush\Console\Commands\Keyword\BuildKdi::class,
            \Ecomtracker\Semrush\Console\Commands\Keyword\BuildRelated::class,
        ]);
        
        

    }

}