<?php

namespace App\Contracts\Repository;

/**
 * Interface ShopsRepositoryInterface
 * @package Contract\Repository
 */
interface ShopRepositoryInterface
{
    /**
     * @param string $shopId
     * @param array $data
     *
     * @return mixed
     */
    public function createOrUpdate(string $shopId, array $data = []);

    /**
     * @return bool
     */
    public function delete() : bool ;

    /**
     * @return mixed
     */
    public function  all();

    /**
     * @param string $shopId
     * @return mixed
     */
    public function detail(string $shopId);
	
	/**
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function getAttributes( array $data = []);

    public function checkShopDomain($shopDomain);
}
