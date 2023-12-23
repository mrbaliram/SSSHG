<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Language') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session()->has('success'))                        
                        <div style="color: green;" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                          <span class="font-medium">Success alert!</span> 
                          {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="mb-4 flex justify-end">
                        <input id="globalSearch" type="text" placeholder="Search.."> &nbsp;
                        @if(Auth::user()->type == 'admin')
                            <a href="{{ route('language.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 flex">
                                <svg class="h-5 w-5 text-white-700"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
                            &nbsp;&nbsp;{{ __('Add') }}</a>
                        @endif                        
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
         
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3" align="center">
                                        Status
                                    </th>
                                    @if(Auth::user()->type == 'admin')
                                        <th scope="col" class="px-6 py-3">Action
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="dataListTable">
                                @foreach($results as $data)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $data->name }}
                                        </td>
                                        <td  class="px-6 py-4" align="center">
                                            @if($data->status == 1)
                                                Yes
                                            @elseif($data->status == 0)
                                                No
                                            @endif
                                        </td>
                                        @if(Auth::user()->type == 'admin')
                                            <td class="px-6 py-4 flex">
                                                <a href="{{ route('language.edit', $data->id) }}" class="text-blue-600 hover:underline" title="Edit / Update">
                                                    <svg class="h-6 w-6 text-blue-600"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />  <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg>
                                                </a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <form action="{{ route('language.destroy', $data->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="Delete this record" onclick="return confirm('Are you sure, you want to delete this item?')" type="submit" class="confirm-button text-red-600 hover:underline">
                                                        <svg class="h-6 w-6 text-blue-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="4" y1="7" x2="20" y2="7" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" />  <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />  <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $results->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>