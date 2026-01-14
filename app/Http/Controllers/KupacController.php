<?php

namespace App\Http\Controllers;

use App\Models\Kupac;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KupacController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $kupci = Kupac::latest()->paginate(15);

        return view('kupacs.index', compact('kupci'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('kupacs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'email' => 'required|email|unique:kupacs,email',
            'telefon' => 'nullable|string|max:20',
            'adresa' => 'nullable|string|max:500',
        ]);

        Kupac::create($validated);

        return redirect()->route('kupacs.index')
            ->with('success', 'Kupac je uspešno kreiran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kupac $kupac): View
    {
        $kupac->load('narudzbine', 'servisi');

        return view('kupacs.show', compact('kupac'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kupac $kupac): View
    {
        return view('kupacs.edit', compact('kupac'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kupac $kupac): RedirectResponse
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'email' => 'required|email|unique:kupacs,email,'.$kupac->id,
            'telefon' => 'nullable|string|max:20',
            'adresa' => 'nullable|string|max:500',
        ]);

        $kupac->update($validated);

        return redirect()->route('kupacs.index')
            ->with('success', 'Kupac je uspešno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kupac $kupac): RedirectResponse
    {
        $kupac->delete();

        return redirect()->route('kupacs.index')
            ->with('success', 'Kupac je uspešno obrisan.');
    }
}
