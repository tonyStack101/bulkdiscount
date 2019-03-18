<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_variant';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'sku',
        'product_id',
        'product_image',
        'price_rule_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @var array
     */
    protected $hidden = [

    ];
    public function getIdAttribute($value)
    {
        return (float)($value);
    }
}
