<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCodeModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'discount_code';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'usage_count',
        'price_rule_id'
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
