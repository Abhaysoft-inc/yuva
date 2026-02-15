<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('shgs.index') }}" class="text-indigo-600 hover:underline">SHG Directory</a>
            &raquo;
            <a href="{{ route('shgs.show', $shg) }}" class="text-indigo-600 hover:underline">{{ $shg->shg_name }}</a>
            &raquo;
            <a href="{{ route('shgs.members.index', $shg) }}" class="text-indigo-600 hover:underline">Members</a>
            &raquo; Add New Member
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('shgs.members.store', $shg) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- SHG Info & Membership ID --}}
                        <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                            <legend class="text-lg font-semibold text-gray-700 px-2">SHG: {{ $shg->shg_name }} ({{ $shg->shg_code ?? 'N/A' }})</legend>
                            <div class="mt-4">
                                <p class="text-sm text-gray-500">Membership ID will be <strong>auto-generated</strong> on save.</p>
                            </div>
                        </fieldset>

                        {{-- Personal Information --}}
                        <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                            <legend class="text-lg font-semibold text-gray-700 px-2">Personal Information / व्यक्तिगत जानकारी</legend>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="name" value="Member Name / सदस्य का नाम *" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required placeholder="Full Name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="husband_father_name" value="Husband/Father Name / पति/पिता का नाम" />
                                    <x-text-input id="husband_father_name" name="husband_father_name" type="text" class="mt-1 block w-full" :value="old('husband_father_name')" />
                                    <x-input-error :messages="$errors->get('husband_father_name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="role" value="Role / भूमिका" />
                                    <select id="role" name="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="member" {{ old('role', 'member') == 'member' ? 'selected' : '' }}>Member / सदस्य</option>
                                        <option value="president" {{ old('role') == 'president' ? 'selected' : '' }}>President / अध्यक्ष</option>
                                        <option value="secretary" {{ old('role') == 'secretary' ? 'selected' : '' }}>Secretary / सचिव</option>
                                        <option value="treasurer" {{ old('role') == 'treasurer' ? 'selected' : '' }}>Treasurer / कोषाध्यक्ष</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="date_of_birth" value="Date of Birth / जन्म तिथि" />
                                    <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth')" />
                                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="mobile" value="Mobile Number / मोबाइल नंबर" />
                                    <x-text-input id="mobile" name="mobile" type="text" class="mt-1 block w-full" :value="old('mobile')" placeholder="10-digit Mobile" />
                                    <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="aadhar_number" value="Aadhaar Number / आधार नंबर" />
                                    <x-text-input id="aadhar_number" name="aadhar_number" type="text" class="mt-1 block w-full" :value="old('aadhar_number')" placeholder="12-digit Aadhaar" maxlength="12" />
                                    <x-input-error :messages="$errors->get('aadhar_number')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="pan_number" value="PAN Card Number / पैन कार्ड नंबर" />
                                    <x-text-input id="pan_number" name="pan_number" type="text" class="mt-1 block w-full" :value="old('pan_number')" placeholder="10-character PAN" maxlength="10" />
                                    <x-input-error :messages="$errors->get('pan_number')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="blood_group" value="Blood Group / रक्त समूह" />
                                    <select id="blood_group" name="blood_group" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">-- Select --</option>
                                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                            <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('blood_group')" class="mt-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="address" value="Full Address / पूरा पता" />
                                    <textarea id="address" name="address" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Full Address">{{ old('address') }}</textarea>
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                            </div>
                        </fieldset>

                        {{-- Bank Details --}}
                        <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                            <legend class="text-lg font-semibold text-gray-700 px-2">Bank Details / बैंक विवरण</legend>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="bank_name" value="Bank Name / बैंक का नाम" />
                                    <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full" :value="old('bank_name')" />
                                </div>
                                <div>
                                    <x-input-label for="branch" value="Branch / शाखा" />
                                    <x-text-input id="branch" name="branch" type="text" class="mt-1 block w-full" :value="old('branch')" />
                                </div>
                                <div>
                                    <x-input-label for="account_number" value="Account Number / खाता नंबर" />
                                    <x-text-input id="account_number" name="account_number" type="text" class="mt-1 block w-full" :value="old('account_number')" />
                                </div>
                                <div>
                                    <x-input-label for="ifsc_code" value="IFSC Code / आईएफएससी कोड" />
                                    <x-text-input id="ifsc_code" name="ifsc_code" type="text" class="mt-1 block w-full" :value="old('ifsc_code')" />
                                </div>
                            </div>
                        </fieldset>

                        {{-- Member Documents --}}
                        <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                            <legend class="text-lg font-semibold text-gray-700 px-2">Member Documents / सदस्य दस्तावेज़</legend>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="passport_photo" value="Passport Photo / पासपोर्ट फोटो" />
                                    <input id="passport_photo" name="passport_photo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                    <x-input-error :messages="$errors->get('passport_photo')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="aadhar_card_doc" value="Aadhaar Card / आधार कार्ड" />
                                    <input id="aadhar_card_doc" name="aadhar_card_doc" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                    <x-input-error :messages="$errors->get('aadhar_card_doc')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="pan_card_doc" value="PAN Card / पैन कार्ड" />
                                    <input id="pan_card_doc" name="pan_card_doc" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                    <x-input-error :messages="$errors->get('pan_card_doc')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="bank_passbook_doc" value="Bank Passbook / बैंक पासबुक" />
                                    <input id="bank_passbook_doc" name="bank_passbook_doc" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                    <x-input-error :messages="$errors->get('bank_passbook_doc')" class="mt-2" />
                                </div>
                            </div>
                        </fieldset>

                        {{-- Submit --}}
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('shgs.members.index', $shg) }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>
                                {{ __('Save Member / सदस्य सहेजें') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
