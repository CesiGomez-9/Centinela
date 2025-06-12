<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ServicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $requiere = $this->faker->boolean();
        return [
            'nombre' => $this->faker->words(3, true),  // Cambiado a string
            'descripcion' => $this->faker->paragraph,
            'tipo' => $this->faker->randomElement(['Instalación', 'Mantenimiento', 'Asesoría']),
            'duracion_estimada' => $this->faker->randomElement(['2 horas', '1 día', '3 días']),
            'requiere_productos' => $requiere,
            'productos_especificos' => $requiere ? $this->faker->words(3, true) : null,
        ];
    }

}
