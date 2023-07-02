<?php

namespace Database\Seeders;

use App\Models\Accion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccionSeeder extends Seeder
{

    public function run(): void
    {

        Accion::create([
            'acci_nombre' => 'Firmar',
        ]);

        Accion::create([
            'acci_nombre' => 'Archivo',
        ]);
        Accion::create([
            'acci_nombre' => 'Opinión',
        ]);
        Accion::create([
            'acci_nombre' => 'Acción inmediata',
        ]);
        Accion::create([
            'acci_nombre' => 'Informe',
        ]);
        Accion::create([
            'acci_nombre' => 'Ejecución',
        ]);
        Accion::create([
            'acci_nombre' => 'Tramite',
        ]);

        Accion::create([
            'acci_nombre' => 'Proveido',
        ]);
        Accion::create([
            'acci_nombre' => 'Devolver al interesado',
        ]);
    }
}
