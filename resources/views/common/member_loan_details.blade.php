<!-- Show the main info -->
<div class="mb-4">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ 'Your Loans' }}
    </h2>
    <div class="mb-2"></div>
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
                           {{$extraAmount}}
                        </td>

                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           <?php
                                $needRef = ceil($extraAmount / $results->amount);
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
</div>

<!-- payment histrory -->
<div class="mb-4"></div>
<div class="mb-4">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ 'Payment History' }}
    </h2>
    <div class="mb-2"></div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Society Member</th>
                    <th scope="col" class="px-6 py-3">Paid Amount</th>
                    <th scope="col" class="px-6 py-3">Intrest Amount</th>
                    
                    <th scope="col" class="px-6 py-3">Pay Date</th>
                    
                </tr>
            </thead>
            
            <tbody id="dataListTable">
                @foreach($loan_paymentsResults as $data)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $data->memberName }} [{{ $data->societyName }}]
                        </td>

                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $data->paid_amount }}
                        </td>

                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $data->intrest_amount }}
                        </td>



                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ carbon\carbon::parse($data->pay_date)->format('d-m-Y') }}
                        </td>
                        
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- allRefrences -->

<!-- Show the all others refrence if added -->
@if($allRefrences->count() > 0 )
    <div class="mb-4">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ 'Refrence Person' }}
    </h2>
    <div class="mb-2"></div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Refrence Member</th>
                    <th scope="col" class="px-6 py-3">Loan Main Member</th>
                    <th scope="col" class="px-6 py-3">Amount</th>
                    <th scope="col" class="px-6 py-3">Rate of intrest</th>
                    <th scope="col" class="px-6 py-3">Start Date</th>                                
                </tr>
            </thead>
            
            <tbody id="dataListTable">
                 @foreach($allRefrences as $refData)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           {{$refData->memberName}}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           {{$results->memberName}}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           {{$refData->amount}}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           {{$results->intrest_rate}}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           {{date('Y-m-d', strtotime($results->end_date))}}
                        </td>
                    </tr>
                 @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endif