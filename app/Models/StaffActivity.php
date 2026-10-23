<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffActivity extends Model
{
    protected $fillable = [
        'staff_name',
        'role',
        'assignment',
        'shift',
        'activity',
        'status',
        'activity_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
        ];
    }
}
