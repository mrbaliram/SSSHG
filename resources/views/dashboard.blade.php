<x-app-layout>
   <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
   </x-slot>

   <div class="py-2">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <?php $showAddLink = "visibility: hidden;"?>
         @if(Auth::user()->id == '1')
            <?php $showAddLink = "visibility: none;"?>
         @endif
         <!-- start row 1 ----------------------------------------------- --> 
         <div class="flex py-2">
            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                  <div class="flex justify-left">
                     <svg class="h-16 w-16 text-blue-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="3" y1="21" x2="21" y2="21" />  <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />  <path d="M5 21v-10.15" />  <path d="M19 21v-10.15" />  <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" /></svg>
                  </div>
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('society.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white">{{$societiesCount}}  <br>Society</h5>
                     </a>
                  </div> 
                  <div class="flex justify-end" style={{$showAddLink}}>
                     <a href="{{route('society.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>
               </div>
            </div>

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                  <div class="flex justify-left">
                     <svg class="h-16 w-16 text-blue-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="6" r="2" />  <circle cx="6" cy="18" r="2" />  <circle cx="18" cy="18" r="2" />  <line x1="6" y1="8" x2="6" y2="16" />  <line x1="8" y1="6" x2="16" y2="6" />  <line x1="8" y1="18" x2="16" y2="18" />  <line x1="18" y1="8" x2="18" y2="16" /></svg>
                  </div>
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('member.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white"> {{$memberCount}} <br> Members</h5>
                     </a>
                  </div>
                  <div class="flex justify-end" style="{{$showAddLink}}">
                     <a href="{{route('member.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>
               </div>
            </div>

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                  <div class="flex justify-left">
                     <svg class="h-16 w-16 text-blue-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="7" cy="17" r="2" />  <circle cx="17" cy="17" r="2" />  <path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v6h-5l2 2m0 -4l-2 2" />  <path d="M9 17h6" />  <path d="M13 6h5l3 5v6h-2" /></svg>
                  </div>
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('society_member.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white">{{$societiesMemberCount}} <br> Societies Member</h5>
                     </a>
                  </div>
                  <div class="flex justify-end" style="{{$showAddLink}}">
                     <a href="{{route('society_member.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>
               </div>
            </div>

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                  <div class="flex justify-left">
                     <svg class="h-16 w-16 text-blue-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />  <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" /></svg>
                  </div>
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('contribution_payment.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white">{{$contribution_payment}} <br>Contribution Amount</h5>
                     </a>
                  </div>
                  <div class="flex justify-end" style="{{$showAddLink}}">
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
                  <div class="flex justify-left">
                     <svg class="h-16 w-16 text-blue-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="3" y1="21" x2="21" y2="21" />  <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />  <path d="M5 21v-10.15" />  <path d="M19 21v-10.15" />  <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" /></svg>
                  </div>
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('loan_account.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white">{{$loanAccountCount}}  <br>Loan</h5>
                     </a>
                  </div> 
                  <div class="flex justify-end" style={{$showAddLink}}>
                     <a href="{{route('loan_account.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>
               </div>
            </div>

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                  <div class="flex justify-left">
                     <svg class="h-16 w-16 text-blue-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="6" r="2" />  <circle cx="6" cy="18" r="2" />  <circle cx="18" cy="18" r="2" />  <line x1="6" y1="8" x2="6" y2="16" />  <line x1="8" y1="6" x2="16" y2="6" />  <line x1="8" y1="18" x2="16" y2="18" />  <line x1="18" y1="8" x2="18" y2="16" /></svg>
                  </div>

                  <div class="mb-1 flex justify-center">
                     <a href="{{route('loan_account.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white"> {{$loanAmountOutStanding}} <br> Loan Amount</h5>
                     </a>
                  </div>

                  <div class="flex justify-end" style="{{$showAddLink}}">
                     <a href="{{route('loan_account.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>

               </div>
            </div>
            
            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                  <div class="flex justify-left">
                     <svg class="h-16 w-16 text-blue-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="6" r="2" />  <circle cx="6" cy="18" r="2" />  <circle cx="18" cy="18" r="2" />  <line x1="6" y1="8" x2="6" y2="16" />  <line x1="8" y1="6" x2="16" y2="6" />  <line x1="8" y1="18" x2="16" y2="18" />  <line x1="18" y1="8" x2="18" y2="16" /></svg>
                  </div>

                  <div class="mb-1 flex justify-center">
                     <a href="{{route('loan_account.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white"> {{$loanPaid}} <br> Loan Paid Amount</h5>
                     </a>
                  </div>

                  <div class="flex justify-end" style="{{$showAddLink}}">
                     <a href="{{route('loan_account.create')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <svg class="h-5 w-5 text-blue-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                     </a>
                  </div>

               </div>
            </div>

            <div class="w-1/4 p-2">
               <div class="max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                  <div class="flex justify-left">
                     <svg class="h-16 w-16 text-blue-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="6" r="2" />  <circle cx="6" cy="18" r="2" />  <circle cx="18" cy="18" r="2" />  <line x1="6" y1="8" x2="6" y2="16" />  <line x1="8" y1="6" x2="16" y2="6" />  <line x1="8" y1="18" x2="16" y2="18" />  <line x1="18" y1="8" x2="18" y2="16" /></svg>
                  </div>

                  <div class="mb-1 flex justify-center">
                     <a href="{{route('loan_account.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white"> {{$loanIntrestPaind}} <br> Loan Intrest Paid</h5>
                     </a>
                  </div>

                  <div class="flex justify-end" style="{{$showAddLink}}">
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
                  <div class="flex justify-left">
                     <svg class="h-16 w-16 text-blue-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="3" y1="21" x2="21" y2="21" />  <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />  <path d="M5 21v-10.15" />  <path d="M19 21v-10.15" />  <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" /></svg>
                  </div>
                  <div class="mb-1 flex justify-center">
                     <a href="{{route('user.index')}}" class="inline-flex items-center text-blue-600 hover:underline">
                     <h5 class="mb-2 text-2xl font-semibold tracking-tight text-blue-900 dark:text-white">{{$userCount}}  <br>Users</h5>
                     </a>
                  </div> 
                  <div class="flex justify-end" style={{$showAddLink}}>
                     <a href="{{route('user.add')}}" class="inline-flex items-center text-blue-600 hover:underline">
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