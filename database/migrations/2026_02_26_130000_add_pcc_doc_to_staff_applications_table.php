<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_applications', function (Blueprint $table) {
            $table->string('pcc_doc')->nullable()->after('bank_passbook_doc');
        });
    }

    public function down(): void
    {
        Schema::table('staff_applications', function (Blueprint $table) {
            $table->dropColumn('pcc_doc');
        });
    }
};
