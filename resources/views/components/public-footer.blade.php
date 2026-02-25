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
                    <li><a href="{{ route('gallery.public') }}" class="hover:text-orange-500 transition">Gallery</a></li>
                    <li><a href="{{ route('apply') }}" class="hover:text-orange-500 transition">Member Apply</a></li>
                    @if (Route::has('login'))
                        <li><a href="{{ route('login') }}" class="hover:text-orange-500 transition">Login</a></li>
                    @endif
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-black mb-4">Contact / संपर्क</h4>
                <ul class="space-y-2 text-sm">
                    <li>Email: {{ $contactInfo['email'] ?? 'info@yuvamaitree.org' }}</li>
                    <li>Phone: {{ $contactInfo['phone'] ?? '' }}</li>
                    <li>Location: {{ $contactInfo['address'] ?? '' }}</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-200 mt-10 pt-6 text-center text-sm">
            <p>&copy; {{ date('Y') }} Yuva Maitree Foundation. All rights reserved.</p>
        </div>
    </div>
</footer>
