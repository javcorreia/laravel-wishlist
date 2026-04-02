<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use javcorreia\Wishlist\Facades\Wishlist;
use Exception;

beforeEach(function () {
    DB::table('wishlist')->delete();
});

test('check for products to add', function () {
    $count = DB::table('products')->count();

    expect($count)->toBeGreaterThan(0);
});

test('check for users to use', function () {
    $count = DB::table('users')->count();

    expect($count)->toBeGreaterThan(0);
});

test('check for wishlist add', function () {
    $countBefore = DB::table('wishlist')->count();
    $wishlistAdd = Wishlist::add(1, 1);
    $checkForRecord = DB::table('wishlist')->orderBy('id', 'desc')->first();
    $countAfter = DB::table('wishlist')->count();

    expect($wishlistAdd)->toBeTrue()
        ->and($checkForRecord->user_id)->toBe(1)
        ->and($checkForRecord->item_id)->toBe(1)
        ->and($countAfter)->toBeGreaterThanOrEqual($countBefore);
});

test('check for wishlist collection get', function () {
    $wishlistCollection = Wishlist::getUserWishList(1);

    expect($wishlistCollection)->toBeInstanceOf(Collection::class);
});

test('check for wishlist remove', function () {
    $wishlistAdd = Wishlist::add(1, 1);
    $countBefore = DB::table('wishlist')->count();
    $getRecordToRemove = DB::table('wishlist')->orderBy('id', 'desc')->first();
    $wishlistRemoval = Wishlist::remove($getRecordToRemove->id, $getRecordToRemove->user_id);
    $countAfter = DB::table('wishlist')->count();

    expect($wishlistRemoval)->toBeBool()
        ->and($wishlistRemoval)->toBeTrue()
        ->and($countBefore)->toBeGreaterThan($countAfter);
});

test('it adds a wishlist item for a user', function () {
    $result = Wishlist::add(1, 1);

    $record = DB::table('wishlist')->where('user_id', 1)->where('item_id', 1)->first();

    expect($result)->toBeTrue()
        ->and($record)->not->toBeNull()
        ->and($record->user_id)->toBe(1)
        ->and($record->item_id)->toBe(1);
});

test('it adds a wishlist item for a session', function () {
    $sessionId = 'session-123';

    $result = Wishlist::add(1, $sessionId, 'session');

    $record = DB::table('wishlist')->where('session_id', $sessionId)->where('item_id', 1)->first();

    expect($result)->toBeTrue()
        ->and($record)->not->toBeNull()
        ->and($record->session_id)->toBe($sessionId)
        ->and($record->item_id)->toBe(1);
});

test('it does not create duplicate wishlist items for the same user and item', function () {
    Wishlist::add(1, 1);
    Wishlist::add(1, 1);

    $count = DB::table('wishlist')->where('user_id', 1)->where('item_id', 1)->count();

    expect($count)->toBe(1);
});

test('it returns a user wishlist collection', function () {
    Wishlist::add(1, 1);
    Wishlist::add(2, 1);
    Wishlist::add(3, 2);

    $wishlist = Wishlist::getUserWishList(1);

    expect($wishlist)->toBeInstanceOf(Collection::class)
        ->and($wishlist)->toHaveCount(2);
});

test('it gets a wishlist item by item id', function () {
    Wishlist::add(10, 1);

    $item = Wishlist::getWishListItem(10, 1);

    expect($item)->not->toBeNull()
        ->and($item->item_id)->toBe(10)
        ->and($item->user_id)->toBe(1);
});

test('it returns null when a wishlist item does not exist', function () {
    $item = Wishlist::getWishListItem(999, 1);

    expect($item)->toBeNull();
});

test('it removes a wishlist item by id', function () {
    Wishlist::add(1, 1);
    Wishlist::add(2, 1);

    $record = DB::table('wishlist')->where('user_id', 1)->where('item_id', 1)->first();

    $result = Wishlist::remove($record->id, 1);

    expect($result)->toBeTrue()
        ->and(DB::table('wishlist')->where('id', $record->id)->exists())->toBeFalse()
        ->and(DB::table('wishlist')->where('user_id', 1)->where('item_id', 2)->exists())->toBeTrue();
});

test('it returns false when removing a missing wishlist item', function () {
    $result = Wishlist::remove(999, 1);

    expect($result)->toBeFalse();
});

test('it removes a wishlist item by item id', function () {
    Wishlist::add(1, 1);
    Wishlist::add(2, 1);

    $result = Wishlist::removeByItem(1, 1);

    expect($result)->toBeTrue()
        ->and(DB::table('wishlist')->where('user_id', 1)->where('item_id', 1)->exists())->toBeFalse()
        ->and(DB::table('wishlist')->where('user_id', 1)->where('item_id', 2)->exists())->toBeTrue();
});

test('it removes all wishlist items for a user', function () {
    Wishlist::add(1, 1);
    Wishlist::add(2, 1);
    Wishlist::add(3, 2);

    $result = Wishlist::removeUserWishList(1);

    expect($result)->toBeInt()
        ->and(DB::table('wishlist')->where('user_id', 1)->count())->toBe(0)
        ->and(DB::table('wishlist')->where('user_id', 2)->count())->toBe(1);
});

test('it associates session wishlist items to a user', function () {
    $sessionId = 'session-123';

    Wishlist::add(1, $sessionId, 'session');
    Wishlist::add(2, $sessionId, 'session');

    $result = Wishlist::assocSessionWishListToUser(1, $sessionId);

    expect($result)->toBeTrue()
        ->and(DB::table('wishlist')->where('session_id', $sessionId)->count())->toBe(0)
        ->and(DB::table('wishlist')->where('user_id', 1)->where('item_id', 1)->exists())->toBeTrue()
        ->and(DB::table('wishlist')->where('user_id', 1)->where('item_id', 2)->exists())->toBeTrue();
});

test('it returns true when associating an empty session wishlist', function () {
    $result = Wishlist::assocSessionWishListToUser(1, 'empty-session');

    expect($result)->toBeTrue();
});

test('it counts wishlist items for a user', function () {
    Wishlist::add(1, 1);
    Wishlist::add(2, 1);
    Wishlist::add(3, 2);

    expect(Wishlist::count(1))->toBe(2)
        ->and(Wishlist::count(2))->toBe(1)
        ->and(Wishlist::count(999))->toBe(0);
});
