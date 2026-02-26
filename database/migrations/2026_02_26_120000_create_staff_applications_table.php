<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_applications', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id_code')->unique()->nullable();
            $table->string('name');
            $table->string('husband_father_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('mobile', 15);
            $table->string('email')->nullable();
            $table->string('aadhar_number', 12)->nullable()->unique();
            $table->string('pan_number', 10)->nullable()->unique();
            $table->text('address');
            $table->string('designation')->nullable();

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

            // Verification
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_applications');
    }
};
