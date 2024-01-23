<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Member Report" }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('reports.member') }}" method="POST" class="inline">
                        @csrf
                        @method('GET')

                        <div class="flex mb-4 text-right">
                            <div  class="w-1/3 h-12 flex items-center text-right">
                                <label for="pay_for_month" class="block text-gray-600 font-medium">Select Sociedty</label>
                            </div>
                            <div class="w-1/3  h-12">                               
                                <select id="society_id" name="society_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="0" selected>--All--</option>
                                    @foreach($societyResults as $societyData)
                                        <option value="{{ $societyData->id }}" {{ $societyData->id == $searchVal_society_id ? 'Selected' : '' }}> {{ $societyData->name }} [{{ $societyData->code }}]</option>
                                    @endforeach
                                </select>
                            </div>&nbsp;&nbsp;&nbsp;
                            <div class="w-1/3 h-12">
                                <button id="searchBtn" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" >
                                    <span class="flex"><svg class="h-5 w-5 text-white-700"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="10" cy="10" r="7" />  <line x1="21" y1="21" x2="15" y2="15" /></svg>Search</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                        
                    
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Society Member</th>
                                    <th scope="col" class="px-6 py-3">Amount</th>
                                    <th scope="col" class="px-6 py-3">Late Fine</th>                              
                                    <th scope="col" class="px-6 py-3">Refered</th>
                                    <th scope="col" class="px-6 py-3">Amount & Refer Members</th>
                                    <th scope="col" class="px-6 py-3">Loan-Payment</th>
                                    <th scope="col" class="px-6 py-3">Loan Int Payment</th>
                                    <th scope="col" class="px-6 py-3">Loan Ballance</th>
                                    <th scope="col" class="px-6 py-3">Start Date</th>
                                </tr>
                            </thead>
                            
                            <tbody id="dataListTable">
                                <?php
                                    $totalcontribution  = 0;
                                    $totalLoanamount    = 0;
                                    $totalLoanrefer     = 0;     
                                    $totalLoanpayment   = 0;
                                    $totalIntpayment    = 0; 
                                    $totalLateFine      = 0; 
                                    $totalLoanBallance  = 0;
                                ?>

                                @foreach($results as $data)
                                    

                                    <?php 
                                        $soMe_loan = $memberLoanAccount_arr[$data->id] ?? 0;
                                        $loan_paid = $laonPay_member_arr[$data->id] ?? 0;
                                        $loanInt_paid = $laonIntPay_member_arr[$data->id] ?? 0;
                                        $loanId = $laon_account_id_arr[$data->id] ?? 0;
                                    ?>

                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" id="row_id_{{$data->id}}">
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <a title="Show the details" target="_blank" class="inline-flex items-center text-blue-600 hover:underline" href="{{ route('society_member.show', $data->id) }}">
                                                {{ $data->memberName }}  ({{ $data->account_nummber }})
                                            </a>
                                        </td>
                                      
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ round($data->totalContributionAmount, 0) }}
                                            <?php $totalcontribution += $data->totalContributionAmount;?>
                                        </td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ round($data->total_late_fine_amount, 0) }}
                                            <?php $totalLateFine += $data->total_late_fine_amount;?>
                                        </td>
                                        
                                        <!-- loan_account/1/refrence -->
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                             @if($data->loanRefered > 0)
                                            <a class="inline-flex items-center text-blue-600 hover:underline" target="_new" href="/loan_account/{{$data->loanReferedAccountId}}/refrence" title="Soow the loan details"> 
                                            {{ $data->loanRefered ?? 0}}
                                            <?php $totalLoanrefer += $data->loanRefered;?>

                                             </a>
                                             @endif
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           
                                            <a class="inline-flex items-center text-blue-600 hover:underline" target="_new" href="/loan_account/{{$loanId}}/show" title="Soow the loan details"> 
                                                {{ $data->totalLoanAmount }} @if($data->loanReferedCount >0 )({{$data->loanReferedCount}}) @endif
                                                <?php $totalLoanamount += $data->totalLoanAmount;?>
                                            </a>
                                            
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{  round($loan_paid,0)}}
                                            <?php $totalLoanpayment += $loan_paid;?>
                                        </td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ round($loanInt_paid,0) }}
                                            <?php $totalIntpayment += $loanInt_paid;?>
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            
                                            <?php 
                                                $loanBallance = $data->totalLoanAmount - $loan_paid;
                                                $totalLoanBallance += $loanBallance;
                                            ?>
                                            {{ $loanBallance }}
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ carbon\carbon::parse($data->start_date)->format('d-m-Y') }}
                                        </td>
                                        
                                    </tr>
                                @endforeach
                                     <tr>                                       
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Total Amount </td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{$totalcontribution}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{$totalLateFine}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalLoanrefer}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalLoanamount}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalLoanpayment}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalIntpayment}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalLoanBallance}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"></td>                              
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>