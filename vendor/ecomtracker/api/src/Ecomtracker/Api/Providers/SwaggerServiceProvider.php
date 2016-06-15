<?php namespace Ecomtracker\Api\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;

class SwaggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $packageDir = realpath(__DIR__.'/..');
        $this->publishes([
            __DIR__.'../../../../../public/swagger' => public_path('vendor/swagger'),
        ], 'public');

        $this->loadViewsFrom($packageDir.'/views/swagger', 'swagger');


        include $packageDir.'/Http/swagger-routes.php';
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../../../config/swagger.php', 'swagger'
        );

        $packageDir = realpath(__DIR__.'/..');
        require_once $packageDir.'/Http/swagger-routes.php';



    }

}