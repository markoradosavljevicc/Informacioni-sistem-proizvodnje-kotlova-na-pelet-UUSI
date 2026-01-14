@extends('layouts.app')

@section('title', 'Pregled Kupca')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Pregled Kupca: {{ $kupac->ime }} {{ $kupac->prezime }}</h2>
        <div class="flex space-x-2">
            <a href="{{ route('kupacs.edit', $kupac) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                Izmeni
            </a>
            <a href="{{ route('kupacs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Nazad
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Osnovni Podaci</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p><strong>ID:</strong> {{ $kupac->id }}</p>
                <p><strong>Ime:</strong> {{ $kupac->ime }}</p>
                <p><strong>Prezime:</strong> {{ $kupac->prezime }}</p>
                <p><strong>Email:</strong> {{ $kupac->email }}</p>
                <p><strong>Telefon:</strong> {{ $kupac->telefon ?? '-' }}</p>
                <p><strong>Adresa:</strong> {{ $kupac->adresa ?? '-' }}</p>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Statistika</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p><strong>Ukupno narudžbina:</strong> {{ $kupac->narudzbine->count() }}</p>
                <p><strong>Ukupno servisa:</strong> {{ $kupac->servisi->count() }}</p>
            </div>
        </div>
    </div>

    @if($kupac->narudzbine->count() > 0)
        <div class="mb-6">
            <h3 class="font-semibold text-gray-700 mb-2">Narudžbine</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Datum</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Ukupna Cena</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kupac->narudzbine as $narudzbina)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $narudzbina->id }}</td>
                                <td class="px-4 py-2">{{ $narudzbina->datum_narudzbine }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">{{ $narudzbina->status }}</span>
                                </td>
                                <td class="px-4 py-2">{{ number_format($narudzbina->ukupna_cena, 2) }} RSD</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if($kupac->servisi->count() > 0)
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Servisi</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Datum Prijave</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Opis Kvara</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kupac->servisi as $servis)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $servis->id }}</td>
                                <td class="px-4 py-2">{{ $servis->datum_prijave }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-sm">{{ $servis->status }}</span>
                                </td>
                                <td class="px-4 py-2">{{ Str::limit($servis->opis_kvara, 50) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
