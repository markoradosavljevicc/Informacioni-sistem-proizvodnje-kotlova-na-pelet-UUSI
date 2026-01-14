@extends('layouts.app')

@section('title', 'Dodaj Narudžbinu')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Dodaj Novu Narudžbinu</h2>

    <form action="{{ route('narudzbinas.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kupac *</label>
                <select name="kupac_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Izaberi kupca</option>
                    @foreach($kupci as $kupac)
                        <option value="{{ $kupac->id }}" {{ old('kupac_id') == $kupac->id ? 'selected' : '' }}>
                            {{ $kupac->ime }} {{ $kupac->prezime }} ({{ $kupac->email }})
                        </option>
                    @endforeach
                </select>
                @error('kupac_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Datum Narudžbine *</label>
                <input type="date" name="datum_narudzbine" value="{{ old('datum_narudzbine', date('Y-m-d')) }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('datum_narudzbine') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Rok Isporuke</label>
                <input type="date" name="rok_isporuke" value="{{ old('rok_isporuke') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('rok_isporuke') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="kreirana" {{ old('status', 'kreirana') == 'kreirana' ? 'selected' : '' }}>Kreirana</option>
                    <option value="potvrdjena" {{ old('status') == 'potvrdjena' ? 'selected' : '' }}>Potvrđena</option>
                    <option value="u_proizvodnji" {{ old('status') == 'u_proizvodnji' ? 'selected' : '' }}>U Proizvodnji</option>
                    <option value="spremna_za_isporuku" {{ old('status') == 'spremna_za_isporuku' ? 'selected' : '' }}>Spremna za Isporuku</option>
                    <option value="isporucena" {{ old('status') == 'isporucena' ? 'selected' : '' }}>Isporučena</option>
                </select>
                @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Ukupna Cena *</label>
                <input type="number" step="0.01" name="ukupna_cena" value="{{ old('ukupna_cena') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('ukupna_cena') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Napomena</label>
                <textarea name="napomena" rows="3"
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('napomena') }}</textarea>
                @error('napomena') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                    Sačuvaj
                </button>
                <a href="{{ route('narudzbinas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Otkaži
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
