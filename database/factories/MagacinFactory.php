<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MagacinFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $balkanskiGradovi = [
            'Beograd, Srbija', 'Novi Sad, Srbija', 'Niš, Srbija', 'Kragujevac, Srbija',
            'Subotica, Srbija', 'Zrenjanin, Srbija', 'Pančevo, Srbija', 'Čačak, Srbija',
            'Banja Luka, Bosna i Hercegovina', 'Sarajevo, Bosna i Hercegovina', 'Tuzla, Bosna i Hercegovina',
            'Zagreb, Hrvatska', 'Split, Hrvatska', 'Rijeka, Hrvatska', 'Osijek, Hrvatska',
            'Podgorica, Crna Gora', 'Nikšić, Crna Gora', 'Pljevlja, Crna Gora',
            'Skoplje, Severna Makedonija', 'Bitola, Severna Makedonija', 'Kumanovo, Severna Makedonija',
            'Ljubljana, Slovenija', 'Maribor, Slovenija', 'Celje, Slovenija',
            'Sarajevo, Bosna i Hercegovina', 'Mostar, Bosna i Hercegovina', 'Zenica, Bosna i Hercegovina',
        ];

        $tipoviMagacina = [
            'Centralni', 'Regionalni', 'Distributivni', 'Glavni', 'Pomoćni', 'Skladišni',
        ];

        $tip = fake()->randomElement($tipoviMagacina);
        $lokacija = fake()->randomElement($balkanskiGradovi);

        return [
            'naziv' => $tip.' Magacin',
            'lokacija' => $lokacija,
        ];
    }
}
