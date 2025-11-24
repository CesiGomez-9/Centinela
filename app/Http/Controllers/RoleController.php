<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // Mostrar formulario para asignar rol
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
