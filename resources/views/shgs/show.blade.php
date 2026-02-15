<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $shg->shg_name }} — SHG Details
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('shgs.edit', $shg) }}"
                   class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 transition ease-in-out duration-150">
                    Edit
                </a>
                <a href="{{ route('shgs.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 transition ease-in-out duration-150">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Basic Information --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">SHG Basic Information / एसएचजी मूल जानकारी</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-sm text-gray-500">SHG Name</span>
                            <p class="font-medium">{{ $shg->shg_name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">SHG Code</span>
                            <p class="font-medium">{{ $shg->shg_code ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Contact</span>
                            <p class="font-medium">{{ $shg->shg_contact ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Formation Date</span>
                            <p class="font-medium">{{ $shg->date_of_formation ? $shg->date_of_formation->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Village</span>
                            <p class="font-medium">{{ $shg->village ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Pincode</span>
                            <p class="font-medium">{{ $shg->pincode ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">State</span>
                            <p class="font-medium">{{ $shg->state ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">District</span>
                            <p class="font-medium">{{ $shg->district ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-3">
                            <span class="text-sm text-gray-500">Address</span>
                            <p class="font-medium">{{ $shg->address ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Officers Details --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Officers Details / अधिकारी विवरण</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-sm text-gray-500">President</span>
                            <p class="font-medium">{{ $shg->president_name ?? '-' }}</p>
                            <p class="text-sm text-gray-400">{{ $shg->president_contact ?? '' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Secretary</span>
                            <p class="font-medium">{{ $shg->secretary_name ?? '-' }}</p>
                            <p class="text-sm text-gray-400">{{ $shg->secretary_contact ?? '' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Treasurer</span>
                            <p class="font-medium">{{ $shg->treasurer_name ?? '-' }}</p>
                            <p class="text-sm text-gray-400">{{ $shg->treasurer_contact ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bank Details --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Bank Details / बैंक विवरण</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm text-gray-500">Account Number</span>
                            <p class="font-medium">{{ $shg->bank_account_number ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Bank Name</span>
                            <p class="font-medium">{{ $shg->bank_name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">IFSC Code</span>
                            <p class="font-medium">{{ $shg->ifsc_code ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Branch</span>
                            <p class="font-medium">{{ $shg->branch_name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FD, Savings & Meetings --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">FD, Savings & Meetings / एफडी, बचत और बैठकें</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-sm text-gray-500">FD Security Money</span>
                            <p class="font-medium">₹ {{ $shg->fd_security_money ?? '0.00' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Meeting Frequency</span>
                            <p class="font-medium">{{ ucfirst($shg->meeting_frequency) }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Monthly Saving (per member)</span>
                            <p class="font-medium">₹ {{ $shg->monthly_saving_amount ?? '100.00' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Group Documents --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Group Documents / समूह दस्तावेज़</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-sm text-gray-500">Meeting Proposal</span>
                            @if($shg->meeting_proposal_document)
                                <a href="{{ asset('storage/' . $shg->meeting_proposal_document) }}" target="_blank" class="text-indigo-600 hover:underline block">View Document</a>
                            @else
                                <p class="text-gray-400">Not uploaded</p>
                            @endif
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Group Photo</span>
                            @if($shg->group_photo)
                                <img src="{{ asset('storage/' . $shg->group_photo) }}" alt="Group Photo" class="mt-1 w-32 h-32 object-cover rounded-lg border">
                            @else
                                <p class="text-gray-400">Not uploaded</p>
                            @endif
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Signature</span>
                            @if($shg->signature)
                                <a href="{{ asset('storage/' . $shg->signature) }}" target="_blank" class="text-indigo-600 hover:underline block">View Signature</a>
                            @else
                                <p class="text-gray-400">Not uploaded</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Members --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center border-b pb-2 mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Members / सदस्य ({{ $shg->members->count() }})</h3>
                        <a href="{{ route('shgs.members.index', $shg) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150">
                            Manage Members
                        </a>
                    </div>

                    @if($shg->members->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Member ID</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mobile</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aadhaar</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($shg->members as $member)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $member->member_id_code ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $member->name }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ ucfirst($member->role) }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $member->mobile ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $member->aadhar_number ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No members added yet.</p>
                    @endif
                </div>
            </div>

            {{-- Status --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500">Status:</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $shg->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($shg->status) }}
                        </span>
                        <span class="text-sm text-gray-500 ml-4">Declaration:</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $shg->declaration_accepted ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $shg->declaration_accepted ? 'Accepted' : 'Not Accepted' }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
