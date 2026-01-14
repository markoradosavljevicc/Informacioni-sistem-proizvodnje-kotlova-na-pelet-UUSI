<nav x-data="{ open: false }" class="bg-red-600 border-b border-red-700 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->check() ? route('dashboard') : route('welcome') }}" class="flex items-center space-x-2 hover:opacity-90 transition">
                        <span class="text-2xl font-bold text-white">
                            MARELLI
                        </span>
                        <span class="text-xl font-semibold text-white">
                            KOTLOVI
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        @if(auth()->user()->isAdmin() || auth()->user()->isDirektor() || auth()->user()->hasRole('komercijalista'))
                            <x-nav-link :href="route('kupacs.index')" :active="request()->routeIs('kupacs.*')">
                                Kupci
                            </x-nav-link>
                            <x-nav-link :href="route('narudzbinas.index')" :active="request()->routeIs('narudzbinas.*')">
                                Narudžbine
                            </x-nav-link>
                            <x-nav-link :href="route('servis.index')" :active="request()->routeIs('servis.*')">
                                Servis
                            </x-nav-link>
                        @endif

                        @if(auth()->user()->isAdmin() || auth()->user()->isDirektor())
                            <x-nav-link :href="route('proizvods.index')" :active="request()->routeIs('proizvods.*')">
                                Proizvodi
                            </x-nav-link>
                        @elseif(auth()->user()->hasRole('user'))
                            <x-nav-link :href="route('proizvods.index')" :active="request()->routeIs('proizvods.*')">
                                Katalog
                            </x-nav-link>
                            <x-nav-link :href="route('moje.narudzbine')" :active="request()->routeIs('moje.*')">
                                Moje Narudžbine
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('proizvods.index')" :active="request()->routeIs('proizvods.*')">
                                Katalog
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-red-500 text-sm leading-4 font-semibold rounded-md text-white bg-red-700 hover:bg-red-800 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                <div class="ms-2">
                                    <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-red-200 hover:bg-red-700 focus:outline-none focus:bg-red-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-red-600">
        <div class="px-4 py-3 border-b border-red-700">
            <a href="{{ auth()->check() ? route('dashboard') : route('welcome') }}" class="flex items-center space-x-2">
                <span class="text-xl font-bold text-white">MARELLI</span>
                <span class="text-lg font-semibold text-white">KOTLOVI</span>
            </a>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                @if(auth()->user()->isAdmin() || auth()->user()->isDirektor() || auth()->user()->hasRole('komercijalista'))
                    <x-responsive-nav-link :href="route('kupacs.index')" :active="request()->routeIs('kupacs.*')">
                        Kupci
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('narudzbinas.index')" :active="request()->routeIs('narudzbinas.*')">
                        Narudžbine
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('servis.index')" :active="request()->routeIs('servis.*')">
                        Servis
                    </x-responsive-nav-link>
                @endif

                @if(auth()->user()->isAdmin() || auth()->user()->isDirektor())
                    <x-responsive-nav-link :href="route('proizvods.index')" :active="request()->routeIs('proizvods.*')">
                        Proizvodi
                    </x-responsive-nav-link>
                @elseif(auth()->user()->hasRole('user'))
                    <x-responsive-nav-link :href="route('proizvods.index')" :active="request()->routeIs('proizvods.*')">
                        Katalog
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('moje.narudzbine')" :active="request()->routeIs('moje.*')">
                        Moje Narudžbine
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('proizvods.index')" :active="request()->routeIs('proizvods.*')">
                        Katalog
                    </x-responsive-nav-link>
                @endif
            @else
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-red-700">
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-red-100">{{ Auth::user()->email }}</div>
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
        @endauth
    </div>
</nav>
