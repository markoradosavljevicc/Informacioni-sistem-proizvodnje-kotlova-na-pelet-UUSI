<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold mb-2" style="color: #000000;">Registruj se</h2>
        <p class="text-gray-600">Kreirajte novi nalog</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold mb-2" style="color: #000000;">
                Ime i prezime
            </label>
            <input id="name" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   autocomplete="name"
                   placeholder="Unesite ime i prezime">
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

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
                   autocomplete="new-password"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-semibold mb-2" style="color: #000000;">
                Potvrdi lozinku
            </label>
            <input id="password_confirmation" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password"
                   placeholder="••••••••">
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg transition">
                Registruj se
            </button>
        </div>

        <div class="mt-6 text-center pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-600 mb-2">Već imate nalog?</p>
            <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 font-semibold hover:underline">
                Prijavite se
            </a>
        </div>
    </form>
</x-guest-layout>
