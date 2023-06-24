<?php

namespace Database\Seeders;

use App\Models\Oficina;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OficinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Oficina::create([
            'ofic_nombre' => 'MESA DE PARTES',
            'ofic_descripcion' => 'Descripción de la Oficina',
            'ofic_ubigeo' => '010101',
            'ofic_direccion' => 'Dirección de la Oficina',
            'ofic_siglas' => 'MP',
            'ofic_publico' => true,
            'ofic_estado' => true,
        ]);

        Oficina::create([
            'ofic_nombre' => 'Oficina de tecnologías de la información',
            'ofic_descripcion' => 'Descripción de la Oficina',
            'ofic_ubigeo' => '010101',
            'ofic_direccion' => 'Dirección de la Oficina',
            'ofic_siglas' => 'OTI',
            'ofic_publico' => false,
            'ofic_estado' => true,
        ]);

        Oficina::create([
            'ofic_nombre' => 'Secretaria geneal',
            'ofic_descripcion' => 'Descripción de la Oficina',
            'ofic_ubigeo' => '010101',
            'ofic_direccion' => 'Dirección de la Oficina',
            'ofic_siglas' => 'SG',
            'ofic_publico' => false,
            'ofic_estado' => true,
        ]);
    }
}
