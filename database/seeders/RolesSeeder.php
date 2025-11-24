<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Borra registros antiguos sin truncar (evita problemas de FK)
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            ['name' => 'Administrador', 'descripcion' => 'Control total de sistema'],
            ['name' => 'Vigilante', 'descripcion' => 'Registrar asistencia y ver turnos'],
            ['name' => 'Técnico', 'descripcion' => 'Ver instalaciones asignadas y asistencia'],
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
