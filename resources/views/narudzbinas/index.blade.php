@extends('layouts.app')

@section('title', 'Narudžbine')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Lista Narudžbina</h2>
        <a href="{{ route('narudzbinas.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            + Dodaj Narudžbinu
        </a>
    </div>

    @if($narudzbine->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Kupac</th>
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
                            <td class="px-4 py-2">{{ $narudzbina->id }}</td>
                            <td class="px-4 py-2">{{ $narudzbina->kupac->ime }} {{ $narudzbina->kupac->prezime }}</td>
                            <td class="px-4 py-2">{{ $narudzbina->datum_narudzbine }}</td>
                            <td class="px-4 py-2">{{ $narudzbina->rok_isporuke ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">{{ $narudzbina->status }}</span>
                            </td>
                            <td class="px-4 py-2">{{ number_format($narudzbina->ukupna_cena, 2) }} RSD</td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('narudzbinas.show', $narudzbina) }}" class="text-blue-500 hover:text-blue-700">Pregled</a>
                                    <a href="{{ route('narudzbinas.edit', $narudzbina) }}" class="text-yellow-500 hover:text-yellow-700">Izmeni</a>
                                    <form action="{{ route('narudzbinas.destroy', $narudzbina) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">Obriši</button>
                                    </form>
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
        <p class="text-gray-600">Nema narudžbina u sistemu.</p>
    @endif
</div>
@endsection
