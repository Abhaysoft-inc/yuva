<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Access Timing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Success Message --}}
            @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-gray-600 text-sm mb-6">Control when staff members can access their panel. Admins are not affected by these restrictions.</p>

                    <form action="{{ route('settings.staff-timing.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Enable/Disable Toggle --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Timing Restriction</label>
                            <div class="flex items-center gap-4">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="enabled" value="1" {{ old('enabled', $timing['enabled']) === '1' ? 'checked' : '' }}
                                           class="text-blue-600 focus:ring-blue-500" id="timing_enabled">
                                    <span class="text-sm text-gray-700">Enabled</span>
                                </label>
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="enabled" value="0" {{ old('enabled', $timing['enabled']) !== '1' ? 'checked' : '' }}
                                           class="text-blue-600 focus:ring-blue-500" id="timing_disabled">
                                    <span class="text-sm text-gray-700">Disabled</span>
                                </label>
                            </div>
                            <p class="text-gray-400 text-xs mt-1">When disabled, staff can login and access the panel at any time.</p>
                        </div>

                        {{-- Time Fields --}}
                        <div id="timing-fields" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {{-- Opening Time --}}
                            <div>
                                <label for="opening_time" class="block text-sm font-medium text-gray-700 mb-1">Opening Time</label>
                                <input type="time" name="opening_time" id="opening_time"
                                       value="{{ old('opening_time', $timing['opening_time']) }}"
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('opening_time')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-400 text-xs mt-1">Staff can login from this time (IST)</p>
                            </div>

                            {{-- Closing Time --}}
                            <div>
                                <label for="closing_time" class="block text-sm font-medium text-gray-700 mb-1">Closing Time</label>
                                <input type="time" name="closing_time" id="closing_time"
                                       value="{{ old('closing_time', $timing['closing_time']) }}"
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('closing_time')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-400 text-xs mt-1">Staff will be logged out after this time (IST)</p>
                            </div>
                        </div>

                        {{-- Current Status Info --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-blue-800">
                                    <p class="font-semibold mb-1">How it works</p>
                                    <ul class="list-disc list-inside space-y-1 text-blue-700">
                                        <li>Staff members can only login during the allowed timing window</li>
                                        <li>If a staff member tries to access any page outside the allowed time, they will be logged out automatically</li>
                                        <li>Admin users are <strong>not affected</strong> by this restriction</li>
                                        <li>Times are in <strong>IST (Indian Standard Time)</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition">
                                Save Timing Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/hide timing fields based on toggle
        function toggleTimingFields() {
            const enabled = document.getElementById('timing_enabled').checked;
            const fields = document.getElementById('timing-fields');
            fields.style.opacity = enabled ? '1' : '0.5';
            fields.style.pointerEvents = enabled ? 'auto' : 'none';
        }

        document.getElementById('timing_enabled').addEventListener('change', toggleTimingFields);
        document.getElementById('timing_disabled').addEventListener('change', toggleTimingFields);

        // Run on page load
        toggleTimingFields();
    </script>
</x-app-layout>
