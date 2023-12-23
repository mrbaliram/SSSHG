<x-app-layout>
    <script type="text/javascript">    
        $(document).ready(function(){
             $("#saveBtn").click(function(){
                if ($("#name").val().trim() == ''){
                     alert('Please enter the name, only space are not allowed');
                     $("#name").focus();
                    return false;

                }else if($("#user_id").val().trim() == ''){
                     alert('Please enter the user for the login access');
                     $("#name").focus();
                    return false;
                
                }else if($("#city").val().trim()  == ''){
                     alert('Please enter the city, only space are not allowed');
                     $("#code").focus();
                    return false;

                }else{
                    return true;
                }
            });
        });
    </script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Update Member' }}
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

                    <form action="{{ route('member.update', $results->id) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <!-- Select User for login and select parent member -->                        
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="user_id" class="block text-gray-600 font-medium">Select User for login<span style="color:red"> *</span></label>
                                <select id="user_id" name="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">--Choose one option--</option>
                                    @foreach($userResults as $userData)
                                        <option value="{{ $userData->id }}" {{ $userData->id == $results->user_id ? 'Selected' : '' }}> {{ $userData->name }} [{{ $userData->email }}]</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="parent_id" class="block text-gray-600 font-medium">Select Parent Member<span style="color:red"> *</span></label>
                                <select id="parent_id" name="parent_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="0">Self</option>
                                    @foreach($memberResults as $data)
                                        <option value="{{ $data->id }}" {{ $data->id == $results->parent_id ? 'Selected' : '' }}> {{ $data->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Select referenc member and sub refrence member -->
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="reference_id" class="block text-gray-600 font-medium">Select First Refrence<span style="color:red"> *</span></label>
                                <select id="reference_id" name="reference_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="0">Self</option>
                                    @foreach($memberResults as $data)
                                        <option value="{{ $data->id }}" {{ $data->id == $results->reference_id ? 'Selected' : '' }}> {{ $data->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="sub_reference_id" class="block text-gray-600 font-medium">Select Second Refrence<span style="color:red"> *</span></label>
                                <select id="sub_reference_id" name="sub_reference_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="0">Self</option>
                                    @foreach($memberResults as $data)
                                        <option value="{{ $data->id }}" {{ $data->id == $results->sub_reference_id ? 'Selected' : '' }}> {{ $data->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- name and guardian -->
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="name" class="block text-gray-600 font-medium">Name<span style="color:red"> *</span></label>
                                <input autofocus="autofocus" type="text" name="name" id="name" value="{{ $results->name }}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="guardian" class="block text-gray-600 font-medium">Guardian / Father / Husband<span style="color:red"> *</span></label>
                                <input  type="text" name="guardian" id="guardian" value="{{ $results->guardian }}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                            </div>
                        </div>
                    
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="address1" class="block text-gray-600 font-medium">Address <span style="color:red"> *</span></label>
                                <input type="text" name="address1" id="address1" value="{{ $results->address1 }}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="address2" class="block text-gray-600 font-medium">Address 2</label>
                                <input type="text" name="address2" id="address2" value="{{ $results->address2 }}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="city" class="block text-gray-600 font-medium">City <span style="color:red"> *</span></label>
                                <input type="text" name="city" id="city" value="{{ $results->city }}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="State" class="block text-gray-600 font-medium">State <span style="color:red"> *</span></label>
                                <input type="text" name="state" id="state" value="{{ $results->state }}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="pin_code" class="block text-gray-600 font-medium">Pin Code</label>
                                <input type="text" name="pin_code" id="pin_code" value="{{ $results->pin_code }}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="email" class="block text-gray-600 font-medium">Email</label>
                                <input type="email" name="email" id="email" value="{{ $results->email }}" class="border rounded-md w-full py-2 px-3 text-gray-700" >
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="phone" class="block text-gray-600 font-medium">Contact no</label>
                                <input type="text" name="phone" id="phone" value="{{ $results->phone }}" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>                            
                            <div class="relative z-0 w-full mb-6 group">
                                 <label for="phone" class="block text-gray-600 font-medium">Remarks</label>
                                <textarea id="remarks" name="remarks" rows="1" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write remarks here...">{{ $results->remarks }}</textarea>
                            </div>                            
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label class="block text-gray-600 font-medium">Photo</label>
                                <input type="file" name="photo_url" id="photo_url" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>                            
                            <div class="relative z-0 w-full mb-6 group">
                                <label class="block text-gray-600 font-medium">Adhar Card</label>
                                <input type="file" name="adhar_card_url" id="adhar_card_url"   class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>                            
                        </div>
                            
                        <div class="flex justify mb-6">
                            <div class="flex items-center mr-4">
                                <label class="block text-gray-600 font-medium">Status<span style="color:red"> *</span></label>
                            </div>
                            <div class="flex items-center mr-4">
                                <input type="radio" name="status" id="active" value="1"  class="mr-2" {{ $results->status == '1' ? 'checked' : '' }}>
                                <label for="active" class="text-gray-700">Yes</label>
                            </div>
                            <div class="flex items-center mr-4">
                                <input type="radio" name="status" id="inactive" value="0" class="mr-2"  {{ $results->status == '0' ? 'checked' : '' }}>
                                <label for="inactive" class="text-gray-700">No</label>
                            </div>  
                        </div>

                        <div class="flex justify mb-6">
                            <div class="flex items-center mr-4">
                                <label class="block text-gray-600 font-medium">Gender<span style="color:red"> *</span></label>
                            </div>
                            <div class="flex items-center mr-4">
                                <input type="radio" name="gender" id="active" value="M" class="mr-2" {{ $results->gender == 'M' ? 'checked' : '' }}>
                                <label for="active" class="text-gray-700">Male</label>
                            </div>
                            <div class="flex items-center mr-4">
                                <input type="radio" name="gender" id="inactive" value="F" class="mr-2" {{ $results->gender == 'F' ? 'checked' : '' }}>
                                <label for="inactive" class="text-gray-700">Female</label>
                            </div>  
                        </div>

                        <div class="flex justify-end mb-6">
                            <button id="saveBtn" type="submit" class="px-5 py-2 mr-2 mb-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"> {{ 'Update' }}</button>
                            
                            <a href="{{ route('member.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __('Go Back') }}</a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>