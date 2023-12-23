
<x-app-layout>

    <script type="text/javascript">    
        $(document).ready(function(){
             $("#saveBtn").click(function(){ 
                if ($("#society_member_id").val().trim() == ''){
                     alert('Please select the society member');
                     $("#society_id").focus();
                    return false;
                }else{
                    return true; 
                }
            });
        });
    </script>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Pay for Society Member' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('error'))
                        <div class="flex p-4 mb-4 text-sm text-asterisk border border-red-300 rounded-lg bg-red-50" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                    <div class="flex p-4 mb-4 text-sm text-asterisk border border-red-300 rounded-lg bg-red-50" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li><b>{{ $error }}</b> can't be blank.</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <form action="{{ route('contribution_payment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="society_member_id" class="block text-gray-600 font-medium">Select Society Member<span style="color:red"> *</span></label>
                                <select id="society_member_id" name="society_member_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">--Choose one option--</option>
                                    @foreach($societyMembersResults as $societyMemberData)
                                        <option value="{{ $societyMemberData->id }}" > {{ $societyMemberData->memberName }} [{{ $societyMemberData->societyName }}]</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="pay_date" class="block text-gray-600 font-medium">Pay Date<span style="color:red"> *</span></label>
                                <input type="date" name="pay_date" id="pay_date" value="{{date('Y-m-d')}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="price" class="block text-gray-600 font-medium">Amount <span id="amount" style="color: green;"></span></label>
                                <input id="amount" type="number" name="amount" value="500" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="late_fine" class="block text-gray-600 font-medium">Late Fine</label>
                                <input id="late_fine" type="number" name="late_fine" value="0" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="pay_for_month" class="block text-gray-600 font-medium">Pay For Month <span id="price" style="color: green;"></span></label>
                                <?php
                                    $dateValue = date('Y-m-d');
                                    $dateArr = explode("-", $dateValue);
                                    $currentYear = $dateArr[0];
                                    $currentMoth = $dateArr[1];
                                   
                                ?>
                                <select id="pay_for_month" name="pay_for_month" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="01" {{ $currentMoth == 1 ? 'Selected' : '' }}>January</option>
                                    <option value="02" {{ $currentMoth == 2 ? 'Selected' : '' }}>February</option>
                                    <option value="03" {{ $currentMoth == 3 ? 'Selected' : '' }}>March</option>
                                    <option value="04" {{ $currentMoth == 4 ? 'Selected' : '' }}>April</option>
                                    <option value="05" {{ $currentMoth == 5 ? 'Selected' : '' }}>May</option>
                                    <option value="06" {{ $currentMoth == 6 ? 'Selected' : '' }}>June</option>
                                    <option value="07" {{ $currentMoth == 7 ? 'Selected' : '' }}>July</option>
                                    <option value="08" {{ $currentMoth == 8 ? 'Selected' : '' }}>August</option>
                                    <option value="09" {{ $currentMoth == 9 ? 'Selected' : '' }}>September</option>
                                    <option value="10" {{ $currentMoth == 10 ? 'Selected' : '' }}>October</option>
                                    <option value="11" {{ $currentMoth == 11 ? 'Selected' : '' }}>November</option>
                                    <option value="12" {{ $currentMoth == 12 ? 'Selected' : '' }}>December</option>
                                </select>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="pay_for_year" class="block text-gray-600 font-medium">Pay For Year <span id="price" style="color: green;"></span></label>
                                <select id="pay_for_year" name="pay_for_year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="2023" {{ $currentYear == 2023 ? 'Selected' : '' }}>2023</option>
                                    <option value="2024" {{ $currentYear == 2024 ? 'Selected' : '' }}>2024</option>
                                    <option value="2025" {{ $currentYear == 2025 ? 'Selected' : '' }}>2025</option>
                                    <option value="2026" {{ $currentYear == 2026 ? 'Selected' : '' }}>2026</option>
                                    <option value="2027" {{ $currentYear == 2027 ? 'Selected' : '' }}>2027</option>
                                    <option value="2028" {{ $currentYear == 2028 ? 'Selected' : '' }}>2028</option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="flex">
                            <div class="flex items-center mr-4">
                                <label class="block text-gray-600 font-medium">Status<span style="color:red"> *</span></label>
                            </div>
                            <div class="flex items-center mr-4">
                                 <input type="radio" name="status" id="active" value="1" checked class="mr-2">
                                 <label for="inactive" class="text-gray-700">Yes</label>
                            </div>
                            <div class="flex items-center mr-4">
                                <input type="radio" name="status" id="inactive" value="0"  class="mr-2">
                                <label for="inactive" class="text-gray-700">No</label>
                            </div>
                        </div>

                        <div class="mb-4" align="center">

                            <button id="saveBtn" type="submit" class="px-5 py-2 mr-2 mb-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"> {{ 'Save' }}</button>

                            <a href="{{ route('contribution_payment.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __('Go Back') }}</a>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>