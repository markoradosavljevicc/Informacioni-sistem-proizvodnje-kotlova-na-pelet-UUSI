<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin i Direktor - pristup svemu
Route::middleware(['auth', 'role:admin,direktor'])->group(function () {
    Route::resource('kupacs', App\Http\Controllers\KupacController::class);
    Route::resource('narudzbinas', App\Http\Controllers\NarudzbinaController::class);
    Route::resource('proizvods', App\Http\Controllers\ProizvodController::class);
    Route::resource('servis', App\Http\Controllers\ServisController::class);
});

// Komercijalista - pristup narudžbinama, servisima, kupcima
Route::middleware(['auth', 'role:komercijalista'])->group(function () {
    Route::resource('kupacs', App\Http\Controllers\KupacController::class)->except(['destroy']);
    Route::resource('narudzbinas', App\Http\Controllers\NarudzbinaController::class)->except(['destroy']);
    Route::resource('servis', App\Http\Controllers\ServisController::class)->except(['destroy']);
});

// User - samo pregled proizvoda i naručivanje (svaki autentifikovani korisnik može da vidi proizvode)
Route::middleware('auth')->group(function () {
    Route::get('/proizvods', [App\Http\Controllers\ProizvodController::class, 'index'])->name('proizvods.index');
    Route::get('/proizvods/{proizvod}', [App\Http\Controllers\ProizvodController::class, 'show'])->name('proizvods.show');
});

// User - samo naručivanje i pregled svojih narudžbina
Route::middleware(['auth', 'role:user'])->group(function () {
    // Rute za naručivanje proizvoda
    Route::get('/proizvods/{proizvod}/naruci', [App\Http\Controllers\ProizvodController::class, 'naruci'])->name('proizvods.naruci');
    Route::post('/proizvods/{proizvod}/naruci', [App\Http\Controllers\ProizvodController::class, 'kreirajNarudzbinu'])->name('proizvods.kreiraj-narudzbinu');
    // Ruta za naručivanje (use case - stara ruta za kompatibilnost)
    Route::post('/narudzbine/kreiraj', [App\Http\Controllers\NarudzbinaController::class, 'kreirajNarudzbinu'])->name('narudzbine.kreiraj');

    // Rute za pregled svojih narudžbina
    Route::get('/moje-narudzbine', [App\Http\Controllers\NarudzbinaController::class, 'mojeNarudzbine'])->name('moje.narudzbine');
    Route::get('/moje-narudzbine/{narudzbina}', [App\Http\Controllers\NarudzbinaController::class, 'mojaNarudzbina'])->name('moja.narudzbina');
    Route::delete('/moje-narudzbine/{narudzbina}', [App\Http\Controllers\NarudzbinaController::class, 'destroy'])->name('moja.narudzbina.destroy');
});

require __DIR__.'/auth.php';
