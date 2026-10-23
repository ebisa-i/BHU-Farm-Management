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
    Schema::create('animals', function (Blueprint $table) {
        $table->id();
        $table->string('animal_id')->unique();
        $table->enum('animal_type', ['Dairy', 'Beef', 'Calf']);
        $table->string('breed')->nullable();
        $table->enum('sex', ['Male', 'Female']);
        $table->date('date_of_birth')->nullable();
        $table->decimal('weight', 8, 2)->nullable();
        $table->string('status')->default('Active');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
