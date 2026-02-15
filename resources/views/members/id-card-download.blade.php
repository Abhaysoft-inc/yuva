<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ID Card Download - Yuva Maitree Foundation</title>
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

    {{-- Main Content --}}
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                </svg>
            </div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">Download Your ID Card</h2>
            <p class="text-lg text-gray-600">अपना आईडी कार्ड डाउनलोड करें</p>
            <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full mt-4"></div>
        </div>

        {{-- Error Message --}}
        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
            <div class="flex">
                <svg class="h-6 w-6 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        {{-- Search Form --}}
        <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8">
            <div class="mb-6">
                <div class="flex items-start space-x-3 text-sm text-gray-600 bg-blue-50 p-4 rounded-lg">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-medium text-blue-800 mb-1">Enter your details to download your ID card</p>
                        <p class="text-blue-700">Please provide your Membership ID and Date of Birth for verification.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('id-card.search') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    {{-- Membership ID --}}
                    <div>
                        <label for="member_id_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Membership ID <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="member_id_code" 
                                id="member_id_code" 
                                value="{{ old('member_id_code') }}" 
                                required 
                                placeholder="e.g., SHG-0001"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg"
                            >
                        </div>
                        @error('member_id_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Enter your membership ID as shown on your documents</p>
                    </div>

                    {{-- Date of Birth --}}
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                            Date of Birth <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input 
                                type="date" 
                                name="date_of_birth" 
                                id="date_of_birth" 
                                value="{{ old('date_of_birth') }}" 
                                required 
                                max="{{ date('Y-m-d') }}"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg"
                            >
                        </div>
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="mt-8 flex justify-center">
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-lg font-semibold rounded-lg shadow-lg hover:shadow-xl transition duration-200 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Search & Download
                    </button>
                </div>
            </form>
        </div>

        {{-- Help Section --}}
        <div class="mt-8 bg-gradient-to-r from-orange-50 to-green-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="w-5 h-5 text-orange-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                </svg>
                Need Help?
            </h3>
            <div class="space-y-2 text-sm text-gray-700">
                <p><strong>Don't remember your Membership ID?</strong> Contact your SHG group leader or our office.</p>
                <p><strong>Wrong Date of Birth?</strong> If the date of birth in our records doesn't match, please contact us to update your information.</p>
                <p><strong>New Member?</strong> Your ID card will be available once your application is approved. Please check back after 2-3 working days.</p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    <strong>Contact:</strong> info@yuvamaitree.org | +91 XXXXX XXXXX
                </p>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-sm">&copy; {{ date('Y') }} Yuva Maitree Foundation. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
