@extends('layouts.app')

@section('title', 'Izmeni Servis')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Izmeni Servis</h2>

    <form action="{{ route('servis.update', $servi) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kupac *</label>
                <select name="kupac_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($kupci as $kupac)
                        <option value="{{ $kupac->id }}" {{ old('kupac_id', $servi->kupac_id) == $kupac->id ? 'selected' : '' }}>
                            {{ $kupac->ime }} {{ $kupac->prezime }} ({{ $kupac->email }})
                        </option>
                    @endforeach
                </select>
                @error('kupac_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Proizvod *</label>
                <select name="proizvod_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($proizvodi as $proizvod)
                        <option value="{{ $proizvod->id }}" {{ old('proizvod_id', $servi->proizvod_id) == $proizvod->id ? 'selected' : '' }}>
                            {{ $proizvod->naziv }} ({{ $proizvod->model ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
                @error('proizvod_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Datum Prijave *</label>
                <input type="date" name="datum_prijave" value="{{ old('datum_prijave', $servi->datum_prijave) }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('datum_prijave') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Datum Završetka</label>
                <input type="date" name="datum_zavrsetka" value="{{ old('datum_zavrsetka', $servi->datum_zavrsetka) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('datum_zavrsetka') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Opis Kvara *</label>
                <textarea name="opis_kvara" rows="4" required
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('opis_kvara', $servi->opis_kvara) }}</textarea>
                @error('opis_kvara') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Opis Popravke</label>
                <textarea name="opis_popravke" rows="4"
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('opis_popravke', $servi->opis_popravke) }}</textarea>
                @error('opis_popravke') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="prijavljen" {{ old('status', $servi->status) == 'prijavljen' ? 'selected' : '' }}>Prijavljen</option>
                    <option value="u_toku" {{ old('status', $servi->status) == 'u_toku' ? 'selected' : '' }}>U Toku</option>
                    <option value="zavrsen" {{ old('status', $servi->status) == 'zavrsen' ? 'selected' : '' }}>Završen</option>
                </select>
                @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                    Ažuriraj
                </button>
                <a href="{{ route('servis.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Otkaži
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
