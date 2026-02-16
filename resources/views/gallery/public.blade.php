<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Photo Gallery - Yuva Maitree Foundation</title>
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
<body class="bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    <x-public-navbar />

    {{-- Gallery Header --}}
    <section class="bg-gradient-to-r from-[#1b6a3c] to-green-700 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">Gallery</h1>
                <p class="text-xl text-green-100">गैलरी</p>
                <p class="text-green-100 mt-4 max-w-2xl mx-auto">
                    Glimpses of our journey, events, and activities in empowering communities
                </p>
            </div>
        </div>
    </section>

    {{-- Filter Tabs --}}
    <section class="bg-white border-b top-[140px] z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex overflow-x-auto gap-2 py-4" id="categoryFilter">
                <button onclick="filterGallery('all')" class="filter-btn active px-6 py-2 rounded-full font-semibold whitespace-nowrap transition">
                    All
                </button>
                <button onclick="filterGallery('general')" class="filter-btn px-6 py-2 rounded-full font-semibold whitespace-nowrap transition">
                    General
                </button>
                <button onclick="filterGallery('events')" class="filter-btn px-6 py-2 rounded-full font-semibold whitespace-nowrap transition">
                    Events
                </button>
                <button onclick="filterGallery('activities')" class="filter-btn px-6 py-2 rounded-full font-semibold whitespace-nowrap transition">
                    Activities
                </button>
                <button onclick="filterGallery('members')" class="filter-btn px-6 py-2 rounded-full font-semibold whitespace-nowrap transition">
                    Members
                </button>
                <button onclick="filterGallery('training')" class="filter-btn px-6 py-2 rounded-full font-semibold whitespace-nowrap transition">
                    Training
                </button>
                <button onclick="filterGallery('workshops')" class="filter-btn px-6 py-2 rounded-full font-semibold whitespace-nowrap transition">
                    Workshops
                </button>
            </div>
        </div>
    </section>

    {{-- Gallery Grid --}}
    <section class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($galleryImages->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="galleryGrid">
                @foreach($galleryImages as $image)
                <div class="gallery-item group relative aspect-square overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer" 
                     data-category="{{ $image->category }}"
                     onclick="openLightbox('{{ asset('storage/' . $image->image_path) }}', '{{ addslashes($image->title ?? '') }}', '{{ addslashes($image->description ?? '') }}', '{{ ucfirst($image->category) }}')">
                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                         alt="{{ $image->title }}" 
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    
                    {{-- Overlay with details --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            @if($image->title)
                            <h3 class="text-white font-semibold text-sm mb-1">{{ $image->title }}</h3>
                            @endif
                            <div class="flex items-center gap-2">
                                <span class="text-xs px-2 py-1 bg-orange-500 text-white rounded-full">
                                    {{ ucfirst($image->category) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Zoom icon --}}
                    <div class="absolute top-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                        </svg>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- No results message (hidden by default) --}}
            <div id="noResults" class="hidden text-center py-20">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-3">No Images Found</h3>
                <p class="text-gray-500">Try selecting a different category.</p>
            </div>
            @else
            {{-- Empty Gallery State --}}
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Gallery Coming Soon</h3>
                <p class="text-gray-600 text-lg mb-2">गैलरी जल्द आ रही है</p>
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
                <p id="lightboxDescription" class="text-gray-300 text-sm mb-2"></p>
                <span id="lightboxCategory" class="inline-block px-3 py-1 bg-orange-500 text-white text-xs rounded-full"></span>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <x-public-footer />

    <script>
        // Filter functionality
        let currentFilter = 'all';

        function filterGallery(category) {
            currentFilter = category;
            const items = document.querySelectorAll('.gallery-item');
            const noResults = document.getElementById('noResults');
            let visibleCount = 0;

            items.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0 && items.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }

            // Update active button style
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Lightbox functionality
        function openLightbox(imageSrc, title, description, category) {
            document.getElementById('lightbox').classList.remove('hidden');
            document.getElementById('lightbox').classList.add('flex');
            document.getElementById('lightboxImage').src = imageSrc;
            document.getElementById('lightboxTitle').textContent = title || '';
            document.getElementById('lightboxDescription').textContent = description || '';
            document.getElementById('lightboxCategory').textContent = category || '';
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

    <style>
        .filter-btn {
            background-color: #f3f4f6;
            color: #374151;
        }
        .filter-btn:hover {
            background-color: #e5e7eb;
        }
        .filter-btn.active {
            background-color: #f97316;
            color: white;
        }
    </style>

</body>
</html>
