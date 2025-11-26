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

        return redirect()->route('users.index')
            ->with('success', 'Rol y permisos asignados correctamente.');
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
    public function index()
    {
        //
    }

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
