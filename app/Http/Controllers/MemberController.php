<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SHG;
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
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:5',
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
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:5',
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
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:5',
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
}
