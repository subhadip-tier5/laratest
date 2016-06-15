<?php

namespace Ecomtracker\Tracking\Providers;

use Illuminate\Support\ServiceProvider;

use Ecomtracker\User\Auth;

class TrackingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $packageDir = realpath(__DIR__.'/..');


        $this->publishes([
            __DIR__.'/../Migrations' => $this->app->databasePath().'/migrations'
        ], 'migrations');



        $this->publishes([
            __DIR__.'/../Seeds' => $this->app->databasePath().'/seeds'
        ], 'seeds');

        $this->publishes([
            __DIR__.'/../config/amazon.php' => config_path('amazon.php'),
        ]);


        /*
        $this->publishes([
            __DIR__.'/../tests' => app_path('tests'),
        ]);
        */

        $this->loadViewsFrom($packageDir.'/Views', 'tracking');

        include $packageDir.'/Http/routes.php';



    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            \Ecomtracker\Tracking\Console\Commands\Tracker::class
        ]);


    }
}
