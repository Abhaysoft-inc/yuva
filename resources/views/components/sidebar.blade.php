{{-- Admin Sidebar Navigation --}}
<div x-data="{ sidebarOpen: false }" class="relative">
    {{-- Mobile Menu Button --}}
    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden fixed top-4 left-4 z-50 p-2 rounded-lg bg-[#1e3a8a] text-white shadow-lg hover:bg-blue-700 transition">
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
           class="w-64 bg-[#1e3a8a] min-h-screen fixed left-0 top-0 overflow-y-auto z-50 lg:translate-x-0 lg:block"
           style="display: none;"
           x-cloak>
        <div class="p-4">
            {{-- Logo/Brand --}}
            <div class="mb-8 text-center">
                <h2 class="text-white text-xl font-bold">Admin Panel</h2>
                <p class="text-blue-200 text-sm">Yuva Maitree Foundation</p>
            </div>

            {{-- Navigation Menu --}}
            <nav class="space-y-1">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium text-sm">DASHBOARD</span>
                </a>

                {{-- Unverified Members --}}
                <a href="{{ route('members.unverified') }}" @click="sidebarOpen = false" class="flex items-center justify-between px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('members.unverified') ? 'bg-blue-700' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="font-medium text-sm">UNVERIFIED MEMBERS</span>
                    </div>
                    @php
                        $pendingCount = \App\Models\Member::where('verification_status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>

                {{-- Verified Members --}}
                <a href="{{ route('members.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('members.index') || request()->routeIs('members.show') || request()->routeIs('members.edit') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium text-sm">VERIFIED MEMBERS</span>
                </a>

                {{-- Pending SHG --}}
                <a href="{{ route('shgs.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('shgs.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-medium text-sm">MANAGE SHG</span>
                </a>

                {{-- Upcoming Events --}}
                <a href="{{ route('events.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('events.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">UPCOMING EVENT</span>
                </a>

                {{-- Hero Slider --}}
                <a href="{{ route('slides.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('slides.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">HERO SLIDER</span>
                </a>

                {{-- Directors --}}
                <a href="{{ route('directors.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('directors.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium text-sm">DIRECTORS</span>
                </a>

                {{-- Gallery --}}
                <a href="{{ route('gallery.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('gallery.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">GALLERY</span>
                </a>

                {{-- Divider --}}
                <div class="border-t border-blue-600 my-2"></div>

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
    <aside class="hidden lg:block w-64 bg-[#1e3a8a] min-h-screen fixed left-0 top-0 overflow-y-auto z-40">
        <div class="p-4">
            {{-- Logo/Brand --}}
            <div class="mb-8 text-center">
                <h2 class="text-white text-xl font-bold">Admin Panel</h2>
                <p class="text-blue-200 text-sm">Yuva Maitree Foundation</p>
            </div>

            {{-- Navigation Menu --}}
            <nav class="space-y-1">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium text-sm">DASHBOARD</span>
                </a>

                {{-- Unverified Members --}}
                <a href="{{ route('members.unverified') }}" class="flex items-center justify-between px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('members.unverified') ? 'bg-blue-700' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="font-medium text-sm">UNVERIFIED MEMBERS</span>
                    </div>
                    @php
                        $pendingCount = \App\Models\Member::where('verification_status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>

                {{-- Verified Members --}}
                <a href="{{ route('members.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('members.index') || request()->routeIs('members.show') || request()->routeIs('members.edit') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium text-sm">VERIFIED MEMBERS</span>
                </a>

                {{-- Pending SHG --}}
                <a href="{{ route('shgs.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('shgs.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-medium text-sm">MANAGE SHG</span>
                </a>

                {{-- Upcoming Events --}}
                <a href="{{ route('events.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('events.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">UPCOMING EVENT</span>
                </a>

                {{-- Hero Slider --}}
                <a href="{{ route('slides.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('slides.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">HERO SLIDER</span>
                </a>

                {{-- Directors --}}
                <a href="{{ route('directors.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('directors.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium text-sm">DIRECTORS</span>
                </a>

                {{-- Gallery --}}
                <a href="{{ route('gallery.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('gallery.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">GALLERY</span>
                </a>

                {{-- Divider --}}
                <div class="border-t border-blue-600 my-2"></div>

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

<style>
    [x-cloak] { display: none !important; }
</style>
