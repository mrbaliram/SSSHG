
<x-app-layout>

    <script type="text/javascript">    
        $(document).ready(function(){
             $("#saveBtn").click(function(){ 
                if ($("#society_id").val().trim() == ''){
                     alert('Please select the society');
                     $("#society_id").focus();
                    return false;
                }else if($("#member_id").val().trim()  == ''){
                      alert('Please select the member');
                     $("#member_id").focus();
                    return false;
                }else{
                    return true; 
                }
            });

            // filter society member
            $('#society_id').change(function() {
              
              if($(this).val() != ''){ //loanpaid="" data-intpaid                    
                    //$society_code_branch = parseInt($(this).find('option:selected').attr('data-intpaid'));
                    $("#account_nummber").val($(this).find('option:selected').attr('data-acountnumber'));
                }else{
                    $("#account_nummber").val('');
                }
                
                //$("#paid_amount").val($minAmount); member_id

              var $options = $('#member_id').val('').find('option').show();
              if (this.value != ''){
                 // $options.not('[data-val="' + this.value + '"],[data-val="0"]').hide();
                //$("#member_id option[data-value='" + this.value + "']").hide();

                    $("#member_id option[data-val=" + this.value + "]").hide();


                }
            })

        });
    </script>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Create Society Member' }}
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
                    
                    <form action="{{ route('society_member.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <!-- Society -->
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="society_id" class="block text-gray-600 font-medium">Select Society<span style="color:red"> *</span></label>
                                <select id="society_id" name="society_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <!-- 'societies.code', 'societies.branch_code' -->
                                    <option value="" data-acountnumber="">--Choose one option--</option>
                                    @foreach($societyResults as $societyData)
                                        <option value="{{ $societyData->id }}" data-acountnumber="{{$societyData->code}}-BR00{{$societyData->branch_code}}"> {{ $societyData->name }} [{{ $societyData->code }}]</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Member -->
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="member_id" class="block text-gray-600 font-medium">Select Society<span style="color:red"> *</span></label>
                                <select id="member_id" name="member_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">--Choose one option--</option>
                                    @foreach($memberResults as $memberData)
                                        <option  data-val="{{$memberData->society_id ?? 0}}" value="{{ $memberData->id }}" > {{ $memberData->name }} ({{ $memberData->guardian }}) [{{$memberData->societyCode ?? 'Still not in any Society'}}]</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <!-- Society -->
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="member_type_id" class="block text-gray-600 font-medium">Select Member Type<span style="color:red"> *</span></label>
                                <select id="member_type_id" name="member_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">--Choose one option--</option>
                                    @foreach($memberTypeResults as $memberTypeData)
                                        <option value="{{ $memberTypeData->id }}"   {{   $memberTypeData->code == 'GEN' ? 'Selected' : '' }}> {{ $memberTypeData->name }} [{{ $memberTypeData->code }}]</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Member -->
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="remarks" class="block text-gray-600 font-medium">Remarks</label>
                                <input type="text" name="remarks" id="remarks" value="" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>

                        <!-- date part -->
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="start_date" class="block text-gray-600 font-medium">Start Date<span style="color:red"> *</span></label>
                                <input type="date" name="start_date" id="start_date" value="{{date('Y-m-d')}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>

                            <div class="relative z-0 w-full mb-6 group">
                                <label for="end_date" class="block text-gray-600 font-medium">End Date<span style="color:red"> *</span></label>
                                <input type="date" name="end_date" id="end_date" value="{{date('Y-m-d', strtotime('+5 years'))}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">

                            <div class="relative z-0 w-full mb-6 group">
                                <label for="Your Account Number" class="block text-gray-600 font-medium">Your Account Number</label>
                                <input type="text" name="account_nummber" id="account_nummber" value="" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>

                            <div class="relative z-0 w-full mb-6 group flex">
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
                            
                        </div>

                        <div class="mb-4" align="center">

                            <button id="saveBtn" type="submit" class="px-5 py-2 mr-2 mb-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"> {{ 'Save' }}</button>

                            <a href="{{ route('society_member.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __('Go Back') }}</a>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>