<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persona>
 */
class PersonaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pers_nombre' => fake()->firstName,
            'pers_paterno' => fake()->lastName,
            'pers_materno' => fake()->lastName,
            'pers_fecha_nacimiento' => fake()->date(),
            'pers_dni' => fake()->unique()->numerify('########'),
            'pers_ugigeo' => '202121',
            'pers_direccion' => fake()->address,
            'pers_celular' => fake()->unique()->numerify('#########'),
            'pers_correo' => fake()->unique()->email,
            'pers_pais' => 'Perú',
            'pers_estado' => true,
        ];
    }
}
