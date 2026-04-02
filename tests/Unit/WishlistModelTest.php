<?php

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use javcorreia\Wishlist\Facades\Wishlist;
use javcorreia\Wishlist\Models\Wishlist as WishlistModel;
use Workbench\App\Models\Product;

beforeEach(function () {
    DB::table('wishlist')->delete();
});

test('it uses the configured table name', function () {
    $model = new WishlistModel();

    expect($model->getTable())->toBe(config('wishlist.table_name'));
});

test('it has the expected fillable attributes', function () {
    $model = new WishlistModel();

    expect($model->getFillable())->toBe([
        'user_id',
        'session_id',
        'item_id',
    ]);
});

test('it filters items by user id using the scope', function () {
    Wishlist::add(1, 1);
    Wishlist::add(2, 1);
    Wishlist::add(3, 2);

    $wishlists = WishlistModel::query()->ofUser(1, 'user')->get();

    expect($wishlists)->toHaveCount(2);

    foreach ($wishlists as $wishlist) {
        expect($wishlist->user_id)->toBe(1);
    }
});

test('it filters items by session id using the scope', function () {
    $sessionId = 'session-123';

    Wishlist::add(1, $sessionId, 'session');
    Wishlist::add(2, $sessionId, 'session');
    Wishlist::add(3, 'session-456', 'session');

    $wishlists = WishlistModel::query()->ofUser($sessionId, 'session')->get();

    expect($wishlists)->toHaveCount(2);

    foreach ($wishlists as $wishlist) {
        expect($wishlist->session_id)->toBe($sessionId);
    }
});

test('it filters items by item id using the scope', function () {
    Wishlist::add(10, 1);
    Wishlist::add(10, 2);
    Wishlist::add(11, 1);

    $wishlists = WishlistModel::query()->byItem(10)->get();

    expect($wishlists)->toHaveCount(2);

    foreach ($wishlists as $wishlist) {
        expect($wishlist->item_id)->toBe(10);
    }
});

test('it defines a belongs to item relationship', function () {
    $model = new WishlistModel();

    expect($model->item())->toBeInstanceOf(BelongsTo::class);
});

test('it returns the related product through the item relationship', function () {
    $product = Product::query()->firstOrFail();

    Wishlist::add($product->getKey(), 1);

    $wishlist = WishlistModel::query()->where('item_id', $product->getKey())->firstOrFail();

    expect($wishlist->item)->toBeInstanceOf(Product::class)
        ->and($wishlist->item->getKey())->toBe($product->getKey());
});
