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
    Schema::create('sales', function (Blueprint $table) {
        $table->id();

        $table->string('sale_number')->unique();

        $table->enum('sale_type', [
            'Animal',
            'Milk',
        ]);

        $table->foreignId('animal_id')
            ->nullable()
            ->constrained('animals')
            ->nullOnDelete();

        $table->string('buyer_name');
        $table->string('buyer_phone')->nullable();

        $table->string('item_description');

        $table->decimal('quantity', 10, 2);
        $table->decimal('unit_price', 12, 2);
        $table->decimal('total_amount', 12, 2);

        $table->date('sale_date');

        $table->text('notes')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
