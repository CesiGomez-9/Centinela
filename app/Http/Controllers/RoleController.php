<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;



class RoleController extends Controller
{
    // Mostrar formulario para asignar rol
    public function index(Request $request)
    {
        $query = Role::query();

        // Filtro por rol (buscador tipo input)
        if ($request->filled('rol')) {
            $query->where('name', 'like', '%' . $request->rol . '%');
        }

        // Filtro por fecha de creación
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Obtener roles paginados, 5 por página
        $roles = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('roles_permisos.index', compact('roles'));
    }


    public function asignarRol()
    {
        // Traer todos los permisos
        $permissions = Permission::all();

        // Definir módulos con los nombres de permisos
        $permisosPorModulo = [
            'Empleados' => ['registrar empleados', 'listado de empleados', 'ver empleados', 'editar empleados'],
            'Servicios' => ['registrar servicio', 'listado de servicio', 'ver servicio', 'editar servicio'],
            'Factura de compra' => ['registrar factura de compra', 'listado de factura de compra', 'ver factura de compra'],
            'Factura de venta' => ['registrar factura de venta', 'listado de factura de venta', 'ver factura de venta'],
            'Venta de servicios' => ['venta de servicios', 'listado de venta de servicios', 'ver venta de servicios'],
            'Incidencias' => ['registrar incidencias', 'listado de incidencias', 'ver incidencias', 'editar incidencias'],
            'Instalaciones' => ['registrar instalación', 'listado de instalación', 'ver instalación'],
            'Memorándum' => ['registrar memorándum', 'listado de memorándum', 'ver memorándum'],
            'Productos' => ['registrar producto', 'listado de producto', 'inventario de producto'],
            'Asistencias' => ['registrar asistencias', 'listado de asistencias', 'ver asistencias'],
            'Incapacidades' => ['registrar incapacidad', 'listado de incapacidad', 'ver incapacidad', 'editar incapacidad'],
            'Capacitaciones' => ['registrar capacitación', 'listado de capacitación', 'ver capacitación', 'editar capacitación'],
            'Promociones' => ['registrar promociones', 'listado de promociones'],
        ];

        // Mapear a objetos Permission reales
        $permisosPorModulo = collect($permisosPorModulo)->mapWithKeys(function($nombres, $modulo) use ($permissions) {
            return [$modulo => $permissions->whereIn('name', $nombres)];
        });

        // Traer todos los roles
        $roles = Role::all();

        // Pasar todo a la vista
        return view('roles_permisos.asignar', compact('roles', 'permisosPorModulo'));
    }


    public function guardarRol(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Crear rol con guard_name = 'web'
        $role = Role::create([
            'name' => $request->role,
            'guard_name' => 'web', // 🔹 clave
        ]);

        // Obtener permisos seleccionados
        $permisos = Permission::whereIn('id', $request->permissions)
            ->where('guard_name', 'web') // 🔹 asegurarse del guard
            ->get();

        // Asignar permisos al rol
        $role->syncPermissions($permisos);

        return redirect()->route('roles_permisos.index')
            ->with('success', 'Rol creado y permisos asignados correctamente.');
    }



    public function ver($id)
    {
        $role = Role::findOrFail($id);

        // Obtener los permisos del rol
        $permissions = $role->permissions;

        // Definir módulos con los nombres de permisos
        $modulos = [
            'Empleados' => ['registrar empleados', 'listado de empleados', 'ver empleados', 'editar empleados'],
            'Servicios' => ['registrar servicio', 'listado de servicio', 'ver servicio', 'editar servicio'],
            'Factura de compra' => ['registrar factura de compra', 'listado de factura de compra', 'ver factura de compra'],
            'Factura de venta' => ['registrar factura de venta', 'listado de factura de venta', 'ver factura de venta'],
            'Venta de servicios' => ['venta de servicios', 'listado de venta de servicios', 'ver venta de servicios'],
            'Incidencias' => ['registrar incidencias', 'listado de incidencias', 'ver incidencias', 'editar incidencias'],
            'Instalaciones' => ['registrar instalación', 'listado de instalación', 'ver instalación'],
            'Memorándum' => ['registrar memorándum', 'listado de memorándum', 'ver memorándum'],
            'Productos' => ['registrar producto', 'listado de producto', 'inventario de producto'],
            'Asistencias' => ['registrar asistencias', 'listado de asistencias', 'ver asistencias'],
            'Incapacidades' => ['registrar incapacidad', 'listado de incapacidad', 'ver incapacidad', 'editar incapacidad'],
            'Capacitaciones' => ['registrar capacitación', 'listado de capacitación', 'ver capacitación', 'editar capacitación'],
            'Promociones' => ['registrar promociones', 'listado de promociones'],
        ];

        // Mapear a objetos Permission del rol, ordenar y eliminar módulos vacíos
        $permisosPorModulo = collect($modulos)->mapWithKeys(function($nombres, $modulo) use ($permissions) {
            $perms = $permissions->whereIn('name', $nombres)->sortBy('name');
            return [$modulo => $perms];
        })->filter(function($perms) {
            return $perms->isNotEmpty(); // Solo módulos con permisos
        });

        return view('roles_permisos.ver', compact('role', 'permisosPorModulo'));
    }




