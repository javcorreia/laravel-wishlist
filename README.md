# Laravel Wishlist
[![Latest Stable Version](https://poser.pugx.org/javcorreia/laravel-wishlist/v/stable?style=flat-square)](https://packagist.org/packages/javcorreia/laravel-wishlist)
[![PHP Version Require](https://poser.pugx.org/javcorreia/laravel-wishlist/require/php?style=flat-square)](https://packagist.org/packages/javcorreia/laravel-wishlist)
[![License](https://poser.pugx.org/javcorreia/laravel-wishlist/license?style=flat-square)](https://packagist.org/packages/javcorreia/laravel-wishlist)
[![Total Downloads](http://poser.pugx.org/javcorreia/laravel-wishlist/downloads?style=flat-square)](https://packagist.org/packages/javcorreia/laravel-wishlist)

A simple Wishlist implementation for Laravel |13.\*
> see [Versions](#versions) for older Laravel versions

- saves items associated with users
- saves items associated with sessions on anonymous navigation
- can retrieve items from a user or session
- session items can be retrieved and associated with user on login

> Forked from [Bhavinjr's](https://github.com/bhavinjr) [laravel-wishlist](https://github.com/bhavinjr/laravel-wishlist) with some added functionality and updated to latest Laravel and PHP versions.

# Table of Contents
- [Versions](#versions)
- [Installation](#installation)
- [Configuration](#configuration)
- [Documentation](#documentation)
- [Testing](#testing)

## Versions
| Version | Supports                      | Status     |
|---------|-------------------------------|------------|
| 5.*     | Laravel [13]; PHP >= 8.3      | current    |
| 4.*     | Laravel [11, 12]; PHP >= 8.1  | deprecated |
| 3.*     | Laravel [5.8, 10]; PHP >= 8.0 | deprecated |
| 2.2     | Laravel [5.8, 9]; PHP ^7.2    | deprecated |
| 2.0     | Laravel [5.8, 8]; PHP ^7.2    | deprecated |

## Installation

Is installed via [Composer](http://getcomposer.org) by running in your project's root.  
```shell
composer require javcorreia/laravel-wishlist
```

Publish the default configuration file:
```shell
php artisan vendor:publish --provider="javcorreia\Wishlist\Providers\WishlistServiceProvider"
```
**Before running migration**, edit the required settings using the resulting `config/wishlist.php` file _([See Configuration](#configuration))_.

To run migrations:
```shell
php artisan migrate
```

## Configuration

Configuration was designed to be as flexible as changing the global configuration in the `config/wishlist.php` file.  
You will need to provide at least, the model for the items to be wishlisted, for example:  
```php
return [
    'item_model' => App\Models\Product::class,
];
```
The other values can be the default ones, unless changes are needed.
  
After updating the `config/wishlist.php` file execute the following command to cache configs:  
```shell
php artisan config:cache
```

## Documentation
See [DOCS.md](DOCS.md)

## Testing
See [TESTS.md](TESTS.md)
