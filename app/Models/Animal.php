<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
    protected $fillable = [
        'animal_id',
        'animal_type',
        'breed',
        'sex',
        'date_of_birth',
        'weight',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'weight' => 'decimal:2',
        ];
    }

    public function healthRecords(): HasMany
    {
        return $this->hasMany(AnimalHealth::class);
    }
}
