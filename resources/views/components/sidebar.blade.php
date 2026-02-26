{{-- Admin Sidebar Navigation --}}
@php $sbColor = $sidebarColor ?? '#1e3a8a'; @endphp

<style>
    :root {
        --sidebar-bg: {{ $sbColor }};
    }
    .sidebar-bg { background-color: var(--sidebar-bg); }
    .sidebar-hover:hover { background-color: rgba(255,255,255,0.15); }
    .sidebar-active { background-color: rgba(255,255,255,0.2); }
    .sidebar-divider { border-color: rgba(255,255,255,0.2); }
    [x-cloak] { display: none !important; }
</style>

<div x-data="{ sidebarOpen: false }" class="relative">
    {{-- Mobile Menu Button --}}
    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden fixed top-4 left-4 z-50 p-2 rounded-lg sidebar-bg text-white shadow-lg sidebar-hover transition">
        <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg x-show="sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    {{-- Overlay for mobile --}}
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden">
    </div>

    {{-- Sidebar --}}
    <aside x-show="sidebarOpen" 
           x-transition:enter="transition ease-in-out duration-300 transform"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in-out duration-300 transform"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="w-64 sidebar-bg min-h-screen fixed left-0 top-0 overflow-y-auto z-50 lg:translate-x-0 lg:block"
           style="display: none;"
           x-cloak>
        <div class="p-4">
            {{-- Logo/Brand --}}
            <div class="mb-8 text-center">
                <h2 class="text-white text-xl font-bold">Admin Panel</h2>
                <p class="text-white text-sm opacity-70">Yuva Maitree Foundation</p>
            </div>

            {{-- Navigation Menu --}}
            <nav class="space-y-1">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium text-sm">DASHBOARD</span>
                </a>

                {{-- SHG & Members Management (visible to both admin and staff) --}}
                {{-- Manage SHG --}}
                <a href="{{ route('shgs.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('shgs.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-medium text-sm">MANAGE SHG</span>
                </a>

                @if(auth()->user()->isAdmin())
                {{-- Admin-only sections --}}
                {{-- Staff Management --}}
                <a href="{{ route('staff.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('staff.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="font-medium text-sm">STAFF MANAGEMENT</span>
                </a>

                {{-- Staff Applications --}}
                <a href="{{ route('staff-applications.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('staff-applications.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="font-medium text-sm">STAFF APPLICATIONS</span>
                </a>

                {{-- Upcoming Events --}}
                <a href="{{ route('events.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('events.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">UPCOMING EVENT</span>
                </a>

                {{-- Hero Slider --}}
                <a href="{{ route('slides.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('slides.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">HERO SLIDER</span>
                </a>

                {{-- Directors --}}
                <a href="{{ route('directors.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('directors.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium text-sm">DIRECTORS</span>
                </a>

                {{-- Gallery --}}
                <a href="{{ route('gallery.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('gallery.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">GALLERY</span>
                </a>

                {{-- Donations --}}
                <a href="{{ route('donations.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('donations.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium text-sm">DONATIONS</span>
                </a>

                {{-- Contact Info Settings --}}
                <a href="{{ route('settings.contact') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('settings.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span class="font-medium text-sm">CONTACT INFO</span>
                </a>

                {{-- Appearance Settings --}}
                <a href="{{ route('settings.appearance') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('settings.appearance*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    <span class="font-medium text-sm">APPEARANCE</span>
                </a>
                @endif

                {{-- Divider --}}
                <div class="sidebar-divider border-t my-2"></div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-white hover:bg-red-600 rounded-lg transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-medium text-sm">LOGOUT</span>
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    {{-- Desktop Sidebar (always visible on large screens) --}}
    <aside class="hidden lg:block w-64 sidebar-bg min-h-screen fixed left-0 top-0 overflow-y-auto z-40">
        <div class="p-4">
            {{-- Logo/Brand --}}
            <div class="mb-8 text-center">
                <h2 class="text-white text-xl font-bold">Admin Panel</h2>
                <p class="text-white text-sm opacity-70">Yuva Maitree Foundation</p>
            </div>

            {{-- Navigation Menu --}}
            <nav class="space-y-1">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium text-sm">DASHBOARD</span>
                </a>

                {{-- Manage SHG (visible to both admin and staff) --}}
                <a href="{{ route('shgs.index') }}" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('shgs.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-medium text-sm">MANAGE SHG</span>
                </a>

                @if(auth()->user()->isAdmin())
                {{-- Admin-only sections --}}
                {{-- Staff Management --}}
                <a href="{{ route('staff.index') }}" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('staff.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="font-medium text-sm">STAFF MANAGEMENT</span>
                </a>

                {{-- Staff Applications --}}
                <a href="{{ route('staff-applications.index') }}" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('staff-applications.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="font-medium text-sm">STAFF APPLICATIONS</span>
                </a>

                {{-- Upcoming Events --}}
                <a href="{{ route('events.index') }}" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('events.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">UPCOMING EVENT</span>
                </a>

                {{-- Hero Slider --}}
                <a href="{{ route('slides.index') }}" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('slides.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">HERO SLIDER</span>
                </a>

                {{-- Directors --}}
                <a href="{{ route('directors.index') }}" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('directors.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium text-sm">DIRECTORS</span>
                </a>

                {{-- Gallery --}}
                <a href="{{ route('gallery.index') }}" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('gallery.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">GALLERY</span>
                </a>

                {{-- Donations --}}
                <a href="{{ route('donations.index') }}" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('donations.*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium text-sm">DONATIONS</span>
                </a>

                {{-- Contact Info Settings --}}
                <a href="{{ route('settings.contact') }}" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('settings.contact*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span class="font-medium text-sm">CONTACT INFO</span>
                </a>

                {{-- Appearance Settings --}}
                <a href="{{ route('settings.appearance') }}" class="flex items-center px-4 py-3 text-white sidebar-hover rounded-lg transition {{ request()->routeIs('settings.appearance*') ? 'sidebar-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    <span class="font-medium text-sm">APPEARANCE</span>
                </a>
                @endif

                {{-- Divider --}}
                <div class="sidebar-divider border-t my-2"></div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-white hover:bg-red-600 rounded-lg transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-medium text-sm">LOGOUT</span>
                    </button>
                </form>
            </nav>
        </div>
    </aside>
</div>
