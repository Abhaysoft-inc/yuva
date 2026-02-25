<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appearance Settings') }}
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
                    <p class="text-gray-600 text-sm mb-6">Customize the look and feel of the admin panel sidebar.</p>

                    <form action="{{ route('settings.appearance.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Sidebar Color --}}
                        <div>
                            <label for="sidebar_color" class="block text-sm font-medium text-gray-700 mb-2">Sidebar Color</label>
                            <div class="flex items-center gap-4">
                                <input type="color" name="sidebar_color" id="sidebar_color" value="{{ old('sidebar_color', $sidebarColor) }}"
                                       class="w-16 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                                <input type="text" id="sidebar_color_hex" value="{{ old('sidebar_color', $sidebarColor) }}"
                                       class="w-32 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm font-mono"
                                       readonly>
                            </div>
                            @error('sidebar_color')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Preset Colors --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quick Presets</label>
                            <div class="flex flex-wrap gap-3">
                                <button type="button" onclick="setColor('#1e3a8a')" class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition" style="background-color: #1e3a8a;" title="Default Blue"></button>
                                <button type="button" onclick="setColor('#1e40af')" class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition" style="background-color: #1e40af;" title="Blue"></button>
                                <button type="button" onclick="setColor('#1b6a3c')" class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition" style="background-color: #1b6a3c;" title="Green"></button>
                                <button type="button" onclick="setColor('#065f46')" class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition" style="background-color: #065f46;" title="Emerald"></button>
                                <button type="button" onclick="setColor('#7c2d12')" class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition" style="background-color: #7c2d12;" title="Orange"></button>
                                <button type="button" onclick="setColor('#991b1b')" class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition" style="background-color: #991b1b;" title="Red"></button>
                                <button type="button" onclick="setColor('#5b21b6')" class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition" style="background-color: #5b21b6;" title="Purple"></button>
                                <button type="button" onclick="setColor('#1f2937')" class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition" style="background-color: #1f2937;" title="Dark Gray"></button>
                                <button type="button" onclick="setColor('#111827')" class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition" style="background-color: #111827;" title="Near Black"></button>
                                <button type="button" onclick="setColor('#0f766e')" class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition" style="background-color: #0f766e;" title="Teal"></button>
                            </div>
                        </div>

                        {{-- Live Preview --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Live Preview</label>
                            <div class="flex gap-4">
                                <div id="sidebarPreview" class="w-48 h-64 rounded-lg shadow-lg p-4 transition-colors duration-300" style="background-color: {{ $sidebarColor }};">
                                    <div class="text-center mb-4">
                                        <p class="text-white text-sm font-bold">Admin Panel</p>
                                        <p class="text-white text-xs opacity-70">Yuva Maitree</p>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="bg-white bg-opacity-20 rounded px-3 py-2">
                                            <span class="text-white text-xs font-medium">Dashboard</span>
                                        </div>
                                        <div class="rounded px-3 py-2">
                                            <span class="text-white text-xs font-medium opacity-80">Manage SHG</span>
                                        </div>
                                        <div class="rounded px-3 py-2">
                                            <span class="text-white text-xs font-medium opacity-80">Members</span>
                                        </div>
                                        <div class="rounded px-3 py-2">
                                            <span class="text-white text-xs font-medium opacity-80">Events</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition">
                                Save Appearance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const colorPicker = document.getElementById('sidebar_color');
        const hexInput = document.getElementById('sidebar_color_hex');
        const preview = document.getElementById('sidebarPreview');

        colorPicker.addEventListener('input', function () {
            hexInput.value = this.value;
            preview.style.backgroundColor = this.value;
        });

        function setColor(color) {
            colorPicker.value = color;
            hexInput.value = color;
            preview.style.backgroundColor = color;
        }
    </script>
</x-app-layout>
