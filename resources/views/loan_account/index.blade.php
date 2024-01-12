<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loan Account Number') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session()->has('success'))                        
                        <div style="color: green;" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                          <span class="font-medium">Success alert!</span> 
                          {{ session()->get('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="flex p-4 mb-4 text-sm text-asterisk border border-red-300 rounded-lg bg-red-50" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-4 flex justify-end">
                        <form action="{{ route('loan_account.index') }}" method="POST" class="inline">
                            @csrf
                            @method('GET')
                            <input id="search" name="search" type="text" placeholder="Search..">
                            <button id="searchBtn" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" >
                                <span class="flex"><svg class="h-5 w-5 text-white-700"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="10" cy="10" r="7" />  <line x1="21" y1="21" x2="15" y2="15" /></svg>
                                &nbsp;&nbsp;Search</span>
                            </button>
                        </form>
                        @if(Auth::user()->type == 'cashier')
                            <a href="{{ route('loan_account.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 flex">
                                <svg class="h-5 w-5 text-white-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>&nbsp;&nbsp;{{ __('Add') }}
                            </a>
                        @endif
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Society Member</th>
                                    <!-- <th scope="col" class="px-6 py-3">Eligible</th> -->
                                    <th scope="col" class="px-6 py-3">Loan</th>
                                    
                                    <th scope="col" class="px-6 py-3">Paid</th>
                                    <th scope="col" class="px-6 py-3">Balance</th>
                                    <th scope="col" class="px-6 py-3">Int Paid</th>
                                    <th scope="col" class="px-6 py-3">Need Refrence</th>
                                    <th scope="col" class="px-6 py-3">Rate of intrest</th>
                                    <th scope="col" class="px-6 py-3">Start Date</th>
                                    <!-- <th scope="col" class="px-6 py-3">End Date</th> -->
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Action
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            
                            <tbody id="dataListTable">
                                <?php 
                                    $over_all_loan = 0;
                                    $over_all_loandPaid = 0;
                                    $over_all_intPaid = 0;
                                    $over_all_loan = 0;
                                ?>

                                @foreach($results as $data)
                                    @if($data->parent_id == 0)
                                        <?php 
                                            $over_all_loan += $data->full_amount;
                                            $loandPaid = 0;
                                            $intPaid = 0;
                                        ?>
                                        @foreach($loan_paymentsTotal as $paymentData)
                                            @if($paymentData->loan_account_id == $data->id)
                                                <?php 
                                                    $loandPaid = $paymentData->total_paid_amount;
                                                    $intPaid = $paymentData->total_intrest_amount;

                                                    $over_all_loandPaid += $loandPaid;
                                                    $over_all_intPaid += $intPaid;
                                                ?>
                                            @endif
                                        @endforeach
                                        
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                 
                                                <a title="Show the details" href="{{ route('society_member.show', $data->society_member_id) }}" target="_blank" class="inline-flex items-center text-blue-600 hover:underline" href="{{ route('loan_account.show', $data->id) }}">{{ $data->memberName }} [{{ $data->societyCode }}]</a>
                                            </td>
                                           <!--  <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $data->amount }}
                                            </td> -->

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $data->full_amount }}
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$loandPaid}}
                                                
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $data->full_amount - $loandPaid }}
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $intPaid }}
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php
                                                    $needRef = ceil($data->full_amount / $data->amount) - 1;
                                                    if($needRef == 0) {
                                                ?>
                                                   No
                                                <?php
                                                    }else{
                                                ?>
                                                <!-- {{ route('loan_account.edit', $data->id) }} -->
                                                <a target="_new" href="{{ route('loan_account.refrence', $data->id) }}" class="inline-flex items-center text-blue-600 hover:underline"> {{ $needRef }} Member</a>
                                                <?php
                                                    }
                                                ?>
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $data->intrest_rate }}
                                            </td>
                                            
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ carbon\carbon::parse($data->start_date)->format('d-m-Y') }}
                                            </td>
                                            <!-- <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ carbon\carbon::parse($data->end_date)->format('d-m-Y') }}
                                            </td> -->
                                            
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                @if($data->status == 1)
                                                    @php $setStatus = "checked"; @endphp
                                                @elseif($data->status == 0)
                                                    @php $setStatus = ""; @endphp
                                                @endif
                                                <label class="relative inline-flex items-center mb-5">
                                                    <input type="checkbox" value="" class="sr-only peer" {{ $setStatus }} disabled>
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                      <span class="ms-3 text-sm font-medium text-gray-400 dark:text-gray-500"></span>
                                                </label>
                                            </td>

                                            <!-- Action button -->
                                            <td class="px-6 py-4 flex">
                                                @if(Auth::user()->type == 'cashier')
                                                    <!-- Edit icon  -->
                                                    <a href="{{ route('loan_account.edit', $data->id) }}" class="text-blue-600 hover:underline" title="Edit / Update">
                                                        <svg class="h-6 w-6 text-blue-600"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />  <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg>
                                                    </a>&nbsp;&nbsp;
                                                    <!-- Delete icon button  -->
                                                    <form action="{{ route('loan_account.destroy', $data->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button title="Delete this record" onclick="return confirm('Are you sure, you want to delete this item?')" type="submit" class="confirm-button text-red-600 hover:underline">
                                                            <svg class="h-6 w-6 text-blue-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="4" y1="7" x2="20" y2="7" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" />  <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />  <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                        </button>
                                                    </form>&nbsp;&nbsp;
                                                @endif
                                                <!-- Show details button  -->
                                                <a title="show details" href="{{ route('loan_account.show', $data->id) }}"class="text-blue-600 hover:underline">
                                                    <svg class="h-6 w-6 text-blue-600"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="16" x2="12" y2="12" />  <line x1="12" y1="8" x2="12.01" y2="8" /></svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        {{ $results->links() }}
                    </div>


                <!-- Dislplay summary  -->
                <br>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Total Loan</th>
                                    <th scope="col" class="px-6 py-3">Total Paid</th>
                                    <th scope="col" class="px-6 py-3">Ballance</th>
                                    <th scope="col" class="px-6 py-3">Intrest Paid</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$over_all_loan}}
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$over_all_loandPaid}}
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$over_all_loan - $over_all_loandPaid}}
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$over_all_intPaid}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>
    </div>

</x-app-layout>