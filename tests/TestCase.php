<?php

namespace javcorreia\Wishlist\Tests;

use Illuminate\Contracts\Config\Repository;
use javcorreia\Wishlist\Providers\WishlistServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Workbench\App\Models\Product;
use Workbench\App\Providers\WorkbenchServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            WishlistServiceProvider::class,
            WorkbenchServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        tap($app['config'], function (Repository $config) {
            $config->set('wishlist.item_model', Product::class);
        });
    }
}
