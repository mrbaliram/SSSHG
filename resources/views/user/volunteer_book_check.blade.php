<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             {{ 'Consolidated Report for' }} ({{ $userResults[0]->name }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- ----------------Book Issue------------------------------ -->
                    <div class="flex justify-end"  style="cursor: pointer;">
                       <a href="{{ route('volunteer.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __('Go Back') }}</a>
                    </div>

                   
                    <div id="accordion-collapse" data-accordion="open">

<!-- Start over all----------------------------------------------------- -->
                        <h2 id="accordion-collapse-heading-book-overr_all">
                            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-book-overr_all" aria-expanded="true" aria-controls="accordion-collapse-body-book-overr_all">
                              <span>Balance Stock With Me ({{ $userResults[0]->name }})</span>
                              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                              </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-book-overr_all" class="hidden" aria-labelledby="accordion-collapse-heading-book-overr_all">
                            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">

                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-white-100 dark:bg-gray-700 dark:text-gray-400">         
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Book</th>
                                            <th scope="col" class="px-6 py-3">Issued Qty</th>
                                            <th scope="col" class="px-6 py-3">Returned Qty</th>
                                            <th scope="col" class="px-6 py-3">Sold Qty</th>
                                            <th scope="col" class="px-6 py-3">Balance Qty</th>
                                            <th scope="col" class="px-6 py-3">Balance Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 
                                            $issued_book_id_array = array();
                                            $total_issuedQty = 0;
                                         ?>


                                        @foreach($bookIssueResult as $data)

                                            <?php

                                            $total_issuedQty += $data->issued_quantity;

                                            if (!in_array($data->book_id, $issued_book_id_array)) {

                                                array_push($issued_book_id_array, $data->book_id);
                                            
                                                ?>
                                               
                                                <?php
                                            }

                                        ?>
                                        @endforeach


                                        <?php
                                            $book_total_issue   = 0;
                                            $book_total_return  = 0;
                                            $book_total_sell    = 0;
                                            $book_total_remain  = 0;
                                            $book_total_remain_all  = 0;

                                            foreach ($issued_book_id_array as $bookId) {
                                              //echo "$bookId <br>";
                                                $thisBookIssue = 0;
                                                $thisBookName = "";
                                                $total_bookPriceBalance = 0;
                                                foreach($bookIssueResult as $bookIssueData){
                                                    if($bookIssueData->book_id == $bookId){
                                                        $thisBookIssue += $bookIssueData->issued_quantity;
                                                        $thisBookName =  $bookIssueData->bookName .' ['. $bookIssueData->langName .'-'. $bookIssueData->bookPrice.']';
                                                        $total_bookPriceBalance = $bookIssueData->bookPrice;
                                                    }
                                                }
                                                $book_total_issue += $thisBookIssue;
                                                // get return record
                                                $thisBookReturn = 0;
                                                foreach($bookReturnResult as $bookReturnData){
                                                    if($bookReturnData->book_id == $bookId){
                                                        $thisBookReturn += $bookReturnData->returned_quantity;
                                                    }
                                                }
                                                $book_total_return += $thisBookReturn;
                                                // get sell record 
                                                $thisBookSell = 0;
                                                foreach($bookSellResult as $bookSellData){
                                                    if($bookSellData->book_id == $bookId){
                                                        $thisBookSell += $bookSellData->soled_quantity;
                                                    }
                                                }
                                                $book_total_sell += $thisBookSell;
                                                ?>

                                                 <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{$thisBookName}} 
                                                    </td>
                                                    
                                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white issued_quantity_sum">
                                                        {{$thisBookIssue}}
                                                    </td>
                                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{$thisBookReturn}}
                                                    </td>
                                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white issued_book_price_sum">
                                                       {{$thisBookSell}}
                                                    </td>
                                                    
                                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <?php 
                                                        $remainThisBook = $thisBookIssue - ($thisBookReturn + $thisBookSell);
                                                        $book_total_remain += $remainThisBook;
                                                        ?>
                                                        {{$remainThisBook}}
                                                    </td>

                                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{$total_bookPriceBalance * $remainThisBook}}
                                                        <?php $book_total_remain_all += $total_bookPriceBalance * $remainThisBook; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                                Total
                                            </td>
                                            
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white issued_quantity_sum">
                                                {{$book_total_issue}}
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$book_total_return}}
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white issued_book_price_sum">
                                               {{$book_total_sell}}
                                            </td>
                                            
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$book_total_remain}}
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$book_total_remain_all}}
                                            </td>

                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <br>
