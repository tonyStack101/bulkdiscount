<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShopModel
 *
 * @package App\Models
 */
class ShopModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'shop';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'country',
        'province',
        'address1',
        'zip',
        'city',
        'phone',
        'currency',
        'iana_timezone',
        'shop_owner',
        'plan_name',
        'myshopify_domain',
        'status',
        'is_version_app',
        'access_token'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        // 'access_token'
    ];
    public function getIdAttribute($value)
    {
        return (float)($value);
    }


}
