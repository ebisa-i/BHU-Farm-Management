<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MilkProduction extends Model
{
    protected $fillable = [
        'animal_id',
        'production_date',
        'session',
        'quantity_liters',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'production_date' => 'date',
            'quantity_liters' => 'decimal:2',
        ];
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
