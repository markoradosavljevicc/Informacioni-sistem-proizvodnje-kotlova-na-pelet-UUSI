<?php

namespace Tests\Feature;

use App\Models\Kupac;
use App\Models\Proizvod;
use App\Models\Servis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServisUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Use Case 3: Evidencija servisa
     * Testira da li se servis može uspešno prijaviti preko public rute
     */
    public function test_prijavi_servis_use_case(): void
    {
        // Kreiraj test podatke
        $kupac = Kupac::factory()->create([
            'ime' => 'Jelena',
            'prezime' => 'Đorđević',
            'email' => 'jelena@example.com',
        ]);

        $proizvod = Proizvod::factory()->create([
            'naziv' => 'EK-350 Kotao',
            'model' => 'EK-350',
        ]);

        // Podaci za servis
        $servisData = [
            'kupac_id' => $kupac->id,
            'proizvod_id' => $proizvod->id,
            'datum_prijave' => now()->format('Y-m-d'),
            'opis_kvara' => 'Kotao se ne pali, verovatno problem sa elektronikom.',
        ];

        // Pošalji POST zahtev
        $response = $this->postJson('/servis/prijavi', $servisData);

        // Proveri da li je zahtev uspešan
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Servis je uspešno prijavljen.',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'servis' => [
                    'id',
                    'kupac_id',
                    'proizvod_id',
                    'datum_prijave',
                    'status',
                    'opis_kvara',
                ],
            ]);

        // Proveri da li je servis sačuvan u bazi
        $this->assertDatabaseHas('servis', [
            'kupac_id' => $kupac->id,
            'proizvod_id' => $proizvod->id,
            'status' => 'prijavljen',
        ]);

        // Proveri da li servis ima ispravan opis kvara
        $servis = Servis::where('kupac_id', $kupac->id)->first();
        $this->assertEquals('Kotao se ne pali, verovatno problem sa elektronikom.', $servis->opis_kvara);
    }

    /**
     * Test validacije za prijavu servisa
     */
    public function test_prijavi_servis_validacija(): void
    {
        $response = $this->postJson('/servis/prijavi', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['kupac_id', 'proizvod_id', 'datum_prijave', 'opis_kvara']);
    }

    /**
     * Test da servis ne može biti prijavljen sa nepostojećim kupcem
     */
    public function test_prijavi_servis_nepostojeci_kupac(): void
    {
        $proizvod = Proizvod::factory()->create();

        $servisData = [
            'kupac_id' => 99999, // Ne postoji
            'proizvod_id' => $proizvod->id,
            'datum_prijave' => now()->format('Y-m-d'),
            'opis_kvara' => 'Test opis',
        ];

        $response = $this->postJson('/servis/prijavi', $servisData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['kupac_id']);
    }
}
