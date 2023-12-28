<x-app-layout>

    <script type="text/javascript">    
        $(document).ready(function(){
             $("#saveBtn").click(function(){ 
                if ($("#society_member_id").val().trim() == ''){
                     alert('Please select the society member');
                     $("#society_member_id").focus();
                    return false;
                }
            });
        });
    </script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Add / Update Loan refrence' }}
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
                    
                    <!-- Show the main info -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Society Member</th>
                                    <th scope="col" class="px-6 py-3">Eligible Amount</th>
                                    <th scope="col" class="px-6 py-3">Full Amount</th>
                                    <th scope="col" class="px-6 py-3">Extra Amount</th>
                                    <th scope="col" class="px-6 py-3">Need Refrence</th>
                                    <th scope="col" class="px-6 py-3">Rate of intrest</th>
                                    <th scope="col" class="px-6 py-3">Start Date</th>
                                    
                                </tr>
                            </thead>
                            
                            <tbody id="dataListTable">
                               
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{$results->memberName}}
                                        </td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{$results->amount}}
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{$results->full_amount}}
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <?php $extraAmount = $results->full_amount - $results->amount;?>
                                           {{$extraAmount / 2}}
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           <?php
                                                $needRef = ceil($results->full_amount / $results->amount) - 1;
                                                if($needRef == 0) {
                                            ?>
                                               No need Refrence
                                            <?php
                                                }else{
                                            ?>
                                           Need {{ $needRef }} Refrence
                                            <?php
                                                }
                                            ?>
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{$results->intrest_rate}}
                                        </td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{date('Y-m-d', strtotime($results->end_date))}}
                                        </td>
                                        
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <form action="{{ route('loan_account.update', $results->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 
                        <br><br>
                        <!-- society and society member need to select -->
                        <?php
                            for($i = 1; $i <= 2; $i++){
                                ?>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <label for="society_member_id" class="block text-gray-600 font-medium">Select Society Main Member<span style="color:red"> *</span></label>
                                            <select id="society_member_id" name="society_member_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                <option data-val="0" value="0">Select one Member </option>
                                                @foreach($societyMembersResults as $societyMemberData)
                                                    <option data-val="{{$societyMemberData->society_id}}" value="{{ $societyMemberData->id }}"> {{ $societyMemberData->memberName }} [{{ $societyMemberData->societyName }}]</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- society_member -->
                                       <div class="relative z-0 w-full mb-6 group">
                                            <label for="amount" class="block text-gray-600 font-medium">Amount <span id="amount" style="color: green;"></span></label>
                                            <input id="full_amount" type="text" name="full_amount" value="{{$extraAmount / 2}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                                        </div>
                                    </div>
                                <?php 
                            }
                        ?>
                        <br>
                        <div class="mb-4" align="center">

                            <button id="saveBtn" type="submit" class="px-5 py-2 mr-2 mb-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"> {{ 'Update' }}</button>

                            <a href="{{ route('loan_account.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __('Go Back') }}</a>
                            
                        </div>
                    </form>
                </div>
                 
            </div>
        </div>
    </div>
</x-app-layout>