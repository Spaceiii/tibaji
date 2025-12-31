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
        'file_path',
        'status',
        'submitted_at',
        'verified_at',
        'admin_comment',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Scopes
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeValid($query)
    {
        return $query->where('status', 'approved')
                     ->where('expiration_date', '>', now());
    }

    /**
     * Helpers
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isExpired()
    {
        return $this->expiration_date < now();
    }

    public function isValid()
    {
        return $this->isApproved() && !$this->isExpired();
    }

    public function canPurchaseCategory($category)
    {
        return $this->isValid() && $this->level === $category;
    }
}
