<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Details - NGO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <x-sidebar />

    <div class="lg:ml-64 min-h-screen">
        <div class="p-8">
            {{-- Header Section --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <a href="{{ route('staff.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Staff Details</h1>
                            <p class="text-gray-600 mt-1">View staff member information</p>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('staff.edit', $staff) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Edit
                        </a>
                        @if($staff->role !== 'admin')
                        <form action="{{ route('staff.destroy', $staff) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Delete
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
            @endif

            {{-- Staff Details Card --}}
            <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
                <div class="space-y-6">
                    {{-- ID --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Staff ID</label>
                        <p class="text-lg text-gray-900">{{ $staff->id }}</p>
                    </div>

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                        <p class="text-lg text-gray-900">{{ $staff->name }}</p>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                        <p class="text-lg text-gray-900">{{ $staff->email }}</p>
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Role</label>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            {{ $staff->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($staff->role) }}
                        </span>
                        <p class="text-sm text-gray-500 mt-2">
                            @if($staff->role === 'admin')
                            Admin has full access to all sections of the admin panel.
                            @else
                            Staff can manage SHG registration and SHG members only.
                            @endif
                        </p>
                    </div>

                    {{-- Joined Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Joined Date</label>
                        <p class="text-lg text-gray-900">{{ $staff->created_at->format('F d, Y') }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $staff->created_at->diffForHumans() }}</p>
                    </div>

                    {{-- Last Updated --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                        <p class="text-lg text-gray-900">{{ $staff->updated_at->format('F d, Y') }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $staff->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
