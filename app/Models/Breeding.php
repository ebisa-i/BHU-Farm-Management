<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Breeding extends Model
{
    protected $fillable = [
        'female_animal_id',
        'male_animal_id',
        'mating_date',
        'expected_calving_date',
        'actual_calving_date',
        'breeding_method',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'mating_date' => 'date',
            'expected_calving_date' => 'date',
            'actual_calving_date' => 'date',
        ];
    }

    public function femaleAnimal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'female_animal_id');
    }

    public function maleAnimal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'male_animal_id');
    }
}
