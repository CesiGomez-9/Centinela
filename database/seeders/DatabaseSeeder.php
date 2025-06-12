<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  // Importa esto para usar DB::table
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Limpia la tabla antes de sembrar
        DB::table('users')->truncate();

        // Ahora crea 10 usuarios con factory
        User::factory(10)->create();

        $this->call([
            ServiciosSeeder::class,
        ]);

        $this->call([
            InventariosTableSeeder::class,
        ]);
    }

}
