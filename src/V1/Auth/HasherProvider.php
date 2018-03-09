<?php
namespace Ax\Neo\V1\Auth;

use Illuminate\Support\ServiceProvider;

/*
 * TODO
 * 1. jangan lupa di config app.php bagian providers dikomen
 * // Illuminate\Hashing\HashServiceProvider::class,
 * 2. ganti jadi
 * Ax\Neo\V1\Auth\HasherProvider::class,
 */
class HasherProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // pakai ini kalo laravel 5.4+
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