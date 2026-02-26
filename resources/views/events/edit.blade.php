<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Event') }}
            </h2>
            <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                ← Back to Events
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Event Title --}}
                        <div class="mb-6">
                            <x-input-label for="title" value="Event Title *" />
                            <x-text-input 
                                id="title" 
                                name="title" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('title', $event->title)" 
                                required 
                                autofocus
                            />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Description --}}
                        <div class="mb-6">
                            <x-input-label for="description" value="Event Description" />
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="4" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            >{{ old('description', $event->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- Event Date --}}
                            <div>
                                <x-input-label for="event_date" value="Event Date *" />
                                <x-text-input 
                                    id="event_date" 
                                    name="event_date" 
                                    type="text" 
                                    class="mt-1 block w-full date-input" 
                                    placeholder="dd/mm/yyyy"
                                    :value="old('event_date', $event->event_date->format('d/m/Y'))" 
                                    required
                                />
                                <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                            </div>

                            {{-- Event Time --}}
                            <div>
                                <x-input-label for="event_time" value="Event Time" />
                                <x-text-input 
                                    id="event_time" 
                                    name="event_time" 
                                    type="time" 
                                    class="mt-1 block w-full" 
                                    :value="old('event_time', $event->event_time)"
                                />
                                <x-input-error :messages="$errors->get('event_time')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Location --}}
                        <div class="mb-6">
                            <x-input-label for="location" value="Location" />
                            <x-text-input 
                                id="location" 
                                name="location" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('location', $event->location)"
                            />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        {{-- Event Image --}}
                        <div class="mb-6">
                            <x-input-label for="event_image" value="Event Image" />
                            @if($event->event_image)
                                <div class="mt-2 mb-3">
                                    <img src="{{ asset('storage/' . $event->event_image) }}" alt="Current event image" class="w-48 h-32 object-cover rounded">
                                    <p class="text-sm text-gray-500 mt-1">Current image</p>
                                </div>
                            @endif
                            <input 
                                type="file" 
                                id="event_image" 
                                name="event_image" 
                                accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                            />
                            <p class="mt-1 text-sm text-gray-500">Max file size: 2MB. Leave empty to keep current image.</p>
                            <x-input-error :messages="$errors->get('event_image')" class="mt-2" />
                        </div>

                        {{-- Status --}}
                        <div class="mb-6">
                            <x-input-label for="status" value="Status *" />
                            <select 
                                id="status" 
                                name="status" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="upcoming" {{ old('status', $event->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                            <x-primary-button>
                                Update Event
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
