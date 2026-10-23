<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    protected $fillable = [
        'name',
        'category',
        'sku',
        'quantity',
        'unit',
        'reorder_level',
        'expiry_date',
        'supplier',
        'unit_cost',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'reorder_level' => 'decimal:2',
            'expiry_date' => 'date',
            'unit_cost' => 'decimal:2',
        ];
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }
}
