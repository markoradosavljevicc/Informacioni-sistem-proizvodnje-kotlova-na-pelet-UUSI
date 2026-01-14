@extends('layouts.app')

@section('title', 'Početna')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-gray-50">
    @guest
        <!-- Hero Section za goste -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
            <div class="text-center">
                <!-- Logo/Brand Section -->
                <div class="mb-8">
                    <h1 class="text-6xl sm:text-7xl font-extrabold mb-4 tracking-tight">
                        <span class="text-red-600 drop-shadow-lg">MARELLI</span>
                        <span class="text-gray-800"> KOTLOVI</span>
                    </h1>
                    <div class="w-24 h-1 bg-red-600 mx-auto rounded-full"></div>
                </div>

                <!-- Main Heading -->
                <h2 class="text-3xl sm:text-4xl font-bold mb-6 text-gray-800 leading-tight">
                    Dobrodošli u naš sistem
                </h2>

                <!-- Description -->
                <p class="text-lg sm:text-xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed px-4">
                    Informacioni sistem za upravljanje proizvodnjom kotlova na biomasu.<br>
                    Pregledajte naš katalog proizvoda i naručite kotao po vašoj meri.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 px-4">
                    <a href="{{ route('login') }}"
                       class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-10 py-4 rounded-xl text-lg font-semibold shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                        Prijavi se
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="w-full sm:w-auto bg-white hover:bg-gray-50 text-red-600 border-2 border-red-600 px-10 py-4 rounded-xl text-lg font-semibold shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                            Registruj se
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- Dashboard za prijavljene korisnike -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-10 mb-8 border border-gray-100">
                <!-- Welcome Header -->
                <div class="text-center mb-10 pb-8 border-b border-gray-200">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-3 text-gray-800">
                        Dobrodošli, <span class="text-red-600">{{ Auth::user()->name }}</span>!
                    </h2>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 rounded-full">
                        <span class="text-sm text-gray-600">Uloga:</span>
                        <span class="font-bold text-red-600">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                </div>

                <!-- Navigation Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
                    @if(auth()->user()->isAdmin() || auth()->user()->isDirektor() || auth()->user()->hasRole('komercijalista'))
                        <a href="{{ route('kupacs.index') }}"
                           class="group bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-6 sm:p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 text-center">
                            <div class="text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">👥</div>
                            <h3 class="text-xl font-bold mb-2">Kupci</h3>
                            <p class="text-sm opacity-95">Upravljanje kupcima</p>
                        </a>
                        <a href="{{ route('narudzbinas.index') }}"
                           class="group bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-6 sm:p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 text-center">
                            <div class="text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">📦</div>
                            <h3 class="text-xl font-bold mb-2">Narudžbine</h3>
                            <p class="text-sm opacity-95">Pregled i upravljanje narudžbinama</p>
                        </a>
                        <a href="{{ route('servis.index') }}"
                           class="group bg-gradient-to-br from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white p-6 sm:p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 text-center">
                            <div class="text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">🔧</div>
                            <h3 class="text-xl font-bold mb-2">Servis</h3>
                            <p class="text-sm opacity-95">Servisne intervencije</p>
                        </a>
                    @endif

                    @if(auth()->user()->isAdmin() || auth()->user()->isDirektor())
                        <a href="{{ route('proizvods.index') }}"
                           class="group bg-gradient-to-br from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white p-6 sm:p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 text-center">
                            <div class="text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">🔥</div>
                            <h3 class="text-xl font-bold mb-2">Proizvodi</h3>
                            <p class="text-sm opacity-95">Upravljanje proizvodima</p>
                        </a>
                    @else
                        <a href="{{ route('proizvods.index') }}"
                           class="group bg-gradient-to-br from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white p-6 sm:p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 text-center">
                            <div class="text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">🔥</div>
                            <h3 class="text-xl font-bold mb-2">Katalog</h3>
                            <p class="text-sm opacity-95">Pregled proizvoda i naručivanje</p>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endguest
</div>
@endsection
