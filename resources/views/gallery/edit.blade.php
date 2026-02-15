<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Gallery Image') }}
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
                    {{-- Current Image --}}
                    @if($gallery->image_path)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="max-w-sm h-auto rounded-lg shadow">
                    </div>
                    @endif

                    <form action="{{ route('gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Image Upload --}}
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                Change Image (Optional) <span class="text-gray-500 text-xs">(Recommended: Square images 800x800px)</span>
                            </label>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('image') border-red-500 @enderror">
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- Image Preview --}}
                            <div id="imagePreview" class="mt-4 hidden">
                                <img id="previewImg" src="" alt="Preview" class="max-w-sm h-auto rounded-lg shadow">
                            </div>
                        </div>

                        {{-- Title --}}
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Title (Optional)
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}"
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
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $gallery->description) }}</textarea>
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
                                <option value="general" {{ old('category', $gallery->category) == 'general' ? 'selected' : '' }}>General</option>
                                <option value="events" {{ old('category', $gallery->category) == 'events' ? 'selected' : '' }}>Events</option>
                                <option value="activities" {{ old('category', $gallery->category) == 'activities' ? 'selected' : '' }}>Activities</option>
                                <option value="members" {{ old('category', $gallery->category) == 'members' ? 'selected' : '' }}>Members</option>
                                <option value="training" {{ old('category', $gallery->category) == 'training' ? 'selected' : '' }}>Training</option>
                                <option value="workshops" {{ old('category', $gallery->category) == 'workshops' ? 'selected' : '' }}>Workshops</option>
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
                            <input type="number" name="order" id="order" value="{{ old('order', $gallery->order) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('order') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Lower numbers appear first (0, 1, 2, 3...)</p>
                            @error('order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Active Status --}}
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $gallery->is_active ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                                Active (Display on homepage)
                            </label>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                Update Image
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
        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
