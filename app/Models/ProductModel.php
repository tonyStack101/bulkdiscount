<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'product';

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
        'handle',
        'image',
        'custom_collection',
        'tag',
        'status',
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
