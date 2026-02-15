<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Donate - Yuva Maitree Foundation</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            padding-top: 140px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    <x-public-navbar />

    {{-- Hero Section --}}
    <section class="bg-gradient-to-r from-[#1b6a3c] to-green-700 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">Make a Donation</h1>
                <p class="text-xl text-green-100">दान करें</p>
                <p class="text-green-100 mt-4 max-w-3xl mx-auto text-lg">
                    Your generous contribution helps us empower more communities and transform more lives
                </p>
            </div>
        </div>
    </section>

    {{-- Donation Form --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Impact Info --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-orange-50 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-orange-600 mb-2">₹500</div>
                    <p class="text-gray-600 text-sm">Provides skill training to 1 woman</p>
                </div>
                <div class="bg-green-50 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">₹2,000</div>
                    <p class="text-gray-600 text-sm">Supports an SHG setup for one month</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">₹5,000</div>
                    <p class="text-gray-600 text-sm">Funds micro-enterprise for one member</p>
                </div>
            </div>

            {{-- Donation Form --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-lg">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Donation Details</h2>
                
                <form id="donationForm" method="POST">
                    @csrf
                    
                    {{-- Quick Amount Selection --}}
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Select Amount *</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <button type="button" onclick="selectAmount(500)" class="amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-semibold hover:border-orange-500 hover:bg-orange-50 transition">
                                ₹500
                            </button>
                            <button type="button" onclick="selectAmount(1000)" class="amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-semibold hover:border-orange-500 hover:bg-orange-50 transition">
                                ₹1,000
                            </button>
                            <button type="button" onclick="selectAmount(2000)" class="amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-semibold hover:border-orange-500 hover:bg-orange-50 transition">
                                ₹2,000
                            </button>
                            <button type="button" onclick="selectAmount(5000)" class="amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-semibold hover:border-orange-500 hover:bg-orange-50 transition">
                                ₹5,000
                            </button>
                        </div>
                        <div class="mt-3">
                            <input type="number" name="amount" id="amount" placeholder="Or enter custom amount" required min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>
                    </div>

                    {{-- Personal Details --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="donor_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="donor_name" id="donor_name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" name="email" id="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" name="phone" id="phone" required maxlength="15"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="pan_number" class="block text-sm font-medium text-gray-700 mb-2">
                                PAN Number <span class="text-gray-500 text-xs">(For 80G Certificate)</span>
                            </label>
                            <input type="text" name="pan_number" id="pan_number" maxlength="10" style="text-transform: uppercase;"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>
                    </div>

                    {{-- Address Details --}}
                    <div class="mb-6">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address (Optional)</label>
                        <textarea name="address" id="address" rows="2"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                            <input type="text" name="city" id="city"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                            <input type="text" name="state" id="state"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="pincode" class="block text-sm font-medium text-gray-700 mb-2">Pincode</label>
                            <input type="text" name="pincode" id="pincode" maxlength="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>
                    </div>

                    {{-- Message --}}
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message (Optional)</label>
                        <textarea name="message" id="message" rows="3" placeholder="Share why you're supporting us..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"></textarea>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" id="donateBtn" class="w-full px-6 py-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition text-lg">
                        Proceed to Payment
                    </button>
                </form>
            </div>

            {{-- Security Info --}}
            <div class="mt-8 text-center">
                <div class="flex items-center justify-center gap-2 text-gray-600 mb-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span class="text-sm font-medium">Secure Payment powered by Razorpay</span>
                </div>
                <p class="text-xs text-gray-500">All donations are eligible for 80G tax exemption certificate</p>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 text-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <img src="{{ asset('images/logo.webp') }}" alt="Logo" class="h-16 w-auto mb-4">
                    <p class="text-sm leading-relaxed">
                        Working towards women empowerment and community development through Self Help Groups across rural India.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-black mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/') }}" class="hover:text-orange-500 transition">Home</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-orange-500 transition">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-orange-500 transition">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-black mb-4">Contact / संपर्क</h4>
                    <ul class="space-y-2 text-sm">
                        <li>Email: info@yuvamaitree.org</li>
                        <li>Phone: +91 XXXXX XXXXX</li>
                        <li>Location: India</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-10 pt-6 text-center text-sm">
                <p>&copy; {{ date('Y') }} Yuva Maitree Foundation. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Quick amount selection
        function selectAmount(amount) {
            document.getElementById('amount').value = amount;
            
            // Update button states
            document.querySelectorAll('.amount-btn').forEach(btn => {
                btn.classList.remove('border-orange-500', 'bg-orange-50');
                btn.classList.add('border-gray-300');
            });
            event.target.classList.remove('border-gray-300');
            event.target.classList.add('border-orange-500', 'bg-orange-50');
        }

        // Handle form submission and Razorpay payment
        document.getElementById('donationForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('donateBtn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';

            try {
                const formData = new FormData(this);
                
                // Call backend to create order
                const response = await fetch('{{ route("donation.initiate") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || 'Payment initiation failed');
                }

                // Initialize Razorpay
                const options = {
                    key: data.key,
                    amount: data.amount,
                    currency: 'INR',
                    name: 'Yuva Maitree Foundation',
                    description: 'Donation',
                    order_id: data.order_id,
                    handler: function(response) {
                        // Payment successful, verify on backend
                        verifyPayment(response, data.donation_id);
                    },
                    prefill: {
                        name: data.name,
                        email: data.email,
                        contact: data.phone
                    },
                    theme: {
                        color: '#f97316'
                    },
                    modal: {
                        ondismiss: function() {
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Proceed to Payment';
                        }
                    }
                };

                const razorpay = new Razorpay(options);
                razorpay.open();

            } catch (error) {
                alert(error.message || 'Something went wrong. Please try again.');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Proceed to Payment';
            }
        });

        async function verifyPayment(payment, donationId) {
            try {
                const formData = new FormData();
                formData.append('razorpay_payment_id', payment.razorpay_payment_id);
                formData.append('razorpay_order_id', payment.razorpay_order_id);
                formData.append('razorpay_signature', payment.razorpay_signature);
                formData.append('donation_id', donationId);

                const response = await fetch('{{ route("donation.verify") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                });

                // Redirect will be handled by backend
                window.location.href = response.url;

            } catch (error) {
                alert('Payment verification failed. Please contact support with your payment ID: ' + payment.razorpay_payment_id);
            }
        }
    </script>

</body>
</html>
