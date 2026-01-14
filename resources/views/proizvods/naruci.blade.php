@extends('layouts.app')

@section('title', 'Naruči Proizvod')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Naruči: {{ $proizvod->naziv }}</h2>

    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <h3 class="font-semibold text-gray-700 mb-2">Informacije o Proizvodu</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p><strong>Naziv:</strong> {{ $proizvod->naziv }}</p>
                <p><strong>Model:</strong> {{ $proizvod->model ?? '-' }}</p>
                <p><strong>Tip Goriva:</strong> {{ $proizvod->tip_goriva ?? '-' }}</p>
            </div>
            <div>
                <p><strong>Cena:</strong> {{ number_format($proizvod->cena, 2) }} RSD</p>
                <p><strong>Na Stanju:</strong> {{ $proizvod->na_stanju }} kom</p>
                <p><strong>Magacin:</strong> {{ $proizvod->magacin->naziv ?? '-' }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('proizvods.kreiraj-narudzbinu', $proizvod) }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Količina *</label>
                <input type="number" name="kolicina" value="{{ old('kolicina', 1) }}" required min="1" max="{{ $proizvod->na_stanju }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-sm text-gray-500 mt-1">Dostupno: {{ $proizvod->na_stanju }} kom</p>
                @error('kolicina') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Rok Isporuke</label>
                <input type="date" name="rok_isporuke" value="{{ old('rok_isporuke') }}"
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('rok_isporuke') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Napomena</label>
                <textarea name="napomena" rows="3"
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('napomena') }}</textarea>
                @error('napomena') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-sm text-gray-700">
                    <strong>Ukupna cena:</strong> 
                    <span id="ukupna-cena" class="text-xl font-bold text-blue-600">
                        {{ number_format($proizvod->cena, 2) }} RSD
                    </span>
                </p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-700 mb-2">Vaši Podaci</h4>
                <p><strong>Ime:</strong> {{ $kupac->ime }} {{ $kupac->prezime }}</p>
                <p><strong>Email:</strong> {{ $kupac->email }}</p>
                <p><strong>Telefon:</strong> {{ $kupac->telefon ?? 'Nije unet' }}</p>
                <p><strong>Adresa:</strong> {{ $kupac->adresa ?? 'Nije uneta' }}</p>
                <p class="text-sm text-gray-500 mt-2">Ako želite da izmenite podatke, možete to uraditi u <a href="{{ route('profile.edit') }}" class="text-blue-500 hover:underline">profilu</a>.</p>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold">
                    Potvrdi Narudžbinu
                </button>
                <a href="{{ route('proizvods.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">
                    Otkaži
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    // Dinamičko računanje ukupne cene
    document.querySelector('input[name="kolicina"]').addEventListener('input', function() {
        const kolicina = parseInt(this.value) || 1;
        const cena = {{ $proizvod->cena }};
        const ukupno = kolicina * cena;
        document.getElementById('ukupna-cena').textContent = ukupno.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' RSD';
    });
</script>
@endsection
