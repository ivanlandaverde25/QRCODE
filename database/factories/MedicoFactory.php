<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medico>
 */
class MedicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'tipo_documento' => fake()->randomElement(['DUI', 'Carne de residencia']),
            'documento' => fake()->numerify('########-#'),
            'correo' => fake()->email(),
        ];
    }
}
