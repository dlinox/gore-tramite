<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Persona;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Persona::factory()->count(10)->create();
        $this->call(OficinaSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
    }
}
