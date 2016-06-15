<?php namespace Ecomtracker\Api\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $packageDir = realpath(__DIR__.'/..');
        include $packageDir.'/Http/routes.php';
    }

    public function register()
    {
        $this->registerJWTServiceProvider();
    }


    public function registerJWTServiceProvider()
    {
        $this->app->register(new JWTAuthServiceProvider($this->app));
        AliasLoader::getInstance()->alias("JWTAuth",JWTAuth::class);
        AliasLoader::getInstance()->alias("JWTFactory",JWTFactory::class);
    }



}