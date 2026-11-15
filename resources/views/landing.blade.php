<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hilang & Temukan</title>
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FAFAFA] text-gray-800 antialiased min-h-screen flex flex-col font-sans">
        
        <!-- NAVBAR HEADER -->
        <header class="w-full bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-emerald-100">
            <div class="max-w-6xl mx-auto px-6 h-16 flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <div class="bg-emerald-600 text-white p-2 rounded-xl shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-extrabold text-lg text-emerald-900 leading-none block">Hilang & Temukan</span>
                        <span class="text-[10px] text-emerald-700 font-semibold tracking-wide">UNIVERSITAS SILIWANGI</span>
                    </div>
                </div>
            </div>
        </header>
        <main class="flex-grow flex flex-col items-start sm:items-center justify-start sm:justify-center px-4 pt-4 pb-8 sm:py-12">
            <div class="max-w-3xl w-full text-center space-y-3 sm:space-y-6">

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-900 tracking-tight leading-snug sm:leading-tight">
                    Barang Hilang di Kampus? <br>
                    <span class="text-emerald-600">Temukan & Laporkan Di Sini :D</span>
                </h1>

                <p class="text-[13px] sm:text-base text-gray-600 max-w-xl mx-auto leading-relaxed">
                    Cek barang yang sudah ditemukan, atau laporkan barangmu yang hilang. Cukup beberapa menit, tanpa harus keliling kampus.
                </p>

                <div class="pt-6 max-w-xl mx-auto">
                    <p class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">Masuk Sebagai</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- MAHASISWA -->
                        <a href="{{ route('login') }}" class="group p-3 sm:p-5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl sm:rounded-2xl transition duration-200 shadow-md hover:shadow-lg text-left flex items-center justify-between border border-emerald-500">
                            <div class="flex items-center gap-3">

                                <div class="p-1.5 sm:p-2.5 bg-white/20 rounded-lg sm:rounded-xl shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    </svg>
                                </div>

                                <div>
                                    <div class="font-bold text-xs sm:text-base leading-tight">Masuk sebagai Mahasiswa</div>
                                    <div class="text-[15px] sm:text-xs text-emerald-100/90 mt-0.5">Lapor & cek barang temu an</div>
                                </div>
                            </div>
                            <span class="text-sm sm:text-xl opacity-70 group-hover:translate-x-1 group-hover:opacity-100 transition-all ml-2">→</span>
                        </a>

                        <!-- ADMIN -->
                        <a href="{{ route('login') }}" class="group p-3 sm:p-5 bg-emerald-900 hover:bg-black text-white rounded-xl sm:rounded-2xl transition duration-200 shadow-md hover:shadow-lg text-left flex items-center justify-between border border-emerald-800">
                            <div class="flex items-center gap-3">

                                <div class="p-1.5 sm:p-2.5 bg-white/10 rounded-lg sm:rounded-xl shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>

                                <div>
                                    <div class="font-bold text-xs sm:text-base leading-tight">Masuk sebagai Admin</div>
                                    <div class="text-[10px] sm:text-xs text-emerald-200/70 mt-0.5">Kelola laporan temuan</div>
                                </div>
                            </div>
                            <span class="text-sm sm:text-xl opacity-70 group-hover:translate-x-1 group-hover:opacity-100 transition-all ml-2">→</span>
                        </a>
                    </div>
                </div>

            </div>
        </main>
        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>