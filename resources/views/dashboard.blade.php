<x-app-layout>
   <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
   </x-slot>

   <div class="py-2">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         @if(Auth::user()->type != 'cashier')
             <script type="text/javascript">    
              $(document).ready(function(){
                  $(".justify-end").hide();
              });
            </script>            
         @endif        

         <!-- start row 1 ----------------------------------------------- --> 
         <div class="flex py-2">
            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                  
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('society.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white">{{$societiesCount}}  <br>Society</h5>
                     </a>
                  </div>
                  <div class="flex justify-end" >
                        <a href="{{route('society.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                        <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                        </a>
                  </div>
               </div>
            </div>

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                  
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('member.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white"> {{$memberCount}} <br> Members</h5>
                     </a>
                  </div>
                  <div class="flex justify-end" >
                     <a href="{{route('member.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>
               </div>
            </div>

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                 
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('society_member.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white">{{$societiesMemberCount}} <br> Societies Member</h5>
                     </a>
                  </div>
                  <div class="flex justify-end" >
                     <a href="{{route('society_member.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>
               </div>
            </div>

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                  
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('contribution_payment.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white">{{$contribution_payment}} <br>Contribution Amount</h5>
                     </a>
                  </div>
                  <div class="flex justify-end" >
                     <a href="{{route('contribution_payment.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>
               </div>
            </div>
         </div>
         
         <!-- End row 1 ----------------------------------------------- -->

         <!-- start row 2 ----------------------------------------------- --> 
         <div class="flex py-2">

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                  
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('loan_account.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white">{{$loanAccountCount}}  <br>Loan</h5>
                     </a>
                  </div>
                     <div class="flex justify-end" >
                        <a href="{{route('loan_account.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                        <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                        </a>
                     </div>
               </div>
            </div>

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                 

                  <div class="mb-1 flex justify-center">
                     <a href="{{route('loan_account.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white"> {{$loanAmountOutStanding}} <br> Loan Amount</h5>
                     </a>
                  </div>

                  <div class="flex justify-end" >
                     <a href="{{route('loan_account.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>

               </div>
            </div>
            
            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                 
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('loan_account.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white"> {{$loanPaid}} <br> Loan Paid Amount</h5>
                     </a>
                  </div>

                  <div class="flex justify-end" >
                     <a href="{{route('loan_account.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>

               </div>
            </div>

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                 

                  <div class="mb-1 flex justify-center">
                     <a href="{{route('loan_account.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white"> {{$loanIntrestPaind}} <br> Loan Intrest Paid</h5>
                     </a>
                  </div>

                  <div class="flex justify-end" >
                     <a href="{{route('loan_account.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>

               </div>
            </div>

         </div>

         <!-- end row 2 ----------------------------------------------- --> 
         

         <!-- Start row 3 ----------------------------------------------- --> 
         <div class="flex py-2">

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                  
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('user.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white">{{$userCount}}  <br>Users</h5>
                     </a>
                  </div> 
                     <div class="flex justify-end" >
                        <a href="{{route('user.add')}}" class="inline-flex items-center text-blue-600 hover:underline">
                        <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                        </a>
                     </div>
               </div>
            </div>

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                 
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('contact_us.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white">{{$contactUsCount}}  <br>Query Raised (Contact us)</h5>
                     </a>
                  </div> 
                     <div class="flex justify-end" >
                        <a href="{{route('contact_us.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                        <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                        </a>
                     </div>
               </div>
            </div>
           

            
         </div>
         <!-- end row 3 ----------------------------------------------- --> 

      </div>
   </div>
</x-app-layout>