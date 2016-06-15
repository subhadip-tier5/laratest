<?php namespace Ecomtracker\Api\Providers;

use Illuminate\Support\ServiceProvider;

class KeywordServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $packageDir = realpath(__DIR__.'/..');
    }

    public function register()
    {
    }

}