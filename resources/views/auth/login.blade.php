<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold mb-2" style="color: #000000;">Prijavi se</h2>
        <p class="text-gray-600">Prijavite se na svoj nalog</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold mb-2" style="color: #000000;">
                Email adresa
            </label>
            <input id="email" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   placeholder="unesite@email.com">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-semibold mb-2" style="color: #000000;">
                Lozinka
            </label>
            <input id="password" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="current-password"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-6 flex items-center">
            <input id="remember_me" 
                   type="checkbox" 
                   class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500" 
                   name="remember">
            <label for="remember_me" class="ms-2 text-sm" style="color: #000000;">
                Zapamti me
            </label>
        </div>

        <div class="mb-4">
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg transition">
                Prijavi se
            </button>
        </div>

        @if (Route::has('register'))
            <div class="mt-6 text-center pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-600 mb-2">Nemate nalog?</p>
                <a href="{{ route('register') }}" class="text-red-600 hover:text-red-700 font-semibold hover:underline">
                    Registrujte se
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>
