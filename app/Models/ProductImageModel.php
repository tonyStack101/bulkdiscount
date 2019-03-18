<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImageModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_image';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'width',
        'height',
        'src',
        'status',
        'product_id'
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
