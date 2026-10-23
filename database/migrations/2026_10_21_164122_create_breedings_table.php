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
    Schema::create('breedings', function (Blueprint $table) {
        $table->id();

        $table->foreignId('female_animal_id')
            ->constrained('animals')
            ->cascadeOnDelete();

        $table->foreignId('male_animal_id')
            ->nullable()
            ->constrained('animals')
            ->nullOnDelete();

        $table->date('mating_date');
        $table->date('expected_calving_date')->nullable();
        $table->date('actual_calving_date')->nullable();

        $table->string('breeding_method')->default('Natural');
        $table->string('status')->default('Pending');
        $table->text('notes')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breedings');
    }
};
