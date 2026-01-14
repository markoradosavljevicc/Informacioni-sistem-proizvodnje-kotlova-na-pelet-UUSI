@extends('layouts.app')

@section('title', 'Proizvodi')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
    @endif
    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isDirektor())
                Lista Proizvoda
            @else
                Katalog Proizvoda
            @endif
            @else
                Katalog Proizvoda
            @endauth
        </h2>
        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isDirektor())
                <a href="{{ route('proizvods.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    + Dodaj Proizvod
                </a>
            @endif
        @endauth
    </div>

    @if($proizvodi->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">Slika</th>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Naziv</th>
                        <th class="px-4 py-2 text-left">Model</th>
                        <th class="px-4 py-2 text-left">Tip Goriva</th>
                        <th class="px-4 py-2 text-left">Cena</th>
                        <th class="px-4 py-2 text-left">Na Stanju</th>
                        <th class="px-4 py-2 text-left">Magacin</th>
                        <th class="px-4 py-2 text-left">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proizvodi as $proizvod)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">
                                @if($proizvod->slika)
                                    <img src="{{ asset('storage/' . $proizvod->slika) }}" alt="{{ $proizvod->naziv }}" 
                                         class="w-16 h-16 object-cover rounded border border-gray-300">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded border border-gray-300 flex items-center justify-center text-gray-400 text-xs">
                                        Nema slike
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $proizvod->id }}</td>
                            <td class="px-4 py-2">{{ $proizvod->naziv }}</td>
                            <td class="px-4 py-2">{{ $proizvod->model ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $proizvod->tip_goriva ?? '-' }}</td>
                            <td class="px-4 py-2">{{ number_format($proizvod->cena, 2) }} RSD</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 {{ $proizvod->na_stanju > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded text-sm">
                                    {{ $proizvod->na_stanju }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $proizvod->magacin->naziv ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('proizvods.show', $proizvod) }}" class="text-blue-500 hover:text-blue-700">Pregled</a>
                                    @auth
                                        @if(auth()->user()->isAdmin() || auth()->user()->isDirektor())
                                            <a href="{{ route('proizvods.edit', $proizvod) }}" class="text-yellow-500 hover:text-yellow-700">Izmeni</a>
                                            <form action="{{ route('proizvods.destroy', $proizvod) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Obriši</button>
                                            </form>
                                        @elseif(auth()->user()->hasRole('user') && $proizvod->na_stanju > 0)
                                            <a href="{{ route('proizvods.naruci', $proizvod) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                                Naruči
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $proizvodi->links() }}
        </div>
    @else
        <p class="text-gray-600">Nema proizvoda u sistemu.</p>
    @endif
</div>
@endsection
