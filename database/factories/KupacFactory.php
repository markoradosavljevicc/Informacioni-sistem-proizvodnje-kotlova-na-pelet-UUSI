<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KupacFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $srpskaImena = [
            'Marko', 'Petar', 'Nikola', 'Stefan', 'Luka', 'Milan', 'Nemanja', 'Aleksandar',
            'Jovan', 'Đorđe', 'Vladimir', 'Ivan', 'Bojan', 'Dejan', 'Miloš', 'Dušan',
            'Ana', 'Jelena', 'Marija', 'Snežana', 'Milica', 'Tamara', 'Jovana', 'Ivana',
            'Katarina', 'Sofija', 'Teodora', 'Aleksandra', 'Tijana', 'Nevena', 'Dragana', 'Sanja',
        ];

        $srpskaPrezimena = [
            'Jovanović', 'Petrović', 'Nikolić', 'Marković', 'Đorđević', 'Stojanović', 'Ilić',
            'Stanković', 'Pavlović', 'Milošević', 'Popović', 'Radović', 'Stefanović', 'Lukić',
            'Kostić', 'Mitić', 'Nedić', 'Mladenović', 'Vuković', 'Simić', 'Tomić', 'Ristić',
            'Đukić', 'Milić', 'Antić', 'Obradović', 'Janković', 'Maksimović', 'Grujić', 'Vasić',
        ];

        $srpskiGradovi = [
            'Beograd', 'Novi Sad', 'Niš', 'Kragujevac', 'Subotica', 'Zrenjanin', 'Pančevo',
            'Čačak', 'Kraljevo', 'Smederevo', 'Leskovac', 'Valjevo', 'Kruševac', 'Vranje',
            'Šabac', 'Užice', 'Sombor', 'Požarevac', 'Pirot', 'Zaječar', 'Sremska Mitrovica',
            'Jagodina', 'Kikinda', 'Vršac', 'Senta', 'Bačka Palanka', 'Prokuplje', 'Sremski Karlovci',
        ];

        $ulice = [
            'Knez Mihailova', 'Terazije', 'Kralja Milana', 'Nemanjina', 'Bulevar Kralja Aleksandra',
            'Vojvode Stepe Stepanovića', 'Bulevar Oslobođenja', 'Kralja Petra', 'Dunavska',
            'Masarikova', 'Bulevar Revolucije', 'Trg Republike', 'Kosovska', 'Vidovdanska',
            'Bulevar Despota Stefana', 'Svetog Save', 'Bulevar Vojvode Putnika', 'Karađorđeva',
            'Bulevar Cara Lazara', 'Bulevar Oslobođenja', 'Partizanska', 'Radnička', 'Industrijska',
        ];

        $ime = fake()->randomElement($srpskaImena);
        $prezime = fake()->randomElement($srpskaPrezimena);
        $grad = fake()->randomElement($srpskiGradovi);
        $ulica = fake()->randomElement($ulice);
        $broj = fake()->numberBetween(1, 200);

        return [
            'ime' => $ime,
            'prezime' => $prezime,
            'email' => strtolower($ime.'.'.$prezime.'@'.fake()->freeEmailDomain()),
            'telefon' => '+381'.fake()->numberBetween(10, 99).fake()->numberBetween(1000000, 9999999),
            'adresa' => $ulica.' '.$broj.', '.$grad,
        ];
    }
}
