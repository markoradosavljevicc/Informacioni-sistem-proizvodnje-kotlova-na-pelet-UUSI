<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin korisnik
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Direktor
        User::create([
            'name' => 'Direktor',
            'email' => 'direktor@example.com',
            'password' => Hash::make('password'),
            'role' => 'direktor',
        ]);

        // Komercijalista
        User::create([
            'name' => 'Komercijalista',
            'email' => 'komercijalista@example.com',
            'password' => Hash::make('password'),
            'role' => 'komercijalista',
        ]);

        // Običan korisnik
        User::create([
            'name' => 'Korisnik',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
