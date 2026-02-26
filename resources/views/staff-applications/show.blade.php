<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Staff Application — {{ $staffApplication->name }}
            </h2>
            <div class="flex space-x-2">
                @if($staffApplication->verification_status === 'verified')
                    <a href="{{ route('staff-applications.id-card', $staffApplication) }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                        ID Card
                    </a>
                @endif

                @if($staffApplication->verification_status === 'pending')
                    <form method="POST" action="{{ route('staff-applications.verify', $staffApplication) }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition" onclick="return confirm('Verify this staff member?')">
                            Verify
                        </button>
                    </form>
                    <form method="POST" action="{{ route('staff-applications.reject', $staffApplication) }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition" onclick="return confirm('Reject this staff member?')">
                            Reject
                        </button>
                    </form>
                @endif

                <a href="{{ route('staff-applications.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Status Badge --}}
                    <div class="mb-6">
                        @if($staffApplication->verification_status === 'verified')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Verified Staff</span>
                        @elseif($staffApplication->verification_status === 'rejected')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                        @else
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending Verification</span>
                        @endif
                    </div>

                    {{-- Photo --}}
                    <div class="flex items-start mb-6">
                        @if($staffApplication->passport_photo)
                            <img src="{{ asset('storage/' . $staffApplication->passport_photo) }}" alt="{{ $staffApplication->name }}" class="w-24 h-24 object-cover rounded-lg border-2 border-gray-200 mr-6">
                        @else
                            <div class="w-24 h-24 bg-indigo-100 rounded-lg flex items-center justify-center mr-6">
                                <span class="text-3xl font-bold text-indigo-600">{{ strtoupper(substr($staffApplication->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $staffApplication->name }}</h3>
                            <p class="text-gray-500">{{ $staffApplication->staff_id_code }}</p>
                            @if($staffApplication->designation)
                                <p class="text-gray-600 mt-1">{{ $staffApplication->designation }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Personal Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="border rounded-lg p-4">
                            <h4 class="font-semibold text-gray-700 mb-3">Personal Information</h4>
                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between"><dt class="text-gray-500">Father/Husband:</dt><dd class="font-medium">{{ $staffApplication->husband_father_name ?? '-' }}</dd></div>
                                <div class="flex justify-between"><dt class="text-gray-500">Date of Birth:</dt><dd class="font-medium">{{ $staffApplication->date_of_birth ? $staffApplication->date_of_birth->format('d/m/Y') : '-' }}</dd></div>
                                <div class="flex justify-between"><dt class="text-gray-500">Blood Group:</dt><dd class="font-medium">{{ $staffApplication->blood_group ?? '-' }}</dd></div>
                                <div class="flex justify-between"><dt class="text-gray-500">Mobile:</dt><dd class="font-medium">{{ $staffApplication->mobile }}</dd></div>
                                <div class="flex justify-between"><dt class="text-gray-500">Email:</dt><dd class="font-medium">{{ $staffApplication->email ?? '-' }}</dd></div>
                                <div class="flex justify-between"><dt class="text-gray-500">Aadhar:</dt><dd class="font-medium">{{ $staffApplication->aadhar_number ?? '-' }}</dd></div>
                                <div class="flex justify-between"><dt class="text-gray-500">PAN:</dt><dd class="font-medium">{{ strtoupper($staffApplication->pan_number ?? '-') }}</dd></div>
                            </dl>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h4 class="font-semibold text-gray-700 mb-3">Bank Details</h4>
                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between"><dt class="text-gray-500">Bank:</dt><dd class="font-medium">{{ $staffApplication->bank_name ?? '-' }}</dd></div>
                                <div class="flex justify-between"><dt class="text-gray-500">Branch:</dt><dd class="font-medium">{{ $staffApplication->branch ?? '-' }}</dd></div>
                                <div class="flex justify-between"><dt class="text-gray-500">Account No.:</dt><dd class="font-medium">{{ $staffApplication->account_number ?? '-' }}</dd></div>
                                <div class="flex justify-between"><dt class="text-gray-500">IFSC Code:</dt><dd class="font-medium">{{ strtoupper($staffApplication->ifsc_code ?? '-') }}</dd></div>
                            </dl>
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="border rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Address</h4>
                        <p class="text-sm text-gray-700">{{ $staffApplication->address ?? '-' }}</p>
                    </div>

                    {{-- Documents --}}
                    <div class="border rounded-lg p-4">
                        <h4 class="font-semibold text-gray-700 mb-3">Uploaded Documents</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach(['passport_photo' => 'Photo', 'aadhar_card_doc' => 'Aadhar Card', 'pan_card_doc' => 'PAN Card', 'bank_passbook_doc' => 'Passbook'] as $field => $label)
                                <div class="text-center">
                                    <p class="text-xs text-gray-500 mb-1">{{ $label }}</p>
                                    @if($staffApplication->$field)
                                        @if(in_array(pathinfo($staffApplication->$field, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                            <img src="{{ asset('storage/' . $staffApplication->$field) }}" class="w-full h-20 object-cover rounded border" alt="{{ $label }}">
                                        @else
                                            <a href="{{ asset('storage/' . $staffApplication->$field) }}" target="_blank" class="text-indigo-600 hover:underline text-xs">View PDF</a>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400">Not uploaded</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
