
<x-app-layout>

    <script type="text/javascript">    
        $(document).ready(function(){
             $("#saveBtn").click(function(){ 
                if ($("#loan_account_id").val().trim() == ''){
                     alert('Please select the loan account');
                     $("#loan_account_id").focus();
                    return false;
                    
                }

                return true; 
            });

            // get full amount based on society member selection 
            $("#loan_account_id").on('change', function() {
                $('#loanDetailsLink').css("visibility", "visible");
                $intrestAmount = 0;
                $minAmount = 1000;
                if($(this).val() != ''){ //loanpaid="" data-intpaid
                    $loanAmount = parseInt($(this).find('option:selected').attr('data-loanamount'));
                    $loanAmountPaid = parseInt($(this).find('option:selected').attr('data-loanpaid'));
                    $intAmountPaid = parseInt($(this).find('option:selected').attr('data-intpaid'));
                    $balance = $loanAmount - $loanAmountPaid;
                    //$("#loanFullAmount").html("Loan Amount : " + $loanAmount + ' ( Payment Done : ' + loanAmountPaid+')');
                    $("#loanFullAmount").html("Amount : " + $loanAmount);
                    $("#loanFullAmount").append("( Paid : " + $loanAmountPaid + ')');
                    //$("#loanFullAmount").append(" intrest Paid  : " + $intAmountPaid);
                    $("#balanceDivId").html(" Ballance : " + $balance);
                    $('#loanDetailsLink').show();
                    $intrestAmount = $balance * 1 / 100;
                    $minAmount = $balance * 10 / 100;
                }else{
                    $("#loanFullAmount").html('');
                    $('#loanDetailsLink').hide();
                }
                $("#intrest_amount").val($intrestAmount);
                $("#paid_amount").val($minAmount);
                    
                //
                var url = '{{ route("loan_account.refrence", ":id") }}';
                //var url =  '{{ route('loan_account.refrence', 1) }}
                url = url.replace(':id', $(this).find('option:selected').val());
                // $('#loanDetailsLink').html('<a href="'+url+'" target="_new">more details </a>');
                $("#loanDetailsLink").attr("href", url)

              
            });
        });
    </script>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Pay Loan' }}
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
                    
                    <form action="{{ route('loan_payment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="loan_account_id" class="block text-gray-600 font-medium">Select the loan account<span style="color:red"> *</span> <span style="color:red" id="loanFullAmount"></span>
                                    
                                </label>
                                <select id="loan_account_id" name="loan_account_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" data-loanamount="" data-loanpaid="" data-intpaid="">--Choose one option--</option>
                                    @foreach($loanAccountResult as $data)
                                        <?php 
                                            //$over_all_loan += $data->full_amount;
                                            $loandPaid = 0;
                                            $intPaid = 0;
                                        ?>
                                        @foreach($loan_paymentsTotal as $paymentData)
                                            @if($paymentData->loan_account_id == $data->id)
                                                <?php 
                                                    $loandPaid = ceil($paymentData->total_paid_amount);
                                                    $intPaid = ceil($paymentData->total_intrest_amount);

                                                    // $over_all_loandPaid += $loandPaid;
                                                    // $over_all_intPaid += $intPaid;
                                                ?>
                                            @endif
                                        @endforeach

                                        <option value="{{ $data->id }}" data-loanamount="{{$data->full_amount}}" data-loanpaid="{{$loandPaid}}" data-intpaid="{{$intPaid}}"> {{ $data->memberName }} [{{ $data->societyCode }}] Amount ({{$data->full_amount}})</option>
                                    @endforeach
                                </select>

                                <span id="loanDetailsLink" style="visibility: hidden;"><a href="" class="inline-flex items-center text-blue-600 hover:underline" target="_new" s>Loan Details</a> <span id="balanceDivId" style="color:green;"></span></span>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="pay_date" class="block text-gray-600 font-medium">Pay Date<span style="color:red"> *</span></label>
                                <input type="date" name="pay_date" id="pay_date" value="{{date('Y-m-d')}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="paid_amount" class="block text-gray-600 font-medium">Amount</label>
                                <input id="paid_amount" type="number" name="paid_amount" value="" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="intrest_amount" class="block text-gray-600 font-medium">Intrest Amount</label>
                                <input id="intrest_amount" type="number" name="intrest_amount" value="" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>                       

                        <div class="flex">
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

                        <div class="mb-4" align="center">

                            <button id="saveBtn" type="submit" class="px-5 py-2 mr-2 mb-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"> {{ 'Save' }}</button>

                            <a href="{{ route('loan_payment.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __('Go Back') }}</a>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>