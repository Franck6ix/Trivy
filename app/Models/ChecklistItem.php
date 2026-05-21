<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    protected $fillable = ['trip_id', 'category', 'label', 'is_checked', 'sort_order'];

    protected function casts(): array
    {
        return ['is_checked' => 'boolean'];
    }
}
