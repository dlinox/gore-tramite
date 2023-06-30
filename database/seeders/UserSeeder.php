<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $personas = Persona::all();

        foreach ($personas as $persona) {
            // Genera un nombre de usuario basado en el nombre y apellido de la persona
            $username = $persona->pers_nombre . ' ' . $persona->pers_paterno;

            // Crea un registro de usuario para cada persona
            User::create([
                'name' => $username,
                'email' => $persona->pers_correo,
                'document' => $persona->pers_dni,
                'email_verified_at' => now(),
                'password' => 'password',
                'pers_id' => $persona->pers_id,
            ]);
        }
    }
}
