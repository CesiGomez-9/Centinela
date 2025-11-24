<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empleado; // <--- importante
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * LISTADO DE USUARIOS
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $users = User::query()
            ->with('empleado')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('apellido', 'like', "%{$search}%")
                        ->orWhere('usuario', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($fechaInicio, function ($query) use ($fechaInicio) {
                $query->whereDate('created_at', '>=', $fechaInicio);
            })
            ->when($fechaFin, function ($query) use ($fechaFin) {
                $query->whereDate('created_at', '<=', $fechaFin);
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString(); // <-- mantiene parámetros de búsqueda en paginación

        return view('users.index', compact('users', 'search', 'fechaInicio', 'fechaFin'));
    }


    /**
     * FORMULARIO DE CREACIÓN
     */
    public function create()
    {
        $roles = ['Administrador', 'Vigilante', 'Técnico'];

        // Obtener empleados registrados
        $empleados = Empleado::orderBy('nombre')->get();

        return view('users.create', compact('roles', 'empleados'));
    }

    /**
     * GUARDAR USUARIO
     */
    /**
     * GUARDAR USUARIO
     */
    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|unique:users,empleado_id',
            'rol' => 'required|string',
            'usuario' => 'required|unique:users,usuario',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'empleado_id.required' => 'Debe seleccionar un empleado.',
            'empleado_id.unique' => 'Este empleado ya tiene un usuario.',
            'rol.required' => 'Debe seleccionar un rol.',
            'usuario.required' => 'El usuario es obligatorio.',
            'usuario.unique' => 'Este usuario ya existe.',
            'email.required' => 'El correo es obligatorio.',
            'email.unique' => 'Este correo ya tiene un usuario.',
        ]);

        $user = User::create([
            'empleado_id' => $request->empleado_id,
            'email'       => $request->email,
            'usuario'     => $request->usuario,
            'password'    => Hash::make($request->password),
            'rol'         => $request->rol,
        ]);

        return redirect()->route('users.index')
            ->with('success', "Usuario creado correctamente. Contraseña temporal: <strong>{$request->password}</strong>");
    }



    /**
     * VER USUARIO
     */
    public function show($id)
    {
        $user = User::with('empleado')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * FORMULARIO DE EDICIÓN
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $empleados = Empleado::all();
        $roles = ['Administrador', 'Vigilante', 'Técnico'];

        return view('users.edit', compact('user', 'empleados', 'roles'));
    }

    /**
     * ACTUALIZAR USUARIO
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'empleado_id' => ['required', Rule::unique('users')->ignore($user->id)],
            'rol' => 'required|string',
        ], [
            'empleado_id.required' => 'Debe seleccionar un empleado.',
            'empleado_id.unique' => 'Este empleado ya tiene un usuario.',
            'rol.required' => 'Debe seleccionar un rol.',
        ]);

        $user->empleado_id = $request->empleado_id;
        $user->rol = $request->rol;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Str::random(10); // o permitir cambiar manual
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }


    /**
     * ELIMINAR USUARIO
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
    /**
     * DASHBOARD SEGÚN ROL
     */
    public function dashboard()
    {
        $user = auth()->user();

        if ($user->rol === 'Administrador') {
            return view('dashboard.admin'); // vista para Admin
        }

        if ($user->rol === 'Vigilante') {
            return view('dashboard.vigilante'); // vista para Vigilante
        }

        if ($user->rol === 'Técnico') {
            return view('dashboard.tecnico'); // vista para Técnico
        }

        abort(403, 'Acceso no autorizado');
    }
    public function verpermisos($id)
    {
        $user = User::findOrFail($id);

        // Por ahora como el rol está en users, solo mostramos el rol
        $rol = $user->rol;

        return view('users.verPermisos', compact('user', 'rol'));
    }



    public function searchEmpleados(Request $request)
    {
        $q = $request->get('q', '');

        $empleados = Empleado::query()
            ->where(function($query) use ($q) {
                $query->where('nombre', 'like', "%{$q}%")
                    ->orWhere('apellido', 'like', "%{$q}%")
                    ->orWhere('identidad', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })
            ->limit(50)
            ->get(['id','nombre','apellido','identidad','email']);

        return response()->json($empleados);
    }
}
