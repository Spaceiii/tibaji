<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accessory extends Model
{
    use HasFactory;

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
