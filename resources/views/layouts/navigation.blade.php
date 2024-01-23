<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/datepicker.min.js"></script>

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard.dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                <!-- Navigation Links -->
                

                @php $member_link_active = false;
                    if(request()->routeIs('member.index') || request()->routeIs('member.create') || request()->routeIs('member.edit') || request()->routeIs('member.show'))
                        $member_link_active = true;
                @endphp

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('member.index')" :active="$member_link_active">
                        {{ __('Members') }}
                    </x-nav-link>
                </div>

                @php $society_member_link_active = false;
                    if(request()->routeIs('society_member.index') || request()->routeIs('society_member.create') || request()->routeIs('society_member.edit') || request()->routeIs('society_member.show'))
                        $society_member_link_active = true;
                @endphp

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('society_member.index')" :active="$society_member_link_active">
                        {{ __('Society-Member') }}
                    </x-nav-link>
                </div>
                <!-- contribution_payment -->
                @php $contribution_payment_link_active = false;
                    if(request()->routeIs('contribution_payment.index') || request()->routeIs('contribution_payment.create') || request()->routeIs('contribution_payment.edit'))
                        $contribution_payment_link_active = true;
                @endphp

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('contribution_payment.index')" :active="$contribution_payment_link_active">
                        {{ __('Contribution') }}
                    </x-nav-link>
                </div>

                <!-- loan_account  refrence-->
                @php $loan_account_link_active = false;
                    if(request()->routeIs('loan_account.index') || request()->routeIs('loan_account.create') || request()->routeIs('loan_account.edit') || request()->routeIs('loan_account.show')  || request()->routeIs('loan_account.refrence'))
                        $loan_account_link_active = true;
                @endphp

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('loan_account.index')" :active="$loan_account_link_active">
                        {{ __('Loan') }}
                    </x-nav-link>
                </div>

                <!-- loan Payment loan_payment-->
                @php $loan_payment_link_active = false;
                    if(request()->routeIs('loan_payment.index') || request()->routeIs('loan_payment.create') || request()->routeIs('loan_payment.edit'))
                        $loan_payment_link_active = true;
                @endphp

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('loan_payment.index')" :active="$loan_payment_link_active">
                        {{ __('Loan-Pay') }}
                    </x-nav-link>
                </div>

                <!-- c  -->
                @php $user_profile = false;
                if(request()->routeIs('user.index') ||  request()->routeIs('user.edit') || request()->routeIs('user.add'))
                   $user_profile = true;
                @endphp
                
                <!-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('user.index')" :active="$user_profile">
                        {{ __('Users') }}
                    </x-nav-link>
                </div> -->

                <!-- Contact us   contact_us-->
                @php $contact_us = false;
                if(request()->routeIs('contact_us.index') ||  request()->routeIs('contact_us.edit') || request()->routeIs('contact_us.create') || request()->routeIs('contact_us.show'))
                   $contact_us = true;
                @endphp
                

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('contact_us.index')" :active="$contact_us">
                        {{ __('Query') }}
                    </x-nav-link>
                </div>


            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">


                <!-- start  - drop down menu for Reports------------------- -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>Reports </div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content" :active="true">

                        <!-- <x-dropdown-link :href="route('reports.contribution')">
                            {{ __('All Contribution Reports') }}
                        </x-dropdown-link> -->                        

                        <x-dropdown-link :href="route('reports.member')">
                            {{ __('Contribution & Loan Reports') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('reports.member_monthly')">
                            {{ __('Monthly Contribution Reports') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('reports.loan')">
                            {{ __('Monthly Loan Reports') }}
                        </x-dropdown-link>

                    </x-slot>
                </x-dropdown>


                <!-- start  - drop down menu for setting -------------- -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>Settings </div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content" :active="true">

                        <x-dropdown-link :href="route('user.index')">
                            {{ __('Users') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('society.index')">
                            {{ __('Societies') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('member_type.index')">
                            {{ __('Member Type') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('society_rule.index')">
                            {{ __('Society Rule') }} 
                        </x-dropdown-link>
                       
                    </x-slot>
                </x-dropdown>

                <!-- Prpfile main menu -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard.dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        @php $member_link_active = false;
            if(request()->routeIs('member.index') || request()->routeIs('member.create') || request()->routeIs('member.edit') || request()->routeIs('member.show'))
                $member_link_active = true;
        @endphp

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('member.index')" :active="$member_link_active">
                {{ __('Members') }}
            </x-responsive-nav-link>
        </div>
        

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
