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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shg_id')->constrained('shgs')->onDelete('cascade');
            $table->string('member_id_code')->unique()->nullable();
            $table->string('name');
            $table->string('husband_father_name')->nullable();
            $table->enum('role', ['member', 'president', 'secretary', 'treasurer'])->default('member');
            $table->date('date_of_birth')->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('aadhar_number', 12)->nullable()->unique();
            $table->string('pan_number', 10)->nullable()->unique();
            $table->text('address')->nullable();

            // Bank Details
            $table->string('bank_name')->nullable();
            $table->string('branch')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();

            // Documents
            $table->string('passport_photo')->nullable();
            $table->string('aadhar_card_doc')->nullable();
            $table->string('pan_card_doc')->nullable();
            $table->string('bank_passbook_doc')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
