<?php

namespace App\Http\Controllers;

use App\Http\Requests\NarudzbinaStoreRequest;
use App\Http\Requests\NarudzbinaUpdateRequest;
use App\Models\Kupac;
use App\Models\Narudzbina;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NarudzbinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $narudzbine = Narudzbina::with('kupac')->latest()->paginate(15);

        return view('narudzbinas.index', compact('narudzbine'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $kupci = Kupac::all();

        return view('narudzbinas.create', compact('kupci'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NarudzbinaStoreRequest $request): RedirectResponse
    {
        $narudzbina = Narudzbina::create($request->validated());

        return redirect()->route('narudzbinas.index')
            ->with('success', 'Narudžbina je uspešno kreirana.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Narudzbina $narudzbina): View
    {
        // Ako je user role, proveri da li je vlasnik
        if (Auth::user()->hasRole('user')) {
            $kupac = Kupac::where('email', Auth::user()->email)->first();
            if ($kupac && $narudzbina->kupac_id === $kupac->id) {
                // Ako je vlasnik, koristi view za user-a
                return $this->mojaNarudzbina($narudzbina);
            } else {
                abort(403, 'Nemate dozvolu da pristupite ovoj narudžbini.');
            }
        }

        $narudzbina->load('kupac', 'stavkaNarudzbines.proizvod');

        return view('narudzbinas.show', compact('narudzbina'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Narudzbina $narudzbina): View
    {
        $kupci = Kupac::all();

        return view('narudzbinas.edit', compact('narudzbina', 'kupci'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NarudzbinaUpdateRequest $request, Narudzbina $narudzbina): RedirectResponse
    {
        $narudzbina->update($request->validated());

        return redirect()->route('narudzbinas.index')
            ->with('success', 'Narudžbina je uspešno ažurirana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Narudzbina $narudzbina): RedirectResponse
    {
        // Proveri da li je user vlasnik narudžbine
        if (Auth::user()->hasRole('user')) {
            $kupac = Kupac::where('email', Auth::user()->email)->first();
            if (! $kupac || $narudzbina->kupac_id !== $kupac->id) {
                abort(403, 'Nemate dozvolu da obrišete ovu narudžbinu.');
            }
        }

        $narudzbina->delete();

        // Redirect u zavisnosti od role
        if (Auth::user()->hasRole('user')) {
            return redirect()->route('moje.narudzbine')
                ->with('success', 'Narudžbina je uspešno obrisana.');
        }

        return redirect()->route('narudzbinas.index')
            ->with('success', 'Narudžbina je uspešno obrisana.');
    }

    /**
     * Use Case 1: Evidentiranje narudžbine kupca
     * Public ruta za kreiranje narudžbine od strane kupca
     */
    public function kreirajNarudzbinu(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kupac_id' => 'required|exists:kupacs,id',
            'datum_narudzbine' => 'required|date',
            'rok_isporuke' => 'nullable|date|after:datum_narudzbine',
            'ukupna_cena' => 'required|numeric|min:0',
            'napomena' => 'nullable|string|max:1000',
        ]);

        $narudzbina = Narudzbina::create([
            'kupac_id' => $validated['kupac_id'],
            'datum_narudzbine' => $validated['datum_narudzbine'],
            'rok_isporuke' => $validated['rok_isporuke'] ?? null,
            'status' => 'kreirana',
            'ukupna_cena' => $validated['ukupna_cena'],
            'napomena' => $validated['napomena'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Narudžbina je uspešno kreirana.',
            'narudzbina' => $narudzbina->load('kupac'),
        ], 201);
    }

    /**
     * Prikaži sve narudžbine trenutnog user-a (za user role)
     */
    public function mojeNarudzbine(): View
    {
        $user = Auth::user();
        $kupac = Kupac::where('email', $user->email)->first();

        if (! $kupac) {
            $narudzbine = collect(); // Prazna kolekcija
        } else {
            $narudzbine = Narudzbina::where('kupac_id', $kupac->id)
                ->with('kupac', 'stavkaNarudzbines.proizvod')
                ->latest()
                ->paginate(15);
        }

        return view('narudzbinas.moje', compact('narudzbine'));
    }

    /**
     * Prikaži jednu narudžbinu user-a (za user role)
     */
    public function mojaNarudzbina(Narudzbina $narudzbina): View
    {
        $user = Auth::user();
        $kupac = Kupac::where('email', $user->email)->first();

        // Proveri da li je user vlasnik narudžbine
        if (! $kupac || $narudzbina->kupac_id !== $kupac->id) {
            abort(403, 'Nemate dozvolu da pristupite ovoj narudžbini.');
        }

        $narudzbina->load('kupac', 'stavkaNarudzbines.proizvod');

        return view('narudzbinas.moja', compact('narudzbina'));
    }
}
