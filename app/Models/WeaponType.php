<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeaponType extends Model
{
    protected $table = 'weapon_types';
    protected $fillable = ['name'];

    public function weapons()
    {
        return $this->hasMany(Weapon::class, 'weapon_type_id', 'id');
    }
}
