<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'shg_id',
        'member_id_code',
        'name',
        'husband_father_name',
        'role',
        'date_of_birth',
        'blood_group',
        'mobile',
        'aadhar_number',
        'pan_number',
        'address',

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

        'status',
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
     * Boot the model and auto-generate member_id_code on creation.
     */
    protected static function booted(): void
    {
        static::creating(function (Member $member) {
            if (empty($member->member_id_code)) {
                $member->member_id_code = static::generateMemberIdCode();
            }
            if (empty($member->valid_from)) {
                $member->valid_from = now()->toDateString();
            }
            if (empty($member->valid_to)) {
                $member->valid_to = now()->addYear()->toDateString();
            }
        });
    }

    /**
     * Generate the next member ID code: YMF/SHG/{YEAR}/0001, 0002, ...
     */
    public static function generateMemberIdCode(): string
    {
        $year = now()->year;
        $prefix = "YMF/SHG/{$year}/";

        // Find the latest code for the current year and increment its trailing number.
        $lastCode = static::where('member_id_code', 'LIKE', $prefix . '%')
            ->orderByDesc('id')
            ->value('member_id_code');

        $lastNumber = 0;
        if ($lastCode && preg_match('/(\d+)$/', $lastCode, $matches) === 1) {
            $lastNumber = (int) $matches[1];
        }

        $nextNumber = $lastNumber + 1;

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the age attribute (calculated from date_of_birth).
     */
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    /**
     * Get the ID number (last 4 digits from member_id_code).
     */
    public function getIdNumberAttribute(): string
    {
        if ($this->member_id_code) {
            return substr($this->member_id_code, strrpos($this->member_id_code, '/') + 1);
        }
        return str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the SHG that this member belongs to.
     */
    public function shg()
    {
        return $this->belongsTo(SHG::class, 'shg_id');
    }

    /**
     * Get the donations associated with the member.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
