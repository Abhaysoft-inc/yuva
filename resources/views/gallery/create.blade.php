<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Image to Gallery') }}
            </h2>
            <a href="{{ route('gallery.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                ← Back to Gallery
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Image Upload --}}
                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                                Images * <span class="text-gray-500 text-xs">(You can select multiple images, max 2MB each)</span>
                            </label>
                            <input type="file" name="images[]" id="images" accept="image/*" multiple required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('images') border-red-500 @enderror @error('images.*') border-red-500 @enderror">
                            @error('images')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- Image Preview --}}
                            <div id="imagePreview" class="mt-4 hidden">
                                <p class="text-sm font-medium text-gray-700 mb-2">Selected images preview:</p>
                                <div id="previewGrid" class="grid grid-cols-2 md:grid-cols-4 gap-3"></div>
                            </div>
                        </div>

                        {{-- Title --}}
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Title (Optional)
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description (Optional)
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Category *
                            </label>
                            <select name="category" id="category" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror">
                                <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>General</option>
                                <option value="events" {{ old('category') == 'events' ? 'selected' : '' }}>Events</option>
                                <option value="activities" {{ old('category') == 'activities' ? 'selected' : '' }}>Activities</option>
                                <option value="members" {{ old('category') == 'members' ? 'selected' : '' }}>Members</option>
                                <option value="training" {{ old('category') == 'training' ? 'selected' : '' }}>Training</option>
                                <option value="workshops" {{ old('category') == 'workshops' ? 'selected' : '' }}>Workshops</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Order --}}
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                                Display Order *
                            </label>
                            <input type="number" name="order" id="order" value="{{ old('order', 0) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('order') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Lower numbers appear first (0, 1, 2, 3...)</p>
                            @error('order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Active Status --}}
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                                Active (Display on homepage)
                            </label>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                Add to Gallery
                            </button>
                            <a href="{{ route('gallery.index') }}" class="flex-1 text-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Multi-image preview
        document.getElementById('images').addEventListener('change', function(e) {
            const files = Array.from(e.target.files || []);
            const preview = document.getElementById('imagePreview');
            const grid = document.getElementById('previewGrid');

            grid.innerHTML = '';

            if (!files.length) {
                preview.classList.add('hidden');
                return;
            }

            files.forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'rounded-lg overflow-hidden shadow border border-gray-200 bg-gray-50';

                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.alt = file.name;
                    img.className = 'w-full h-28 object-cover';

                    const name = document.createElement('p');
                    name.className = 'text-xs text-gray-600 p-2 truncate';
                    name.textContent = file.name;

                    wrapper.appendChild(img);
                    wrapper.appendChild(name);
                    grid.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });

            preview.classList.remove('hidden');
        });
    </script>
</x-app-layout>
