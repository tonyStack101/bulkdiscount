<?php

namespace App\ShopifyApi;

use App\Contracts\ShopifyAPI\ShopsApiInterface;
use App\Services\SpfService;
use Exception;

class ShopsApi extends SpfService implements ShopsApiInterface
{
    /**
     * @return bool
     */
	public function get()
	{
	    return $this->getRequest( 'shop.json' );
	}
}