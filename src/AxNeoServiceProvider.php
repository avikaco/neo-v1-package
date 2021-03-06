<?php
namespace Ax\Neo;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Ax\Neo\V1\Commands\TestConfig;

class AxNeoServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        require_once __DIR__ . '/helper-functions.php';
        
        // overwrite auth model with NEO User model in file /config/auth.php
        Config::set('auth.providers.users.model', \Ax\Neo\V1\Models\User::class);
        $this->mergeConfigFrom(__DIR__ . '/config/neo.php', 'neo');
        
        $this->app['router']->aliasMiddleware('neo.auth.basic', \Ax\Neo\V1\Auth\Middleware::class);
        
        // usage: return view('ax-neo::view_name', compact('variable'));
        $this->loadViewsFrom(__DIR__ . '/views', 'ax-neo');
        
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/ax/neo')
        ]);
        
        $this->publishes([
            __DIR__ . '/config' => base_path('config')
        ], 'config');
        
        if ($this->app->runningInConsole()) {
            $this->commands([
                TestConfig::class
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
