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
        return [

            'nombre_servicio'  => fake()->word(),
            'descripcion' => fake()->sentence(3),
            'direccion' => fake()->address,
            'ciudad' => fake()->city,
            'fecha_inicio' => fake()->date(),
            'duracion' => fake()->randomElement(['1 semana', '2 semanas', '1 mes', '3 meses']),
            'horario' => fake()->time('H:i') . ' - ' . fake()->time('H:i'),
            'cantidad_personal' => fake()->numberBetween(1, 20),
            'tipo_personal'  => fake()->randomElement(['Técnico', 'Ingeniero', 'Ayudante']),
            'incluye_equipamiento' => fake()->boolean(),
            'fecha_solicitud' => fake()->date(),
        ];
    }
}
