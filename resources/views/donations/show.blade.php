<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Donation Details') }}
            </h2>
            <a href="{{ route('donations.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Donation Details --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Status Card --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Receipt Number</h3>
                                <p class="text-2xl font-bold text-orange-600">{{ $donation->receipt_number ?? 'Not Generated' }}</p>
                            </div>
                            <div class="text-right">
                                @if($donation->status === 'completed')
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Completed
                                    </span>
                                @elseif($donation->status === 'pending')
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Pending
                                    </span>
                                @elseif($donation->status === 'failed')
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Failed
                                    </span>
                                @else
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-orange-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Donation Amount</p>
                                <p class="text-2xl font-bold text-orange-600">₹{{ number_format($donation->amount, 2) }}</p>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Payment Method</p>
                                <p class="text-lg font-semibold text-blue-600">{{ ucfirst($donation->payment_method ?? 'Online') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Donor Information --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Donor Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Full Name</label>
                                <p class="text-gray-900 font-semibold">{{ $donation->donor_name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Email</label>
                                <p class="text-gray-900">{{ $donation->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Phone Number</label>
                                <p class="text-gray-900">{{ $donation->phone }}</p>
                            </div>
                            @if($donation->pan_number)
                            <div>
                                <label class="text-sm font-medium text-gray-500">PAN Number</label>
                                <p class="text-gray-900 font-mono">{{ $donation->pan_number }}</p>
                            </div>
                            @endif
                        </div>

                        @if($donation->address || $donation->city || $donation->state || $donation->pincode)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <label class="text-sm font-medium text-gray-500">Address</label>
                            <p class="text-gray-900 mt-1">
                                @if($donation->address){{ $donation->address }}@endif
                                @if($donation->city || $donation->state || $donation->pincode)
                                    <br>
                                    {{ implode(', ', array_filter([$donation->city, $donation->state, $donation->pincode])) }}
                                @endif
                            </p>
                        </div>
                        @endif

                        @if($donation->message)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <label class="text-sm font-medium text-gray-500">Message</label>
                            <p class="text-gray-900 mt-1 italic">"{{ $donation->message }}"</p>
                        </div>
                        @endif
                    </div>

                    {{-- Payment Details --}}
                    @if($donation->razorpay_payment_id || $donation->razorpay_order_id)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Payment Gateway Details
                        </h3>
                        <div class="space-y-3">
                            @if($donation->razorpay_order_id)
                            <div>
                                <label class="text-sm font-medium text-gray-500">Razorpay Order ID</label>
                                <p class="text-gray-900 font-mono text-sm">{{ $donation->razorpay_order_id }}</p>
                            </div>
                            @endif
                            @if($donation->razorpay_payment_id)
                            <div>
                                <label class="text-sm font-medium text-gray-500">Razorpay Payment ID</label>
                                <p class="text-gray-900 font-mono text-sm">{{ $donation->razorpay_payment_id }}</p>
                                <a href="https://dashboard.razorpay.com/app/payments/{{ $donation->razorpay_payment_id }}" 
                                    target="_blank" 
                                    class="text-orange-600 hover:text-orange-700 text-sm mt-1 inline-flex items-center">
                                    View on Razorpay Dashboard
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                            @endif
                            @if($donation->payment_id)
                            <div>
                                <label class="text-sm font-medium text-gray-500">Internal Payment ID</label>
                                <p class="text-gray-900 font-mono text-sm">{{ $donation->payment_id }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Timeline --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
                        <div class="space-y-4">
                            @if($donation->paid_at)
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Payment Completed</p>
                                    <p class="text-xs text-gray-500">{{ $donation->paid_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                            @endif

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Donation Created</p>
                                    <p class="text-xs text-gray-500">{{ $donation->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Receipt Status --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Receipt Status</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">80G Certificate</span>
                                @if($donation->pan_number)
                                    <span class="text-sm font-semibold text-green-600">Eligible</span>
                                @else
                                    <span class="text-sm font-semibold text-gray-400">Not Eligible</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Receipt Sent</span>
                                @if($donation->receipt_sent)
                                    <span class="text-sm font-semibold text-green-600">Yes</span>
                                @else
                                    <span class="text-sm font-semibold text-yellow-600">Pending</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    @if($donation->status === 'completed')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('donation.receipt', $donation->id) }}" target="_blank" class="w-full px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm font-semibold inline-flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download Receipt
                            </a>
                            @if(!$donation->receipt_sent)
                            <form action="{{ route('donations.sendReceipt', $donation->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-semibold inline-flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Send Email Receipt
                                </button>
                            </form>
                            @else
                            <div class="w-full px-4 py-2 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-semibold text-center">
                                ✓ Receipt Already Sent
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
