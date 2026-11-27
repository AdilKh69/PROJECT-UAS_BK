<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F7F8F6]">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hilang & Temukan - Panel Admin') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#F7F8F6] text-gray-800 h-full" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex">
            <!-- Mobile Backdrop -->
            <div x-show="sidebarOpen"
                 x-transition.opacity
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-black/40 z-40 lg:hidden"
                 style="display: none;"></div>

            <!-- SIDEBAR ADMIN -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0F5B54] text-white flex flex-col justify-between transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:inset-auto shrink-0">
                <div>
                    <!-- Brand -->
                    <div class="px-5 py-5 flex items-center justify-between border-b border-white/10">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white text-[#0F5B54] flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[22px]">search_check</span>
                            </div>
                            <div>
                                <span class="font-extrabold text-base text-white leading-none block">Hilang & Temukan</span>
                                <span class="text-[11px] text-emerald-100/80 font-medium block mt-0.5">Panel Admin</span>
                            </div>
                        </a>

                        <button type="button" @click="sidebarOpen = false" class="lg:hidden text-emerald-100 hover:text-white p-1">
                            <span class="material-symbols-outlined text-[22px]">close</span>
                        </button>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="p-3 space-y-1.5 mt-2">
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white' : 'text-emerald-100/85 hover:bg-white/10 hover:text-white' }}">
                            <span class="material-symbols-outlined text-[20px]">list_alt</span>
                            <span>Laporan Mahasiswa</span>
                        </a>

                        <a href="{{ route('barangs.create') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('barangs.create') ? 'bg-white/15 text-white' : 'text-emerald-100/85 hover:bg-white/10 hover:text-white' }}">
                            <span class="material-symbols-outlined text-[20px]">add_circle</span>
                            <span>Input Laporan</span>
                        </a>

                        <a href="{{ route('admin.dashboard') }}#mahasiswa"
                           @click="sidebarOpen = false"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-emerald-100/85 hover:bg-white/10 hover:text-white transition">
                            <span class="material-symbols-outlined text-[20px]">group</span>
                            <span>Data Mahasiswa</span>
                        </a>

                        <div class="pt-2 mt-2 border-t border-white/10">
                            <a href="{{ route('beranda') }}" target="_blank"
                               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-emerald-100/85 hover:bg-white/10 hover:text-white transition">
                                <span class="material-symbols-outlined text-[20px]">open_in_new</span>
                                <span>Lihat Web Publik</span>
                            </a>
                        </div>
                    </nav>
                </div>

                <!-- Sidebar Footer (Admin Profile & Logout) -->
                <div class="p-4 border-t border-white/10 space-y-3">
                    @php
                        $adminName = Auth::user()->name;
                        $nameParts = explode(' ', trim($adminName));
                        $initials = strtoupper(substr($nameParts[0] ?? 'A', 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : substr($nameParts[0] ?? 'D', 1, 1)));
                    @endphp
                    <div class="flex items-center gap-3 px-1">
                        <div class="w-9 h-9 rounded-full bg-white text-[#0F5B54] font-bold text-xs flex items-center justify-center shrink-0">
                            {{ $initials }}
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-bold text-white truncate">{{ $adminName }}</div>
                            <div class="text-[11px] text-emerald-100/75 truncate">Universitas Siliwangi</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-semibold text-emerald-100 hover:bg-white/10 hover:text-white transition">
                            <span class="material-symbols-outlined text-[19px]">logout</span>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- MAIN CONTENT COLUMN -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Mobile Top Bar -->
                <div class="lg:hidden bg-white border-b border-gray-200 px-4 h-14 flex items-center justify-between sticky top-0 z-30">
                    <button type="button" @click="sidebarOpen = true" class="p-1.5 -ml-1.5 text-gray-700 hover:text-[#0F5B54] rounded-lg">
                        <span class="material-symbols-outlined text-[24px]">menu</span>
                    </button>
                    <span class="font-extrabold text-sm text-gray-900">Panel Admin &bull; Hilang & Temukan</span>
                    <div class="w-8"></div>
                </div>

                <!-- Optional Page Header -->
                @isset($header)
                    <header class="px-4 sm:px-6 lg:px-8 pt-6 pb-2">
                        <div class="max-w-7xl mx-auto">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6">
                    <div class="max-w-7xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
