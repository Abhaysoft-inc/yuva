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
        Schema::table('donations', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('donations', 'donor_name')) {
                $table->string('donor_name')->after('id');
            }
            if (!Schema::hasColumn('donations', 'email')) {
                $table->string('email')->nullable()->after('donor_name');
            }
            if (!Schema::hasColumn('donations', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('donations', 'amount')) {
                $table->decimal('amount', 10, 2)->default(0)->after('phone');
            }
            if (!Schema::hasColumn('donations', 'pan_number')) {
                $table->string('pan_number')->nullable()->after('amount');
            }
            if (!Schema::hasColumn('donations', 'address')) {
                $table->text('address')->nullable()->after('pan_number');
            }
            if (!Schema::hasColumn('donations', 'city')) {
                $table->string('city')->nullable()->after('address');
            }
            if (!Schema::hasColumn('donations', 'state')) {
                $table->string('state')->nullable()->after('city');
            }
            if (!Schema::hasColumn('donations', 'pincode')) {
                $table->string('pincode')->nullable()->after('state');
            }
            if (!Schema::hasColumn('donations', 'message')) {
                $table->text('message')->nullable()->after('pincode');
            }

            // Payment gateway fields
            if (!Schema::hasColumn('donations', 'payment_id')) {
                $table->string('payment_id')->nullable()->unique()->after('message');
            }
            if (!Schema::hasColumn('donations', 'razorpay_order_id')) {
                $table->string('razorpay_order_id')->nullable()->after('payment_id');
            }
            if (!Schema::hasColumn('donations', 'razorpay_payment_id')) {
                $table->string('razorpay_payment_id')->nullable()->after('razorpay_order_id');
            }
            if (!Schema::hasColumn('donations', 'razorpay_signature')) {
                $table->string('razorpay_signature')->nullable()->after('razorpay_payment_id');
            }

            // Status and tracking
            if (!Schema::hasColumn('donations', 'status')) {
                $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending')->after('razorpay_signature');
            }
            if (!Schema::hasColumn('donations', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('status');
            }
            if (!Schema::hasColumn('donations', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('payment_method');
            }

            // Receipt fields
            if (!Schema::hasColumn('donations', 'receipt_number')) {
                $table->string('receipt_number')->nullable()->unique()->after('paid_at');
            }
            if (!Schema::hasColumn('donations', 'receipt_sent')) {
                $table->boolean('receipt_sent')->default(false)->after('receipt_number');
            }

            // Rename columns if they exist with different names
            if (Schema::hasColumn('donations', 'donor_email') && !Schema::hasColumn('donations', 'email')) {
                $table->renameColumn('donor_email', 'email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $columns = [
                'donor_name',
                'email',
                'phone',
                'amount',
                'pan_number',
                'address',
                'city',
                'state',
                'pincode',
                'message',
                'payment_id',
                'razorpay_order_id',
                'razorpay_payment_id',
                'razorpay_signature',
                'status',
                'payment_method',
                'paid_at',
                'receipt_number',
                'receipt_sent'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('donations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
