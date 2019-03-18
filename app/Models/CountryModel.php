<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'country';

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
        'name'
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
