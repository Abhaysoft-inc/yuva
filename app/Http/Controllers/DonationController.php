<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class DonationController extends Controller
{
    private $razorpayKey;
    private $razorpaySecret;

    public function __construct()
    {
        $this->razorpayKey = env('RAZORPAY_KEY');
        $this->razorpaySecret = env('RAZORPAY_SECRET');
    }

    /**
     * Display donation form (public)
     */
    public function showDonationForm()
    {
        return view('donations.create');
    }

    /**
     * Create Razorpay order and initiate payment
     */
    public function initiatePayment(Request $request)
    {
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'amount' => 'required|numeric|min:1',
            'pan_number' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:6',
            'message' => 'nullable|string',
        ]);

        try {
            // Create donation record
            $donation = Donation::create([
                'donor_name' => $request->donor_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'amount' => $request->amount,
                'pan_number' => $request->pan_number,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'message' => $request->message,
                'status' => 'pending',
            ]);

            // Create Razorpay order
            $api = new Api($this->razorpayKey, $this->razorpaySecret);

            $orderData = [
                'receipt' => 'donation_' . $donation->id,
                'amount' => $request->amount * 100, // Amount in paise
                'currency' => 'INR',
                'notes' => [
                    'donation_id' => $donation->id,
                    'donor_name' => $request->donor_name,
                    'donor_email' => $request->email,
                ]
            ];

            $razorpayOrder = $api->order->create($orderData);

            // Update donation with order ID
            $donation->update([
                'razorpay_order_id' => $razorpayOrder->id,
                'payment_id' => 'YMF_' . time() . '_' . $donation->id,
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $razorpayOrder->id,
                'amount' => $request->amount * 100,
                'key' => $this->razorpayKey,
                'donation_id' => $donation->id,
                'name' => $request->donor_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment initiation failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Verify payment and update donation status
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required',
            'donation_id' => 'required|exists:donations,id',
        ]);

        try {
            $api = new Api($this->razorpayKey, $this->razorpaySecret);

            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            // Verify signature
            $api->utility->verifyPaymentSignature($attributes);

            // Fetch payment details
            $payment = $api->payment->fetch($request->razorpay_payment_id);

            // Update donation record
            $donation = Donation::find($request->donation_id);
            $donation->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'status' => 'completed',
                'payment_method' => $payment->method,
                'paid_at' => now(),
                'receipt_number' => Donation::generateReceiptNumber(),
            ]);

            return redirect()->route('donation.success', $donation->id)
                ->with('success', 'Thank you for your donation!');
        } catch (\Exception $e) {
            Log::error('Payment verification failed: ' . $e->getMessage());

            if (isset($request->donation_id)) {
                $donation = Donation::find($request->donation_id);
                if ($donation) {
                    $donation->update(['status' => 'failed']);
                }
            }

            return redirect()->route('donation.failed')
                ->with('error', 'Payment verification failed. Please contact support.');
        }
    }

    /**
     * Show success page
     */
    public function success($id)
    {
        $donation = Donation::findOrFail($id);
        return view('donations.success', compact('donation'));
    }

    /**
     * Show failed page
     */
    public function failed()
    {
        return view('donations.failed');
    }

    /**
     * Admin: Display all donations
     */
    public function index(Request $request)
    {
        $query = Donation::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $donations = $query->latest()->paginate(20);

        // Calculate stats
        $stats = [
            'total' => Donation::count(),
            'completed' => Donation::where('status', 'completed')->count(),
            'pending' => Donation::where('status', 'pending')->count(),
            'total_amount' => Donation::where('status', 'completed')->sum('amount'),
        ];

        return view('donations.index', compact('donations', 'stats'));
    }

    /**
     * Admin: Show donation details
     */
    public function show(Donation $donation)
    {
        return view('donations.show', compact('donation'));
    }

    /**
     * Download donation receipt as PDF
     */
    public function downloadReceipt($id)
    {
        $donation = Donation::findOrFail($id);

        if ($donation->status !== 'completed') {
            abort(404, 'Receipt not available for pending or failed donations.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('donations.receipt', compact('donation'));

        // Sanitize filename by replacing / and \ with -
        $filename = str_replace(['/', '\\'], '-', $donation->receipt_number);

        return $pdf->download('donation-receipt-' . $filename . '.pdf');
    }

    /**
     * Send donation receipt via email
     */
    public function sendReceipt(Donation $donation)
    {
        if ($donation->status !== 'completed') {
            return redirect()->back()->with('error', 'Cannot send receipt for incomplete donations.');
        }

        if (!$donation->donor_email) {
            return redirect()->back()->with('error', 'No email address available for this donation.');
        }

        try {
            // Generate PDF receipt
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('donations.receipt', compact('donation'));
            $pdfContent = base64_encode($pdf->output());
            $filename = str_replace(['/', '\\'], '-', $donation->receipt_number) . '.pdf';

            // Generate email HTML content
            $emailHtml = view('emails.donation-receipt', compact('donation'))->render();

            // Send via Brevo API
            $brevoService = new \App\Services\BrevoService();
            $result = $brevoService->sendEmailWithPdf(
                $donation->donor_email,
                $donation->donor_name,
                'Donation Receipt - ' . $donation->receipt_number,
                $emailHtml,
                $pdfContent,
                $filename
            );

            if ($result['success']) {
                // Update receipt_sent flag
                $donation->update(['receipt_sent' => true]);

                return redirect()->back()->with('success', 'Receipt sent successfully to ' . $donation->donor_email);
            } else {
                throw new \Exception($result['error']);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send donation receipt: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send receipt: ' . $e->getMessage());
        }
    }
}
