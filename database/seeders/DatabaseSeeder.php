<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Estado;
use App\Models\Persona;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ConfiguracionSeeder::class);
        Persona::factory()->count(10)->create();
        $this->call(OficinaSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(DocumentoSeeder::class);
        $this->call(ProcesoSeeder::class);
    }
}
