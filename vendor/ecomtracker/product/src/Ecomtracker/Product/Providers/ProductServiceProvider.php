<?php namespace Ecomtracker\Product\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $packageDir = realpath(__DIR__.'/..');
    }

    public function register()
    {

    }

}