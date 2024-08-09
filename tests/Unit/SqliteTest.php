<?php

use Illuminate\Support\Facades\Schema;

test('confirm sqlite is configured', function () {
    expect(config('database.default'))->toBe('sqlite');
});

test('check for table existence', function () {
    $exists = Schema::hasTable('wishlist');

    expect($exists)->toBeTrue();
});
