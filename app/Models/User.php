<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/*
 * DEVBOOK — Pattern Model
 *
 * Un Model Eloquent a 3 responsabilités :
 * 1. Déclarer les champs mass-assignables ($fillable)
 * 2. Déclarer les casts (conversions automatiques de types)
 * 3. Déclarer les relations avec les autres models
 *
 * Il NE contient PAS de logique métier → ça va dans les Actions.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // $fillable = colonnes qu'on peut remplir en masse (ex: User::create([...]))
    // Sécurité : tout ce qui n'est pas ici ne peut pas être injecté par l'user
    protected $fillable = [
        'name',
        'email',
        'password',
        'travel_type',
        'preferences',
        'notifications_enabled',
        'onboarding_completed',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts : Laravel convertit automatiquement ces champs à la lecture
    protected function casts(): array
    {
        return [
            'email_verified_at'     => 'datetime',
            'password'              => 'hashed',
            'preferences'           => 'array',   // JSON → tableau PHP automatiquement
            'notifications_enabled' => 'boolean',
            'onboarding_completed'  => 'boolean',
        ];
    }

    // ── Relations ──

    // Un user a plusieurs voyages
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    // Voyage le plus récent (utile pour le dashboard)
    public function latestTrip()
    {
        return $this->hasOne(Trip::class)->latestOfMany();
    }
}
