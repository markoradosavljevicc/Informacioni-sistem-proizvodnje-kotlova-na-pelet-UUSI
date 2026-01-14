<?php

namespace Database\Factories;

use App\Models\Kupac;
use App\Models\Proizvod;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServisFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'kupac_id' => Kupac::factory(),
            'proizvod_id' => Proizvod::factory(),
            'datum_prijave' => fake()->date(),
            'datum_zavrsetka' => fake()->optional()->dateTimeBetween('now', '+1 month'),
            'opis_kvara' => fake()->sentence(),
            'opis_popravke' => fake()->optional()->sentence(),
            'status' => fake()->randomElement(['prijavljen', 'u_toku', 'zavrsen']),
            'serviser_id' => null,
        ];
    }
}
