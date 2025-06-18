<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventario>
 */
class InventarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->bothify('INV-####'),
            'nombre' => $this->faker->word(),
            'cantidad' => $this->faker->numberBetween(10, 100),
            'precio_unitario' => $this->faker->randomFloat(0, 5, 9999),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