<!-- End ovver all------------------------------------------------------ -->

                        <!-- Start ------Book issue details -------------- -->
                        <h2 id="accordion-collapse-heading-book-issue">
                            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-book-issue" aria-expanded="true" aria-controls="accordion-collapse-body-book-issue">
                              <span>Issued to Me ({{ $userResults[0]->name }})</span>
                              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                              </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-book-issue" class="hidden" aria-labelledby="accordion-collapse-heading-book-issue">
                            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">

                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-white-100 dark:bg-gray-700 dark:text-gray-400">         
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Book</th>
                                            <th scope="col" class="px-6 py-3">Quantity</th>
                                            <th scope="col" class="px-6 py-3">Unit Price</th>
                                            <th scope="col" class="px-6 py-3">Amount</th>
                                            <th scope="col" class="px-6 py-3">Remarks</th>
                                            <th scope="col" class="px-6 py-3">Issue Date </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 

                                            $total_issuedQty = 0;
                                            $total_bookPrice = 0;
                                            $total_bookPrice_WithQty = 0;
                                         ?>

                                        @foreach($bookIssueResult as $data)

                                            <?php 

                                                $total_issuedQty += $data->issued_quantity;
                                                $total_bookPrice += $data->bookPrice;
                                                $total_bookPrice_WithQty += $data->bookPrice * $data->issued_quantity;
                                             ?>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $data->bookName}} [{{$data->langName}} - {{$data->authName}}]
                                                </td>
                                                
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white issued_quantity_sum">
                                                    {{ $data->issued_quantity }}
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $data->bookPrice}}
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white issued_book_price_sum">
                                                    {{ $data->bookPrice * $data->issued_quantity}}
                                                </td>
                                                
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ substr($data->remarks, 0, 40) }}..
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ date('d-m-Y', strtotime($data->issued_date)) }}
                                                </td>                                    
                                                
                                            </tr>
                                        @endforeach

                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 font-bold">
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                               Total
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white issued_quantity_sum">
                                               {{$total_issuedQty}}
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                               {{$total_bookPrice}}
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white issued_book_price_sum" colspan="2">
                                               {{$total_bookPrice_WithQty}}
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <br>
                        <!-- End ------Book issue details -------------- -->
                        
                        <!-- Start ------Book Return details -------------- -->
                        <h2 id="accordion-collapse-heading-book-return">
                            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-book-return" aria-expanded="true" aria-controls="accordion-collapse-body-book-return">
                              <span>Returned by Me ({{ $userResults[0]->name }})</span>
                              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                              </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-book-return" class="hidden" aria-labelledby="accordion-collapse-heading-book-return">
                            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">

                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-white-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Book</th><!-- 
                                            <th scope="col" class="px-6 py-3">Volunteer</th> -->
                                            <th scope="col" class="px-6 py-3">Quantity</th>
                                            <th scope="col" class="px-6 py-3">Unit Price</th>
                                            <th scope="col" class="px-6 py-3">Amount</th>
                                            <th scope="col" class="px-6 py-3">Remarks</th>
                                            <th scope="col" class="px-6 py-3">Return Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                            $total_returnQty = 0;
                                            $total_returnBookPrice = 0;
                                            $total_return_bookPrice_WithQty = 0;
                                         ?>
                                        @foreach($bookReturnResult as $data)

                                            <?php
                                        
                                                $total_returnQty += $data->returned_quantity;
                                                $total_returnBookPrice += $data->bookPrice;
                                                $total_return_bookPrice_WithQty += $data->returned_quantity * $data->bookPrice;
                                             ?>

                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $data->bookName}} [{{$data->langName}} - {{$data->authName}}]
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white return_quantity_sum">
                                                    {{ $data->returned_quantity }}
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $data->bookPrice }}
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white return_book_price_sum">
                                                    {{ $data->bookPrice * $data->returned_quantity}}
                                                </td>

                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ substr($data->remarks, 0, 40) }}..
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ date('d-m-Y', strtotime($data->returned_date)) }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 font-bold">
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                               Total
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white issued_quantity_sum">
                                               {{$total_returnQty}}
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                               {{$total_returnBookPrice}}
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white issued_book_price_sum" colspan="2">
                                               {{$total_return_bookPrice_WithQty}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                                
                            </div>
                        </div>
                        <br>
                        <!-- End ------Book Return details -------------- -->

                        <!-- Start ------Book Sell details -------------- -->
                        <h2 id="accordion-collapse-heading-book-sell">
                            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-book-sell" aria-expanded="true" aria-controls="accordion-collapse-body-book-sell">
                              <span>Sold by Me ({{ $userResults[0]->name }})</span>
                              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                              </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-book-sell" class="hidden" aria-labelledby="accordion-collapse-heading-book-sell">
                            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-white-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Book</th>
                                            <!-- <th scope="col" class="px-6 py-3">Volunteer</th> -->
                                            <th scope="col" class="px-6 py-3">Qty</th>
                                            <th scope="col" class="px-6 py-3">Unit Price</th>
                                            <th scope="col" class="px-6 py-3">Expected Sell Amount</th>
                                            <th scope="col" class="px-6 py-3">Actual Sell Amount</th>
                                            <th scope="col" class="px-6 py-3">Donation Amount</th>
                                            
                                            <th scope="col" class="px-6 py-3">Sell Date</th>
                                            <th scope="col" class="px-6 py-3">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                            $total_soldQty = 0;
                                            $total_soldUnitPrice = 0;
                                            $total_expected_sell_amount = 0;
                                            $total_actual_sell_amount = 0;
                                            $total_donation_amount = 0;
                                         ?>
                                        @foreach($bookSellResult as $data)

                                            <?php
                                        
                                                $total_soldQty += $data->soled_quantity;
                                                $total_soldUnitPrice += $data->bookPrice;
                                                $total_expected_sell_amount += $data->price;
                                                $total_actual_sell_amount += $data->soled_price;
                                                $total_donation_amount += $data->soled_price - $data->price;
                                             ?>

                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white">
                                                    {{ $data->bookName}} [{{$data->langName}} - {{$data->authName}}]
                                                </td>
                                                
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white sell_quantity_sum">
                                                    {{ $data->soled_quantity }}
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white sell_book_price_sum">
                                                    {{ $data->bookPrice }}
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $data->price }}
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $data->soled_price}}
                                                </td>

                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $data->soled_price - $data->price}}
                                                </td>
                                                
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ date('d-m-Y', strtotime($data->soled_date)) }}
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ substr($data->remarks, 0, 40) }}..
                                                </td>
                                            </tr>
                                        @endforeach
                                         <!-- $total_soldQty = 0;
                                            $total_soldUnitPrice = 0;
                                            $total_expected_sell_amount = 0;
                                            $total_actual_sell_amount = 0;
                                            $total_donation_amount = 0; -->

                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white text-right">
                                            Total
                                            </td>
                                            
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white sell_quantity_sum">
                                                {{ $total_soldQty }}
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white sell_book_price_sum">
                                                {{ $total_soldUnitPrice }}
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $total_expected_sell_amount }}
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $total_actual_sell_amount}}
                                            </td>

                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" colspan="3">
                                                {{ $total_donation_amount}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <!-- End ------Book Sell details -------------- -->

                        <!-- Start ------Book Payments details -------------- -->
                        <h2 id="accordion-collapse-heading-book-payment">
                            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-book-payment" aria-expanded="true" aria-controls="accordion-collapse-body-book-payment">
                              <span>Payments Made by Me ({{ $userResults[0]->name }})</span>
                              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                              </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-book-payment" class="hidden" aria-labelledby="accordion-collapse-heading-book-payment">
                            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                               <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-white-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Volunteer</th>
                                            <th scope="col" class="px-6 py-3">Amount</th>
                                            <th scope="col" class="px-6 py-3">Remarks</th>
                                            <th scope="col" class="px-6 py-3">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $total_payment = 0;
                                         ?>
                                        @foreach($paymentResult as $data)
                                            <?php
                                                $total_payment += $data->amount;
                                             ?>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $data->volunteerName }}
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white payment_done">
                                                    {{ $data->amount }}
                                                </td>
                                                
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ substr($data->remarks, 0, 40) }}..
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ date('d-m-Y', strtotime($data->payment_date)) }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white  text-right">
                                                    Total
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white payment_done" colspan="3">
                                                    {{ $total_payment }}
                                                </td>
                                                
                                                
                                            </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <!-- End ------Book Payments details -------------- -->
                        
                        <!-- Start ------Book Summary details -------------- -->
                        <h2 id="accordion-collapse-heading-book-summary">
                            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-book-summary" aria-expanded="true" aria-controls="accordion-collapse-body-book-summary">
                              <span>Consolidated Balance Report</span>
                              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                              </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-book-summary" class="hidden" aria-labelledby="accordion-collapse-heading-book-summary">
                            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                               <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-white-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Issued Qty</th>
                                            <th scope="col" class="px-6 py-3">Issued Worth</th>
                                            <th scope="col" class="px-6 py-3">Returned Qty</th>
                                            <th scope="col" class="px-6 py-3">Returned Worth</th>
                                            <th scope="col" class="px-6 py-3">Sold Qty</th>
                                            <th scope="col" class="px-6 py-3">Amount</th>
                                            <th scope="col" class="px-6 py-3">Required To Pay</th>
                                            <th scope="col" class="px-6 py-3">Total Paid</th>
                                            
                                            <th scope="col" class="px-6 py-3">Payable Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- $total_issuedQty
                                            $total_returnQty
                                            $total_soldQty  -->
                                        <td scope="row" id="issued_quantity_sum_div" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$total_issuedQty}}</td>
                                        <td scope="row" id="issued_book_price_sum_div" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$total_bookPrice_WithQty}}</td>
                                         
                                        <td scope="row" id="return_quantity_sum_div" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$total_returnQty}}</td>
                                        <td scope="row" id="return_book_price_sum_div" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$total_return_bookPrice_WithQty}}</td>
                                        <td scope="row" id="sell_quantity_sum_div" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$total_soldQty}}</td>
                                        <td scope="row" id="sell_book_price_sum_div" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$total_expected_sell_amount}}</td>
                                        <td scope="row" id="needToPay_div" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php $need2pay = $total_bookPrice_WithQty - $total_return_bookPrice_WithQty; ?>
                                        {{$need2pay}}</td>
                                        <td scope="row" id="paid_div" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$total_payment}}</td>
                                        <td scope="row" id="remain_div" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$need2pay - $total_payment}}</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <!-- End ------Book Summary details-------------- -->

                        <!-- Start ------All Book Status details -------------- -->
                        <h2 id="accordion-collapse-heading-book-allStatus">
                            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-book-allStatus" aria-expanded="true" aria-controls="accordion-collapse-body-book-allStatus">
                              <span>Consolidated Stock Report</span>
                              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                              </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-book-allStatus" class="hidden" aria-labelledby="accordion-collapse-heading-book-allStatus">
                            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                               <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-white-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Issued Qty</th>
                                            <th scope="col" class="px-6 py-3">Returned Qty</th>
                                            <th scope="col" class="px-6 py-3">Sold Qty</th>
                                            <th scope="col" class="px-6 py-3">Remaining Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- $total_issuedQty
                                            $total_returnQty
                                            $total_soldQty  -->
                                        <?php
                                            $remainQty = $total_issuedQty - ($total_returnQty + $total_soldQty);
                                        ?>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">{{$total_issuedQty}}</td>
                                         
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">{{$total_returnQty}}</td>
                                        
                                        <td scope="row"  class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">{{$total_soldQty}}</td>
                                        
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">{{$remainQty}}</td>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                        <!-- End ------All Book Status details -------------- -->
                          
                    </div>

                </div>
            </div>
        </div>
    </div>

    
    


    <script type="text/javascript">
        $(document).ready(function(){

            // ------------ issue book sum price and quientity
            // //issued_quantity_sum_div issued_book_price_sum issued_book_price_sum_div
            // var issued_quantity_sum = 0;
            // $(".issued_quantity_sum").each(function(){
            //     issued_quantity_sum += parseFloat($(this).text());
            // });
            // $('#issued_quantity_sum_div').html(issued_quantity_sum);
            // $('#issued_quantity_sum_div2').html(issued_quantity_sum);
            // var issued_book_price_sum = 0;
            // $(".issued_book_price_sum").each(function(){
            //     issued_book_price_sum += parseFloat($(this).text());
            // });
            // $('#issued_book_price_sum_div').html(issued_book_price_sum);

            // // ------------ Return book sum price and quientity
            // //return_quantity_sum return_book_price_sum
            // var return_quantity_sum = 0;
            // $(".return_quantity_sum").each(function(){
            //     return_quantity_sum += parseFloat($(this).text());
            // });
            // $('#return_quantity_sum_div').html(return_quantity_sum);
            // $('#return_quantity_sum_div2').html(return_quantity_sum);
            // var return_book_price_sum = 0;
            // $(".return_book_price_sum").each(function(){
            //     return_book_price_sum += parseFloat($(this).text());
            // }); 
            // $('#return_book_price_sum_div').html(return_book_price_sum);

            // // ------------ SELL book sum price and quientity
            // //sell_quantity_sum sell_book_price_sum 
            // // sell_quantity_sum_div sell_book_price_sum_div
            // var sell_quantity_sum = 0;
            // $(".sell_quantity_sum").each(function(){
            //     sell_quantity_sum += parseFloat($(this).text());
            // });
            // $('#sell_quantity_sum_div').html(sell_quantity_sum);
            // $('#sell_quantity_sum_div2').html(sell_quantity_sum);
            // var sell_book_price_sum = 0;
            // $(".sell_book_price_sum").each(function(){
            //     sell_book_price_sum += parseFloat($(this).text());
            // }); 
            // $('#sell_book_price_sum_div').html(sell_book_price_sum);

            // // Paymen is already done paid_div
            // var payment_done = 0;
            // $(".payment_done").each(function(){
            //     payment_done += parseFloat($(this).text());
            // }); 
            // $('#paid_div').html(payment_done);


            // var issuBookPriceTotal = parseFloat($('#issued_book_price_sum_div').html());
            // var returnBookPriceTotal =parseFloat($('#return_book_price_sum_div').html());
            // var needToPay = issuBookPriceTotal - returnBookPriceTotal
            // //alert(sum_sell_bookPrice);
            // $('#needToPay_div').html(needToPay);

            // var alreadyPaid = parseFloat($('#paid_div').html())
            // //var returnBookPriceTotal =parseFloat($('#return_book_price_sum_div').html())
            // //alert(sum_sell_bookPrice);
            // $('#remain_div').html(needToPay - alreadyPaid);

            // // Ballance book qty
            // $('#remain_div_qty2').html(issued_quantity_sum - (return_quantity_sum + sell_quantity_sum));
            // // -------------------HIDE AND SHOW-------------------------------
            // //-----IssueTableBody IssueTableHeader
            // $("#IssueTableHeader").click(function(){
            //     //$("#IssueTableBody").toggle();
            //     $('#IssueTableBody').toggle(1000);
            // });

            // //-----returnTableBody returnTableHeader
            // $("#returnTableHeader").click(function(){
            //     $('#returnTableBody').toggle(1000);
            // });

            // //-----sellTableHeader sellTableBody
            // $("#sellTableHeader").click(function(){
            //     $('#sellTableBody').toggle(1000);
            // });

            // //-----paymentTableHeader paymentTableBody
            // $("#paymentTableHeader").click(function(){
            //     $('#paymentTableBody').toggle(1000);
            // });

            // //-----summaryTableHeader summaryTableBody
            // $("#summaryTableHeader").click(function(){
            //     $('#summaryTableBody').toggle(1000);
            // });
            // //allBookStatusTableBody  allBookStatusTableHeader 
            // $("#allBookStatusTableHeader").click(function(){
            //     $('#allBookStatusTableBody').toggle(1000);
            // });

        });  
    </script>
</x-app-layout>