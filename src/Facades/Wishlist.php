<?php 

namespace Bhavinjr\Wishlist\Facades;

use Illuminate\Support\Facades\Facade;

class Wishlist extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
	protected static function getFacadeAccessor()
	{
		return 'wishlist';
	}
	
}