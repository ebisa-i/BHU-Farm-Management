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
        Schema::table('staff_activities', function (Blueprint $table) {
            $table->string('staff_name');
            $table->string('role');
            $table->string('assignment');
            $table->string('shift');
            $table->string('activity');
            $table->string('status')->default('Scheduled');
            $table->date('activity_date');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_activities', function (Blueprint $table) {
            $table->dropColumn([
                'staff_name',
                'role',
                'assignment',
                'shift',
                'activity',
                'status',
                'activity_date',
                'notes',
            ]);
        });
    }
};
