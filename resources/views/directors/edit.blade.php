<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Director') }}
            </h2>
            <a href="{{ route('directors.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                ← Back to Directors
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Current Photo --}}
                    @if($director->photo_path)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Photo</label>
                        <img src="{{ asset('storage/' . $director->photo_path) }}" alt="{{ $director->name }}" class="max-w-xs h-auto rounded-lg shadow">
                    </div>
                    @endif

                    <form action="{{ route('directors.update', $director) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Photo Upload --}}
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Change Photo (Optional) <span class="text-gray-500 text-xs">(Recommended: 400x500px portrait)</span>
                            </label>
                            <input type="file" name="photo" id="photo" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('photo') border-red-500 @enderror">
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- Image Preview --}}
                            <div id="imagePreview" class="mt-4 hidden">
                                <img id="previewImg" src="" alt="Preview" class="max-w-xs h-auto rounded-lg shadow">
                            </div>
                        </div>

                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Name *
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $director->name) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Title --}}
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Title/Position *
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $director->title) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description *
                            </label>
                            <textarea name="description" id="description" rows="4" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $director->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Order --}}
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                                Display Order *
                            </label>
                            <input type="number" name="order" id="order" value="{{ old('order', $director->order) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('order') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Lower numbers appear first (0, 1, 2, 3...)</p>
                            @error('order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Active Status --}}
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $director->is_active ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                                Active (Display on homepage)
                            </label>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                Update Director
                            </button>
                            <a href="{{ route('directors.index') }}" class="flex-1 text-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
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
        document.getElementById('photo').addEventListener('change', function(e) {
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
