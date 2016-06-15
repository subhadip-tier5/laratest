<?php namespace Ecomtracker\User\Providers;

use Ecomtracker\User\Models\Permission;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Ecomtracker\User\AuthManager;
use Ecomtracker\User\Auth;


class UserServiceProvider extends ServiceProvider
{
    public function boot(GateContract $gate, DispatcherContract $events)
    {


        /*
         * checking if running migrations
         */
        if (\App::runningInConsole())
        {

            $commands = \Request::server('argv', null);
            if ( isset($commands[1]) && ( $commands[1]=="migrate" or  $commands[1]=="migrate:reset" or $commands[1]=="migrate:refresh"   ) )
            {
                //echo "Migration runs";
                return false;  // brake the boot() running
            }
            //exit();
        }



        $packageDir = realpath(__DIR__.'/..');

          //Event Observers
        $events->listen('eloquent.creating: Ecomtracker\User\Models\User', 'Ecomtracker\User\Listeners\UserBeforeCreate');

        //View Composer
        view()->composer(
            'frontend::*', 'Ecomtracker\User\Http\ViewComposers\UserComposer'
        );

        //User permissions

//
        //Build permissions from all of the permissions and attach them to user

        /*
         * HOTFix to allow run migrations on a clean database
         */

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $gate->define($permission->key, function ($user) use ($permission) {

                //If we haven't passed an actual user to this get it
                if(!isset($user->id))
                {
                    try{
                        $user = \JWTAuth::parseToken()->authenticate();
                    } catch(\Exception $e)
                    {
                        $user = \Auth::user();

                    }
                }

                if (!$user) return false;
                if (!$user->roles) return false;

                return $user->roles()->get()->can($permission->key);

            });

        }





        include $packageDir.'/Http/routes.php';

    }

    public function register()
    {
        $this->registerAuth();
    }

    public function registerJWTServiceProvider()
    {
        $this->app->register(new JWTAuthServiceProvider($this->app));
        AliasLoader::getInstance()->alias("JWTAuth",JWTAuth::class);
        AliasLoader::getInstance()->alias("JWTFactory",JWTFactory::class);
    }


    public function registerAuth()
    {

        $this->app->bind ("auth", function($app) {
            $app['auth.loaded'] = true;
            return new AuthManager($app);
        });

        $this->app->singleton('auth', function ($app) {
            return new Auth();
        });


        $abstract = 'Ecomtracker\User\AuthInterface';
        $this->app->bind ($abstract, 'auth.driver');
        $this->app->bind ("auth", function($app) {
            $app['auth.loaded'] = true;
            return new AuthManager($app);
        });
        $this->app->singleton('auth.driver', function($app) {
            return $app['auth']->driver();
        });




    }



}