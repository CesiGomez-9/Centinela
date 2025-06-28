<?php

namespace Database\Seeders;

use App\Models\Factura;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacturasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Factura::factory()->count(20)->create();
    }
}
