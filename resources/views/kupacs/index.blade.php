@extends('layouts.app')

@section('title', 'Kupci')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Lista Kupaca</h2>
        <a href="{{ route('kupacs.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            + Dodaj Kupca
        </a>
    </div>

    @if($kupci->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Ime</th>
                        <th class="px-4 py-2 text-left">Prezime</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Telefon</th>
                        <th class="px-4 py-2 text-left">Adresa</th>
                        <th class="px-4 py-2 text-left">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kupci as $kupac)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $kupac->id }}</td>
                            <td class="px-4 py-2">{{ $kupac->ime }}</td>
                            <td class="px-4 py-2">{{ $kupac->prezime }}</td>
                            <td class="px-4 py-2">{{ $kupac->email }}</td>
                            <td class="px-4 py-2">{{ $kupac->telefon ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $kupac->adresa ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('kupacs.show', $kupac) }}" class="text-blue-500 hover:text-blue-700">Pregled</a>
                                    <a href="{{ route('kupacs.edit', $kupac) }}" class="text-yellow-500 hover:text-yellow-700">Izmeni</a>
                                    <form action="{{ route('kupacs.destroy', $kupac) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni?')">
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
            {{ $kupci->links() }}
        </div>
    @else
        <p class="text-gray-600">Nema kupaca u sistemu.</p>
    @endif
</div>
@endsection
