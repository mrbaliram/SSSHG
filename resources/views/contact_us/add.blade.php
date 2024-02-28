
<x-app-layout>

    <script type="text/javascript">    
        $(document).ready(function(){
             $("#saveBtn").click(function(){ // title sort_desc
                if ($("#name").val().trim() == ''){
                     alert('Please enter the name, only space are not allowed');
                     $("#name").focus();
                    return false;
                }else if($("#message").val().trim()  == ''){
                     alert('Please enter sort_desc');
                     $("#sort_desc").focus();
                    return false;
                }else{
                    return true; 
                }
            });
        });
    </script>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Add Contact' }}
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
                    
                    <form action="{{ route('contact_us.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                   
                         <!-- name -->
                        <div class="grid md:grid-cols-2 md:gap-6">
                           
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="name" class="block text-gray-600 font-medium">Name<span style="color:red"> *</span></label>
                                <input type="text" name="name" id="name" value="" class="border rounded-md w-full py-2 px-3 text-gray-700">

                            </div>

                            <div class="relative z-0 w-full mb-6 group">
                                <label for="name" class="block text-gray-600 font-medium">Socity Member<span style="color:red"> *</span></label>
                                <select id="member_id" name="member_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">--Choose one option--</option>

                                    @foreach($societyMembersResults as $societyMemberData)
                                      
                                        <option  value="{{ $societyMemberData->id }}" > {{ $societyMemberData->memberName }} [{{ $societyMemberData->societyName }}]</option>
                                    @endforeach

                                   
                                </select>
                            </div>

                        </div>

                        <!-- name -->
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="remarks" class="block text-gray-600 font-medium">Remarks</label>
                                <input type="text" name="remarks" id="remarks" value="" class="border rounded-md w-full py-2 px-3 text-gray-700">
                            </div>
                            <!-- mobile -->
                             <div class="relative z-0 w-full mb-6 group">
                                <label for="mobile" class="block text-gray-600 font-medium">Mobile</label>
                                <input type="text" name="mobile" id="mobile" value="" class="border rounded-md w-full py-2 px-3 text-gray-700" maxlength="10">
                            </div>
                        </div>


                        <!-- Remarks-->
                        <div class="mb-4">                           
                            <!-- Message -->
                            
                                <label for="message" class="block text-gray-600 font-medium">Message<span style="color:red"> *</span></label>
                                <textarea name="message" id="message" rows="5" cols="77"></textarea>
                            
                         </div>
                        <!-- other info -->
                        <!-- <div class="mb-4">
                            <label for="other_info1" class="block text-gray-600 font-medium">Other Info 1<span style="color:red"> *</span></label>
                            <input type="text" name="other_info1" id="other_info1" value="" class="border rounded-md w-full py-2 px-3 text-gray-700">
                        </div>
                         other info 2 -->
                        <!-- <div class="mb-4">
                            <label for="other_info2" class="block text-gray-600 font-medium">Other Info 2</label>
                            <input type="text" name="other_info2" id="other_info2" value="" class="border rounded-md w-full py-2 px-3 text-gray-700">
                        </div> -->

                        <div class="flex">
                            <div class="flex items-center mr-4">
                                <label class="block text-gray-600 font-medium">Status<span style="color:red"> *</span></label>
                            </div>
                            <div class="flex items-center mr-4">
                                 <input type="radio" name="status" id="active" value="1" {{ (old('status', isset($results) ? $results->status : '') == '1') ? 'checked' : '' }} class="mr-2" checked>
                                 <label for="inactive" class="text-gray-700">Yes</label>
                            </div>
                            <div class="flex items-center mr-4">
                                <input type="radio" name="status" id="inactive" value="0" {{ (old('status', isset($results) ? $results->status : '') == '0') ? 'checked' : '' }} class="mr-2">
                                <label for="inactive" class="text-gray-700">No</label>
                            </div>
                        </div>

                        <div class="mb-4" align="center">

                            <button id="saveBtn" type="submit" class="px-5 py-2 mr-2 mb-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"> {{ $results ? 'Update' : 'Save' }}</button>

                            <a href="{{ route('contact_us.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __('Go Back') }}</a>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>