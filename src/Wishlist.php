<?php

namespace javcorreia\Wishlist;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wishlist
{
	public Model $instance;
    private string $wishlistModel;

    public function __construct()
    {
        $this->wishlistModel = config('wishlist.model');
    	$this->instance = new $this->wishlistModel;
    }

    /**
     * Adds a product to the wishlist associating it to a given user.
     * Returns false on failure.
     *
     * @param int $item
     * @param int|string $user
     * @param string $type
     * @return bool
     */
    public function add(int $item, int|string $user, string $type='user'): bool
    {
        return Wishlist::create($item, $user, $type);
    }

    /**
     * Returns the wishlist of a specified user.
     *
     * @param int|string $user
     * @param string $type
     * @return Collection
     */
    public function getUserWishList(int|string $user, string $type='user'): Collection
    {
        return $this->instance->ofUser($user, $type)->get();
    }

    /**
     * Removes a specific wishlist entry from a given user.
     *
     * @param int $id
     * @param int|string $user
     * @param string $type
     * @return bool|null
     */
    public function remove(int $id, int|string $user, string $type='user'): bool|null
    {
        $wishList = $this->instance->where('id', $id)
            ->ofUser($user, $type)->first();

        if (!$wishList) {
            return false;
        }

        return $wishList->delete();
    }

    /**
     * Removes all values from a user wishlist.
     *
     * @param int|string $user
     * @param string $type
     * @return mixed
     */
    public function removeUserWishList(int|string $user, string $type='user'): mixed
    {
        return $this->instance->ofUser($user, $type)->delete();
    }

    /**
     * Removes a specific item from a specified user.
     *
     * @param int $item
     * @param int|string $user
     * @param string $type
     * @return bool|null
     */
    public function removeByItem(int $item, int|string $user, string $type='user'): bool|null
    {
        return $this->getWishListItem($item, $user, $type)->delete();
    }

    /**
     * Number of wishlist items by user
     *
     * @param int|string $user
     * @param string $type
     * @return int
     */
    public function count(int|string $user, string $type='user'): int
    {
        return $this->instance->ofUser($user, $type)->count();
    }

    /**
     * Get wishlist item from a user
     *
     * @param int $item
     * @param int|string $user
     * @param string $type
     * @return Model
     */
    public function getWishListItem(int $item, int|string $user, string $type='user'): Model
    {
        return $this->instance->byItem($item)
            ->ofUser($user, $type)->first();
    }

    /**
     * Associates a session_id wishlist to a given user_id wishlist.
     *
     * @param int $user_id
     * @param string $session_id
     * @return bool
     */
    public function assocSessionWishListToUser(int $user_id, string $session_id): bool
    {
        $sessionWishList = $this->getUserWishList($session_id, 'session');
        if ($sessionWishList->isEmpty()) {
            return true;
        }

        try {
            DB::transaction(function () use ($sessionWishList, $user_id, $session_id) {
                foreach ($sessionWishList as $sessionItem) {
                    $association = Wishlist::create($sessionItem->item_id, $user_id);
                    if (!$association) {
                        throw new \Exception('Error');
                    }
                }

                $this->removeUserWishList($session_id, 'session');
            });
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    protected static function create(int $item, int|string $user, string $type='user'): bool
    {
        $column = ($type === 'user') ? 'user_id' : 'session_id';

        $matchThese = [
            'item_id' => $item,
            $column => $user
        ];

        $wishList =	config('wishlist.model')::updateOrCreate($matchThese, $matchThese);

        return !!$wishList;
    }
}