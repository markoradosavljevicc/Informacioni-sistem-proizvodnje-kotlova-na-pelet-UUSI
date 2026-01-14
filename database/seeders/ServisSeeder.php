<?php

namespace Database\Seeders;

use App\Models\Servis;
use Illuminate\Database\Seeder;

class ServisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Servis::factory()->count(10)->create();
    }
}
