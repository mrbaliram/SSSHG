<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Loan Report" }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Search Filter heading -->
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <label for="pay_for_month" class="block text-gray-600 font-medium">Month</label>
                        </div>
                        <div>
                            <label for="pay_for_month" class="block text-gray-600 font-medium">Year</label>
                        </div>
                        <div >
                            <label for="pay_for_month" class="block text-gray-600 font-medium">Society</label>
                        </div>
                    </div>
                    <div class="mb-2"></div>
                    <form action="{{ route('reports.loan') }}" method="POST" class="inline">
                            @csrf
                            @method('GET')
                        <div class="grid grid-cols-4 gap-4">
                        
                            <div>
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
                            <div>
                                <select id="pay_for_year" name="pay_for_year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="2023" {{ $currentYear == 2023 ? 'Selected' : '' }}>2023</option>
                                    <option value="2024" {{ $currentYear == 2024 ? 'Selected' : '' }}>2024</option>
                                    <option value="2025" {{ $currentYear == 2025 ? 'Selected' : '' }}>2025</option>
                                    <option value="2026" {{ $currentYear == 2026 ? 'Selected' : '' }}>2026</option>
                                    <option value="2027" {{ $currentYear == 2027 ? 'Selected' : '' }}>2027</option>
                                    <option value="2028" {{ $currentYear == 2028 ? 'Selected' : '' }}>2028</option>
                                </select>
                            </div>
                            <div>
                                <select id="society_id" name="society_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="0" selected>--All--</option>
                                    @foreach($societyResults as $societyData)
                                        <option value="{{ $societyData->id }}" {{ $societyData->id == $searchVal_society_id ? 'Selected' : '' }}> {{ $societyData->name }} [{{ $societyData->code }}]</option>
                                    @endforeach
                                </select>
                            </div>
                            <div align="center">
                                <button id="searchBtn" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" >
                                    <span class="flex"><svg class="h-5 w-5 text-white-700"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="10" cy="10" r="7" />  <line x1="21" y1="21" x2="15" y2="15" /></svg>Search</span>
                                </button>
                            </div>                        
                        </div>
                    </form> 
                    <div class="mb-2"></div>
                    <!-- Display Data -->
                    
                  
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Society Member</th>
                                    <th scope="col" class="px-6 py-3">Loan</th>
                                    <th scope="col" class="px-6 py-3">Paid</th>
                                    <th scope="col" class="px-6 py-3">Balance</th>
                                    <th scope="col" class="px-6 py-3">Int Paid</th>
                                    <th scope="col" class="px-6 py-3">Need Refrence</th>
                                    <th scope="col" class="px-6 py-3">Rate of intrest</th>
                                    <th scope="col" class="px-6 py-3">Month-Year</th>
                                    <th scope="col" class="px-6 py-3">Start Date</th>
                                </tr>
                            </thead>
                             <tbody id="dataListTable">
                                
                                <?php 
                                    

                                    $fiterMonthYear = $currentMoth.'-'.$currentYear;
                                    

                                    $totalLone = 0;
                                    $totalPaid = 0;
                                    $totalBalance= 0;
                                    $totalIntpaid= 0;

                                    $over_all_loan = 0;
                                    $over_all_loandPaid = 0;
                                    $over_all_intPaid = 0;
                                    $over_all_loan = 0;
                                ?>

                                @foreach($results as $data)
                                    <?php

                                        $year = date('Y', strtotime($data->start_date));
                                        $month = date('m', strtotime($data->start_date));
                                        $month_year = $month.'-'.$year;
                                    ?>

                                    @if($data->parent_id == 0 )
                                        <?php 
                                            $over_all_loan += $data->full_amount;
                                            $loandPaid = 0;
                                            $intPaid = 0;

                                            $year = date('Y', strtotime($data->start_date));
                                            $month = date('m', strtotime($data->start_date));
                                            $month_year = $month.'-'.$year;
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
                                                 
                                                <a title="Show the details" target="_blank" class="inline-flex items-center text-blue-600 hover:underline" href="{{ route('society_member.show', $data->society_member_id) }}">{{ $data->memberName }} [{{ $data->societyCode }}]</a>
                                            </td>
                                          
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $data->full_amount }}
                                                <?php $totalLone += $data->full_amount;?>
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$loandPaid}}
                                                 <?php $totalPaid += $loandPaid;?>
                                                
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $data->full_amount - $loandPaid }}
                                                 <?php $totalBalance += $data->full_amount - $loandPaid;?>
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $intPaid }}
                                                 <?php $totalIntpaid += $intPaid;?>
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
                                                <a target="_new" href="{{ route('loan_account.refrence', $data->id) }}" class="inline-flex items-center text-blue-600 hover:underline"> {{ $needRef }} Member</a>
                                                <?php
                                                    }
                                                ?>
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $data->intrest_rate }}
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $month_year }} {{$fiterMonthYear}}
                                            </td>
                                            
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ carbon\carbon::parse($data->start_date)->format('d-m-Y') }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                <tr>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Total Amount </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalLone}}</td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalPaid}}</td>
                                   <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalBalance}}</td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalIntpaid}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr> 
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>