    public function editar($id)
    {
        // Obtener el rol
        $role = Role::findOrFail($id);

        // Obtener todos los permisos
        $permissions = Permission::all();

        // Definir módulos con los nombres de permisos
        $permisosPorModulo = [
            'Empleados' => ['registrar empleados', 'listado de empleados', 'ver empleados', 'editar empleados'],
            'Servicios' => ['registrar servicio', 'listado de servicio', 'ver servicio', 'editar servicio'],
            'Factura de compra' => ['registrar factura de compra', 'listado de factura de compra', 'ver factura de compra'],
            'Factura de venta' => ['registrar factura de venta', 'listado de factura de venta', 'ver factura de venta'],
            'Venta de servicios' => ['venta de servicios', 'listado de venta de servicios', 'ver venta de servicios'],
            'Incidencias' => ['registrar incidencias', 'listado de incidencias', 'ver incidencias', 'editar incidencias'],
            'Instalaciones' => ['registrar instalación', 'listado de instalación', 'ver instalación'],
            'Memorándum' => ['registrar memorándum', 'listado de memorándum', 'ver memorándum'],
            'Productos' => ['registrar producto', 'listado de producto', 'inventario de producto'],
            'Asistencias' => ['registrar asistencias', 'listado de asistencias', 'ver asistencias'],
            'Incapacidades' => ['registrar incapacidad', 'listado de incapacidad', 'ver incapacidad', 'editar incapacidad'],
            'Capacitaciones' => ['registrar capacitación', 'listado de capacitación', 'ver capacitación', 'editar capacitación'],
            'Promociones' => ['registrar promociones', 'listado de promociones'],
        ];

        // Mapear permisos a objetos Permission
        $permisosPorModulo = collect($permisosPorModulo)->mapWithKeys(function($nombres, $modulo) use ($permissions) {
            return [$modulo => $permissions->whereIn('name', $nombres)];
        });

        // Obtener IDs de los permisos asignados al rol
        $rolePermisos = $role->permissions()->pluck('id')->toArray();

        // Traer todos los roles para el datalist
        $roles = Role::all();

        return view('roles_permisos.editar', compact('role', 'permisosPorModulo', 'rolePermisos', 'roles'));
    }

    public function actualizar(Request $request, $id)
    {
        // Validar campos
        $request->validate([
            'role' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Obtener el rol
        $role = Role::findOrFail($id);
        $role->name = $request->role;
        $role->save();

        // Convertir permisos a enteros y sincronizar
        $permissionIds = array_map('intval', $request->permissions);
        $role->syncPermissions($permissionIds);

        return redirect()->route('roles_permisos.index')
            ->with('success', 'Rol actualizado correctamente.');
    }





    public function assignForm()
    {
        $users = User::all();
        $roles = DB::table('roles')->get();
        return view('roles.assign', compact('users', 'roles'));
    }

    // Guardar rol asignado a usuario
    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        DB::table('role_user')->updateOrInsert(
            ['user_id' => $request->user_id],
            ['role_id' => $request->role_id]
        );

        return redirect()->back()->with('success', 'Rol asignado correctamente.');
    }

    // Listar roles por usuario
    public function list()
    {
        $users = User::with('roles')->get(); // relación definida en User model
        return view('roles.list', compact('users'));
    }

    /**
     * Display a listing of the resource.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function eliminar($id)
    {
        $user = User::findOrFail($id);

        // Si quieres también puedes remover los roles antes de eliminar
        $user->roles()->detach();

        $user->delete();

        return redirect()->route('roles_permisos.index')
            ->with('success', 'Registro eliminado correctamente.');
    }

}
