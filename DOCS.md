# Documentation

## Extending the Base Model to extra functionalities
If needed you can create a Model file, extend the base Wishlist model to add extra functionalities.  
In the following example, we'll add the `SoftDeletes` trait to have soft deletes in the wishlist table.
### Create a migration to add soft delete functionality to the wishlist table
```shell
php artisan make:migration add_softdelete_to_wishlist
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
php artisan migrate
```
### Extend the base model
Create the model:
```shell
php artisan make:model MyWishlist
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
