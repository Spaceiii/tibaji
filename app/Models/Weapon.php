<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    protected $table = 'weapons';
    protected $fillable = [
        'model',
        'brand',
        'weapon_type_id',
        'caliber',
        'category',
        'serial_number',
        'price',
        'quantity',
    ];

    public function weaponType()
    {
        return $this->belongsTo(WeaponType::class, 'weapon_type_id', 'id');
    }
}
