<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Monthly Report" }}
        </h2>
    </x-slot>
    <?php
        $dateValue = date('Y-m-d');
        $dateArr = explode("-", $dateValue);
        $currentYear = $dateArr[0];
        $currentMoth = $dateArr[1];     
    ?>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                     <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="pay_for_month" class="block text-gray-600 font-medium">Pay For Month <span id="price" style="color: green;"></span></label>
                                
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