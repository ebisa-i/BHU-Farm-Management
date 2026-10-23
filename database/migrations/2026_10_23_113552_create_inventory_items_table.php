<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->string('sku')->unique();
            $table->decimal('quantity', 12, 2)->default(0);
            $table->string('unit', 50);
            $table->decimal('reorder_level', 12, 2)->default(0);
            $table->date('expiry_date')->nullable();
            $table->string('supplier')->nullable();
            $table->decimal('unit_cost', 12, 2)->default(0);
            $table->timestamps();

            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
