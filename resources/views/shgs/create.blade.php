<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SHG Registration / एसएचजी पंजीकरण') }}
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

                    <form action="{{ route('shgs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- SHG Basic Information --}}
                        <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                            <legend class="text-lg font-semibold text-gray-700 px-2">SHG Basic Information / एसएचजी मूल जानकारी</legend>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="shg_name" value="SHG Name / एसएचजी नाम *" />
                                    <x-text-input id="shg_name" name="shg_name" type="text" class="mt-1 block w-full" :value="old('shg_name')" required />
                                    <x-input-error :messages="$errors->get('shg_name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="shg_code" value="SHG Code / एसएचजी कोड" />
                                    <x-text-input id="shg_code" name="shg_code" type="text" class="mt-1 block w-full" :value="old('shg_code')" placeholder="Auto-generated or manual" />
                                    <x-input-error :messages="$errors->get('shg_code')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="shg_contact" value="SHG Contact No. / संपर्क नंबर" />
                                    <x-text-input id="shg_contact" name="shg_contact" type="text" class="mt-1 block w-full" :value="old('shg_contact')" placeholder="10-digit mobile" />
                                    <x-input-error :messages="$errors->get('shg_contact')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="date_of_formation" value="Date of Formation / गठन की तिथि" />
                                    <x-text-input id="date_of_formation" name="date_of_formation" type="date" class="mt-1 block w-full" :value="old('date_of_formation')" />
                                    <x-input-error :messages="$errors->get('date_of_formation')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="village" value="Village / Gram Panchayat / गांव" />
                                    <x-text-input id="village" name="village" type="text" class="mt-1 block w-full" :value="old('village')" />
                                    <x-input-error :messages="$errors->get('village')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="pincode" value="Pincode / पिनकोड" />
                                    <x-text-input id="pincode" name="pincode" type="text" class="mt-1 block w-full" :value="old('pincode')" />
                                    <x-input-error :messages="$errors->get('pincode')" class="mt-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="address" value="Full Address / पूरा पता" />
                                    <textarea id="address" name="address" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('address') }}</textarea>
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="state" value="State / राज्य" />
                                    <select id="state" name="state" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">-- Select State / राज्य चुनें --</option>
                                        @foreach(['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal'] as $state)
                                            <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="district" value="District / जिला" />
                                    <x-text-input id="district" name="district" type="text" class="mt-1 block w-full" :value="old('district')" placeholder="Enter district name" />
                                    <x-input-error :messages="$errors->get('district')" class="mt-2" />
                                </div>
                            </div>
                        </fieldset>

                        {{-- Officers Details --}}
                        <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                            <legend class="text-lg font-semibold text-gray-700 px-2">Officers Details / अधिकारी विवरण</legend>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="president_name" value="President Name / अध्यक्ष का नाम" />
                                    <x-text-input id="president_name" name="president_name" type="text" class="mt-1 block w-full" :value="old('president_name')" />
                                </div>
                                <div>
                                    <x-input-label for="president_contact" value="President Contact No. / अध्यक्ष संपर्क नं." />
                                    <x-text-input id="president_contact" name="president_contact" type="text" class="mt-1 block w-full" :value="old('president_contact')" />
                                </div>
                                <div>
                                    <x-input-label for="secretary_name" value="Secretary Name / सचिव का नाम" />
                                    <x-text-input id="secretary_name" name="secretary_name" type="text" class="mt-1 block w-full" :value="old('secretary_name')" />
                                </div>
                                <div>
                                    <x-input-label for="secretary_contact" value="Secretary Contact No. / सचिव संपर्क नं." />
                                    <x-text-input id="secretary_contact" name="secretary_contact" type="text" class="mt-1 block w-full" :value="old('secretary_contact')" />
                                </div>
                                <div>
                                    <x-input-label for="treasurer_name" value="Treasurer Name / कोषाध्यक्ष का नाम" />
                                    <x-text-input id="treasurer_name" name="treasurer_name" type="text" class="mt-1 block w-full" :value="old('treasurer_name')" />
                                </div>
                                <div>
                                    <x-input-label for="treasurer_contact" value="Treasurer Contact No. / कोषाध्यक्ष संपर्क नं." />
                                    <x-text-input id="treasurer_contact" name="treasurer_contact" type="text" class="mt-1 block w-full" :value="old('treasurer_contact')" />
                                </div>
                            </div>
                        </fieldset>

                        {{-- Group Documents --}}
                        <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                            <legend class="text-lg font-semibold text-gray-700 px-2">Group Documents / समूह दस्तावेज़</legend>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="meeting_proposal_document" value="Meeting Proposal Document / बैठक प्रस्ताव" />
                                    <input id="meeting_proposal_document" name="meeting_proposal_document" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                    <x-input-error :messages="$errors->get('meeting_proposal_document')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="group_photo" value="Group Photo / समूह फोटो" />
                                    <input id="group_photo" name="group_photo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                    <x-input-error :messages="$errors->get('group_photo')" class="mt-2" />
                                </div>
                            </div>
                        </fieldset>

                        {{-- Bank Details --}}
                        <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                            <legend class="text-lg font-semibold text-gray-700 px-2">Bank Details / बैंक विवरण</legend>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="bank_account_number" value="Bank Account Number / बैंक खाता संख्या" />
                                    <x-text-input id="bank_account_number" name="bank_account_number" type="text" class="mt-1 block w-full" :value="old('bank_account_number')" />
                                </div>
                                <div>
                                    <x-input-label for="bank_name" value="Bank Name / बैंक का नाम" />
                                    <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full" :value="old('bank_name')" />
                                </div>
                                <div>
                                    <x-input-label for="ifsc_code" value="IFSC Code / आईएफएससी कोड" />
                                    <x-text-input id="ifsc_code" name="ifsc_code" type="text" class="mt-1 block w-full" :value="old('ifsc_code')" />
                                </div>
                                <div>
                                    <x-input-label for="branch_name" value="Branch Name / शाखा का नाम" />
                                    <x-text-input id="branch_name" name="branch_name" type="text" class="mt-1 block w-full" :value="old('branch_name')" />
                                </div>
                            </div>
                        </fieldset>

                        {{-- FD & Security --}}
                        <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                            <legend class="text-lg font-semibold text-gray-700 px-2">FD & Security / एफडी और सुरक्षा</legend>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="fd_security_money" value="FD Security Money / एफडी सुरक्षा राशि" />
                                    <x-text-input id="fd_security_money" name="fd_security_money" type="number" step="0.01" class="mt-1 block w-full" :value="old('fd_security_money')" placeholder="₹ Amount" />
                                </div>
                            </div>
                        </fieldset>

                        {{-- Savings & Meetings --}}
                        <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                            <legend class="text-lg font-semibold text-gray-700 px-2">Savings & Meetings / बचत और बैठकें</legend>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="meeting_frequency" value="Meeting Frequency / बैठक आवृत्ति" />
                                    <select id="meeting_frequency" name="meeting_frequency" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="weekly" {{ old('meeting_frequency', 'weekly') == 'weekly' ? 'selected' : '' }}>Weekly / साप्ताहिक</option>
                                        <option value="biweekly" {{ old('meeting_frequency') == 'biweekly' ? 'selected' : '' }}>Biweekly / पाक्षिक</option>
                                        <option value="monthly" {{ old('meeting_frequency') == 'monthly' ? 'selected' : '' }}>Monthly / मासिक</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="monthly_saving_amount" value="Monthly Saving Amount (per member) / मासिक बचत राशि" />
                                    <x-text-input id="monthly_saving_amount" name="monthly_saving_amount" type="number" step="0.01" class="mt-1 block w-full" :value="old('monthly_saving_amount', '100')" placeholder="₹ 100" />
                                </div>
                            </div>
                        </fieldset>

                        {{-- Declaration --}}
                        <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                            <legend class="text-lg font-semibold text-gray-700 px-2">Declaration / घोषणा</legend>

                            <div class="mt-4">
                                <label class="flex items-start gap-3">
                                    <input type="checkbox" name="declaration_accepted" value="1" class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('declaration_accepted') ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-600">
                                        I hereby declare that all the information provided above is true to the best of my knowledge. We agree to abide by the rules and regulations of Yuva Maitree Foundation. /
                                        मैं एतद्द्वारा घोषणा करता/करती हूं कि ऊपर दी गई सभी जानकारी मेरी जानकारी के अनुसार सत्य है। हम युवा मैत्री फाउंडेशन के नियमों का पालन करने के लिए सहमत हैं।
                                    </span>
                                </label>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="signature" value="Digital Signature / Upload Signature / हस्ताक्षर अपलोड" />
                                <input id="signature" name="signature" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                <x-input-error :messages="$errors->get('signature')" class="mt-2" />
                            </div>
                        </fieldset>

                        {{-- Submit --}}
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('shgs.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>
                                {{ __('Submit Registration / पंजीकरण जमा करें') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
