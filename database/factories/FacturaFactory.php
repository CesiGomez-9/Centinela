<?php

namespace Database\Factories;

use App\Models\DetalleFactura;
use App\Models\Factura;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factura>
 */
class FacturaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Factura::class;

    public function definition(): array
    {
        return [
            'numero_factura' => $this->faker->unique()->numerify('N°-#######'),
            'fecha' => $this->faker->date(),
            'proveedor' => $this->faker->randomElement([
                'TE seguridad',
                'TecnoSeguridad SA',
                'Alarmas Prosegur',
                'Seguridad Total',
                'LockPro Cerraduras',
                'VigiTech Honduras',
                'Securitas HN',
                'AlertaHN',
                'MoniSegur',
                'RejaMax',
            ]),
            'forma_pago' => $this->faker->randomElement(['Efectivo', 'Cheque', 'Transferencia']),
            'subtotal' => 0,
            'impuestos' => 0,
            'totalF' => 0,
            'responsable' => $this->faker->name(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Factura $factura) {
            $nombresPorCategoria = [
                'Cámaras de seguridad' => ['Cámara IP Full HD',
                    'Cámara Bullet 4K',
                    'Cámara domo PTZ',
                    'Cámara térmica portátil',
                    'Cámara con visión nocturna'],
                'Alarmas antirrobo' => ['Alarma inalámbrica',
                    'Alarma con sirena',
                    'Alarma de puerta y ventana',
                    'Sistema de alarma GSM',
                    'Alarma con detector de humo'],
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

            $subtotal = 0;

            for ($i = 0; $i < rand(2, 5); $i++) {
                $categoria = $this->faker->randomElement(array_keys($nombresPorCategoria));
                $producto = $this->faker->randomElement($nombresPorCategoria[$categoria]);
                $precio = $this->faker->randomFloat(2, 10, 200);
                $cantidad = $this->faker->numberBetween(1, 3);
                $subtotal = $precio * $cantidad;
                $iva = 15;
                $ivaCalculado = ($iva / 100) * $subtotal;
                $total = $subtotal + $ivaCalculado;

                DetalleFactura::create([
                    'factura_id' => $factura->id,
                    'producto' => $producto,
                    'categoria' => $categoria,
                    'precioCompra' => $precio,
                    'precioVenta' => $precio,
                    'cantidad' => $cantidad,
                    'iva' => $iva, // O genera un iva aleatorio si deseas
                    'total' => $total,
                ]);

            }

            $impuestos = $subtotal * 0.15;
            $totalFinal = $subtotal + $impuestos;

            $factura->update([
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'totalF' => $totalFinal,
            ]);
        });
    }

}
