<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventario>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lista de nombres por categoría
        $nombresPorCategoria = [
            'Cámaras de seguridad' => [
                'Cámara IP Full HD',
                'Cámara Bullet 4K',
                'Cámara domo PTZ',
                'Cámara térmica portátil',
                'Cámara con visión nocturna'
            ],
            'Alarmas antirrobo' => [
                'Alarma inalámbrica',
                'Alarma con sirena',
                'Alarma de puerta y ventana',
                'Sistema de alarma GSM',
                'Alarma con detector de humo'
            ],
            'Cerraduras inteligentes' => [
                'Cerradura biométrica',
                'Cerradura con teclado',
                'Cerradura Bluetooth',
                'Cerradura con control remoto',
                'Cerradura electrónica para puertas'
            ],
            'Sensores de movimiento' => [
                'Sensor PIR inalámbrico',
                'Sensor de movimiento con cámara',
                'Sensor de movimiento para interiores',
                'Sensor de movimiento con alarma',
                'Sensor doble tecnología'
            ],
            'Luces con sensor de movimiento' => [
                'Luz LED con sensor',
                'Luz solar con sensor',
                'Foco exterior con sensor',
                'Luz para jardín con sensor',
                'Lámpara de seguridad con sensor'
            ],
            'Rejas o puertas de seguridad' => [
                'Reja metálica reforzada',
                'Puerta de seguridad con cerradura',
                'Reja plegable de acero',
                'Puerta blindada residencial',
                'Reja corrediza automática'
            ],
            'Sistema de monitoreo 24/7' => [
                'Sistema CCTV avanzado',
                'Monitoreo remoto por app',
                'Servicio de vigilancia en tiempo real',
                'Sistema con alertas SMS',
                'Monitoreo con sensores integrados'
            ],
            'Implementos de seguridad' => [
                'Chaleco antibalas',
                'Casco de seguridad',
                'Guantes tácticos',
                'Botas reforzadas',
                'Radio comunicador portátil'
            ],
        ];

        // Elegir categoría aleatoria
        $categoria = $this->faker->randomElement(array_keys($nombresPorCategoria));

        return [
            'serie' => $this->faker->unique()->bothify('PRO-####'),
            'codigo' => $this->faker->unique()->bothify('COD-####'),
            'nombre' => $this->faker->randomElement($nombresPorCategoria[$categoria]),
            'marca' => $this->faker->word(),
            'modelo' => strtoupper($this->faker->bothify('MDL-##??')),
            'categoria' => $categoria,
            'material' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
        ];
    }

}
