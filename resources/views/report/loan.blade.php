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
                                    <th scope="col" class="px-6 py-3">Start Date</th>
                                </tr>
                            </thead>
                             <tbody id="dataListTable">

                                <?php 

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
                                                 
                                                <a title="Show the details" target="_blank" class="inline-flex items-center text-blue-600 hover:underline" href="{{ route('loan_account.show', $data->id) }}">{{ $data->memberName }} [{{ $data->societyCode }}]</a>
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