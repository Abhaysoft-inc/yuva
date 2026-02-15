<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yuva Maitree Foundation</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-800">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold text-lg">Y</div>
                    <div>
                        <span class="font-bold text-lg text-gray-900">Yuva Maitree Foundation</span>
                        <span class="hidden sm:inline text-xs text-gray-400 ml-2">युवा मैत्री फाउंडेशन</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-orange-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                    Empowering Communities,<br>
                    <span class="text-orange-500">Transforming Lives</span>
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 mb-4">
                    समुदायों को सशक्त बनाना, जीवन बदलना
                </p>
                <p class="text-gray-500 mb-8 max-w-xl mx-auto">
                    Yuva Maitree Foundation works towards women empowerment, skill development, and financial inclusion through Self Help Groups (SHGs) across rural India.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition text-lg">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition text-lg">
                            Get Started
                        </a>
                    @endauth
                    <a href="#about" class="px-8 py-3 border-2 border-orange-500 text-orange-600 hover:bg-orange-50 font-semibold rounded-lg transition text-lg">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Bar --}}
    <section class="bg-orange-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
                <div>
                    <p class="text-3xl sm:text-4xl font-extrabold">50+</p>
                    <p class="text-orange-100 text-sm mt-1">Self Help Groups</p>
                </div>
                <div>
                    <p class="text-3xl sm:text-4xl font-extrabold">500+</p>
                    <p class="text-orange-100 text-sm mt-1">Members</p>
                </div>
                <div>
                    <p class="text-3xl sm:text-4xl font-extrabold">20+</p>
                    <p class="text-orange-100 text-sm mt-1">Villages Covered</p>
                </div>
                <div>
                    <p class="text-3xl sm:text-4xl font-extrabold">5+</p>
                    <p class="text-orange-100 text-sm mt-1">Years of Service</p>
                </div>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="py-16 sm:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">About Us / हमारे बारे में</h2>
                <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full"></div>
            </div>
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Yuva Maitree Foundation is a non-governmental organization dedicated to the upliftment of rural communities, especially women, through the formation and management of Self Help Groups (SHGs).
                </p>
                <p class="text-gray-600 text-lg leading-relaxed">
                    We believe in the power of collective effort. By bringing women together in SHGs, we help them build savings, access credit, develop skills, and become financially independent — creating a ripple effect of positive change in families and communities.
                </p>
            </div>
        </div>
    </section>

    {{-- What We Do --}}
    <section class="py-16 sm:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">What We Do / हम क्या करते हैं</h2>
                <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Card 1 --}}
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-8 text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">SHG Formation</h3>
                    <p class="text-gray-500">We organize women into Self Help Groups, providing training and guidance to help them manage savings, loans, and group finances.</p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Skill Development</h3>
                    <p class="text-gray-500">We conduct training programs in tailoring, handicrafts, agriculture, and digital literacy to help members earn a sustainable livelihood.</p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Financial Inclusion</h3>
                    <p class="text-gray-500">We help members open bank accounts, link them to government schemes, and facilitate access to microfinance and credit facilities.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 sm:py-20 bg-gradient-to-r from-orange-500 to-orange-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Join Us in Making a Difference</h2>
            <p class="text-orange-100 text-lg mb-8">हमारे साथ जुड़ें और बदलाव लाएं</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="inline-block px-8 py-3 bg-white text-orange-600 font-semibold rounded-lg shadow-lg hover:shadow-xl hover:bg-gray-50 transition text-lg">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-white text-orange-600 font-semibold rounded-lg shadow-lg hover:shadow-xl hover:bg-gray-50 transition text-lg">
                    Register Now
                </a>
            @endauth
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold text-lg">Y</div>
                        <span class="font-bold text-lg text-white">Yuva Maitree Foundation</span>
                    </div>
                    <p class="text-sm leading-relaxed">
                        Working towards women empowerment and community development through Self Help Groups across rural India.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#about" class="hover:text-orange-400 transition">About Us</a></li>
                        @if (Route::has('login'))
                            <li><a href="{{ route('login') }}" class="hover:text-orange-400 transition">Login</a></li>
                        @endif
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="hover:text-orange-400 transition">Register</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Contact / संपर्क</h4>
                    <ul class="space-y-2 text-sm">
                        <li>Email: info@yuvamaitree.org</li>
                        <li>Phone: +91 XXXXX XXXXX</li>
                        <li>Location: India</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-10 pt-6 text-center text-sm">
                <p>&copy; {{ date('Y') }} Yuva Maitree Foundation. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
       