@extends('layouts.app')

@section('title', 'Pregled Servisa')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Servis #{{ $servi->id }}</h2>
        <div class="flex space-x-2">
            <a href="{{ route('servis.edit', $servi) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                Izmeni
            </a>
            <a href="{{ route('servis.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Nazad
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Osnovni Podaci</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p><strong>ID:</strong> {{ $servi->id }}</p>
                <p><strong>Kupac:</strong> {{ $servi->kupac->ime }} {{ $servi->kupac->prezime }}</p>
                <p><strong>Email:</strong> {{ $servi->kupac->email }}</p>
                <p><strong>Proizvod:</strong> {{ $servi->proizvod->naziv ?? 'N/A' }}</p>
                <p><strong>Datum Prijave:</strong> {{ $servi->datum_prijave }}</p>
                <p><strong>Datum Završetka:</strong> {{ $servi->datum_zavrsetka ?? '-' }}</p>
                <p><strong>Status:</strong> 
                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-sm">{{ $servi->status }}</span>
                </p>
                <p><strong>Serviser:</strong> {{ $servi->serviser->name ?? '-' }}</p>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Detalji</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p><strong>Opis Kvara:</strong></p>
                <p class="text-gray-600 mb-4">{{ $servi->opis_kvara ?? '-' }}</p>
                <p><strong>Opis Popravke:</strong></p>
                <p class="text-gray-600">{{ $servi->opis_popravke ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
