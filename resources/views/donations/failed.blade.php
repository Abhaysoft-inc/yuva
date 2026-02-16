<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Failed - Yuva Maitree Foundation</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            padding-top: 140px;
        }
    </style>
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <x-public-navbar />

    {{-- Failed Message --}}
    <section class="py-16 min-h-screen flex items-center justify-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
                {{-- Error Icon --}}
                <div class="flex justify-center mb-6">
                    <div class="rounded-full bg-red-100 p-6">
                        <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>

                {{-- Error Message --}}
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Payment Failed</h1>
                <p class="text-xl text-gray-600 mb-2">भुगतान विफल</p>
                <p class="text-lg text-gray-700 mb-8">
                    We're sorry, but your payment could not be processed at this time. Please try again.
                </p>

                {{-- Possible Reasons --}}
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8 text-left">
                    <h2 class="font-semibold text-gray-900 mb-4">Common reasons for payment failure:</h2>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>Insufficient balance in your account</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>Incorrect card details or CVV</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>Card limit exceeded</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>Payment gateway timeout or network issue</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>Bank declined the transaction</span>
                        </li>
                    </ul>
                </div>

                {{-- What to do next --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8 text-left">
                    <h3 class="font-semibold text-blue-900 mb-3">What you can do:</h3>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Check your account balance and card details</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Try using a different payment method</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Wait a few minutes and try again</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Contact your bank if the issue persists</span>
                        </li>
                    </ul>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('donate') }}" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition">
                        Try Again
                    </a>
                    <a href="{{ url('/') }}" class="px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-lg border-2 border-gray-300 transition">
                        Return to Home
                    </a>
                </div>

                {{-- Contact Support --}}
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-3">Need help?</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-sm">
                        <a href="mailto:info@yuvamaitree.org" class="flex items-center gap-2 text-orange-600 hover:text-orange-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            info@yuvamaitree.org
                        </a>
                        <span class="text-gray-300 hidden sm:inline">|</span>
                        <a href="tel:+91XXXXXXXXXX" class="flex items-center gap-2 text-orange-600 hover:text-orange-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            +91 XXXXX XXXXX
                        </a>
                    </div>
                </div>

                {{-- Note about charges --}}
                <div class="mt-6 text-xs text-gray-500">
                    <p>Note: No amount has been deducted from your account. If you see a temporary hold, it will be released by your bank within 5-7 business days.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <x-public-footer />

</body>
</html>
