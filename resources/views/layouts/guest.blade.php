<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F7F8F6]">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hilang & Temukan - Universitas Siliwangi') }}</title>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased min-h-full flex flex-col justify-center py-10 sm:px-6 lg:px-8 bg-[#F7F8F6]">
        <div class="sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
            <div class="flex items-center justify-center mb-6">
                <a href="{{ route('landing') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-[#0F5B54] text-white flex items-center justify-center ">
                        <span class="material-symbols-outlined text-[24px]">search_check</span>
                    </div>
                    <div>
                        <span class="font-extrabold text-lg text-gray-900 leading-none block tracking-tight">Hilang & Temukan</span>
                        <span class="text-[10px] text-gray-500 font-bold tracking-wider">UNIVERSITAS SILIWANGI</span>
                    </div>
                </a>
            </div>

            <div class="bg-white border border-gray-200/80  rounded-2xl p-6 sm:p-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
