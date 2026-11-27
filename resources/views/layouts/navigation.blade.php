<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('beranda') }}" class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-[#0F5B54] text-white flex items-center justify-center ">
                            <span class="material-symbols-outlined text-[20px]">search_check</span>
                        </div>
                        <div>
                            <span class="font-extrabold text-base text-gray-900 leading-none block">Hilang & Temukan</span>
                            <span class="text-[9px] text-gray-500 font-bold tracking-wider">UNIVERSITAS SILIWANGI</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-8 sm:flex">
                    <x-nav-link :href="route('beranda')" :active="request()->routeIs('beranda')">
                        {{ __('Katalog Barang') }}
                    </x-nav-link>
                    <x-nav-link :href="route('barangs.create')" :active="request()->routeIs('barangs.create')">
                        {{ __('+ Buat Laporan') }}
                    </x-nav-link>
                    <x-nav-link :href="route('barangs.my')" :active="request()->routeIs('barangs.my')">
                        {{ __('Laporan Saya') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <a href="{{ route('barangs.create') }}" class="me-4 inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-accent hover:bg-accent-600 text-white text-xs font-bold rounded-lg  transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Lapor Barang
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-gray-200 text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="flex items-center gap-2">
                                <span>{{ Auth::user()->name }}</span>
                                @if(Auth::user()->isAdmin())
                                    <span class="px-1.5 py-0.5 text-[10px] bg-red-100 text-red-700 rounded font-bold uppercase">Admin</span>
                                @else
                                    <span class="px-1.5 py-0.5 text-[10px] bg-emerald-100 text-emerald-700 rounded font-semibold">Mhs</span>
                                @endif
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100 text-xs text-gray-500">
                            <div>Email: {{ Auth::user()->email }}</div>
                            @if(Auth::user()->npm)
                                <div>NPM: {{ Auth::user()->npm }}</div>
                            @endif
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil Akun') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Keluar (Log Out)') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('beranda')" :active="request()->routeIs('beranda')">
                {{ __('Katalog Barang') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('barangs.create')" :active="request()->routeIs('barangs.create')">
                {{ __('+ Buat Laporan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('barangs.my')" :active="request()->routeIs('barangs.my')">
                {{ __('Laporan Saya') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil Akun') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Keluar (Log Out)') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
