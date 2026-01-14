@extends('layouts.app')

@section('title', 'Moje Narudžbine')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Moje Narudžbine</h2>
        <a href="{{ route('proizvods.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            + Nova Narudžbina
        </a>
    </div>

    @if($narudzbine->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">Broj Narudžbine</th>
                        <th class="px-4 py-2 text-left">Datum</th>
                        <th class="px-4 py-2 text-left">Rok Isporuke</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Ukupna Cena</th>
                        <th class="px-4 py-2 text-left">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($narudzbine as $narudzbina)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 font-semibold">#{{ $narudzbina->id }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($narudzbina->datum_narudzbine)->format('d.m.Y') }}</td>
                            <td class="px-4 py-2">{{ $narudzbina->rok_isporuke ? \Carbon\Carbon::parse($narudzbina->rok_isporuke)->format('d.m.Y') : '-' }}</td>
                            <td class="px-4 py-2">
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
                            </td>
                            <td class="px-4 py-2 font-semibold">{{ number_format($narudzbina->ukupna_cena, 2) }} RSD</td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('moja.narudzbina', $narudzbina) }}" class="text-blue-500 hover:text-blue-700 font-semibold">Pregled</a>
                                    @if($narudzbina->status === 'kreirana')
                                        <form action="{{ route('moja.narudzbina.destroy', $narudzbina) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovu narudžbinu?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Obriši</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $narudzbine->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg mb-4">Nemate nijednu narudžbinu.</p>
            <a href="{{ route('proizvods.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg inline-block">
                Pregledaj Katalog i Naruči
            </a>
        </div>
    @endif
</div>
@endsection
