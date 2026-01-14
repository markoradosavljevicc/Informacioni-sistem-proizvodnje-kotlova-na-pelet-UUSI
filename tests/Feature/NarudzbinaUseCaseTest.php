<?php

namespace Tests\Feature;

use App\Models\Kupac;
use App\Models\Narudzbina;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NarudzbinaUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Use Case 1: Evidentiranje narudžbine kupca
     * Testira da li se narudžbina može uspešno kreirati preko public rute
     */
    public function test_kreiraj_narudzbinu_use_case(): void
    {
        // Kreiraj test korisnika sa 'user' ulogom
        $user = \App\Models\User::factory()->create(['role' => 'user']);
        
        // Kreiraj test kupca sa istim email-om kao user
        $kupac = Kupac::factory()->create([
            'ime' => 'Milan',
            'prezime' => 'Petrović',
            'email' => $user->email,
        ]);

        // Podaci za narudžbinu
        $narudzbinaData = [
            'kupac_id' => $kupac->id,
            'datum_narudzbine' => now()->format('Y-m-d'),
            'rok_isporuke' => now()->addMonths(2)->format('Y-m-d'),
            'ukupna_cena' => 150000.00,
            'napomena' => 'Hitna narudžbina',
        ];

        // Pošalji POST zahtev kao autentifikovani korisnik
        $response = $this->actingAs($user)->postJson('/narudzbine/kreiraj', $narudzbinaData);

        // Proveri da li je zahtev uspešan
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Narudžbina je uspešno kreirana.',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'narudzbina' => [
                    'id',
                    'kupac_id',
                    'datum_narudzbine',
                    'status',
                    'ukupna_cena',
                    'kupac' => [
                        'id',
                        'ime',
                        'prezime',
                    ],
                ],
            ]);

        // Proveri da li je narudžbina sačuvana u bazi
        $this->assertDatabaseHas('narudzbinas', [
            'kupac_id' => $kupac->id,
            'status' => 'kreirana',
            'ukupna_cena' => 150000.00,
        ]);
    }

    /**
     * Test validacije za kreiranje narudžbine
     */
    public function test_kreiraj_narudzbinu_validacija(): void
    {
        $user = \App\Models\User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->postJson('/narudzbine/kreiraj', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['kupac_id', 'datum_narudzbine', 'ukupna_cena']);
    }
}
