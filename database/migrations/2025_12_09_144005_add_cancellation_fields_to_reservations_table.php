<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // New column to track the request status: pending -> approved -> rejected
            $table->enum('cancellation_status', ['none', 'pending', 'approved', 'rejected'])
                  ->default('none')
                  ->after('status'); 
            
            // New column to store the user's reason for cancellation
            $table->text('cancellation_reason')->nullable()->after('cancellation_status');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('cancellation_status');
            $table->dropColumn('cancellation_reason');
        });
    }
};
