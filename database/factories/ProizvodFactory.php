<?php

namespace Database\Factories;

use App\Models\Magacin;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProizvodFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $naziviKotlova = [
            'EcoFlame', 'BioTherm', 'GreenHeat', 'EcoMax', 'BioPower', 'ThermoEco',
            'GreenFlame', 'EcoBurn', 'BioMaster', 'ThermoGreen', 'EcoStar', 'BioHeat',
            'GreenMax', 'EcoPro', 'BioTherm Pro', 'ThermoFlame', 'EcoMaster', 'BioStar',
            'GreenPro', 'EcoTherm', 'BioMax', 'ThermoEco Pro', 'EcoPower', 'BioFlame',
            'GreenMaster', 'EcoHeat', 'BioPro', 'ThermoMax', 'EcoBurn Pro', 'BioStar Pro'
        ];

        $serije = ['Classic', 'Premium', 'Elite', 'Pro', 'Plus', 'Ultra', 'Advanced', 'Expert'];
        $tipoviGoriva = ['Pellet', 'Drvo', 'Ugalj', 'Pelet i Drvo', 'Biomasa'];
        $modeli = ['MK', 'EK', 'BK', 'PK', 'GK', 'HK', 'SK', 'TK'];

        $naziv = fake()->randomElement($naziviKotlova);
        $serija = fake()->randomElement($serije);
        $model = fake()->randomElement($modeli) . '-' . fake()->numberBetween(100, 999);
        $tipGoriva = fake()->randomElement($tipoviGoriva);

        // Kombinuj naziv sa serijom (ne uvek, da bude raznovrsnije)
        if (fake()->boolean(60)) {
            $naziv = $naziv . ' ' . $serija;
        }

        return [
            'naziv' => $naziv . ' Kotao',
            'model' => $model,
            'tip_goriva' => $tipGoriva,
            'cena' => fake()->randomFloat(2, 80000, 650000),
            'na_stanju' => fake()->numberBetween(0, 50),
            'magacin_id' => Magacin::factory(),
        ];
    }
}
