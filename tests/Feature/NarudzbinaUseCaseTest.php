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
        // Kreiraj test kupca
        $kupac = Kupac::factory()->create([
            'ime' => 'Milan',
            'prezime' => 'Petrović',
            'email' => 'milan@example.com',
        ]);

        // Podaci za narudžbinu
        $narudzbinaData = [
            'kupac_id' => $kupac->id,
            'datum_narudzbine' => now()->format('Y-m-d'),
            'rok_isporuke' => now()->addMonths(2)->format('Y-m-d'),
            'ukupna_cena' => 150000.00,
            'napomena' => 'Hitna narudžbina',
        ];

        // Pošalji POST zahtev
        $response = $this->postJson('/narudzbine/kreiraj', $narudzbinaData);

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
     * Test Use Case 2: Praćenje statusa proizvodnje
     * Testira da li se status narudžbine može uspešno dohvatiti
     */
    public function test_status_proizvodnje_use_case(): void
    {
        // Kreiraj test podatke
        $kupac = Kupac::factory()->create();
        $narudzbina = Narudzbina::factory()->create([
            'kupac_id' => $kupac->id,
            'status' => 'u_proizvodnji',
            'datum_narudzbine' => now()->subDays(5),
            'rok_isporuke' => now()->addDays(10),
            'ukupna_cena' => 200000.00,
        ]);

        // Pošalji GET zahtev
        $response = $this->getJson("/proizvodnja/status/{$narudzbina->id}");

        // Proveri da li je zahtev uspešan
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'narudzbina' => [
                    'id',
                    'broj_narudzbine',
                    'status',
                    'datum_narudzbine',
                    'rok_isporuke',
                    'ukupna_cena',
                    'kupac' => [
                        'ime',
                        'prezime',
                        'email',
                    ],
                    'stavke',
                ],
            ])
            ->assertJsonPath('narudzbina.status', 'u_proizvodnji')
            ->assertJsonPath('narudzbina.kupac.ime', $kupac->ime);
    }

    /**
     * Test validacije za kreiranje narudžbine
     */
    public function test_kreiraj_narudzbinu_validacija(): void
    {
        $response = $this->postJson('/narudzbine/kreiraj', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['kupac_id', 'datum_narudzbine', 'ukupna_cena']);
    }
}
