
<x-app-layout>

    <script type="text/javascript">    
        $(document).ready(function(){
             $("#saveBtn").click(function(){ // title sort_desc
                if ($("#title").val().trim() == ''){
                     alert('Please enter the title, only space are not allowed');
                     $("#title").focus();
                    return false;
                }else if($("#sort_desc").val().trim()  == ''){
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
            {{ $results ? 'Update Society Rule' : 'Create Society Rule' }}
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
                    
                    <form action="{{ $results ? route('society_rule.update', $results->id) : route('society_rule.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <?php $tempSociety_id = "" ?>
                    @if ($results)
                        @method('PUT')
                        <?php $tempSociety_id = $results->society_id ?>
                    @endif

                        <!-- society -->
                        <div class="mb-4">
                            <label for="society_id" class="block text-gray-600 font-medium">Select Society<span style="color:red"> *</span></label>
                            <select id="society_id" name="society_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="">--Choose one option--</option>
                                @foreach($societyResults as $societyData)
                                    <option value="{{ $societyData->id }}" {{   $societyData->id == $tempSociety_id ? 'Selected' : '' }}> {{ $societyData->name }} [{{ $societyData->code }}]</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="title" class="block text-gray-600 font-medium">Title<span style="color:red"> *</span></label>
                            <input type="text" name="title" id="title" value="{{old('title', $results->title ?? '')}}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                        </div>

                        <div class="mb-4">
                            <label for="sort_desc" class="block text-gray-600 font-medium">Short Desc<span style="color:red"> *</span></label>
                            <input type="text" name="sort_desc" id="sort_desc" value="{{old('sort_desc', $results->sort_desc ?? '')}}" class="border rounded-md w-full py-2 px-3 text-gray-700" required>
                        </div>

                        <div class="mb-4">
                            <label for="long_desc" class="block text-gray-600 font-medium">Long Description</label>
                                <textarea id="long_desc" name="long_desc" rows="4" class="block p-2.5 w-full text-sm text-gray-600 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Long Description...">{{old('long_desc', $results->long_desc ?? '')}}</textarea>
                        </div>

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

                            <a href="{{ route('society_rule.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __('Go Back') }}</a>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>