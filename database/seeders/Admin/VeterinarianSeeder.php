<?php

namespace Database\Seeders\Admin;

use App\Models\Veterinarian;
use Illuminate\Database\Seeder;

class VeterinarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Veterinarian::factory(20)->create();
    }
}
