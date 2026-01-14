@extends('layouts.app')

@section('title', 'Servis')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Lista Servisa</h2>
        <a href="{{ route('servis.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            + Dodaj Servis
        </a>
    </div>

    @if($servisi->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Kupac</th>
                        <th class="px-4 py-2 text-left">Proizvod</th>
                        <th class="px-4 py-2 text-left">Datum Prijave</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Serviser</th>
                        <th class="px-4 py-2 text-left">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servisi as $servi)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $servi->id }}</td>
                            <td class="px-4 py-2">{{ $servi->kupac->ime }} {{ $servi->kupac->prezime }}</td>
                            <td class="px-4 py-2">{{ $servi->proizvod->naziv ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $servi->datum_prijave }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-sm">{{ $servi->status }}</span>
                            </td>
                            <td class="px-4 py-2">{{ $servi->serviser->name ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('servis.show', $servi) }}" class="text-blue-500 hover:text-blue-700">Pregled</a>
                                    <a href="{{ route('servis.edit', $servi) }}" class="text-yellow-500 hover:text-yellow-700">Izmeni</a>
                                    <form action="{{ route('servis.destroy', $servi) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni?')">
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
            {{ $servisi->links() }}
        </div>
    @else
        <p class="text-gray-600">Nema servisa u sistemu.</p>
    @endif
</div>
@endsection
