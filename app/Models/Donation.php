<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
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
        'receipt_sent',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'receipt_sent' => 'boolean',
    ];

    /**
     * Generate a unique receipt number
     */
    public static function generateReceiptNumber()
    {
        $year = date('Y');
        $prefix = "YMF/DON/{$year}/";

        $lastDonation = self::where('receipt_number', 'LIKE', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastDonation && $lastDonation->receipt_number) {
            $lastNumber = (int) substr($lastDonation->receipt_number, -5);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Scope for completed donations
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending donations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
