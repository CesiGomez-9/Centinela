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
            'nombre' => fake()->word(),
            'categoria'  => fake()->word(),
            'marca'  => fake()->word(),
            'modelo' => fake()->numerify('###-###'),
            'descripcion' => $this->faker->sentence(),
            'codigo_interno' =>fake()->unique()->numerify('#########'),
            'fecha_ingreso' => fake()->date(),
            'proveedor' => fake()->name(),
            'precio_compra' => fake()->numberBetween(500, 12000),
            'precio_venta'  => fake()->numberBetween(1000, 15000),
            'unidades_stock' => $this->faker->numberBetween(1, 100),
        ];
    }
}
