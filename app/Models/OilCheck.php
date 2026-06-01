<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OilCheck extends Model
{
    protected $fillable = [
        'current_odometer',
        'last_change_date',
        'last_change_odometer',
        'needs_change',
    ];

    protected function casts(): array
    {
        return [
            'last_change_date' => 'date',
            'needs_change' => 'boolean',
        ];
    }
}
