<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'identidad' => 'required|string|max:20|unique:empleados,identidad',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email|unique:empleados,email',
            'telefono' => 'required|string|max:15',
            'contactodeemergencia' => 'required|string|max:100',
            'telefonodeemergencia' => 'required|string|max:15',
            'tipodesangre' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'alergias' => 'required|array',
            'alergias.*' => 'required|string'
        ]);

        Empleado::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'identidad' => $request->identidad,
            'direccion' => $request->direccion,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'contactodeemergencia' => $request->contactodeemergencia,
            'telefonodeemergencia' => $request->telefonodeemergencia,
            'tipodesangre' => $request->tipodesangre,
            'alergias' => implode(', ', $request->alergias ?? [])


        ]);

        return redirect()->back()->with('success', 'Empleado registrado correctamente');
    }
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
