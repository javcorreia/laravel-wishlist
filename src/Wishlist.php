<?php

namespace javcorreia\Wishlist;

use Illuminate\Support\Facades\DB;

class Wishlist
{
    public $modelInstance;
	public $instance;

	public function __construct()
    {
        $this->wishlistModel = config('wishlist.model');
    	$this->instance = new $this->wishlistModel;
    }

    /**
     * Adds a product to the wishlist associating it to a given user.
     * Returns false on failure.
     *
     * @param $item
     * @param $user
     * @param string $type
     * @return bool
     */
    public function add($item, $user, $type='user') {
        return Wishlist::create($item, $user, $type);
    }

    /**
     * Returns the wishlist of a specified user.
     *
     * @param $user
     * @param string $type
     * @return mixed
     */
    public function getUserWishList($user, $type='user')
    {
        return $this->instance->ofUser($user, $type)->get();
    }

    /**
     * Removes a specific wishlist entry from a given user.
     *
     * @param $id
     * @param $user
     * @param string $type
     * @return mixed
     */
    public function remove($id, $user, $type='user')
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
     * @param $user
     * @param $type
     * @return mixed
     */
    public function removeUserWishList($user, $type='user')
    {
        return $this->instance->ofUser($user, $type)->delete();
    }

    /**
     * Removes a specific item from a specified user.
     *
     * @param $item
     * @param $user
     * @param string $type
     * @return mixed
     */
    public function removeByItem($item, $user, $type='user')
    {
        return $this->getWishListItem($item, $user, $type)->delete();
    }

    /**
     * Number of wishlist items by user
     *
     * @param $user
     * @param string $type
     * @return mixed
     */
    public function count($user, $type='user')
    {
        return $this->instance->ofUser($user, $type)->count();
    }

    /**
     * Get wishlist item from a user
     *
     * @param $item
     * @param $user
     * @param string $type
     * @return mixed
     */
    public function getWishListItem($item, $user, $type='user')
    {
        return $this->instance->byItem($item)
            ->ofUser($user, $type)->first();
    }

    /**
     * Associates a session_id wishlist to a given user_id wishlist.
     *
     * @param $user_id
     * @param $session_id
     * @return bool
     */
    public function assocSessionWishListToUser($user_id, $session_id)
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

    protected static function create($item, $user, $type='user')
    {
        $column = ($type === 'user') ? 'user_id' : 'session_id';

        $matchThese = [
            'item_id' => $item,
            $column => $user
        ];

        $wishList =	config('wishlist.model')::updateOrCreate($matchThese, $matchThese);

        return (!$wishList) ? false : true;
    }
}