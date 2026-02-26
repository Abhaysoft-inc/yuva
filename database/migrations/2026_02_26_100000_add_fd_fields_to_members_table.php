<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->decimal('fd_amount', 12, 2)->nullable()->after('ifsc_code');
            $table->decimal('fd_interest_rate', 5, 2)->default(12.00)->after('fd_amount');
            $table->date('fd_start_date')->nullable()->after('fd_interest_rate');
            $table->date('fd_maturity_date')->nullable()->after('fd_start_date');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['fd_amount', 'fd_interest_rate', 'fd_start_date', 'fd_maturity_date']);
        });
    }
};
