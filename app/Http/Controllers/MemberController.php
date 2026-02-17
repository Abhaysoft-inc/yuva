<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SHG;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of members for a specific SHG.
     */
    public function index(SHG $shg)
    {
        $members = $shg->members()->latest()->paginate(15);
        return view('members.index', compact('shg', 'members'));
    }

    /**
     * Show the form for creating a new member under an SHG.
     */
    public function create(SHG $shg)
    {
        return view('members.create', compact('shg'));
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request, SHG $shg)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'husband_father_name' => 'nullable|string|max:255',
            'role' => 'nullable|in:member,president,secretary,treasurer',
            'date_of_birth' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if (!$this->isValidDateInput($value)) {
                    $fail('The ' . str_replace('_', ' ', $attribute) . ' format is invalid.');
                }
            }],
            'mobile' => 'nullable|string|max:15',
            'aadhar_number' => 'nullable|string|max:12|unique:members,aadhar_number',
            'pan_number' => 'nullable|string|max:10|unique:members,pan_number',
            'address' => 'nullable|string',

            'bank_name' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',

            'passport_photo' => 'nullable|image|max:2048',
            'aadhar_card_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'pan_card_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'bank_passbook_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $validated['date_of_birth'] = $this->normalizeDateInput($validated['date_of_birth'] ?? null);

        $validated['shg_id'] = $shg->id;

        // Handle file uploads
        if ($request->hasFile('passport_photo')) {
            $validated['passport_photo'] = $request->file('passport_photo')->store('member-photos', 'public');
        }
        if ($request->hasFile('aadhar_card_doc')) {
            $validated['aadhar_card_doc'] = $request->file('aadhar_card_doc')->store('member-documents', 'public');
        }
        if ($request->hasFile('pan_card_doc')) {
            $validated['pan_card_doc'] = $request->file('pan_card_doc')->store('member-documents', 'public');
        }
        if ($request->hasFile('bank_passbook_doc')) {
            $validated['bank_passbook_doc'] = $request->file('bank_passbook_doc')->store('member-documents', 'public');
        }

        Member::create($validated);

        return redirect()->route('shgs.members.index', $shg)->with('success', 'Member added successfully!');
    }

    /**
     * Display the specified member.
     */
    public function show(SHG $shg, Member $member)
    {
        return view('members.show', compact('shg', 'member'));
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(SHG $shg, Member $member)
    {
        return view('members.edit', compact('shg', 'member'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, SHG $shg, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'husband_father_name' => 'nullable|string|max:255',
            'role' => 'nullable|in:member,president,secretary,treasurer',
            'date_of_birth' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if (!$this->isValidDateInput($value)) {
                    $fail('The ' . str_replace('_', ' ', $attribute) . ' format is invalid.');
                }
            }],
            'mobile' => 'nullable|string|max:15',
            'aadhar_number' => 'nullable|string|max:12|unique:members,aadhar_number,' . $member->id,
            'pan_number' => 'nullable|string|max:10|unique:members,pan_number,' . $member->id,
            'address' => 'nullable|string',

            'bank_name' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',

            'passport_photo' => 'nullable|image|max:2048',
            'aadhar_card_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'pan_card_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'bank_passbook_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $validated['date_of_birth'] = $this->normalizeDateInput($validated['date_of_birth'] ?? null);

        // Handle file uploads
        if ($request->hasFile('passport_photo')) {
            $validated['passport_photo'] = $request->file('passport_photo')->store('member-photos', 'public');
        }
        if ($request->hasFile('aadhar_card_doc')) {
            $validated['aadhar_card_doc'] = $request->file('aadhar_card_doc')->store('member-documents', 'public');
        }
        if ($request->hasFile('pan_card_doc')) {
            $validated['pan_card_doc'] = $request->file('pan_card_doc')->store('member-documents', 'public');
        }
        if ($request->hasFile('bank_passbook_doc')) {
            $validated['bank_passbook_doc'] = $request->file('bank_passbook_doc')->store('member-documents', 'public');
        }

        $member->update($validated);

        return redirect()->route('shgs.members.index', $shg)->with('success', 'Member updated successfully!');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(SHG $shg, Member $member)
    {
        $member->delete();
        return redirect()->route('shgs.members.index', $shg)->with('success', 'Member deleted successfully!');
    }

    /**
     * Show standalone create member form with SHG chooser.
     */
    public function createStandalone()
    {
        $shgs = SHG::where('status', 'active')->orderBy('shg_name')->get();
        return view('members.create-standalone', compact('shgs'));
    }

    /**
     * Store member from standalone form.
     */
    public function storeStandalone(Request $request)
    {
        $validated = $request->validate([
            'shg_id' => 'required|exists:shgs,id',
            'name' => 'required|string|max:255',
            'husband_father_name' => 'nullable|string|max:255',
            'role' => 'nullable|in:member,president,secretary,treasurer',
            'date_of_birth' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if (!$this->isValidDateInput($value)) {
                    $fail('The ' . str_replace('_', ' ', $attribute) . ' format is invalid.');
                }
            }],
            'mobile' => 'nullable|string|max:15',
            'aadhar_number' => 'nullable|string|max:12|unique:members,aadhar_number',
            'pan_number' => 'nullable|string|max:10|unique:members,pan_number',
            'address' => 'nullable|string',

            'bank_name' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',

            'passport_photo' => 'nullable|image|max:2048',
            'aadhar_card_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'pan_card_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'bank_passbook_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $validated['date_of_birth'] = $this->normalizeDateInput($validated['date_of_birth'] ?? null);

        if ($request->hasFile('passport_photo')) {
            $validated['passport_photo'] = $request->file('passport_photo')->store('member-photos', 'public');
        }
        if ($request->hasFile('aadhar_card_doc')) {
            $validated['aadhar_card_doc'] = $request->file('aadhar_card_doc')->store('member-documents', 'public');
        }
        if ($request->hasFile('pan_card_doc')) {
            $validated['pan_card_doc'] = $request->file('pan_card_doc')->store('member-documents', 'public');
        }
        if ($request->hasFile('bank_passbook_doc')) {
            $validated['bank_passbook_doc'] = $request->file('bank_passbook_doc')->store('member-documents', 'public');
        }

        $shg = SHG::findOrFail($validated['shg_id']);
        Member::create($validated);

        return redirect()->route('shgs.members.index', $shg)->with('success', 'Member added successfully!');
    }

    /**
     * Generate and display the member's ID card.
     */
    public function idCard(SHG $shg, Member $member)
    {
        $member->load('shg');
        return view('members.id-card', compact('shg', 'member'));
    }

    /**
     * Generate and display the printable membership form.
     */
    public function membershipForm(SHG $shg, Member $member)
    {
        $member->load('shg');
        return view('members.membership-form', compact('shg', 'member'));
    }

    /**
     * Show the public member application form.
     */
    public function showApplicationForm()
    {
        $shgs = SHG::where('status', 'active')->orderBy('shg_name')->get();
        return view('members.apply', compact('shgs'));
    }

    /**
     * Handle public member application submission.
     */
    public function submitApplication(Request $request)
    {
        $validated = $request->validate([
            'shg_id' => 'required|exists:shgs,id',
            'name' => 'required|string|max:255',
            'husband_father_name' => 'nullable|string|max:255',
            'date_of_birth' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if (!$this->isValidDateInput($value)) {
                    $fail('The ' . str_replace('_', ' ', $attribute) . ' format is invalid.');
                }
            }],
            'mobile' => 'required|string|max:15',
            'aadhar_number' => 'nullable|string|max:12|unique:members,aadhar_number',
            'pan_number' => 'nullable|string|max:10|unique:members,pan_number',
            'address' => 'required|string',
            'bank_name' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'passport_photo' => 'nullable|image|max:2048',
            'aadhar_card_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'pan_card_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'bank_passbook_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $validated['date_of_birth'] = $this->normalizeDateInput($validated['date_of_birth'] ?? null);

        // Handle file uploads
        if ($request->hasFile('passport_photo')) {
            $validated['passport_photo'] = $request->file('passport_photo')->store('member-photos', 'public');
        }
        if ($request->hasFile('aadhar_card_doc')) {
            $validated['aadhar_card_doc'] = $request->file('aadhar_card_doc')->store('member-docs', 'public');
        }
        if ($request->hasFile('pan_card_doc')) {
            $validated['pan_card_doc'] = $request->file('pan_card_doc')->store('member-docs', 'public');
        }
        if ($request->hasFile('bank_passbook_doc')) {
            $validated['bank_passbook_doc'] = $request->file('bank_passbook_doc')->store('member-docs', 'public');
        }

        // Generate membership ID
        $shg = SHG::findOrFail($validated['shg_id']);
        $memberCount = $shg->members()->count();
        $validated['member_id_code'] = strtoupper($shg->shg_code ?? 'SHG') . '-' . str_pad($memberCount + 1, 4, '0', STR_PAD_LEFT);
        $validated['role'] = 'member';
        $validated['verification_status'] = 'pending'; // Set as pending for admin verification

        Member::create($validated);

        return redirect()->route('apply')->with('success', 'Your application has been submitted successfully! Please wait for admin verification.');
    }

    /**
     * Show the public ID card download form.
     */
    public function showIdCardDownloadForm()
    {
        return view('members.id-card-download');
    }

    /**
     * Search for member and display their ID card.
     */
    public function searchAndDownloadIdCard(Request $request)
    {
        $validated = $request->validate([
            'member_id_code' => 'required|string',
            'date_of_birth' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!$this->isValidDateInput($value)) {
                    $fail('The ' . str_replace('_', ' ', $attribute) . ' format is invalid.');
                }
            }],
        ]);

        $searchDate = $this->normalizeDateInput($validated['date_of_birth']);

        $member = Member::where('member_id_code', $validated['member_id_code'])
            ->whereDate('date_of_birth', $searchDate)
            ->first();

        if (!$member) {
            return redirect()->route('id-card.download')
                ->withInput()
                ->with('error', 'No member found with the provided Membership ID and Date of Birth. Please check and try again.');
        }

        $member->load('shg');
        $shg = $member->shg;

        return view('members.id-card', compact('member', 'shg'));
    }

    /**
     * Display all verified members across all SHGs.
     */
    public function indexAll()
    {
        $members = Member::with('shg')
            ->where('verification_status', 'verified')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('members.all', compact('members'));
    }

    /**
     * Display unverified members.
     */
    public function unverified()
    {
        $members = Member::with('shg')
            ->where('verification_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('members.unverified', compact('members'));
    }

    /**
     * Verify a member application.
     */
    public function verify(Member $member)
    {
        $member->update(['verification_status' => 'verified']);

        return redirect()->route('members.unverified')->with('success', 'Member verified successfully!');
    }

    /**
     * Reject a member application.
     */
    public function reject(Member $member)
    {
        $member->update(['verification_status' => 'rejected']);

        return redirect()->route('members.unverified')->with('success', 'Member application rejected.');
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
