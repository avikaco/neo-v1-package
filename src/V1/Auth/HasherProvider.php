<?php
namespace Ax\Neo\V1\Auth;

use Illuminate\Support\ServiceProvider;

class HasherProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('hash', function () {
            return new Hasher();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'hash'
        );
    }
}