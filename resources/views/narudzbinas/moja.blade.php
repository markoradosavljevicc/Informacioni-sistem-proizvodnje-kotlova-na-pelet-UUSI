@extends('layouts.app')

@section('title', 'Moja Narudžbina')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Narudžbina #{{ $narudzbina->id }}</h2>
        <div class="flex space-x-2">
            @if($narudzbina->status === 'kreirana')
                <form action="{{ route('moja.narudzbina.destroy', $narudzbina) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovu narudžbinu?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                        Obriši Narudžbinu
                    </button>
                </form>
            @endif
            <a href="{{ route('moje.narudzbine') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Nazad na Listu
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="font-semibold text-gray-700 mb-2 text-lg">Osnovni Podaci</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="mb-2"><strong>Broj Narudžbine:</strong> #{{ $narudzbina->id }}</p>
                <p class="mb-2"><strong>Datum Narudžbine:</strong> {{ \Carbon\Carbon::parse($narudzbina->datum_narudzbine)->format('d.m.Y') }}</p>
                <p class="mb-2"><strong>Rok Isporuke:</strong> {{ $narudzbina->rok_isporuke ? \Carbon\Carbon::parse($narudzbina->rok_isporuke)->format('d.m.Y') : 'Nije određen' }}</p>
                <p class="mb-2"><strong>Status:</strong> 
                    @php
                        $statusColors = [
                            'kreirana' => 'bg-blue-100 text-blue-800',
                            'u obradi' => 'bg-yellow-100 text-yellow-800',
                            'isporučena' => 'bg-green-100 text-green-800',
                            'otkazana' => 'bg-red-100 text-red-800',
                        ];
                        $color = $statusColors[$narudzbina->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2 py-1 {{ $color }} rounded text-sm">{{ ucfirst($narudzbina->status) }}</span>
                </p>
                <p class="mb-2"><strong>Ukupna Cena:</strong> 
                    <span class="text-xl font-bold text-green-600">{{ number_format($narudzbina->ukupna_cena, 2) }} RSD</span>
                </p>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-gray-700 mb-2 text-lg">Vaši Podaci</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="mb-2"><strong>Ime i Prezime:</strong> {{ $narudzbina->kupac->ime }} {{ $narudzbina->kupac->prezime }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ $narudzbina->kupac->email }}</p>
                <p class="mb-2"><strong>Telefon:</strong> {{ $narudzbina->kupac->telefon ?? 'Nije unet' }}</p>
                <p class="mb-2"><strong>Adresa:</strong> {{ $narudzbina->kupac->adresa ?? 'Nije uneta' }}</p>
            </div>
        </div>
    </div>

    @if($narudzbina->napomena)
        <div class="mb-6">
            <h3 class="font-semibold text-gray-700 mb-2 text-lg">Napomena</h3>
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-gray-700">{{ $narudzbina->napomena }}</p>
            </div>
        </div>
    @endif

    @if($narudzbina->stavkaNarudzbines->count() > 0)
        <div>
            <h3 class="font-semibold text-gray-700 mb-2 text-lg">Stavke Narudžbine</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded-lg">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left">Proizvod</th>
                            <th class="px-4 py-3 text-left">Model</th>
                            <th class="px-4 py-3 text-left">Količina</th>
                            <th class="px-4 py-3 text-left">Cena po Jedinici</th>
                            <th class="px-4 py-3 text-left">Ukupno</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($narudzbina->stavkaNarudzbines as $stavka)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-semibold">{{ $stavka->proizvod->naziv ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $stavka->proizvod->model ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $stavka->kolicina }} kom</td>
                                <td class="px-4 py-3">{{ number_format($stavka->cena_jedinice, 2) }} RSD</td>
                                <td class="px-4 py-3 font-semibold">{{ number_format($stavka->kolicina * $stavka->cena_jedinice, 2) }} RSD</td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-100 font-bold">
                            <td colspan="4" class="px-4 py-3 text-right">UKUPNO:</td>
                            <td class="px-4 py-3 text-lg text-green-600">{{ number_format($narudzbina->ukupna_cena, 2) }} RSD</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 p-4 rounded-lg">
            <p class="text-yellow-800">Nema stavki u ovoj narudžbini.</p>
        </div>
    @endif

    @if($narudzbina->status === 'kreirana')
        <div class="mt-6 bg-blue-50 p-4 rounded-lg">
            <p class="text-sm text-blue-800">
                <strong>Napomena:</strong> Možete obrisati narudžbinu samo dok je u statusu "kreirana". 
                Kada narudžbina pređe u status "u obradi", više ne možete da je obrišete.
            </p>
        </div>
    @endif
</div>
@endsection
