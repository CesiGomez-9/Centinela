<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Mostrar listado de usuarios
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('users.index', compact('users', 'search'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Guardar usuario
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:50|regex:/^[\p{L}\s]+$/u',
            'apellido' => 'required|string|max:50|regex:/^[\p{L}\s]+$/u',
            'email' => [
                'required',
                'email',
                'max:50',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    // Validar que termine en .com
                    if (!preg_match('/\.com$/i', $value)) {
                        $fail('El correo debe terminar en .com');
                    }
                }
            ],
            'password' => [
                $request->routeIs('users.store') ? 'required' : 'nullable', // obligatorio al crear, opcional al editar
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    if ($value && !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $value)) {
                        $fail('La contraseña debe tener mínimo 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial');
                    }
                }
            ],
        ];

        $messages = [
            'name.required' => 'Debe ingresar un nombre',
            'name.max' => 'El nombre no debe superar 50 caracteres',
            'apellido.required' => 'Debe ingresar un apellido',
            'apellido.max' => 'El apellido no debe superar 50 caracteres',
            'email.required' => 'Debe ingresar un correo electrónico',
            'email.email' => 'Debe ingresar un correo electrónico válido',
            'email.unique' => 'Este correo ya está registrado',
            'password.required' => 'Debe ingresar una contraseña',
            'password.max' => 'La contraseña no debe superar 50 caracteres',
        ];

        $validated = $request->validate($rules, $messages);

        // Hashear contraseña si se envió
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']); // si es edición y no cambió
        }

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Usuario registrado correctamente.');
    }


    /**
     * Mostrar detalle
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => ['required', 'string', 'max:50'],
            'apellido' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user->name = $request->name;
        $user->apellido = $request->apellido;
        $user->email = $request->email;

        // Si envió contraseña nueva, asignarla
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
