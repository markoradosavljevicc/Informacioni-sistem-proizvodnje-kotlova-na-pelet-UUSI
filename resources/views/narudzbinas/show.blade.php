@extends('layouts.app')

@section('title', 'Pregled Narudžbine')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Narudžbina #{{ $narudzbina->id }}</h2>
        <div class="flex space-x-2">
            <a href="{{ route('narudzbinas.edit', $narudzbina) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                Izmeni
            </a>
            <a href="{{ route('narudzbinas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Nazad
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Osnovni Podaci</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p><strong>ID:</strong> {{ $narudzbina->id }}</p>
                <p><strong>Kupac:</strong> {{ $narudzbina->kupac->ime }} {{ $narudzbina->kupac->prezime }}</p>
                <p><strong>Email:</strong> {{ $narudzbina->kupac->email }}</p>
                <p><strong>Datum Narudžbine:</strong> {{ $narudzbina->datum_narudzbine }}</p>
                <p><strong>Rok Isporuke:</strong> {{ $narudzbina->rok_isporuke ?? '-' }}</p>
                <p><strong>Status:</strong> 
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">{{ $narudzbina->status }}</span>
                </p>
                <p><strong>Ukupna Cena:</strong> {{ number_format($narudzbina->ukupna_cena, 2) }} RSD</p>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Dodatne Informacije</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p><strong>Napomena:</strong></p>
                <p class="text-gray-600">{{ $narudzbina->napomena ?? 'Nema napomene' }}</p>
            </div>
        </div>
    </div>

    @if($narudzbina->stavkaNarudzbines->count() > 0)
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Stavke Narudžbine</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">Proizvod</th>
                            <th class="px-4 py-2 text-left">Količina</th>
                            <th class="px-4 py-2 text-left">Cena po Jedinici</th>
                            <th class="px-4 py-2 text-left">Ukupno</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($narudzbina->stavkaNarudzbines as $stavka)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $stavka->proizvod->naziv ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $stavka->kolicina }}</td>
                                <td class="px-4 py-2">{{ number_format($stavka->cena_jedinice, 2) }} RSD</td>
                                <td class="px-4 py-2">{{ number_format($stavka->kolicina * $stavka->cena_jedinice, 2) }} RSD</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
