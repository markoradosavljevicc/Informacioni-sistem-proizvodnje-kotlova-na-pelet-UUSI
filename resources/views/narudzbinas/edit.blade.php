@extends('layouts.app')

@section('title', 'Izmeni Narudžbinu')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Izmeni Narudžbinu</h2>

    <form action="{{ route('narudzbinas.update', $narudzbina) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kupac *</label>
                <select name="kupac_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($kupci as $kupac)
                        <option value="{{ $kupac->id }}" {{ old('kupac_id', $narudzbina->kupac_id) == $kupac->id ? 'selected' : '' }}>
                            {{ $kupac->ime }} {{ $kupac->prezime }} ({{ $kupac->email }})
                        </option>
                    @endforeach
                </select>
                @error('kupac_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Datum Narudžbine *</label>
                <input type="date" name="datum_narudzbine" value="{{ old('datum_narudzbine', $narudzbina->datum_narudzbine) }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('datum_narudzbine') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Rok Isporuke</label>
                <input type="date" name="rok_isporuke" value="{{ old('rok_isporuke', $narudzbina->rok_isporuke) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('rok_isporuke') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="kreirana" {{ old('status', $narudzbina->status) == 'kreirana' ? 'selected' : '' }}>Kreirana</option>
                    <option value="potvrdjena" {{ old('status', $narudzbina->status) == 'potvrdjena' ? 'selected' : '' }}>Potvrđena</option>
                    <option value="u_proizvodnji" {{ old('status', $narudzbina->status) == 'u_proizvodnji' ? 'selected' : '' }}>U Proizvodnji</option>
                    <option value="spremna_za_isporuku" {{ old('status', $narudzbina->status) == 'spremna_za_isporuku' ? 'selected' : '' }}>Spremna za Isporuku</option>
                    <option value="isporucena" {{ old('status', $narudzbina->status) == 'isporucena' ? 'selected' : '' }}>Isporučena</option>
                </select>
                @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Ukupna Cena *</label>
                <input type="number" step="0.01" name="ukupna_cena" value="{{ old('ukupna_cena', $narudzbina->ukupna_cena) }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('ukupna_cena') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Napomena</label>
                <textarea name="napomena" rows="3"
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('napomena', $narudzbina->napomena) }}</textarea>
                @error('napomena') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                    Ažuriraj
                </button>
                <a href="{{ route('narudzbinas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Otkaži
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
