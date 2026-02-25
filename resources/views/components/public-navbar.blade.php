{{-- Public Navbar Component --}}
<nav id="publicNavbar" class="bg-white fixed top-0 left-0 right-0 z-50 shadow-md transition-transform duration-300 ease-in-out">
    {{-- Top Header --}}
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/logo.webp') }}" alt="Logo" class="h-[80px] w-auto">
                </div>
                
                {{-- Organization Name with Decorative Leaves --}}
                <div class="flex-1 text-center px-4">
                    <div class="flex items-center justify-center gap-3">
                        <div>
                            <h1 class="text-xl sm:text-3xl lg:text-2xl font-extrabold text-gray-900 tracking-wide">
                                YUVA MAITREE FOUNDATION
                            </h1>
                            <p class="text-xs sm:text-xs text-gray-500 mt-1">युवा मैत्री फाउंडेशन</p>
                        </div>
                    </div>
                </div>
                
                {{-- Enquiry Button --}}
                <div class="flex-shrink-0">
                    <a href="#contact" class="px-6 py-2.5 bg-[#1b6a3c] hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-200 text-sm sm:text-base whitespace-nowrap">
                        Enquiry Now
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Green Navigation Menu --}}
    <div class="bg-green-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between overflow-x-auto">
                <div class="flex items-center space-x-1 py-1">
                    {{-- Home --}}
                    <a href="{{ url('/') }}" class="flex items-center gap-1 px-3 py-2 text-white hover:bg-green-700 rounded transition text-sm font-medium whitespace-nowrap">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Home
                    </a>
                    
                    {{-- ID Card Download --}}
                    <a href="{{ route('id-card.download') }}" class="px-3 py-2 text-white hover:bg-green-700 rounded transition text-sm font-medium whitespace-nowrap">
                        ID Card Download
                    </a>
                    
                    {{-- Upcoming Event --}}
                    <a href="{{ url('/#events') }}" class="px-3 py-2 text-white hover:bg-green-700 rounded transition text-sm font-medium whitespace-nowrap">
                        Upcoming Event
                    </a>
                    
                    {{-- Donate --}}
                    <a href="{{ route('donate') }}" class="px-3 py-2 text-white hover:bg-green-700 rounded transition text-sm font-medium whitespace-nowrap">
                        Donate
                    </a>
                    
                    {{-- List of Donors --}}
                    <a href="{{ url('/#donors') }}" class="px-3 py-2 text-white hover:bg-green-700 rounded transition text-sm font-medium whitespace-nowrap">
                        List of Donors
                    </a>
                    
                    {{-- Gallery --}}
                    <a href="{{ route('gallery.public') }}" class="px-3 py-2 text-white hover:bg-green-700 rounded transition text-sm font-medium whitespace-nowrap">
                        Gallery
                    </a>
                    
                    {{-- About Us --}}
                    <a href="{{ route('about') }}" class="px-3 py-2 text-white hover:bg-green-700 rounded transition text-sm font-medium whitespace-nowrap">
                        About Us
                    </a>
                    
                    {{-- Contact Us --}}
                    <a href="{{ route('contact') }}" class="px-3 py-2 text-white hover:bg-green-700 rounded transition text-sm font-medium whitespace-nowrap">
                        Contact Us
                    </a>
                    
                    {{-- Login --}}
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-3 py-2 text-white hover:bg-green-700 rounded transition text-sm font-medium whitespace-nowrap">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-3 py-2 text-white hover:bg-green-700 rounded transition text-sm font-medium whitespace-nowrap">
                                Login
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Navbar hide on scroll down, show on scroll up
    let lastScrollTop = 0;
    const navbar = document.getElementById('publicNavbar');
    let scrollTimeout;

    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        
        scrollTimeout = setTimeout(function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // If at the top of the page, always show navbar
            if (scrollTop <= 0) {
                navbar.style.transform = 'translateY(0)';
                return;
            }
            
            // Scrolling down
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                navbar.style.transform = 'translateY(-100%)';
            } 
            // Scrolling up
            else if (scrollTop < lastScrollTop) {
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        }, 10); // Small delay to improve performance
    });
</script>
