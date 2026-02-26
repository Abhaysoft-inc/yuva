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
        
        /* Slider Styles */
        .slider-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 400px;
        }
        
        @media (min-width: 768px) {
            .slider-container {
                height: 400px;
            }
        }
        
        .slider-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 100%;
        }
        
        .slide {
            min-width: 100%;
            height: 100%;
            position: relative;
            background-size: cover;
            background-position: center;
        }
        
        .slide-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0,0,0,0.6), rgba(0,0,0,0.3));
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .slide-content {
            color: white;
            text-align: center;
            padding: 2rem;
            max-width: 800px;
        }
        
        .slider-nav {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }
        
        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .slider-dot.active {
            background: white;
            width: 30px;
            border-radius: 6px;
        }
        
        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.3);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            z-index: 10;
        }
        
        .slider-arrow:hover {
            background: rgba(255,255,255,0.5);
        }
        
        .slider-arrow.prev {
            left: 20px;
        }
        
        .slider-arrow.next {
            right: 20px;
        }
        
        /* Spacer for fixed navbar */
        body {
            padding-top: 140px;
        }
    </style>
</head>
<body class="bg-white text-gray-800">

    {{-- Navbar --}}
    <x-public-navbar />

    {{-- Hero Slider --}}
    @if($slides->count() > 0)
    <section class="slider-container">
        <div class="slider-track" id="sliderTrack">
            @foreach($slides as $slide)
            <div class="slide" style="background-image: url('{{ asset('storage/' . $slide->image_path) }}');">
                <div class="slide-overlay">
                    <div class="slide-content">
                        @if($slide->title)
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 drop-shadow-lg">
                            {{ $slide->title }}
                        </h1>
                        @endif
                        @if($slide->description)
                        <p class="text-lg sm:text-xl md:text-2xl drop-shadow-md">
                            {{ $slide->description }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Navigation Arrows --}}
        @if($slides->count() > 1)
        <button class="slider-arrow prev" onclick="moveSlide(-1)">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button class="slider-arrow next" onclick="moveSlide(1)">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        
        {{-- Dots Navigation --}}
        <div class="slider-nav" id="sliderNav">
            @foreach($slides as $index => $slide)
            <div class="slider-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></div>
            @endforeach
        </div>
        @endif
    </section>

    <script>
        let currentSlide = 0;
        const totalSlides = {{ $slides->count() }};
        const autoPlayInterval = 5000; // 5 seconds
        let autoPlay;

        function updateSlider() {
            const track = document.getElementById('sliderTrack');
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update dots
            const dots = document.querySelectorAll('.slider-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }

        function moveSlide(direction) {
            currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
            updateSlider();
            resetAutoPlay();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateSlider();
            resetAutoPlay();
        }

        function resetAutoPlay() {
            clearInterval(autoPlay);
            startAutoPlay();
        }

        function startAutoPlay() {
            if (totalSlides > 1) {
                autoPlay = setInterval(() => {
                    moveSlide(1);
                }, autoPlayInterval);
            }
        }

        // Start auto-play on page load
        startAutoPlay();
    </script>
    @else
    {{-- Fallback if no slides --}}
    <section class="bg-gradient-to-br from-orange-100 to-orange-50 py-20">
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
                    Yuva Maitree Foundation works towards women empowerment, skill development, and financial inclusion across rural India.
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
    @endif

    {{-- About Section --}}
    <section id="about" class="py-16 sm:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">About Us / हमारे बारे में</h2>
                <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full"></div>
            </div>
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Yuva Maitree Foundation is a non-governmental organization dedicated to the upliftment of rural communities, especially women, through community development and empowerment programs.
                </p>
                <p class="text-gray-600 text-lg leading-relaxed">
                    We believe in the power of collective effort. By bringing women together, we help them build savings, access credit, develop skills, and become financially independent — creating a ripple effect of positive change in families and communities.
                </p>
            </div>
        </div>
    </section>

    {{-- Directors & Board Members Section --}}
    @if($directors->count() > 0)
    <section class="py-16 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-4">
                <p class="text-sm font-semibold text-orange-600 tracking-wide uppercase mb-2">OUR LEADERSHIP</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Directors & Board Members</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mb-8">
                    Meet the visionary leaders guiding Yuva Maitree Foundation towards its mission of youth empowerment and social change.
                </p>
                <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-12">
                @foreach($directors as $director)
                <div class="group">
                    {{-- Photo Card --}}
                    <div class="relative overflow-hidden rounded-2xl shadow-lg mb-4 aspect-[3/4]">
                        <img src="{{ asset('storage/' . $director->photo_path) }}" 
                             alt="{{ $director->name }}" 
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    
                    {{-- Info Card --}}
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $director->name }}</h3>
                        <p class="text-sm font-semibold text-orange-600 uppercase tracking-wide mb-3">{{ $director->title }}</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $director->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

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
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Women Empowerment</h3>
                    <p class="text-gray-500">We organize women into community groups, providing training and guidance to help them manage savings, loans, and group finances.</p>
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

    {{-- Upcoming Events Section --}}
    <section id="events" class="py-16 sm:py-20 bg-gradient-to-br from-blue-50 via-white to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Upcoming Events / आगामी कार्यक्रम</h2>
                <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full"></div>
            </div>
            
            @if($upcomingEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($upcomingEvents as $event)
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden">
                    @if($event->event_image)
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $event->event_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        </div>
                    @else
                        <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center gap-2 text-sm text-orange-600 mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-semibold">{{ $event->event_date->format('d M, Y') }}</span>
                            @if($event->event_time)
                                <span>• {{ date('g:i A', strtotime($event->event_time)) }}</span>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $event->title }}</h3>
                        
                        @if($event->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $event->description }}</p>
                        @endif
                        
                        @if($event->location)
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $event->location }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            {{-- No Events Message --}}
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">No Upcoming Events</h3>
                <p class="text-gray-600 text-lg mb-2">कोई आगामी कार्यक्रम नहीं</p>
                <p class="text-gray-500">Check back soon for exciting events and activities!</p>
            </div>
            @endif
        </div>
    </section>

    {{-- Gallery Section --}}
    <section id="gallery" class="py-16 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Gallery / गैलरी</h2>
                <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full"></div>
            </div>
            
            @if($galleryImages->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($galleryImages as $image)
                <div class="group relative aspect-square overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer"
                     onclick="openLightbox('{{ asset('storage/' . $image->image_path) }}', '{{ $image->title }}', '{{ $image->description }}')">
                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                         alt="{{ $image->title }}" 
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    
                    {{-- Overlay with title --}}
                    @if($image->title)
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white font-semibold text-sm">{{ $image->title }}</h3>
                            @if($image->category)
                            <p class="text-orange-300 text-xs mt-1">{{ ucfirst($image->category) }}</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    {{-- Zoom icon --}}
                    <div class="absolute top-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                        </svg>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- View All Button --}}
            <div class="text-center mt-10">
                <a href="{{ route('gallery.public') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition text-lg">
                    View All Gallery
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            @else
            {{-- No Gallery Images Message --}}
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">No Images Yet</h3>
                <p class="text-gray-600 text-lg mb-2">अभी तक कोई छवि नहीं</p>
                <p class="text-gray-500">Check back soon for photos from our activities and events!</p>
            </div>
            @endif
        </div>
    </section>

    {{-- Lightbox Modal --}}
    <div id="lightbox" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4" onclick="closeLightbox()">
        <div class="relative max-w-5xl w-full" onclick="event.stopPropagation()">
            {{-- Close button --}}
            <button onclick="closeLightbox()" class="absolute -top-12 right-0 text-white hover:text-orange-400 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            {{-- Image --}}
            <img id="lightboxImage" src="" alt="" class="w-full h-auto max-h-[80vh] object-contain rounded-lg">
            
            {{-- Caption --}}
            <div id="lightboxCaption" class="mt-4 text-center text-white">
                <h3 id="lightboxTitle" class="text-xl font-semibold mb-2"></h3>
                <p id="lightboxDescription" class="text-gray-300 text-sm"></p>
            </div>
        </div>
    </div>

    <script>
        function openLightbox(imageSrc, title, description) {
            document.getElementById('lightbox').classList.remove('hidden');
            document.getElementById('lightbox').classList.add('flex');
            document.getElementById('lightboxImage').src = imageSrc;
            document.getElementById('lightboxTitle').textContent = title || '';
            document.getElementById('lightboxDescription').textContent = description || '';
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Close lightbox on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    </script>

    {{-- CTA Section --}}
    <section class="py-16 sm:py-20 bg-gradient-to-r from-[#1b6a3c] to-[#1b6a3c]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Join Us in Making a Difference</h2>
            <p class="text-orange-100 text-lg mb-8">हमारे साथ जुड़ें और बदलाव लाएं</p>
           <a href="{{ url('/apply') }}" class="inline-block px-8 py-3 bg-white text-orange-600 font-semibold rounded-lg shadow-lg hover:shadow-xl hover:bg-gray-50 transition text-lg">
                    Become a Staff Member
                </a>
        </div>
    </section>

    {{-- Footer --}}
    <x-public-footer />

</body>
</html>
       