@extends('layouts.app')

@section('title', 'Pregled Proizvoda')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">{{ $proizvod->naziv }}</h2>
        <div class="flex space-x-2">
            @auth
                @if(auth()->user()->isAdmin() || auth()->user()->isDirektor())
                    <a href="{{ route('proizvods.edit', $proizvod) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                        Izmeni
                    </a>
                @elseif(auth()->user()->hasRole('user') && $proizvod->na_stanju > 0)
                    <a href="{{ route('proizvods.naruci', $proizvod) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Naruči Proizvod
                    </a>
                @endif
            @endauth
            <a href="{{ route('proizvods.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Nazad
            </a>
        </div>
    </div>

    @if($proizvod->slika)
        <div class="mb-6">
            <img src="{{ asset('storage/' . $proizvod->slika) }}" alt="{{ $proizvod->naziv }}"
                 class="w-full max-w-2xl mx-auto rounded-lg shadow-lg object-cover" style="max-height: 500px;">
        </div>
    @endif

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Osnovni Podaci</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p><strong>ID:</strong> {{ $proizvod->id }}</p>
                <p><strong>Naziv:</strong> {{ $proizvod->naziv }}</p>
                <p><strong>Model:</strong> {{ $proizvod->model ?? '-' }}</p>
                <p><strong>Tip Goriva:</strong> {{ $proizvod->tip_goriva ?? '-' }}</p>
                <p><strong>Cena:</strong> {{ number_format($proizvod->cena, 2) }} RSD</p>
                <p><strong>Na Stanju:</strong>
                    <span class="px-2 py-1 {{ $proizvod->na_stanju > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded text-sm">
                        {{ $proizvod->na_stanju }}
                    </span>
                </p>
                <p><strong>Magacin:</strong> {{ $proizvod->magacin->naziv ?? '-' }}</p>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Statistika</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p><strong>Ukupno u narudžbinama:</strong> {{ $proizvod->stavkaNarudzbines->count() }}</p>
                <p><strong>Ukupno servisa:</strong> {{ $proizvod->servis->count() }}</p>
            </div>
        </div>

        @auth
            @if(auth()->user()->hasRole('user') && $proizvod->na_stanju > 0)
                <div class="mt-6 text-center">
                    <a href="{{ route('proizvods.naruci', $proizvod) }}" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg text-lg font-semibold inline-block">
                        🛒 Naruči Ovaj Proizvod
                    </a>
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection
