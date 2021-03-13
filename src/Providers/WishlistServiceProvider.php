<?php
namespace javcorreia\Wishlist\Providers;

use Illuminate\Support\ServiceProvider;
use javcorreia\Wishlist\Wishlist;

class WishlistServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfiguration();
        $this->publishMigrations();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $config = __DIR__ . '/../../config/wishlist.php';
        $this->mergeConfigFrom($config, 'wishlist');
        $this->app->singleton('Wishlist', Wishlist::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Wishlist'];
    }

    public function publishConfiguration()
    {
        $path = realpath(__DIR__.'/../../config/wishlist.php');
        $this->publishes([$path => config_path('wishlist.php')], 'config');
    }

    public function publishMigrations()
    {
        $this->publishes([
            __DIR__.'/../../database/migrations/' => database_path('/migrations')
        ], 'migrations');
    }
}
