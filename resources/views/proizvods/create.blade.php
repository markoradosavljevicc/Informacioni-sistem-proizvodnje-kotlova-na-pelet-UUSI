@extends('layouts.app')

@section('title', 'Dodaj Proizvod')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Dodaj Novi Proizvod</h2>

    <form action="{{ route('proizvods.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Naziv *</label>
                <input type="text" name="naziv" value="{{ old('naziv') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('naziv') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Model</label>
                <input type="text" name="model" value="{{ old('model') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('model') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Tip Goriva</label>
                <select name="tip_goriva" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Izaberi tip</option>
                    <option value="pellet" {{ old('tip_goriva') == 'pellet' ? 'selected' : '' }}>Pellet</option>
                    <option value="drvo" {{ old('tip_goriva') == 'drvo' ? 'selected' : '' }}>Drvo</option>
                    <option value="ugalj" {{ old('tip_goriva') == 'ugalj' ? 'selected' : '' }}>Ugalj</option>
                </select>
                @error('tip_goriva') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Cena *</label>
                <input type="number" step="0.01" name="cena" value="{{ old('cena') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('cena') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Na Stanju *</label>
                <input type="number" name="na_stanju" value="{{ old('na_stanju', 0) }}" required min="0"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('na_stanju') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Magacin</label>
                <select name="magacin_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Izaberi magacin</option>
                    @foreach($magacini as $magacin)
                        <option value="{{ $magacin->id }}" {{ old('magacin_id') == $magacin->id ? 'selected' : '' }}>
                            {{ $magacin->naziv }} ({{ $magacin->lokacija ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
                @error('magacin_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Slika Proizvoda</label>
                <input type="file" name="slika" accept="image/jpeg,image/png,image/jpg,image/gif"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-sm text-gray-500 mt-1">Maksimalna veličina: 2MB. Dozvoljeni formati: JPEG, PNG, JPG, GIF</p>
                @error('slika') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                    Sačuvaj
                </button>
                <a href="{{ route('proizvods.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Otkaži
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
