<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'reservationable_id',
        'reservationable_type',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relations
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Polymorphic relation - can be Weapon or Accessory
     */
    public function reservationable()
    {
        return $this->morphTo();
    }

    /**
     * Helpers
     */
    public function isWeapon()
    {
        return $this->reservationable_type === Weapon::class;
    }

    public function isAccessory()
    {
        return $this->reservationable_type === Accessory::class;
    }

    /**
     * Boot method to calculate subtotal automatically
     */
    protected static function booted()
    {
        static::saving(function ($item) {
            $item->subtotal = $item->quantity * $item->unit_price;
        });
    }
}
