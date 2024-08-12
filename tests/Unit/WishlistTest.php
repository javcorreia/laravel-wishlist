<?php

test('check for products to add', function () {
    $count = \Illuminate\Support\Facades\DB::table('products')->count();

    expect($count)->toBeGreaterThan(0);
});

test('check for users to use', function () {
    $count = \Illuminate\Support\Facades\DB::table('users')->count();

    expect($count)->toBeGreaterThan(0);
});

test('check for wishlist add', function () {
    $countBefore = \Illuminate\Support\Facades\DB::table('wishlist')->count();
    $wishlistAdd = \javcorreia\Wishlist\Facades\Wishlist::add(1, 1);
    $checkForRecord = \Illuminate\Support\Facades\DB::table('wishlist')->orderBy('id', 'desc')->first();
    $countAfter = \Illuminate\Support\Facades\DB::table('wishlist')->count();

    expect($wishlistAdd)->toBeTrue()
        ->and($checkForRecord->user_id)->toBe(1)
        ->and($checkForRecord->item_id)->toBe(1)
        ->and($countAfter)->toBeGreaterThanOrEqual($countBefore);
});

test('check for wishlist collection get', function () {
    $wishlistCollection = \javcorreia\Wishlist\Facades\Wishlist::getUserWishList(1);

    expect($wishlistCollection)->toBeInstanceOf(\Illuminate\Database\Eloquent\Collection::class);
});

test('check for wishlist remove', function () {
    $countBefore = \Illuminate\Support\Facades\DB::table('wishlist')->count();
    $getRecordToRemove = \Illuminate\Support\Facades\DB::table('wishlist')->orderBy('id', 'desc')->first();
    $wishlistRemoval = \javcorreia\Wishlist\Facades\Wishlist::remove($getRecordToRemove->id, $getRecordToRemove->user_id);
    $countAfter = \Illuminate\Support\Facades\DB::table('wishlist')->count();

    expect($wishlistRemoval)->toBeBool()
        ->and($wishlistRemoval)->toBeTrue()
        ->and($countBefore)->toBeGreaterThan($countAfter);
});
