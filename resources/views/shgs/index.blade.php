<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('SHG Directory / एसएचजी निर्देशिका') }}
            </h2>
            <a href="{{ route('shgs.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + New SHG Registration
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Member Search Bar --}}
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Search Members / सदस्य खोजें</h3>
                    <form method="GET" action="{{ route('shgs.index') }}" class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <input type="text" name="member_search" value="{{ $search ?? '' }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Enter member name or mobile number...">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                                <svg class="w-5 h-5 inline -mt-0.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Search
                            </button>
                            @if($search)
                            <a href="{{ route('shgs.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                                Clear
                            </a>
                            @endif
                        </div>
                    </form>

                    {{-- Search Results --}}
                    @if($search)
                    <div class="mt-4">
                        @if($memberResults->count() > 0)
                        <p class="text-sm text-gray-600 mb-3">Found <strong>{{ $memberResults->count() }}</strong> member(s) matching "<strong>{{ $search }}</strong>"</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-indigo-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-indigo-600 uppercase">#</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-indigo-600 uppercase">Name</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-indigo-600 uppercase">Mobile</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-indigo-600 uppercase">SHG</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-indigo-600 uppercase">Member ID</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-indigo-600 uppercase">Status</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-indigo-600 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($memberResults as $member)
                                    <tr class="hover:bg-indigo-50 transition">
                                        <td class="px-4 py-2 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $member->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $member->mobile ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $member->shg->shg_name ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $member->member_id_code ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $member->verification_status === 'verified' ? 'bg-green-100 text-green-800' : ($member->verification_status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($member->verification_status ?? 'pending') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-sm space-x-2">
                                            @if($member->shg)
                                            <a href="{{ route('shgs.members.show', [$member->shg, $member]) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('shgs.members.edit', [$member->shg, $member]) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <p class="text-gray-500">No members found matching "<strong>{{ $search }}</strong>"</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SHG Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Village</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Members</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Formation Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($shgs as $shg)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration + ($shgs->currentPage() - 1) * $shgs->perPage() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $shg->shg_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $shg->shg_code ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $shg->shg_contact ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $shg->village ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $shg->members_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $shg->date_of_formation ? $shg->date_of_formation->format('d/m/Y') : '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $shg->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($shg->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('shgs.members.index', $shg) }}" class="text-green-600 hover:text-green-900">Manage Members</a>
                                            <a href="{{ route('shgs.show', $shg) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('shgs.edit', $shg) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            <form action="{{ route('shgs.destroy', $shg) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this SHG?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">No SHGs registered yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $shgs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
