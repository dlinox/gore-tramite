<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Estado;
use App\Models\Persona;
use Faker\Provider\ar_EG\Person;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Persona::create([
            'pers_nombre' => 'Pepe',
            'pers_paterno' => 'Quispe',
            'pers_materno' => 'Mamani',
            'pers_fecha_nacimiento' => '2013-01-06',
            'pers_dni' => '71822345',
            'pers_ugigeo' => '202120',
            'pers_celular' => '951487845',
            'pers_correo' => 'user@gmail.com',
            'pers_pais' => 'Perú',
            'pers_estado' => true,
        ]);

        $this->call(ConfiguracionSeeder::class);
        Persona::factory()->count(10)->create();
        $this->call(AccionSeeder::class);
        $this->call(OficinaSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(DocumentoSeeder::class);
        $this->call(ProcesoSeeder::class);
    }
}
