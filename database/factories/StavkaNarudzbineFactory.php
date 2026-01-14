<?php

namespace Database\Factories;

use App\Models\Foreign;
use App\Models\NarudzbinaProizvod;
use Illuminate\Database\Eloquent\Factories\Factory;

class StavkaNarudzbineFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'narudzbina_id' => Foreign::factory(),
            'proizvod_id' => Foreign::factory(),
            'kolicina' => fake()->numberBetween(-10000, 10000),
            'cena_jedinice' => fake()->randomFloat(2, 0, 999999.99),
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
            'narudzbina_proizvod_id' => NarudzbinaProizvod::factory(),
        ];
    }
}
