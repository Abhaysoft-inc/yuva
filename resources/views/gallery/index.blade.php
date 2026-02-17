<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gallery Management') }}
            </h2>
            <a href="{{ route('gallery.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Add New Image
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Success Message --}}
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($galleries->count() > 0)
                        <form id="bulkDeleteForm" action="{{ route('gallery.bulk-delete') }}" method="POST" class="mb-4 flex flex-wrap items-center gap-3">
                            @csrf
                            @method('DELETE')
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                                <input type="checkbox" id="selectAllGallery" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                Select All
                            </label>
                            <button type="submit" id="deleteSelectedBtn" disabled class="px-4 py-2 bg-red-600 text-white rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-red-700 transition">
                                Delete Selected
                            </button>
                            <button type="button" id="clearSelectionBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                Clear Selection
                            </button>
                            <span id="selectedCount" class="text-sm text-gray-500">0 selected</span>
                        </form>

                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($galleries as $gallery)
                            <div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition">
                                <div class="absolute z-20 top-2 left-2">
                                    <input type="checkbox" name="gallery_ids[]" form="bulkDeleteForm" value="{{ $gallery->id }}" class="gallery-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>

                                {{-- Image --}}
                                <div class="aspect-square bg-gray-200 relative">
                                    @if($gallery->image_path)
                                        <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                                             alt="{{ $gallery->title }}" 
                                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                    @endif
                                    
                                    {{-- Overlay on Hover --}}
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <div class="flex gap-2">
                                            <a href="{{ route('gallery.edit', $gallery) }}" 
                                               class="px-3 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('gallery.destroy', $gallery) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Status Badge --}}
                                    <div class="absolute top-2 right-2">
                                        @if($gallery->is_active)
                                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Active</span>
                                        @else
                                            <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded-full">Inactive</span>
                                        @endif
                                    </div>

                                    {{-- Order Badge --}}
                                    <div class="absolute top-2 left-11">
                                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full font-bold">{{ $gallery->order }}</span>
                                    </div>

                                    {{-- Category Badge --}}
                                    <div class="absolute bottom-2 left-2">
                                        <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full">{{ $gallery->category }}</span>
                                    </div>
                                </div>

                                {{-- Info --}}
                                @if($gallery->title)
                                <div class="p-3 bg-white">
                                    <h3 class="font-semibold text-sm text-gray-900 truncate">{{ $gallery->title }}</h3>
                                    @if($gallery->description)
                                        <p class="text-xs text-gray-600 truncate">{{ $gallery->description }}</p>
                                    @endif
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No images in gallery</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by uploading your first image.</p>
                            <div class="mt-6">
                                <a href="{{ route('gallery.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    + Add New Image
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const selectAll = document.getElementById('selectAllGallery');
        const checkboxes = Array.from(document.querySelectorAll('.gallery-checkbox'));
        const deleteBtn = document.getElementById('deleteSelectedBtn');
        const clearBtn = document.getElementById('clearSelectionBtn');
        const selectedCount = document.getElementById('selectedCount');
        const bulkForm = document.getElementById('bulkDeleteForm');

        function syncSelectionState() {
            const checkedCount = checkboxes.filter(cb => cb.checked).length;
            const allChecked = checkboxes.length > 0 && checkedCount === checkboxes.length;

            if (selectAll) {
                selectAll.checked = allChecked;
                selectAll.indeterminate = checkedCount > 0 && !allChecked;
            }

            if (deleteBtn) {
                deleteBtn.disabled = checkedCount === 0;
            }

            if (selectedCount) {
                selectedCount.textContent = checkedCount + ' selected';
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                syncSelectionState();
            });
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                checkboxes.forEach(cb => {
                    cb.checked = false;
                });
                if (selectAll) {
                    selectAll.checked = false;
                    selectAll.indeterminate = false;
                }
                syncSelectionState();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', syncSelectionState);
        });

        if (bulkForm) {
            bulkForm.addEventListener('submit', function(e) {
                const checkedCount = checkboxes.filter(cb => cb.checked).length;
                if (checkedCount === 0) {
                    e.preventDefault();
                    return;
                }

                if (!confirm('Are you sure you want to delete ' + checkedCount + ' selected image(s)?')) {
                    e.preventDefault();
                }
            });
        }

        syncSelectionState();
    </script>
</x-app-layout>
