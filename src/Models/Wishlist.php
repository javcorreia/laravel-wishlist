<?php
// @codeCoverageIgnoreStart
namespace javcorreia\Wishlist\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'session_id', 'item_id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('wishlist.table_name');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(config('wishlist.item_model'),'item_id');
    }

    public function scopeOfUser(Builder $query, int|string $user, string $type): Builder
    {
        $column = ($type === 'user') ? 'user_id' : 'session_id';

        return $query->where($column, '=', $user);
    }

    public function scopeByItem(Builder $query, int $item): Builder
    {
        return $query->where('item_id', '=', $item);
    }
}
// @codeCoverageIgnoreEnd