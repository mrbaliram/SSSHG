<x-app-layout>

    <script type="text/javascript">    
        $(document).ready(function(){
             $("#saveBtn").click(function(){     //backBtn      //saveBtn 
                //category_id language_id author_id name price
                if ($("#name").val() == ''){
                     alert('Please select language')
                    return false;
                }else if($("#code").val() == ''){
                     alert('Please select category')
                    return false;
                }else{
                    return true;
                }
            });           
        });
    </script>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Update Society' }}
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
                    
                    <form action="{{ route('society.update', $results->id) }}" 
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="name" class="block text-gray-600 font-medium">Society Name<span style="color:red"> *</span></label>
                                <input autofocus="autofocus" type="text" name="name" id="name" value="{{$results->name}}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="code" class="block text-gray-600 font-medium">Society Code<span style="color:red"> *</span></label>
                                <input  type="text" name="code" id="code" value="{{$results->code}}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                            </div>
                        </div>
                        <!-- contribution_amount
                        maximum_loan_amount -->
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="contribution_amount" class="block text-gray-600 font-medium">Contribution Amount <span id="contribution_amount" style="color: green;"></span></label>
                                <input id="contribution_amount" type="number" name="contribution_amount" value="{{$results->contribution_amount}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="maximum_loan_amount" class="block text-gray-600 font-medium">Maximum Loan Amount</label>
                                <input id="maximum_loan_amount" type="number" name="maximum_loan_amount" value="{{$results->maximum_loan_amount}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>
                        <!-- Branch Code and Rate of intrest -->
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="branch_code" class="block text-gray-600 font-medium">Branch Code</span></label>
                                <input id="branch_code" type="number" name="branch_code" value="{{$results->branch_code}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="intrest_rate" class="block text-gray-600 font-medium">Intrest Rate</label>
                                <select id="intrest_rate" name="intrest_rate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="1" {{$results->intrest_rate == 1 ? 'Selected' : '' }}> 1 </option>
                                    <option value="2" {{$results->intrest_rate == 2 ? 'Selected' : '' }}> 2 </option>
                                    <option value="3" {{$results->intrest_rate == 3 ? 'Selected' : '' }}> 3 </option>
                                </select>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="address1" class="block text-gray-600 font-medium">Address <span style="color:red"> *</span></label>
                                <input type="text" name="address1" id="address1" value="{{$results->address1}}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="address2" class="block text-gray-600 font-medium">Address 2</label>
                                <input type="text" name="address2" id="address2" value="{{$results->address2}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="city" class="block text-gray-600 font-medium">City <span style="color:red"> *</span></label>
                                <input type="text" name="city" id="city" value="{{$results->city}}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="State" class="block text-gray-600 font-medium">State <span style="color:red"> *</span></label>
                                <input type="text" name="state" id="state" value="{{$results->state}}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="pin_code" class="block text-gray-600 font-medium">Pin Code</label>
                                <input type="text" name="pin_code" id="pin_code" value="{{$results->pin_code}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="S date" class="block text-gray-600 font-medium">Start Date <span style="color:red"> *</span></label>
                                <input type="date" name="start_date" id="start_date" value="{{date('Y-m-d', strtotime($results->start_date))}}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="contact_person" class="block text-gray-600 font-medium">Contact Person Name</label>
                                <input type="text" name="contact_person" id="contact_person" value="{{$results->contact_person}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>                            
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="contact_no" class="block text-gray-600 font-medium">Contact Person Phone</label>
                                <input type="text" name="contact_no" id="contact_no" value="{{$results->contact_no}}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div> 
                        </div>
                        
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label class="block text-gray-600 font-medium">Logo</label>
                                <input type="file" name="logo_url" id="logo_url"   class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                            
                            <div class="relative z-0 w-full mb-6 group">
                                <label class="block text-gray-600 font-medium">Image</label>
                                <input type="file" name="image_url" id="image_url"   class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>

                        <div class="mb-6">
                            <textarea id="remarks" name="remarks" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write remarks here...">{{$results->remarks}}</textarea>
                        </div>

                        <div class="flex justify mb-6">
                            <div class="flex items-center mr-4">
                                <label class="block text-gray-600 font-medium">Status<span style="color:red"> *</span></label>
                            </div>
                            

                            <div class="flex items-center mr-4">
                                <input type="radio" name="status" id="active" value="1" {{ $results->status == '1' ? 'checked' : '' }} >
                                <label for="active" class="text-gray-700">Yes</label>
                            </div>
                            <div class="flex items-center mr-4">
                                <input type="radio" name="status" id="inactive" value="0" class="mr-2" {{ $results->status == '0' ? 'checked' : '' }} >
                                <label for="inactive" class="text-gray-700">No</label>
                            </div>
                        </div>

                        <div class="flex justify-end mb-6">

                            <button id="saveBtn" type="submit" class="px-5 py-2 mr-2 mb-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"> {{ 'Update' }}</button>
                            
                            <a href="{{ route('society.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __('Go Back') }}</a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>