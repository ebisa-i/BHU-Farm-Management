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
    Schema::create('milk_productions', function (Blueprint $table) {
        $table->id();

        $table->foreignId('animal_id')
            ->constrained('animals')
            ->cascadeOnDelete();

        $table->date('production_date');

        $table->enum('session', [
            'Morning',
            'Afternoon',
            'Evening',
        ]);

        $table->decimal('quantity_liters', 8, 2);

        $table->text('notes')->nullable();

        $table->timestamps();

        $table->unique([
            'animal_id',
            'production_date',
            'session',
        ]);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_productions');
    }
};
