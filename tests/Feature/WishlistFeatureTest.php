<?php

test('test database consistency after adding and deleting a favorite', function () {
    $countBefore = \Illuminate\Support\Facades\DB::table('wishlist')->count();
    $wishlistAdd = \javcorreia\Wishlist\Facades\Wishlist::add(1, 1);
    $getRecordToRemove = \Illuminate\Support\Facades\DB::table('wishlist')->orderBy('id', 'desc')->first();
    $wishlistRemoval = \javcorreia\Wishlist\Facades\Wishlist::remove($getRecordToRemove->id, $getRecordToRemove->user_id);
    $countAfter = \Illuminate\Support\Facades\DB::table('wishlist')->count();

    expect($wishlistAdd)->toBeTrue()
        ->and($countAfter)->toEqual($countBefore)
        ->and($wishlistRemoval)->toBeBool()
        ->and($wishlistRemoval)->toBeTrue();
});