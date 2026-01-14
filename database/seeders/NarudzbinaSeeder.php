<?php

namespace Database\Seeders;

use App\Models\Narudzbina;
use Illuminate\Database\Seeder;

class NarudzbinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Narudzbina::factory()->count(20)->create();
    }
}
