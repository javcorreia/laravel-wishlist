<?php

test('confirm environment is set to testing', function () {
    expect(config('app.env'))->toBe('testing');
});

test('confirm wishlist item_model is set', function () {
    expect(config('wishlist.item_model'))->toBe(\Workbench\App\Models\Product::class);
});

test('confirm wishlist table_name is set', function () {
    expect(config('wishlist.table_name'))->toBe('wishlist');
});
