<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeaponType extends Model
{
    use HasFactory;

    protected $table = 'weapon_types';
    protected $fillable = ['name'];

    public function weapons()
    {
        return $this->hasMany(Weapon::class, 'weapon_type_id', 'id');
    }
}
