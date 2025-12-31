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
        'price',
        'quantity',
        'description',
        'image',
    ];

    public function accessoryType()
    {
        return $this->belongsTo(AccessoryType::class, 'accessory_type_id', 'id');
    }

    public function reservationItems()
    {
        return $this->morphMany(ReservationItem::class, 'reservationable');
    }

    public function scopeAvailable($query)
    {
        return $query->where('quantity', '>', 0);
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
