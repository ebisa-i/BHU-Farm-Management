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
    Schema::create('animal_health', function (Blueprint $table) {
        $table->id();

        $table->foreignId('animal_id')
            ->constrained('animals')
            ->cascadeOnDelete();

        $table->date('checkup_date');
        $table->string('health_status')->default('Healthy');
        $table->string('disease')->nullable();
        $table->text('symptoms')->nullable();
        $table->text('treatment')->nullable();
        $table->string('medicine')->nullable();
        $table->date('next_checkup_date')->nullable();
        $table->text('notes')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_healths');
    }
};
