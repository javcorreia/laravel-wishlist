# Laravel Wishlist

A simple Wishlist implementation for Laravel 11.\*
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

## Extending the Base Model to extra functionalities
If needed you can create a Model file, extend the base Wishlist model to add extra functionalities.  
In the following example, we'll add the `SoftDeletes` trait to have soft deletes in the wishlist table.
### Create a migration to add soft delete functionality to the wishlist table
```shell
$ php artisan make:migration add_softdelete_to_wishlist
```
In the migration:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $schemaTableName = config('wishlist.table_name');

        Schema::table($schemaTableName, function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $schemaTableName = config('wishlist.table_name');

        Schema::table($schemaTableName, function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}; 
```
Run migrate to update table:
```shell
$ php artisan migrate
```
### Extend the base model
Create the model:
```shell
$ php artisan make:model MyWishlist
```
Add the `SoftDeletes` trait:
```php
namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use javcorreia\Wishlist\Models\Wishlist as BaseWishlist;

class MyWishlist extends BaseWishlist
{
    use SoftDeletes;
}
```
### Change config to use your new Model class
In `wishlist.php` config file:
```php
<?php

return [

    // (...)
    
    /*
    |--------------------------------------------------------------------------
    | Custom Wishlist model
    |--------------------------------------------------------------------------
    |
    | This option allows for the extension of the wishlist Model
	| App\Models\MyWishlist::class
    |
    */
    'model' => App\Models\MyWishlist::class

];
```

## Usage
Just use the provided facade to access its methods.
> **Hint:** use [Laravel IDE Helper Generator](https://github.com/barryvdh/laravel-ide-helper) to have code completion on facade methods
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
## Testing
Compose require dev packages.  
The tests are done with resource to [PestPHP](https://pestphp.com/) and [Testbench](https://github.com/orchestral/testbench).  
To execute them run the following:
```shell
vendor/bin/testbench db:migrate
vendor/bin/testbench db:seed --class=\\Workbench\\Database\\Seeders\\DatabaseSeeder
vendor/bin/pest
```
