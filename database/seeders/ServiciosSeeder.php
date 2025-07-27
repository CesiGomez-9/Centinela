<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Servicio::create([
            'nombre' => 'Supervisión Nocturna',
            'descripcion' => 'Servicio de vigilancia durante la noche',
            'categoria' => 'vigilancia',
            'tipo_personal' => 'vigilancia',
            'costo' => 750,
            'duracion_cantidad' => 8,
            'duracion_tipo' => 'horas',
            'productos_vigilancia' => ['Linterna', 'Botas reforzadas', 'Chaleco antibalas']
        ]);

        Servicio::create([
            'nombre' => 'Instalación de Cámaras HD',
            'descripcion' => 'Instalación técnica de cámaras en interiores',
            'categoria' => 'tecnico',
            'tipo_personal' => 'tecnico',
            'costo' => 850,
            'duracion_cantidad' => 3,
            'duracion_tipo' => 'dias',
            'productos_tecnico' => ['Cámara Bullet 4K', 'Caja de herramientas', 'Escalera']
        ]);

        Servicio::factory()->count(5)->create();
    }
}
