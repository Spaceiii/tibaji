<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessoryType extends Model
{
    protected $table = 'accessory_types';
    protected $fillable = ['name'];

    public function accessories()
    {
        return $this->hasMany(Accessory::class, 'accessory_type_id', 'id');
    }
}
