<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - Yuva Maitree Foundation</title>
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
<body class="bg-white text-gray-800">

    {{-- Navbar --}}
    <x-public-navbar />

    {{-- Hero Section --}}
    <section class="bg-gradient-to-r from-[#1b6a3c] to-green-700 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">About Us</h1>
                <p class="text-xl text-green-100">हमारे बारे में</p>
                <p class="text-green-100 mt-4 max-w-3xl mx-auto text-lg">
                    Empowering Communities, Transforming Lives Through Self Help Groups
                </p>
            </div>
        </div>
    </section>

    {{-- Mission & Vision --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                {{-- Mission --}}
                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        To empower rural women and youth through Self Help Groups (SHGs), promoting financial inclusion, skill development, and sustainable livelihoods. We strive to create self-reliant communities where every individual has the opportunity to thrive.
                    </p>
                </div>

                {{-- Vision --}}
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Vision</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        A society where every woman is economically independent, socially empowered, and has equal opportunities for growth. We envision thriving rural communities built on the foundation of mutual support, collective action, and sustainable development.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- About Content --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Who We Are</h2>
                <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full"></div>
            </div>

            <div class="prose prose-lg max-w-none">
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Yuva Maitree Foundation is a dedicated non-governmental organization working towards the holistic development of rural communities across India. Founded with the vision of empowering women and youth, we specialize in the formation and management of Self Help Groups (SHGs) that serve as catalysts for socio-economic transformation.
                </p>

                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Our organization operates on the principle that collective action and mutual support can break the cycle of poverty and create sustainable pathways to prosperity. Through our SHG model, we bring together women from similar economic backgrounds, helping them build savings, access credit, develop skills, and establish micro-enterprises.
                </p>

                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    We believe that when women are economically empowered, entire families and communities benefit. Our comprehensive approach includes financial literacy training, vocational skill development, entrepreneurship support, and linkages with government schemes and banking services.
                </p>
            </div>
        </div>
    </section>

    {{-- What We Do --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">What We Do</h2>
                <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Service 1 --}}
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-5">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">SHG Formation & Management</h3>
                    <p class="text-gray-600">Organizing women into Self Help Groups and providing training on group management, savings mobilization, and internal lending practices.</p>
                </div>

                {{-- Service 2 --}}
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-5">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Skill Development Programs</h3>
                    <p class="text-gray-600">Conducting training in tailoring, handicrafts, agriculture, food processing, and digital literacy to enhance employability and income generation.</p>
                </div>

                {{-- Service 3 --}}
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-5">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Financial Inclusion</h3>
                    <p class="text-gray-600">Facilitating bank account opening, linking members to government schemes, and enabling access to microfinance and credit facilities.</p>
                </div>

                {{-- Service 4 --}}
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-5">
                        <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Financial Literacy Training</h3>
                    <p class="text-gray-600">Building awareness about banking, savings, budgeting, and financial planning to help members make informed economic decisions.</p>
                </div>

                {{-- Service 5 --}}
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-5">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Entrepreneurship Support</h3>
                    <p class="text-gray-600">Guiding members in starting and managing micro-enterprises, from business planning to market linkages and product development.</p>
                </div>

                {{-- Service 6 --}}
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-5">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Government Scheme Linkage</h3>
                    <p class="text-gray-600">Connecting SHG members with various central and state government welfare schemes and ensuring they receive entitled benefits.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Impact Stats --}}
    <section class="py-16 bg-[#1b6a3c]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Our Impact</h2>
                <p class="text-green-100 text-lg">Making a difference in communities across India</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
                <div>
                    <p class="text-4xl sm:text-5xl font-extrabold mb-2">50+</p>
                    <p class="text-green-100 text-sm sm:text-base">Self Help Groups</p>
                </div>
                <div>
                    <p class="text-4xl sm:text-5xl font-extrabold mb-2">500+</p>
                    <p class="text-green-100 text-sm sm:text-base">Active Members</p>
                </div>
                <div>
                    <p class="text-4xl sm:text-5xl font-extrabold mb-2">20+</p>
                    <p class="text-green-100 text-sm sm:text-base">Villages Reached</p>
                </div>
                <div>
                    <p class="text-4xl sm:text-5xl font-extrabold mb-2">5+</p>
                    <p class="text-green-100 text-sm sm:text-base">Years of Service</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Join Our Mission</h2>
            <p class="text-gray-600 text-lg mb-8">
                Be a part of the change. Together, we can empower more communities and transform more lives.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('apply') }}" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition text-lg">
                    Become a Member
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-3 border-2 border-orange-500 text-orange-600 hover:bg-orange-50 font-semibold rounded-lg transition text-lg">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <x-public-footer />

</body>
</html>
