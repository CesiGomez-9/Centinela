<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear el rol super_admin si no existe
        $rolSuperAdmin = Role::firstOrCreate(['nombre' => 'super_admin']);

        // 2. Crear usuario super admin si no existe
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@centinela.com'],
            [
                'name' => 'Super Administrador',
                'password' => Hash::make('SuperAdmin123'),
            ]
        );

        // 3. Asignar rol
        $superAdmin->roles()->syncWithoutDetaching([$rolSuperAdmin->id]);
    }
}
