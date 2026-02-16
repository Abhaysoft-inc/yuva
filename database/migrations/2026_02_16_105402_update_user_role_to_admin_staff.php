<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing 'member' roles to 'staff'
        DB::table('users')->where('role', 'member')->update(['role' => 'staff']);

        // Alter the enum to include 'staff' instead of 'member'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'staff') DEFAULT 'staff'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update existing 'staff' roles back to 'member'
        DB::table('users')->where('role', 'staff')->update(['role' => 'member']);

        // Alter the enum back to include 'member' instead of 'staff'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'member') DEFAULT 'member'");
    }
};
