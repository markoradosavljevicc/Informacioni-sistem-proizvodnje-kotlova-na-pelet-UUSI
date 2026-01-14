<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiStoreRequest;
use App\Http\Requests\ServiUpdateRequest;
use App\Models\Kupac;
use App\Models\Proizvod;
use App\Models\Servis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $servisi = Servis::with(['kupac', 'proizvod', 'serviser'])->latest()->paginate(15);

        return view('servis.index', compact('servisi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $kupci = Kupac::all();
        $proizvodi = Proizvod::all();

        return view('servis.create', compact('kupci', 'proizvodi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiStoreRequest $request): RedirectResponse
    {
        $servis = Servis::create($request->validated());

        return redirect()->route('servis.index')
            ->with('success', 'Servis je uspešno kreiran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Servis $servi): View
    {
        $servi->load('kupac', 'proizvod', 'serviser');

        return view('servis.show', compact('servi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servis $servi): View
    {
        $kupci = Kupac::all();
        $proizvodi = Proizvod::all();

        return view('servis.edit', compact('servi', 'kupci', 'proizvodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiUpdateRequest $request, Servis $servi): RedirectResponse
    {
        $servi->update($request->validated());

        return redirect()->route('servis.index')
            ->with('success', 'Servis je uspešno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servis $servi): RedirectResponse
    {
        $servi->delete();

        return redirect()->route('servis.index')
            ->with('success', 'Servis je uspešno obrisan.');
    }

    /**
     * Use Case 3: Evidencija servisa
     * Public ruta za prijavu servisa od strane kupca
     */
    public function prijaviServis(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kupac_id' => 'required|exists:kupacs,id',
            'proizvod_id' => 'required|exists:proizvods,id',
            'datum_prijave' => 'required|date',
            'opis_kvara' => 'required|string|max:2000',
        ]);

        $servis = Servis::create([
            'kupac_id' => $validated['kupac_id'],
            'proizvod_id' => $validated['proizvod_id'],
            'datum_prijave' => $validated['datum_prijave'],
            'opis_kvara' => $validated['opis_kvara'],
            'status' => 'prijavljen',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Servis je uspešno prijavljen.',
            'servis' => $servis->load('kupac', 'proizvod'),
        ], 201);
    }
}
