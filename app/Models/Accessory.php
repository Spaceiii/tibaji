<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $table = 'accessories';
    protected $fillable = [
        'name',
        'accessory_type_id',
        'brand',
        'model',
        'price',
        'quantity',
    ];

    public function accessoryType()
    {
        return $this->belongsTo(AccessoryType::class, 'accessory_type_id', 'id');
    }
}
