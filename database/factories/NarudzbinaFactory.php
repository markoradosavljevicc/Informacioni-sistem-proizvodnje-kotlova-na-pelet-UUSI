<?php

namespace Database\Factories;

use App\Models\Kupac;
use Illuminate\Database\Eloquent\Factories\Factory;

class NarudzbinaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'kupac_id' => Kupac::factory(),
            'datum_narudzbine' => fake()->date(),
            'rok_isporuke' => fake()->dateTimeBetween('now', '+3 months'),
            'status' => fake()->randomElement(['kreirana', 'potvrdjena', 'u_proizvodnji', 'spremna_za_isporuku', 'isporucena']),
            'ukupna_cena' => fake()->randomFloat(2, 50000, 500000),
            'napomena' => fake()->sentence(),
        ];
    }
}
