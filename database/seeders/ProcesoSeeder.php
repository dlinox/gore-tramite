<?php

namespace Database\Seeders;

use App\Models\Proceso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Proceso::create([
            'proc_nombre' => 'Tramite de partida',
            'proc_docu_id' => rand(1, 20),
            'proc_plazo' => 5
        ]);

        Proceso::create([
            'proc_nombre' => 'Tramite de certificado',
            'proc_docu_id' => rand(1, 20),
            'proc_plazo' => 5
        ]);

        Proceso::create([
            'proc_nombre' => 'Otros tramites',
            'proc_docu_id' => rand(1, 20),
            'proc_plazo' => 5
        ]);

        Proceso::create([
            'proc_nombre' => 'Tramite de licencia',
            'proc_docu_id' => rand(1, 20),
            'proc_plazo' => 5
        ]);
    }
}
