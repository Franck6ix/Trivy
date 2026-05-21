<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ChecklistItem;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    protected $fillable = [
        'user_id',
        'destination',
        'start_date',
        'end_date',
        'transport_type',
        'accommodation',
        'trip_types',
        'activities',
        'amenities',
    ];

    protected function casts(): array
    {
        return [
            'start_date'  => 'date',
            'end_date'    => 'date',
            'trip_types'  => 'array',
            'activities'  => 'array',
            'amenities'   => 'array',
        ];
    }

    // ── Relations ──

    // Un voyage appartient à un user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Un voyage a plusieurs voyageurs
    public function travellers(): HasMany
    {
        return $this->hasMany(Traveller::class);
    }

    // Un voyage a plusieurs items de checklist
    public function checklistItems(): HasMany
    {
        return $this->hasMany(ChecklistItem::class);
    }

    // ── Accesseurs utiles ──

    // Nombre de jours du voyage
    public function getDurationAttribute(): int
    {
        if (! $this->start_date || ! $this->end_date) {
            return 0;
        }
        return $this->start_date->diffInDays($this->end_date);
    }
}
