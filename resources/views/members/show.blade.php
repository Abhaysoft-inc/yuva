<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('shgs.index') }}" class="text-indigo-600 hover:underline">SHG Directory</a>
                &raquo;
                <a href="{{ route('shgs.show', $shg) }}" class="text-indigo-600 hover:underline">{{ $shg->shg_name }}</a>
                &raquo;
                <a href="{{ route('shgs.members.index', $shg) }}" class="text-indigo-600 hover:underline">Members</a>
                &raquo; {{ $member->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('shgs.members.membership-form', [$shg, $member]) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150">
                    Form
                </a>
                <a href="{{ route('shgs.members.edit', [$shg, $member]) }}"
                   class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 transition ease-in-out duration-150">
                    Edit
                </a>
                <a href="{{ route('shgs.members.index', $shg) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 transition ease-in-out duration-150">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Personal Information --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Personal Information / व्यक्तिगत जानकारी</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        {{-- Photo --}}
                        <div class="md:row-span-3 flex justify-center">
                            @if($member->passport_photo)
                                <img src="{{ asset('storage/' . $member->passport_photo) }}" alt="Photo" class="w-32 h-40 object-cover rounded-lg border shadow">
                            @else
                                <div class="w-32 h-40 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400 text-3xl font-bold border">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Member Name</span>
                            <p class="font-medium">{{ $member->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Member ID</span>
                            <p class="font-medium">{{ $member->member_id_code ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">SHG</span>
                            <p class="font-medium">
                                @if($member->shg)
                                    <a href="{{ route('shgs.show', $member->shg) }}" class="text-indigo-600 hover:underline">{{ $member->shg->shg_name }}</a>
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Husband/Father Name</span>
                            <p class="font-medium">{{ $member->husband_father_name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Role</span>
                            <p class="font-medium">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $member->role === 'president' ? 'bg-purple-100 text-purple-800' :
                                       ($member->role === 'secretary' ? 'bg-blue-100 text-blue-800' :
                                       ($member->role === 'treasurer' ? 'bg-yellow-100 text-yellow-800' :
                                       'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($member->role) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Status</span>
                            <p class="font-medium">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $member->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Date of Birth</span>
                            <p class="font-medium">{{ $member->date_of_birth ? $member->date_of_birth->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Age</span>
                            <p class="font-medium">{{ $member->age ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Mobile</span>
                            <p class="font-medium">{{ $member->mobile ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Aadhaar Number</span>
                            <p class="font-medium">{{ $member->aadhar_number ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">PAN Number</span>
                            <p class="font-medium">{{ $member->pan_number ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Blood Group</span>
                            <p class="font-medium">{{ $member->blood_group ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-3">
                            <span class="text-sm text-gray-500">Address</span>
                            <p class="font-medium">{{ $member->address ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Valid From</span>
                            <p class="font-medium">{{ $member->valid_from ? $member->valid_from->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Valid To</span>
                            <p class="font-medium">{{ $member->valid_to ? $member->valid_to->format('d/m/Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bank Details --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Bank Details / बैंक विवरण</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <span class="text-sm text-gray-500">Bank Name</span>
                            <p class="font-medium">{{ $member->bank_name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Branch</span>
                            <p class="font-medium">{{ $member->branch ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Account Number</span>
                            <p class="font-medium">{{ $member->account_number ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">IFSC Code</span>
                            <p class="font-medium">{{ $member->ifsc_code ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Documents --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Member Documents / सदस्य दस्तावेज़</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <span class="text-sm text-gray-500">Passport Photo</span>
                            @if($member->passport_photo)
                                <a href="{{ asset('storage/' . $member->passport_photo) }}" target="_blank" class="text-indigo-600 hover:underline block mt-1">View Photo</a>
                            @else
                                <p class="text-gray-400 mt-1">Not uploaded</p>
                            @endif
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Aadhaar Card</span>
                            @if($member->aadhar_card_doc)
                                <a href="{{ asset('storage/' . $member->aadhar_card_doc) }}" target="_blank" class="text-indigo-600 hover:underline block mt-1">View Document</a>
                            @else
                                <p class="text-gray-400 mt-1">Not uploaded</p>
                            @endif
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">PAN Card</span>
                            @if($member->pan_card_doc)
                                <a href="{{ asset('storage/' . $member->pan_card_doc) }}" target="_blank" class="text-indigo-600 hover:underline block mt-1">View Document</a>
                            @else
                                <p class="text-gray-400 mt-1">Not uploaded</p>
                            @endif
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Bank Passbook</span>
                            @if($member->bank_passbook_doc)
                                <a href="{{ asset('storage/' . $member->bank_passbook_doc) }}" target="_blank" class="text-indigo-600 hover:underline block mt-1">View Document</a>
                            @else
                                <p class="text-gray-400 mt-1">Not uploaded</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
