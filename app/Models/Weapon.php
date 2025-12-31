<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Weapon extends Model
{
    use HasFactory;

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
        'image',
    ];

    public function weaponType()
    {
        return $this->belongsTo(WeaponType::class, 'weapon_type_id', 'id');
    }

    public function reservationItems()
    {
        return $this->morphMany(ReservationItem::class, 'reservationable');
    }

    public function scopeAvailable($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function isAvailable()
    {
        return $this->quantity > 0;
    }

    public function hasStock($quantity = 1)
    {
        return $this->quantity >= $quantity;
    }
}
