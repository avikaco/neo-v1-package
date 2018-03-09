<?php
namespace Ax\Neo;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class AxNeoServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Config::set('auth.providers.users.model', \Ax\Neo\V1\Auth\Models\User::class);
        
        // usage: ``` return view('ax-neo::view_name', compact('variable'));```
        // $this->loadViewsFrom(base_path('resources/views'), 'ax-neo');
        
        // $this->publishes([
        // __DIR__ . '/views' => base_path('resources/views')
        // ], 'views');
        
        // $this->publishes([
        // __DIR__ . '/configs' => base_path('config')
        // ], 'config');
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
