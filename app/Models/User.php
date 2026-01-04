<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne; // Assurez-vous que cet import est là

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * CORRECTION ICI : Relation HasOne (Singulier)
     * Car un utilisateur n'a qu'un seul dossier de licence actif dans notre système.
     */
    public function license(): HasOne
    {
        return $this->hasOne(License::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }

    /**
     * CORRECTION ICI : Adaptation pour utiliser la relation singulière
     */
    public function hasValidLicenseFor($category)
    {
        // On récupère la licence unique
        $license = $this->license;

        // Si pas de licence, ou pas approuvée, ou expirée, c'est faux
        if (!$license || $license->status !== 'approved' || $license->expiration_date <= now()) {
            return false;
        }

        // Vérification de la catégorie (Logique simplifiée)
        // Si j'ai une licence B, je peux acheter B et C.
        // Si j'ai une licence C, je ne peux acheter que C.
        if ($license->level === 'B') {
            return true; // B couvre tout
        }

        if ($license->level === 'C' && $category === 'C') {
            return true;
        }

        return false;
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
