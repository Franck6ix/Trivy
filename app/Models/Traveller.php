<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Traveller extends Model
{
    protected $fillable = [
        'trip_id',
        'name',
        'age_group',
        'is_baby',
        'is_child',
        'specific_needs',
    ];

    protected function casts(): array
    {
        return [
            'is_baby'  => 'boolean',
            'is_child' => 'boolean',
        ];
    }

    // Un voyageur appartient à un voyage
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
