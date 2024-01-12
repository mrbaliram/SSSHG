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

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Society Member</th>
                                    <th scope="col" class="px-6 py-3">Account Number</th>
                                    <th scope="col" class="px-6 py-3">Contribution</th>
                                    <th scope="col" class="px-6 py-3">Loan Refer</th>
                                    <th scope="col" class="px-6 py-3">loan-Amount</th>
                                    <th scope="col" class="px-6 py-3">Loan-Payment</th>
                                    <th scope="col" class="px-6 py-3">Int-Payment</th>
                                    <th scope="col" class="px-6 py-3">Start Date</th>
                                </tr>
                            </thead>
                            
                            <tbody id="dataListTable">
                                <?php
                                    $totalcontribution = 0 ;
                                    $totalLoanamount  = 0;
                                    $totalLoanrefer =0;     
                                    $totalLoanpayment =0;
                                    $totalIntpayment  =0; 

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
                                            {{ $data->memberName }} [{{ $data->societyCode }}]
                                              </a>
                                        </td>
                                        
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $data->account_nummber }}
                                        </td>
                                        
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $data->totalContributionAmount }}
                                            <?php $totalcontribution += $data->totalContributionAmount;?>
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
                                           
                                            <a class="inline-flex items-center text-blue-600 hover:underline" target="_new" href="/loan_account/{{$loanId}}/show" title="Soow the loan details"> {{ $data->totalLoanAmount }} 
                                            <?php $totalLoanamount += $data->totalLoanAmount;?></a>
                                            
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{  $loan_paid }}
                                            <?php $totalLoanpayment += $loan_paid;?>
                                        </td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loanInt_paid }}
                                            <?php $totalIntpayment += $loanInt_paid;?>
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ carbon\carbon::parse($data->start_date)->format('d-m-Y') }}
                                        </td>
                                        
                                    </tr>
                                @endforeach
                                     <tr>                                       
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Total Amount </td>
                                        <td></td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{$totalcontribution}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalLoanrefer}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalLoanamount}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalLoanpayment}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalIntpayment}}</td>
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