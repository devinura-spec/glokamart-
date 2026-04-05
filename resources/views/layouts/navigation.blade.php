@php
    // Hitung jumlah item di keranjang
    $cartCount = session('cart') ? count(session('cart')) : 0;
@endphp

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left: Logo + Menu -->
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->role_id == 1 
            ? route('admin.dashboard') 
            : route('home') }}">

                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Menu -->
                @if(auth()->user()->role_id == 1)
    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
        Dashboard Admin
    </x-nav-link>
@else
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        Dashboard
    </x-nav-link>
@endif

                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                        Pesanan Saya
                    </x-nav-link>
                </div>
            </div>

            <!-- Right: Cart + User -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">

                <!-- Cart -->
                <div class="relative">
                    <a href="{{ route('cart.index') }}" class="text-yellow-500 hover:text-yellow-600 flex items-center transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 2.25l1.5 1.5M2.25 6h1.386a.75.75 0 01.728.546l1.312 4.607A2.25 2.25 0 007.845 13.5h8.31a2.25 2.25 0 002.169-1.347l2.373-5.659A.75.75 0 0020.06 6H6.75m0 0L5.25 2.25M7.5 21a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm11.25 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                        </svg>
                    </a>

                    @if ($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-yellow-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </div>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md
                                       text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 
                                       dark:hover:text-gray-300 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

    @if(auth()->check() && auth()->user()->role_id == 1)
        
        <x-dropdown-link :href="route('admin.dashboard')">
            Dashboard Admin
        </x-dropdown-link>

    @else

        <x-dropdown-link :href="route('profile.edit')">
            Akun Saya
        </x-dropdown-link>

        <x-dropdown-link :href="route('orders.index')">
            Pesanan Saya
        </x-dropdown-link>

    @endif


                       <!-- Logout -->
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit"
        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
        Logout
    </button>
</form>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 
                               dark:hover:bg-gray-900 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" 
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round" 
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">
     @if(auth()->check() && auth()->user()->role_id == 1)

    <x-responsive-nav-link :href="route('admin.dashboard')">
        Dashboard Admin
    </x-responsive-nav-link>
@else
    <x-responsive-nav-link :href="route('dashboard')">
        Dashboard
    </x-responsive-nav-link>
@endif


            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                Pesanan Saya
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                Keranjang
                @if ($cartCount > 0)
                    <span class="ml-2 bg-yellow-500 text-white text-xs font-semibold rounded-full px-2 py-0.5">
                        {{ $cartCount }}
                    </span>
                @endif
            </x-responsive-nav-link>
        </div>

        <!-- User Info -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Akun Saya
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>

    </div>
</nav>
