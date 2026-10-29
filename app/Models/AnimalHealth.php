<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalHealth extends Model
{
    protected $table = 'animal_health';

    protected $fillable = [
        'animal_id',
        'checkup_date',
        'health_status',
        'disease',
        'symptoms',
        'treatment',
        'medicine',
        'next_checkup_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'checkup_date' => 'date',
            'next_checkup_date' => 'date',
        ];
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
