# laravel-wishlist

A simple Wishlist implementation for Laravel 5.8|6.\*|7.\*|8.\*|9.\*.

[![Latest Stable Version](https://poser.pugx.org/javcorreia/laravel-wishlist/v/stable?format=flat-square)](https://packagist.org/packages/javcorreia/laravel-wishlist)
[![License](https://poser.pugx.org/javcorreia/laravel-wishlist/license?format=flat-square)](https://packagist.org/packages/javcorreia/laravel-wishlist)

This is fork of the excellent [Bhavinjr's](https://github.com/bhavinjr) [laravel-wishlist](https://github.com/bhavinjr/laravel-wishlist).

I've added the possibility to save a wishlist associated with a custom session id, instead of just a user_id, making it more flexible.  
It's also possible to extend the default Model wishlist model to add soft deletes possibility, if needed.  

Hence, the table was changed a bit, as well as the methods.

## Installation

Is installed via [Composer](http://getcomposer.org) by running in your project's root.  
```shell
$ composer require javcorreia/laravel-wishlist
```

Publish the default configuration file:
```shell
$ php artisan vendor:publish --provider="javcorreia\Wishlist\Providers\WishlistServiceProvider"
```
**Before running migration**, edit the required settings using the resulting `config/wishlist.php` file _([See Configuration](#Configuration))_.

To create the table run migrations:
```shell
$ php artisan migrate
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
$ php artisan config:cache
```

## Extending Base Model to use Soft Deletes
If needed you can create a Model file, extend the base Wishlist model and add `SoftDeletes` trait.
```php
namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use javcorreia\Wishlist\Models\Wishlist as BaseWishlist;
class Wishlist extends BaseWishlist
{
    use SoftDeletes;
}
```

## Usage
Just use the provided facade to access its methods.
> **Hint:** use [Laravel IDE Helper Generator](https://github.com/barryvdh/laravel-ide-helper) for methods code completion
```php
namespace App\Http\Controllers;

use javcorreia\Wishlist\Facades\Wishlist;

// ...
```

The package gives you the following methods to use:

Adding an item to the wishlist is really simple 

you need specify the **item** to add and the **user** to add it to respectively.  
These two parameters are required. 

> **type** ['user', 'session'] is an optional parameter which tells the service if the user is an application authenticated user_id or  
a custom session/cookie id.  

### Wishlist::add(item, user[, type='user'])

```php
// add item to user_id
Wishlist::add(15, 1);

// add item to session_id
Wishlist::add(15, 'CUSTOM_SESSION_ID', 'session');
```

### Wishlist::remove(id, user[, type='user'])

To remove an item from the wishlist, specify the wishlist_id and the user associated with the item. 

> **type** ['user', 'session'] is an optional parameter wich tells the service if the user is an application authenticated user_id or  
a custom session/cookie id.

```php
// remove item from user_id
Wishlist::remove(2, 1);

// remove item from session_id
Wishlist::remove(2, 'CUSTOM_SESSION_ID', 'session');
```

### Wishlist::getUserWishList(user[, type='user'])

To get all wishlist items from a user, specify the user_id. 

> **type** ['user', 'session'] is an optional parameter wich tells the service if the user is an application authenticated user_id or  
a custom session/cookie id.

```php
// get all items from user_id
Wishlist::getUserWishList(1);

// get all items from session_id
Wishlist::getUserWishList('CUSTOM_SESSION_ID', 'session');
```

### Wishlist::removeUserWishList(user[, type='user'])

To remove all wishlist items from a user, specify the user_id. 

> **type** ['user', 'session'] is an optional parameter wich tells the service if the user is an application authenticated user_id or  
a custom session/cookie id.

```php
// remove all items from user_id
Wishlist::removeUserWishList(1);

// remove all items from session_id
Wishlist::removeUserWishList('CUSTOM_SESSION_ID');
```

### Wishlist::removeByItem(item, user[, type='user'])

To remove a particular item, specify the item and user respectively. 

> **type** ['user', 'session'] is an optional parameter wich tells the service if the user is an application authenticated user_id or  
a custom session/cookie id.

```php
// remove item from user_id
Wishlist::removeByItem(15, 1);

// remove item from session_id
Wishlist::removeByItem(15, 'CUSTOM_SESSION_ID', 'session');
```


### Wishlist::count(user[, type='user'])

Total wishlist items from a user.

```php
// total items from user_id
Wishlist::count(1);

// total items from session_id
Wishlist::count('CUSTOM_SESSION_ID', 'session');
```

### Wishlist::getWishListItem(item, user[, type='user'])

To get particular wishlist item, specify the item and user respectively. 

> **type** ['user', 'session'] is an optional parameter wich tells the service if the user is an application authenticated user_id or  
a custom session/cookie id.

```php
// get item from user_id
Wishlist::getWishListItem(15, 1);

// get item from session_id
Wishlist::getWishListItem(15, 'CUSTOM_SESSION_ID', 'session');
```

### Wishlist::assocSessionWishListToUser(user_id, session_id)

To associate a particular session_id wishlist to an authenticated user.  
A user who has number of favorites while unlogged, if he logins, this method could be run to preserve the potentialy new wishlist items.

```php
// get item from user_id
Wishlist::assocSessionWishListToUser(1, 'CUSTOM_SESSION_ID');
```

You can the load item detail using laravel Eloquent association:
```php
$result = Wishlist::getUserWishList(1)->load('item');
```
or you can access it directly invoking the appropriate Eloquent model
```php
$result = Wishlist::getUserWishList(1);
$product = Product::find($result->id);
```
