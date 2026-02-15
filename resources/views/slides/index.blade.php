<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Hero Slider Management') }}
            </h2>
            <a href="{{ route('slides.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Add New Slide
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
                    @if($slides->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($slides as $slide)
                            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                                {{-- Image --}}
                                <div class="aspect-video bg-gray-200 relative">
                                    @if($slide->image_path)
                                        <img src="{{ asset('storage/' . $slide->image_path) }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                                    @endif
                                    
                                    {{-- Status Badge --}}
                                    <div class="absolute top-2 right-2">
                                        @if($slide->is_active)
                                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Active</span>
                                        @else
                                            <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded-full">Inactive</span>
                                        @endif
                                    </div>

                                    {{-- Order Badge --}}
                                    <div class="absolute top-2 left-2">
                                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full font-bold">Order: {{ $slide->order }}</span>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg mb-1">{{ $slide->title ?: 'No Title' }}</h3>
                                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($slide->description, 80) }}</p>

                                    {{-- Actions --}}
                                    <div class="flex gap-2">
                                        <a href="{{ route('slides.edit', $slide) }}" class="flex-1 text-center px-3 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('slides.destroy', $slide) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this slide?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-3 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No slides</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new slide.</p>
                            <div class="mt-6">
                                <a href="{{ route('slides.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    + Add New Slide
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
