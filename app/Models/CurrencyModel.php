<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'currency';

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
        'name',
        'country_id'
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
