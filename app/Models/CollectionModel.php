<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'collection';

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
        'price_rule_id'
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
