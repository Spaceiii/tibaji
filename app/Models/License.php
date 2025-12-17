<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class License extends Model
{
    use HasFactory;

    protected $table = 'licenses';
    protected $fillable = [
        'license_number',
        'issued_by',
        'issue_date',
        'expiry_date',
        'holder_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
