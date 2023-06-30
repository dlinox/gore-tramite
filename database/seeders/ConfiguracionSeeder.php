<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Configuracion::create([
            'conf_periodo' => date('Y'), 
        ]);
    }
}
