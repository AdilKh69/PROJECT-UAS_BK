import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Tema Utama Aplikasi (Berdasarkan Desain Referensi UI/UX)
                surface: {
                    DEFAULT: '#F7F8F6',
                    50: '#FFFFFF',
                    100: '#F7F8F6',
                    200: '#EFEFEA',
                    300: '#E4E5DE',
                },
                // Warna Utama Hijau Pine (#0F5B54) yang lebih cerah & nyata terlihat hijau
                brand: {
                    DEFAULT: '#0F5B54',
                    50: '#F0F9F8',
                    100: '#D8EDE9',
                    200: '#B5DDD5',
                    300: '#86C5BA',
                    400: '#52A699',
                    500: '#2C877A',
                    600: '#0F5B54', // Hijau Pine Utama
                    700: '#0C4A44',
                    800: '#0B3C37',
                    900: '#0A312D',
                    950: '#051E1B',
                },
                accent: {
                    DEFAULT: '#E88D2A',
                    50: '#FEF8F0',
                    100: '#FCEEDB',
                    200: '#FAD9B3',
                    300: '#F5BE81',
                    400: '#EFA04F',
                    500: '#E88D2A', // Warna Aksen Amber
                    600: '#D2761C',
                    700: '#AC5918',
                    800: '#894519',
                    900: '#703A18',
                    950: '#3D1C09',
                },
                // Alias agar semua class emerald di Blade otomatis memakai warna Hijau Pine #0F5B54
                emerald: {
                    50: '#F0F9F8',
                    100: '#D8EDE9',
                    200: '#B5DDD5',
                    300: '#86C5BA',
                    400: '#52A699',
                    500: '#2C877A',
                    600: '#0F5B54', // #0F5B54
                    700: '#0C4A44',
                    800: '#0B3C37',
                    900: '#0A312D',
                    950: '#051E1B',
                },
                amber: {
                    50: '#FEF8F0',
                    100: '#FCEEDB',
                    200: '#FAD9B3',
                    300: '#F5BE81',
                    400: '#EFA04F',
                    500: '#E88D2A',
                    600: '#D2761C',
                    700: '#AC5918',
                    800: '#894519',
                    900: '#703A18',
                    950: '#3D1C09',
                },
            },
        },
    },

    plugins: [
        forms,
    ],
};
