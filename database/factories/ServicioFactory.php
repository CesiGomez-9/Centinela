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
        $categoria = $this->faker->randomElement(['vigilancia', 'tecnico']);

        return [
            'nombre' => $this->faker->words(3, true),
            'descripcion' => $this->faker->sentence(5),
            'categoria' => $categoria,
            'tipo_personal' => $categoria,
            'costo' => $this->faker->numberBetween(100, 5000),
            'duracion_cantidad' => $this->faker->numberBetween(1, 30),
            'duracion_tipo' => $this->faker->randomElement(['horas', 'dias', 'meses', 'años']),
            'productos_tecnico' => $categoria === 'tecnico' ? ['Cámara IP Full HD', 'Escalera'] : null,
            'productos_vigilancia' => $categoria === 'vigilancia' ? ['Botas reforzadas', 'Linterna'] : null,
        ];
    }

}
