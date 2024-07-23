<?php

namespace javcorreia\Wishlist\Tests;

use javcorreia\Wishlist\Providers\WishlistServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            WishlistServiceProvider::class,
        ];
    }
}
