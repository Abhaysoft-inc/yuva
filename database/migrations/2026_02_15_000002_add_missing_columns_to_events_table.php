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
        Schema::table('events', function (Blueprint $table) {
            // Add missing columns only if they don't exist
            if (!Schema::hasColumn('events', 'event_date')) {
                $table->date('event_date')->nullable();
            }

            if (!Schema::hasColumn('events', 'event_time')) {
                $table->time('event_time')->nullable();
            }

            if (!Schema::hasColumn('events', 'location')) {
                $table->string('location')->nullable();
            }

            if (!Schema::hasColumn('events', 'event_image')) {
                $table->string('event_image')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $columns = ['event_date', 'event_time', 'location', 'event_image'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('events', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
