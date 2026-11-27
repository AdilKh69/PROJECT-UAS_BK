<x-guest-layout>
    <div class="mb-6">
        <span class="inline-block px-2.5 py-0.5 bg-[#E6F4F1] text-[#0F5B54] text-[11px] font-bold rounded-md mb-2">
            Portal Administrator
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Masuk Panel Admin</h1>
        <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
            Masuk khusus administrator kampus Hilang & Temukan UNSIL.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-4" x-data="{ showPass: false }">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-800 mb-1.5">Email Administrator</label>
            <input id="email" class="block w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-300 bg-white placeholder-gray-400 focus:border-[#0F5B54] focus:ring-1 focus:ring-[#0F5B54] transition"
                   type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@unsil.ac.id" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-gray-800 mb-1.5">Kata sandi</label>
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
                Masuk ke Panel Admin
            </button>
        </div>

        <!-- Quick Demo Admin Account -->
        <div class="mt-6 pt-4 border-t border-gray-100">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center mb-2">Akun Demo Administrator:</p>
            <button type="button" onclick="isiAdmin('admin@unsil.ac.id', 'password')"
                    class="w-full px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold text-xs rounded-lg text-center transition border border-gray-200">
                Isi Akun Admin Demo
            </button>
        </div>
    </form>

    <script>
        function isiAdmin(email, pass) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
        }
    </script>
</x-guest-layout>
