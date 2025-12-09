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
        Schema::table('schedules', function (Blueprint $table) {
            // Remove the 'arrival_time' column completely
            $table->dropColumn('arrival_time');
        });
    }

    public function down(): void
    {
        // Re-add the column if you ever roll back this migration (optional, but good practice)
        Schema::table('schedules', function (Blueprint $table) {
            $table->timestamp('arrival_time')->nullable();
        });
    }
};
