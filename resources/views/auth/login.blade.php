<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Masuk ke akunmu</h1>
        <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
            Masuk untuk membuat laporan dan memantau barangmu.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4" x-data="{ showPass: false }">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-800 mb-1.5">Email</label>
            <input id="email" class="block w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-300 bg-white placeholder-gray-400 focus:border-[#0F5B54] focus:ring-1 focus:ring-[#0F5B54] transition"
                   type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold text-gray-800">Kata sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-[#0F5B54] hover:underline font-semibold" href="{{ route('password.request') }}">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <input id="password" class="block w-full px-3.5 py-2.5 pr-10 text-sm rounded-xl border border-gray-300 bg-white placeholder-gray-400 focus:border-[#0F5B54] focus:ring-1 focus:ring-[#0F5B54] transition"
                       :type="showPass ? 'text' : 'password'"
                       name="password"
                       required autocomplete="current-password" placeholder="Masukkan kata sandi" />
                <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-hidden">
                    <span class="material-symbols-outlined text-[20px]" x-text="showPass ? 'visibility_off' : 'visibility'"></span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center pt-0.5">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#0F5B54] focus:ring-[#0F5B54]" name="remember">
                <span class="ms-2 text-xs text-gray-600 font-medium">Ingat saya di perangkat ini</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3 px-4 bg-[#0F5B54] hover:bg-[#0C4A44] text-white font-bold text-sm rounded-xl transition duration-150">
                Masuk
            </button>
        </div>

        <!-- Tautan Daftar Akun Khusus Mahasiswa -->
        @if (Route::has('register'))
            <p class="text-center text-xs text-gray-600 pt-2">
                Belum punya akun mahasiswa?
                <a href="{{ route('register') }}" class="font-bold text-[#0F5B54] hover:underline">Daftar di sini</a>
            </p>
        @endif

        <!-- Quick Demo Account (Mahasiswa Only) -->
        <div class="mt-6 pt-4 border-t border-gray-100">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center mb-2">Akun Demo Mahasiswa:</p>
            <button type="button" onclick="isiAkun('mahasiswa@unsil.ac.id', 'password')"
                    class="w-full px-3 py-2 bg-[#F0F9F8] hover:bg-[#D8EDE9] text-[#0F5B54] font-semibold text-xs rounded-lg text-center transition border border-[#B5DDD5]">
                Isi Akun Mahasiswa Demo
            </button>
        </div>
    </form>

    <script>
        function isiAkun(email, pass) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
        }
    </script>
</x-guest-layout>
