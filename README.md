# Laravel Wishlist

A simple Wishlist implementation for Laravel 11.\*|12.\*
> **For Laravel versions 5.8|6|7|8|9|10** install previous stable version 3.1  
> **If you have problems with the minimum PHP version of 8.0:** install previous stable version 2.2

[![Latest Stable Version](https://poser.pugx.org/javcorreia/laravel-wishlist/v/stable?format=flat-square)](https://packagist.org/packages/javcorreia/laravel-wishlist)
[![License](https://poser.pugx.org/javcorreia/laravel-wishlist/license?format=flat-square)](https://packagist.org/packages/javcorreia/laravel-wishlist)
[![Total Downloads](http://poser.pugx.org/javcorreia/laravel-wishlist/downloads)](https://packagist.org/packages/javcorreia/laravel-wishlist)

- saves items associated with users
- saves items associated with sessions on anonymous navigation
- can retrieve items from a user or session
- session items can be retrieved and associated with user on login

> This was forked from the excellent [Bhavinjr's](https://github.com/bhavinjr) [laravel-wishlist](https://github.com/bhavinjr/laravel-wishlist) with added functionality.

## Installation

Is installed via [Composer](http://getcomposer.org) by running in your project's root.  
```shell
composer require javcorreia/laravel-wishlist
```

Publish the default configuration file:
```shell
php artisan vendor:publish --provider="javcorreia\Wishlist\Providers\WishlistServiceProvider"
```
**Before running migration**, edit the required settings using the resulting `config/wishlist.php` file _([See Configuration](#Configuration))_.

To create the table run migrations:
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
