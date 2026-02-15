<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Unverified Members') }} — Pending Verification
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Success Message --}}
            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex">
                    <svg class="h-6 w-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            {{-- Members Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($members->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SHG</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobile</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied On</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($members as $member)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $member->member_id_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                        @if($member->husband_father_name)
                                        <div class="text-sm text-gray-500">S/D/W: {{ $member->husband_father_name }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $member->shg->shg_name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $member->mobile ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $member->created_at->format('d M, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        {{-- View Details --}}
                                        <button onclick="showMemberDetails({{ $member->id }})" class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        {{-- Verify --}}
                                        <form method="POST" action="{{ route('members.verify', $member) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Are you sure you want to verify this member?')">
                                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </form>

                                        {{-- Reject --}}
                                        <form method="POST" action="{{ route('members.reject', $member) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to reject this application?')">
                                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Hidden Details Row --}}
                                <tr id="details-{{ $member->id }}" class="hidden bg-gray-50">
                                    <td colspan="6" class="px-6 py-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-2">Personal Information</h4>
                                                <p class="text-sm"><strong>DOB:</strong> {{ $member->date_of_birth ? $member->date_of_birth->format('d M, Y') : 'N/A' }}</p>
                                                <p class="text-sm"><strong>Aadhar:</strong> {{ $member->aadhar_number ?? 'N/A' }}</p>
                                                <p class="text-sm"><strong>PAN:</strong> {{ $member->pan_number ?? 'N/A' }}</p>
                                                <p class="text-sm"><strong>Address:</strong> {{ $member->address ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-2">Bank Information</h4>
                                                <p class="text-sm"><strong>Bank:</strong> {{ $member->bank_name ?? 'N/A' }}</p>
                                                <p class="text-sm"><strong>Branch:</strong> {{ $member->branch ?? 'N/A' }}</p>
                                                <p class="text-sm"><strong>Account:</strong> {{ $member->account_number ?? 'N/A' }}</p>
                                                <p class="text-sm"><strong>IFSC:</strong> {{ $member->ifsc_code ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <h4 class="font-semibold text-gray-900 mb-2">Documents</h4>
                                            <div class="flex gap-4">
                                                @if($member->passport_photo)
                                                <a href="{{ asset('storage/' . $member->passport_photo) }}" target="_blank" class="text-blue-600 hover:underline text-sm">View Photo</a>
                                                @endif
                                                @if($member->aadhar_card_doc)
                                                <a href="{{ asset('storage/' . $member->aadhar_card_doc) }}" target="_blank" class="text-blue-600 hover:underline text-sm">View Aadhar</a>
                                                @endif
                                                @if($member->pan_card_doc)
                                                <a href="{{ asset('storage/' . $member->pan_card_doc) }}" target="_blank" class="text-blue-600 hover:underline text-sm">View PAN</a>
                                                @endif
                                                @if($member->bank_passbook_doc)
                                                <a href="{{ asset('storage/' . $member->bank_passbook_doc) }}" target="_blank" class="text-blue-600 hover:underline text-sm">View Passbook</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $members->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No pending applications</h3>
                        <p class="mt-1 text-sm text-gray-500">All member applications have been verified.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function showMemberDetails(memberId) {
            const detailsRow = document.getElementById('details-' + memberId);
            if (detailsRow.classList.contains('hidden')) {
                detailsRow.classList.remove('hidden');
            } else {
                detailsRow.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
