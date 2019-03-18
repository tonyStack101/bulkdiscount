<?php
declare(strict_types=1);
namespace App\Repository;

use App\Contracts\Repository\ShopRepositoryInterface;
use App\Models\ShopModel;
use App\Models\ProductModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class ShopsRepository
 * @package App\Repository
 */
class ShopRepository implements ShopRepositoryInterface
{
    /**
     *
     */
    public function all()
    {

    }
    
    /**
     * @return bool
     */
    public function delete(): bool
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param string $shopId
     * @return mixed
     */
    public function detail(string $shopId)
    {
        if($shopInfo = ShopModel::find($shopId))
            return $shopInfo;

        return false;
    }

    public function checkShopDomain($shopDomain)
    {
        return ShopModel::where('myshopify_domain', '=', $shopDomain)
            ->orWhere('domain', '=', $shopDomain)->first();
    }

    public function checkShopStatus($shopDomain)
    {
        return ShopModel::where('myshopify_domain', '=', $shopDomain)
            ->select('status')->first();
    }
    /**
     * @param array $data
     *
     * @return bool
     */
	public function getAttributes( array $data = [])
	{
		$shopInfo = ShopModel::where( $data )->first();
		if($shopInfo)
			return $shopInfo;
		return false;
	}

    /**
     * @param string $shopId
     * @param array $data
     *
     * @return mixed
     */
    public function createOrUpdate(string $shopId, array $data = [])
    {
        $shopModel = new ShopModel();

        $filterData = array_only($data, $shopModel->getFillable());
        if($shop = $shopModel->find($shopId))
            return $shop->update($filterData);

        $filterData['id'] = $shopId;

        return $shopModel->firstOrCreate($filterData);
    }

    /**
     * @param string $public_token
     * 
     * @return mixed
     */
    public function getShopId($public_token)
    {
        $shopId = ShopModel::where('public_token',$public_token)->select('id')->first();
        if($shopId)
            return $shopId;

        return false;
        
    }

    public function updateSingleTotalQuantityProduct($productId) {
        $product = ProductModel::find($productId);
        if(! $product) 
            return false;
        $product->total_quantity = $product->productVariant()->sum('source_quantity');
        return $product->save();
    }

    public function updateAllTotalQuantityProduct() {
        $queryUpdate = DB::table('product')
            ->join(DB::raw("(SELECT product_id, 
                                SUM(source_quantity) AS total_quantity
                            FROM product_variant
                            WHERE deleted_at IS NULL
                            GROUP BY product_id) product_variant_total"),
                            "product.id",
                            "product_variant_total.product_id");
        return $queryUpdate->update(['product.total_quantity' => DB::raw("product_variant_total.total_quantity")]);
    }

}