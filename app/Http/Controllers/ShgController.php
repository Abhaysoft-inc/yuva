<?php

namespace App\Http\Controllers;

use App\Models\SHG;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShgController extends Controller
{
    /**
     * Display a listing of the SHGs.
     */
    public function index(Request $request)
    {
        $search = $request->input('member_search');
        $memberResults = collect();

        if ($search) {
            $memberResults = Member::with('shg')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%");
                })
                ->limit(20)
                ->get();
        }

        $shgs = SHG::withCount('members')->latest()->paginate(10);
        return view('shgs.index', compact('shgs', 'memberResults', 'search'));
    }

    /**
     * Show the form for creating a new SHG.
     */
    public function create()
    {
        return view('shgs.create');
    }

    /**
     * Store a newly created SHG in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shg_name' => 'required|string|max:255',
            'shg_code' => 'nullable|string|max:255|unique:shgs,shg_code',
            'shg_contact' => 'nullable|string|max:15',
            'date_of_formation' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if (!$this->isValidDateInput($value)) {
                    $fail('The ' . str_replace('_', ' ', $attribute) . ' format is invalid.');
                }
            }],
            'village' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'state' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',

            'president_name' => 'nullable|string|max:255',
            'president_contact' => 'nullable|string|max:15',
            'secretary_name' => 'nullable|string|max:255',
            'secretary_contact' => 'nullable|string|max:15',
            'treasurer_name' => 'nullable|string|max:255',
            'treasurer_contact' => 'nullable|string|max:15',

            'meeting_proposal_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'group_photo' => 'nullable|image|max:2048',

            'bank_account_number' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',

            'fd_security_money' => 'nullable|numeric|min:0',
            'meeting_frequency' => 'nullable|in:weekly,biweekly,monthly',
            'monthly_saving_amount' => 'nullable|numeric|min:0',

            'declaration_accepted' => 'nullable|boolean',
            'signature' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $validated['date_of_formation'] = $this->normalizeDateInput($validated['date_of_formation'] ?? null);

        // Handle file uploads
        if ($request->hasFile('meeting_proposal_document')) {
            $validated['meeting_proposal_document'] = $request->file('meeting_proposal_document')->store('shg-documents', 'public');
        }
        if ($request->hasFile('group_photo')) {
            $validated['group_photo'] = $request->file('group_photo')->store('shg-photos', 'public');
        }
        if ($request->hasFile('signature')) {
            $validated['signature'] = $request->file('signature')->store('shg-signatures', 'public');
        }

        $validated['declaration_accepted'] = $request->has('declaration_accepted');

        SHG::create($validated);

        return redirect()->route('shgs.index')->with('success', 'SHG registered successfully!');
    }

    /**
     * Display the specified SHG.
     */
    public function show(SHG $shg)
    {
        $shg->load('members');
        return view('shgs.show', compact('shg'));
    }

    /**
     * Show the form for editing the specified SHG.
     */
    public function edit(SHG $shg)
    {
        return view('shgs.edit', compact('shg'));
    }

    /**
     * Update the specified SHG in storage.
     */
    public function update(Request $request, SHG $shg)
    {
        $validated = $request->validate([
            'shg_name' => 'required|string|max:255',
            'shg_code' => 'nullable|string|max:255|unique:shgs,shg_code,' . $shg->id,
            'shg_contact' => 'nullable|string|max:15',
            'date_of_formation' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if (!$this->isValidDateInput($value)) {
                    $fail('The ' . str_replace('_', ' ', $attribute) . ' format is invalid.');
                }
            }],
            'village' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'state' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',

            'president_name' => 'nullable|string|max:255',
            'president_contact' => 'nullable|string|max:15',
            'secretary_name' => 'nullable|string|max:255',
            'secretary_contact' => 'nullable|string|max:15',
            'treasurer_name' => 'nullable|string|max:255',
            'treasurer_contact' => 'nullable|string|max:15',

            'meeting_proposal_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'group_photo' => 'nullable|image|max:2048',

            'bank_account_number' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',

            'fd_security_money' => 'nullable|numeric|min:0',
            'meeting_frequency' => 'nullable|in:weekly,biweekly,monthly',
            'monthly_saving_amount' => 'nullable|numeric|min:0',

            'declaration_accepted' => 'nullable|boolean',
            'signature' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $validated['date_of_formation'] = $this->normalizeDateInput($validated['date_of_formation'] ?? null);

        // Handle file uploads
        if ($request->hasFile('meeting_proposal_document')) {
            $validated['meeting_proposal_document'] = $request->file('meeting_proposal_document')->store('shg-documents', 'public');
        }
        if ($request->hasFile('group_photo')) {
            $validated['group_photo'] = $request->file('group_photo')->store('shg-photos', 'public');
        }
        if ($request->hasFile('signature')) {
            $validated['signature'] = $request->file('signature')->store('shg-signatures', 'public');
        }

        $validated['declaration_accepted'] = $request->has('declaration_accepted');

        $shg->update($validated);

        return redirect()->route('shgs.index')->with('success', 'SHG updated successfully!');
    }

    /**
     * Remove the specified SHG from storage.
     */
    public function destroy(SHG $shg)
    {
        $shg->delete();
        return redirect()->route('shgs.index')->with('success', 'SHG deleted successfully!');
    }

    private function isValidDateInput(?string $value): bool
    {
        if (empty($value)) {
            return true;
        }

        foreach (['Y-m-d', 'd/m/Y'] as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);
                if ($date && $date->format($format) === $value) {
                    return true;
                }
            } catch (\Throwable) {
                // Try next format
            }
        }

        return false;
    }

    private function normalizeDateInput(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) === 1) {
            return Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
        }

        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value) === 1) {
            return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }

        return null;
    }
}
