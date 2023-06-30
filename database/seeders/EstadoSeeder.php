<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estado::create([
            'esta_nombre' => 'Borrador',
            'esta_tipo' => 1,
        ]);

        Estado::create([
            'esta_nombre' => 'Tramite',
            'esta_tipo' => 1,
        ]);

        Estado::create([
            'esta_nombre' => 'Observado',
            'esta_tipo' => 1,
        ]);

        Estado::create([
            'esta_nombre' => 'Finalizado',
            'esta_tipo' => 1,
        ]);

        Estado::create([
            'esta_nombre' => 'Pendiente',
            'esta_tipo' => 2,
        ]);

        Estado::create([
            'esta_nombre' => 'Recibido',
            'esta_tipo' => 2,
        ]);

        Estado::create([
            'esta_nombre' => 'Derivados',
            'esta_tipo' => 2,
        ]);

        Estado::create([
            'esta_nombre' => 'Finalizados',
            'esta_tipo' => 2,
        ]);

        Estado::create([
            'esta_nombre' => 'Archivados',
            'esta_tipo' => 2,
        ]);
    }
}
