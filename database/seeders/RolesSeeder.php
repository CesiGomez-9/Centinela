<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Limpiar cache de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Lista de permisos según tu definición
        $permisos = [
            // Productos
            'registrar producto', 'listado de producto', 'inventario de producto',
            // Factura de compra
            'registrar factura de compra', 'listado de factura de compra', 'ver factura de compra',
            // Factura de venta
            'registrar factura de venta', 'listado de factura de venta', 'ver factura de venta',
            // Servicios
            'registrar servicio', 'listado de servicio', 'ver servicio', 'editar servicio',
            // Venta de servicios
            'venta de servicios', 'listado de venta de servicios', 'ver venta de servicios',
            // Incidencias
            'registrar incidencias', 'listado de incidencias', 'ver incidencias', 'editar incidencias',
            // Instalaciones
            'registrar instalación', 'listado de instalación', 'ver instalación',
            // Empleados
            'registrar empleados', 'listado de empleados', 'ver empleados', 'editar empleados',
            // Memorándum
            'registrar memorándum', 'listado de memorándum', 'ver memorándum',
            // Asistencias
            'registrar asistencias', 'listado de asistencias', 'ver asistencias',
            // Incapacidades
            'registrar incapacidad', 'listado de incapacidad', 'ver incapacidad', 'editar incapacidad',
            // Capacitaciones
            'registrar capacitación', 'listado de capacitación', 'ver capacitación', 'editar capacitación',
            // Promociones
            'registrar promociones', 'listado de promociones',
        ];

        // Crear permisos
        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Crear roles y asignar permisos
        $roles = [
            'super_admin' => $permisos, // Super admin tiene todos los permisos
            'administrador' => [
                // Ajusta según necesites
                'registrar producto', 'listado de producto', 'inventario de producto',
                'registrar factura de compra', 'listado de factura de compra', 'ver factura de compra',
                'registrar factura de venta', 'listado de factura de venta', 'ver factura de venta',
                'registrar servicio', 'listado de servicio', 'ver servicio',
                'venta de servicios', 'listado de venta de servicios', 'ver venta de servicios',
                'registrar incidencias', 'listado de incidencias', 'ver incidencias',
                'registrar instalación', 'listado de instalación', 'ver instalación',
                'registrar empleados', 'listado de empleados', 'ver empleados',
                'registrar memorándum', 'listado de memorándum', 'ver memorándum',
                'registrar asistencias', 'listado de asistencias', 'ver asistencias',
                'registrar incapacidad', 'listado de incapacidad', 'ver incapacidad',
                'registrar capacitación', 'listado de capacitación', 'ver capacitación',
                'registrar promociones', 'listado de promociones',
            ],
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);
        }
    }
}
