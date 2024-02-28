<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Admin\RolesAndPermissionsSeeder;
use Database\Seeders\Admin\ServiceSeeder;
use Database\Seeders\Admin\SpecieTypeSeeder;
use Database\Seeders\Admin\VeterinarianSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            SpecieTypeSeeder::class,
            RolesAndPermissionsSeeder::class
        ]);
    }
}
