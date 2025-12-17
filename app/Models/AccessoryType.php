<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessoryType extends Model
{
    use HasFactory;

    protected $table = 'accessory_types';
    protected $fillable = ['name'];

    public function accessories()
    {
        return $this->hasMany(Accessory::class, 'accessory_type_id', 'id');
    }
}
