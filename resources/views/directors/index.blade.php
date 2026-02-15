<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Directors & Board Members') }}
            </h2>
            <a href="{{ route('directors.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Add New Director
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
                    @if($directors->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($directors as $director)
                            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                                {{-- Photo --}}
                                <div class="aspect-[3/4] bg-gray-200 relative">
                                    @if($director->photo_path)
                                        <img src="{{ asset('storage/' . $director->photo_path) }}" alt="{{ $director->name }}" class="w-full h-full object-cover">
                                    @endif
                                    
                                    {{-- Status Badge --}}
                                    <div class="absolute top-2 right-2">
                                        @if($director->is_active)
                                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Active</span>
                                        @else
                                            <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded-full">Inactive</span>
                                        @endif
                                    </div>

                                    {{-- Order Badge --}}
                                    <div class="absolute top-2 left-2">
                                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full font-bold">{{ $director->order }}</span>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-1">{{ $director->name }}</h3>
                                    <p class="text-sm text-orange-600 font-semibold mb-2">{{ $director->title }}</p>
                                    <p class="text-gray-600 text-xs mb-4">{{ Str::limit($director->description, 60) }}</p>

                                    {{-- Actions --}}
                                    <div class="flex gap-2">
                                        <a href="{{ route('directors.edit', $director) }}" class="flex-1 text-center px-3 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('directors.destroy', $director) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this director?');">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No directors</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding a new director.</p>
                            <div class="mt-6">
                                <a href="{{ route('directors.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    + Add New Director
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
