<?php

return [

	/*
    |--------------------------------------------------------------------------
    | Custom model
    |--------------------------------------------------------------------------
    |
    | This option defines the item model, by pointing it to a laravel model, e.g
	| App\Models\Product::class
    |
    */
    'item_model' => 'LARAVEL_PRODUCT_MODEL',

    /*
    |--------------------------------------------------------------------------
    | Wishlist table name
    |--------------------------------------------------------------------------
    |
    | Provide a different table name if needed.
    |
    */
    'table_name' => 'wishlist',

    /*
    |--------------------------------------------------------------------------
    | Custom Wishlist model
    |--------------------------------------------------------------------------
    |
    | This option allows for the extension of the wishlist Model
	| App\Models\MyWishlist::class
    |
    */
    'model' => \javcorreia\Wishlist\Models\Wishlist::class
];
