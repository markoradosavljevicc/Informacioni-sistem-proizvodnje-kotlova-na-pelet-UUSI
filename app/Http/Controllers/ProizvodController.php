<?php

namespace App\Http\Controllers;

use App\Models\Kupac;
use App\Models\Magacin;
use App\Models\Narudzbina;
use App\Models\Proizvod;
use App\Models\StavkaNarudzbine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProizvodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $proizvodi = Proizvod::with('magacin')->latest()->paginate(15);

        return view('proizvods.index', compact('proizvodi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $magacini = Magacin::all();

        return view('proizvods.create', compact('magacini'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'model' => 'nullable|string|max:100',
            'tip_goriva' => 'nullable|string|max:50',
            'cena' => 'required|numeric|min:0',
            'na_stanju' => 'required|integer|min:0',
            'magacin_id' => 'nullable|exists:magacins,id',
            'slika' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('slika')) {
            $validated['slika'] = $request->file('slika')->store('proizvodi', 'public');
        }

        Proizvod::create($validated);

        return redirect()->route('proizvods.index')
            ->with('success', 'Proizvod je uspešno kreiran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proizvod $proizvod): View
    {
        $proizvod->load('magacin', 'stavkaNarudzbines', 'servis');

        return view('proizvods.show', compact('proizvod'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proizvod $proizvod): View
    {
        $magacini = Magacin::all();

        return view('proizvods.edit', compact('proizvod', 'magacini'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proizvod $proizvod): RedirectResponse
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'model' => 'nullable|string|max:100',
            'tip_goriva' => 'nullable|string|max:50',
            'cena' => 'required|numeric|min:0',
            'na_stanju' => 'required|integer|min:0',
            'magacin_id' => 'nullable|exists:magacins,id',
            'slika' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('slika')) {
            // Obriši staru sliku ako postoji
            if ($proizvod->slika) {
                Storage::disk('public')->delete($proizvod->slika);
            }
            $validated['slika'] = $request->file('slika')->store('proizvodi', 'public');
        }

        $proizvod->update($validated);

        return redirect()->route('proizvods.index')
            ->with('success', 'Proizvod je uspešno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proizvod $proizvod): RedirectResponse
    {
        // Obriši sliku ako postoji
        if ($proizvod->slika) {
            Storage::disk('public')->delete($proizvod->slika);
        }

        $proizvod->delete();

        return redirect()->route('proizvods.index')
            ->with('success', 'Proizvod je uspešno obrisan.');
    }

    /**
     * Prikaži formu za naručivanje proizvoda (za user role)
     */
    public function naruci(Proizvod $proizvod): View
    {
        $user = auth()->user();

        // Pronađi ili kreiraj kupca na osnovu user-a
        $kupac = Kupac::where('email', $user->email)->first();

        if (! $kupac) {
            // Ako kupac ne postoji, kreiraj ga na osnovu user podataka
            $kupac = Kupac::create([
                'ime' => explode(' ', $user->name)[0] ?? $user->name,
                'prezime' => explode(' ', $user->name)[1] ?? '',
                'email' => $user->email,
            ]);
        }

        return view('proizvods.naruci', compact('proizvod', 'kupac'));
    }

    /**
     * Kreiraj narudžbinu za proizvod (za user role)
     */
    public function kreirajNarudzbinu(Request $request, Proizvod $proizvod): RedirectResponse
    {
        $validated = $request->validate([
            'kolicina' => 'required|integer|min:1|max:'.$proizvod->na_stanju,
            'rok_isporuke' => 'nullable|date|after:today',
            'napomena' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();

        // Pronađi ili kreiraj kupca
        $kupac = Kupac::where('email', $user->email)->first();

        if (! $kupac) {
            $kupac = Kupac::create([
                'ime' => explode(' ', $user->name)[0] ?? $user->name,
                'prezime' => explode(' ', $user->name)[1] ?? '',
                'email' => $user->email,
            ]);
        }

        // Kreiraj narudžbinu
        $ukupna_cena = $proizvod->cena * $validated['kolicina'];

        $narudzbina = Narudzbina::create([
            'kupac_id' => $kupac->id,
            'datum_narudzbine' => now()->toDateString(),
            'rok_isporuke' => $validated['rok_isporuke'] ?? null,
            'status' => 'kreirana',
            'ukupna_cena' => $ukupna_cena,
            'napomena' => $validated['napomena'] ?? null,
        ]);

        // Kreiraj stavku narudžbine
        StavkaNarudzbine::create([
            'narudzbina_id' => $narudzbina->id,
            'proizvod_id' => $proizvod->id,
            'kolicina' => $validated['kolicina'],
            'cena_jedinice' => $proizvod->cena,
        ]);

        return redirect()->route('proizvods.index')
            ->with('success', 'Narudžbina je uspešno kreirana! Broj narudžbine: #'.$narudzbina->id);
    }
}
