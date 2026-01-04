<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_type',
        'item_id',
        'item_name',
        'price',
        'quantity',
        'category',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getSubtotal()
    {
        return $this->price * $this->quantity;
    }
}
