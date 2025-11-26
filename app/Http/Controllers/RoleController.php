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

    // Listado de usuarios con sus roles
    public function index(Request $request)
    {
        $roles = Role::whereIn('name', ['administrador', 'vigilante', 'tecnico'])->get();

        $search = $request->input('search');
        $rolFiltrado = $request->input('rol');

        $users = User::with('roles', 'empleado')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('empleado', function ($q) use ($search) {
                    $q->where('nombre', 'like', '%' . $search . '%')
                        ->orWhere('apellido', 'like', '%' . $search . '%');
                });
            })
            ->when($rolFiltrado, function ($query) use ($rolFiltrado) {
                $query->whereHas('roles', function ($q2) use ($rolFiltrado) {
                    $q2->where('name', $rolFiltrado);
                });
            })
            ->paginate(10);

        return view('roles_permisos.index', compact('users', 'roles'));
    }


    public function asignarRol(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();

        // Obtener los IDs de permisos del usuario desde tu tabla pivot
        $userPermissions = DB::table('user_permissions')
            ->where('user_id', $user->id)
            ->pluck('permission_id')
            ->toArray();

        return view('roles_permisos.asignar', compact('user', 'roles', 'permissions', 'userPermissions'));
    }




    public function guardarRol(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id', // usar id si en checkbox envías IDs
        ]);

        // Asignar rol al usuario en tu tabla pivot role_user
        DB::table('role_user')->where('user_id', $user->id)->delete();
        $role = Role::where('name', $request->role)->first();
        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        // Asignar permisos seleccionados al usuario
        DB::table('user_permissions')->where('user_id', $user->id)->delete();
        if ($request->permissions) {
            $insert = [];
            foreach ($request->permissions as $permId) {
                $insert[] = [
                    'user_id' => $user->id,
                    'permission_id' => $permId,
                ];
            }
            DB::table('user_permissions')->insert($insert);
        }

        return redirect()->route('roles_permisos.index')
            ->with('success', 'Rol y permisos asignados correctamente.');
    }

    public function ver($id)
    {
        $user = User::with('roles', 'permissions')->findOrFail($id);

        // Obtener los permisos asignados directamente al usuario
        $directPermissions = $user->permissions;

        // Obtener permisos heredados de roles
        $rolePermissions = collect();
        foreach ($user->roles as $role) {
            $rolePermissions = $rolePermissions->merge($role->permissions);
        }

        // Unir permisos directos + de roles, sin repetir
        $userPermissions = $directPermissions->merge($rolePermissions)->unique('id');

        return view('roles_permisos.ver', compact('user', 'userPermissions'));
    }


    public function editar(User $user)
    {
        $roles = Role::all();
        $permissions = DB::table('permissions')->get(); // Todos los permisos
        $userPermissions = DB::table('user_permissions')
            ->where('user_id', $user->id)
            ->pluck('permission_id')
            ->toArray();

        $userRole = DB::table('role_user')->where('user_id', $user->id)->value('role_id');

        return view('roles_permisos.editar', compact('user', 'roles', 'permissions', 'userPermissions', 'userRole'));
    }

    // Actualizar rol y permisos
    public function actualizar(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Actualizar rol
        DB::table('role_user')->where('user_id', $user->id)->delete();
        $role = DB::table('roles')->where('name', $request->role)->first();
        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        // Actualizar permisos
        DB::table('user_permissions')->where('user_id', $user->id)->delete();
        if ($request->permissions) {
            $insert = [];
            foreach ($request->permissions as $permId) {
                $insert[] = [
                    'user_id' => $user->id,
                    'permission_id' => $permId,
                ];
            }
            DB::table('user_permissions')->insert($insert);
        }

        return redirect()->route('roles_permisos.index')
            ->with('success', 'Rol y permisos actualizados correctamente.');
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
    public function destroy(string $id)
    {
        //
    }
}
