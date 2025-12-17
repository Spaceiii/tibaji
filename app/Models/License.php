<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class License extends Model
{
    use HasFactory;

    protected $table = 'licenses';
    protected $fillable = [
        'user_id',
        'license_number',
        'expiration_date',
        'level',
    ];

    protected $casts = [
        'expiration_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
