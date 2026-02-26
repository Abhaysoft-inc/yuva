<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffApplication extends Model
{
    protected $fillable = [
        'staff_id_code',
        'name',
        'husband_father_name',
        'date_of_birth',
        'blood_group',
        'mobile',
        'email',
        'aadhar_number',
        'pan_number',
        'address',
        'designation',

        // Bank Details
        'bank_name',
        'branch',
        'account_number',
        'ifsc_code',

        // Documents
        'passport_photo',
        'aadhar_card_doc',
        'pan_card_doc',
        'bank_passbook_doc',

        'verification_status',
        'valid_from',
        'valid_to',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'valid_from' => 'date',
        'valid_to' => 'date',
    ];

    /**
     * Boot the model and auto-generate staff_id_code on creation.
     */
    protected static function booted(): void
    {
        static::creating(function (StaffApplication $staff) {
            if (empty($staff->staff_id_code)) {
                $staff->staff_id_code = static::generateStaffIdCode();
            }
            if (empty($staff->valid_from)) {
                $staff->valid_from = now()->toDateString();
            }
            if (empty($staff->valid_to)) {
                $staff->valid_to = now()->addYear()->toDateString();
            }
        });
    }

    /**
     * Generate the next staff ID code: YMF/STAFF/{YEAR}/0001, 0002, ...
     */
    public static function generateStaffIdCode(): string
    {
        $year = now()->year;
        $prefix = "YMF/STAFF/{$year}/";

        $lastCode = static::where('staff_id_code', 'like', $prefix . '%')
            ->orderByRaw('CAST(SUBSTRING(staff_id_code, ' . (strlen($prefix) + 1) . ') AS UNSIGNED) DESC')
            ->value('staff_id_code');

        if ($lastCode) {
            $lastNumber = (int) substr($lastCode, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the age attribute from date_of_birth.
     */
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }
}
