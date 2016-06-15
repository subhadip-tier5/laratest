<?php namespace Ecomtracker\Admin\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $packageDir = realpath(__DIR__.'/..');
        include $packageDir.'/Http/routes.php';
        $this->loadViewsFrom($packageDir.'/views', 'admin');

    }

    public function register()
    {
        \View::composer('*', function($view){

            \View::share('view_name', $view->getName());

        });


        $packageDir = realpath(__DIR__.'/..');

    }

}