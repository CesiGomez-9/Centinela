<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear el rol super_admin si no existe
        $rolSuperAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // 2. Crear usuario super admin si no existe
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@centinela.com'],
            [
                'usuario' => 'Super Administrador',
                'rol' => 'super_admin',
                'password' => Hash::make('SuperAdmin123'),
            ]
        );

        // 3. Asignar rol con Spatie
        $superAdmin->assignRole($rolSuperAdmin);
    }
}
