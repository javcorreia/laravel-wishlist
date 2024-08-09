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
