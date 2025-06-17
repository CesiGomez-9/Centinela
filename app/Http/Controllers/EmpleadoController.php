<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {

        $request->validate([
            'search' => ['nullable', 'regex:/^[A-Za-z]+(?: [A-Za-z]+)*$/', 'max:25']
        ], [
            'search.regex' => 'Ingresa el nombre que quieras buscar'
        ]);

        $search = $request->input('search');

        $empleados = Empleado::query();

        if ($search) {
            $empleados = $empleados->where('nombre', 'like', "%{$search}%");
        }

        $empleados = $empleados->paginate(10);

        return view('empleados.index', compact('empleados'));
    }

    public function create(Request $request)
    {

        $empleados = $request->session()->get('empleados', null);
        $guardado = $request->session()->get('guardado', false);
        return view('empleados.create', compact('empleados', 'guardado'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:25',
            'apellido' => 'required|string|max:25',
            'identidad' => 'required|string|size:15|unique:empleados,identidad',
            'direccion' => 'required|string|max:25',
            'email' => 'required|email|max:20|unique:empleados,email',
            'telefono' => 'required|string|max:11',
            'contactodeemergencia' => 'required|string|max:25',
            'telefonodeemergencia' => 'required|string|max:11',
            'tipodesangre' => 'required|string',
            'alergias' => 'required|array|min:1',
            'alergiaOtros' => 'nullable|string|max:50',
        ]);


        $alergias = $validated['alergias'];
        if(in_array('Otros', $alergias) && !empty($validated['alergiaOtros'])) {
            $index = array_search('Otros', $alergias);
            $alergias[$index] = 'Otros: ' . $validated['alergiaOtros'];
        }
        $validated['alergias'] = implode(', ', $alergias);
        unset($validated['alergiaOtros']);

        Empleado::create($validated);
        $empleados = Empleado::all();
        return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente.');
    }
    public function show(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.show', compact('empleado'));
    }

    public function edit(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, string $id)
    {
        $empleado = Empleado::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:25',
            'apellido' => 'required|string|max:25',
            'direccion' => 'required|string|max:25',
            'email' => 'required|email|max:20|unique:empleados,email,' . $empleado->id,
            'telefono' => 'required|string|max:11',
            'identidad' => 'required|string|max:15|unique:empleados,identidad,' . $empleado->id,
            'contactodeemergencia' => 'required|string|max:25',
            'telefonodeemergencia' => 'required|string|max:11',
            'tipodesangre' => 'required|string',
            'alergias' => 'required|array|min:1',
            'alergiaOtros' => 'required|string|max:50',
        ]);

        $empleado->update([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'direccion' => $validated['direccion'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'],
            'identidad' => $validated['identidad'],
            'contactodeemergencia' => $validated['contactodeemergencia'],
            'telefonodeemergencia' => $validated['telefonodeemergencia'],
            'tipodesangre' => $validated['tipodesangre'],
            'alergias' => json_encode($validated['alergias']),
            'alergiaOtros' => $validated['alergiaOtros'],
        ]);

        $empleado->save();
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente');
    }


    public function destroy(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado correctamente.');
    }
}
