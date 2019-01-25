<?php

namespace javcorreia\Wishlist\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'session_id', 'item_id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('wishlist.table_name');
    }

    public function item()
    {
        return $this->belongsTo(config('wishlist.item_model'),'item_id');
    }

    public function scopeOfUser($query, $user, $type)
    {
        $column = ($type === 'user') ? 'user_id' : 'session_id';

        return $query->where($column, $user);
    }

    public function scopeByItem($query, $item)
    {
        return $query->where('item_id', $item);
    }
}
