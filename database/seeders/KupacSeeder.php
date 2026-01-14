<?php

namespace Database\Seeders;

use App\Models\Kupac;
use Illuminate\Database\Seeder;

class KupacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kupac::factory()->count(10)->create();
    }
}
