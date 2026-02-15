<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SHG extends Model
{
    protected $table = 'shgs';

    protected $fillable = [
        // Basic Information
        'shg_name',
        'shg_code',
        'shg_contact',
        'date_of_formation',
        'village',
        'pincode',
        'address',
        'state',
        'district',

        // Officers Details
        'president_name',
        'president_contact',
        'secretary_name',
        'secretary_contact',
        'treasurer_name',
        'treasurer_contact',

        // Group Documents
        'meeting_proposal_document',
        'group_photo',

        // Bank Details
        'bank_account_number',
        'bank_name',
        'ifsc_code',
        'branch_name',

        // FD & Security
        'fd_security_money',

        // Savings & Meetings
        'meeting_frequency',
        'monthly_saving_amount',

        // Declaration
        'declaration_accepted',
        'signature',

        'status',
    ];

    protected $casts = [
        'date_of_formation' => 'date',
        'fd_security_money' => 'decimal:2',
        'monthly_saving_amount' => 'decimal:2',
        'declaration_accepted' => 'boolean',
    ];

    /**
     * Get the members belonging to this SHG.
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'shg_id');
    }
}
