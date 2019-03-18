<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceRuleModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'price_rule';

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
        'value_type',
        'value',
        'currency_id',
        'customer_selection',
        'target_type',
        'target_selection',
        'allocation_method',
        'allocation_limit',
        'once_per_customer',
        'starts_at',
        'ends_at'
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
