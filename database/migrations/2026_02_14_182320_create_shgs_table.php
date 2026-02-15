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
        Schema::create('shgs', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('shg_name');
            $table->string('shg_code')->unique()->nullable();
            $table->string('shg_contact', 15)->nullable();
            $table->date('date_of_formation')->nullable();
            $table->string('village')->nullable();
            $table->string('pincode', 10)->nullable();
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();

            // Officers Details
            $table->string('president_name')->nullable();
            $table->string('president_contact', 15)->nullable();
            $table->string('secretary_name')->nullable();
            $table->string('secretary_contact', 15)->nullable();
            $table->string('treasurer_name')->nullable();
            $table->string('treasurer_contact', 15)->nullable();

            // Group Documents
            $table->string('meeting_proposal_document')->nullable();
            $table->string('group_photo')->nullable();

            // Bank Details
            $table->string('bank_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('branch_name')->nullable();

            // FD & Security
            $table->decimal('fd_security_money', 12, 2)->nullable();

            // Savings & Meetings
            $table->enum('meeting_frequency', ['weekly', 'biweekly', 'monthly'])->default('weekly');
            $table->decimal('monthly_saving_amount', 10, 2)->default(100);

            // Declaration
            $table->boolean('declaration_accepted')->default(false);
            $table->string('signature')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shgs');
    }
};
