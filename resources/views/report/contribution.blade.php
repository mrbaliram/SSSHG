<x-app-layout>

   

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Contribution Report" }}
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
                                    <th scope="col" class="px-6 py-3">Any Loan</th>
                                    <th scope="col" class="px-6 py-3">Amount</th>
                                    <th scope="col" class="px-6 py-3">Late Fine</th>
                                    <th scope="col" class="px-6 py-3">Pay Month</th>                                 
                                    <th scope="col" class="px-6 py-3">Pay Date</th>                                 
                                </tr>
                            </thead>
                             <tbody id="dataListTable">
                                <?php  
                                       $totalContribution = 0;
                                       $totalanyloan = 0;   
                                       $totallate_fine = 0;

                                ?>
                                @foreach($results as $data)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $data->memberName }} [{{ $data->societyName }}]
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <!-- society_member_id -->
                                            <?php
                                                $loanAmount = 0;
                                            ?>
                                            @foreach($societyMembersLoan as $loanData)
                                                @if($loanData->society_member_id == $data->society_member_id)
                                                    <?php 

                                                        $loanAmount = $loanData->total_loan_taken;
                                                        // $loandPaid = $paymentData->total_paid_amount;
                                                        // $intPaid = $paymentData->total_intrest_amount;

                                                        // $over_all_loandPaid += $loandPaid;
                                                        // $over_all_intPaid += $intPaid;
                                                    ?>
                                                    
                                                @endif
                                            @endforeach

                                            {{$loanAmount}}
                                            <?php $totalanyloan += $loanAmount;?>

                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $data->amount }}
                                            <?php $totalContribution += $data->amount;?>
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $data->late_fine }}
                                            <?php $totallate_fine += $data->late_fine;?>
                                        </td>


                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $data->pay_for_month_year }}
                                        </td>

                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ carbon\carbon::parse($data->pay_date)->format('d-m-Y') }}
                                        </td>
                                        
                                    </tr>
                                @endforeach
                                    <tr>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Total Amount </td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalanyloan}} </td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totalContribution}}</td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$totallate_fine}}</td>
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