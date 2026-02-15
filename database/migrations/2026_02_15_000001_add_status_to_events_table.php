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
        // Check if status column doesn't exist before adding
        if (!Schema::hasColumn('events', 'status')) {
            Schema::table('events', function (Blueprint $table) {
                $table->enum('status', ['upcoming', 'completed', 'cancelled'])
                    ->default('upcoming');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('events', 'status')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
