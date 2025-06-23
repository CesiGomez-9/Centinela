<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departamentos = range(1, 18);
        $departamento = str_pad(fake()->randomElement($departamentos), 2, '0', STR_PAD_LEFT);
        $identidad = $departamento . '-' . fake()->numerify('####') . '-' . fake()->numerify('#####');
        return [
            'nombre' => fake()->firstName(),
            'apellido' => fake()->lastName(),
            'identidad' => $identidad,
            'direccion' => fake()->address(),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->unique()->numerify('9########'),
            'contactodeemergencia' => fake()->name(),
            'telefonodeemergencia' => fake()->numerify('3########'),
            'tipodesangre' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'alergias' => fake()->randomElement(['Ninguna', 'Medicamentos', 'Alimentos', 'Otros']),
            'alergiaOtros' => fake()->optional()->words(3, true),
            'alergiaAlimentos' => fake()->optional()->words(2, true),
            'alergiaMedicamentos' => fake()->optional()->words(2, true),
        ];
    }
}
