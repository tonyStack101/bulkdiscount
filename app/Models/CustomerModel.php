<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'customer';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'first_name',
        'last_name',
        'phone',
        'currency',
        'country',
        'group_id',
        'price_rule_id'
    ];
    public function getIdAttribute($value)
    {
        return (float)($value);
    }
}
