<?php

namespace App\Http\Controllers;

use App\Models\StaffApplication;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StaffApplicationController extends Controller
{
    /**
     * Show the public staff application form.
     */
    public function showApplicationForm()
    {
        return view('staff-applications.apply');
    }

    /**
     * Handle public staff application submission.
     */
    public function submitApplication(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'husband_father_name' => 'nullable|string|max:255',
            'date_of_birth' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if (!$this->isValidDateInput($value)) {
                    $fail('The ' . str_replace('_', ' ', $attribute) . ' format is invalid.');
                }
            }],
            'blood_group' => 'nullable|string|max:5',
            'mobile' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'aadhar_number' => 'nullable|string|max:12|unique:staff_applications,aadhar_number',
            'pan_number' => 'nullable|string|max:10|unique:staff_applications,pan_number',
            'address' => 'required|string',
            'designation' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'passport_photo' => 'nullable|image|max:2048',
            'aadhar_card_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'pan_card_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'bank_passbook_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'pcc_doc' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $validated['date_of_birth'] = $this->normalizeDateInput($validated['date_of_birth'] ?? null);

        // Handle file uploads
        if ($request->hasFile('passport_photo')) {
            $validated['passport_photo'] = $request->file('passport_photo')->store('staff-photos', 'public');
        }
        if ($request->hasFile('aadhar_card_doc')) {
            $validated['aadhar_card_doc'] = $request->file('aadhar_card_doc')->store('staff-docs', 'public');
        }
        if ($request->hasFile('pan_card_doc')) {
            $validated['pan_card_doc'] = $request->file('pan_card_doc')->store('staff-docs', 'public');
        }
        if ($request->hasFile('bank_passbook_doc')) {
            $validated['bank_passbook_doc'] = $request->file('bank_passbook_doc')->store('staff-docs', 'public');
        }
        if ($request->hasFile('pcc_doc')) {
            $validated['pcc_doc'] = $request->file('pcc_doc')->store('staff-docs', 'public');
        }

        $validated['verification_status'] = 'pending';

        StaffApplication::create($validated);

        return redirect()->route('apply')->with('success', 'Your staff application has been submitted successfully! Please wait for admin verification.');
    }

    /**
     * Admin: list all staff applications.
     */
    public function index()
    {
        $applications = StaffApplication::orderByRaw("FIELD(verification_status, 'pending', 'verified', 'rejected')")
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('staff-applications.index', compact('applications'));
    }

    /**
     * Admin: show a staff application.
     */
    public function show(StaffApplication $staffApplication)
    {
        return view('staff-applications.show', compact('staffApplication'));
    }

    /**
     * Admin: verify a staff application.
     */
    public function verify(StaffApplication $staffApplication)
    {
        $staffApplication->update(['verification_status' => 'verified']);

        return redirect()->back()->with('success', $staffApplication->name . ' has been verified as staff.');
    }

    /**
     * Admin: reject a staff application.
     */
    public function reject(StaffApplication $staffApplication)
    {
        $staffApplication->update(['verification_status' => 'rejected']);

        return redirect()->back()->with('success', $staffApplication->name . ' has been rejected.');
    }

    /**
     * Display staff ID card in browser.
     */
    public function idCard(StaffApplication $staffApplication)
    {
        return view('staff-applications.id-card', compact('staffApplication'));
    }

    /**
     * Download staff ID card as PDF.
     */
    public function idCardPdf(StaffApplication $staffApplication)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('staff-applications.id-card-pdf', compact('staffApplication'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('staff-id-card-' . str_replace(['/', '\\'], '-', $staffApplication->staff_id_code ?? $staffApplication->id) . '.pdf');
    }

    /**
     * Public: show ID card download/search form.
     */
    public function showIdCardDownloadForm()
    {
        return view('staff-applications.id-card-download');
    }

    /**
     * Public: search staff by email and show ID card.
     */
    public function searchAndDownloadIdCard(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $staffApplication = StaffApplication::where('email', $validated['email'])
            ->where('verification_status', 'verified')
            ->first();

        if (!$staffApplication) {
            return redirect()->route('id-card.download')
                ->withInput()
                ->with('error', 'No verified staff member found with the provided email address. Please check and try again.');
        }

        return view('staff-applications.id-card', compact('staffApplication'));
    }

    // --- Date helpers ---

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
