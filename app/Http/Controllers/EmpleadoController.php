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
        $rules = [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'identidad' => 'required|string|size:15|unique:empleados,identidad',
            'direccion' => 'required|string|max:150',
            'email' => 'required|email|max:50|unique:empleados,email',
            'telefono' => 'required|string|max:8|unique:empleados,telefono',
            'contactodeemergencia' => 'required|string|max:100',
            'telefonodeemergencia' => 'required|string|max:8|unique:empleados,telefonodeemergencia',
            'tipodesangre' => 'required|string',
            'alergias' => 'required|array|min:1',
            'alergiaOtros' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
            'alergiaAlimentos' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
            'alergiaMedicamentos' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
        ];

        $messages = [
            'nombre.required' => 'Debe ingresar un nombre',
            'apellido.required' => 'Debe ingresar un apellido',
            'identidad.required' => 'Debe ingresar una identidad',
            'identidad.size' => 'La identidad debe tener exactamente 15 caracteres',
            'identidad.unique' => 'Esta identidad ya está registrada',
            'direccion.required' => 'Debe ingresar una dirección',
            'telefono.required' => 'Debe ingresar un número de teléfono',
            'telefono.unique' => 'Este número de teléfono ya está registrado',
            'email.required' => 'Debe ingresar un correo electrónico',
            'email.email' => 'Debe ingresar un correo electrónico válido',
            'email.unique' => 'Este correo ya está registrado',
            'tipodesangre.required' => 'Debe seleccionar un tipo de sangre',
            'alergias.required' => 'Debe seleccionar al menos una alergia',
            'alergiaOtros.regex' => 'Solo letras y espacios en el campo de alergia',
            'alergiaAlimentos.regex' => 'Solo letras y espacios en el campo de alimentos',
            'alergiaMedicamentos.regex' => 'Solo letras y espacios en el campo de medicamentos',
            'contactodeemergencia.required' => 'Debe ingresar un nombre con su apellido',
            'telefonodeemergencia.required' => 'Debe ingresar un número de teléfono',
            'telefonodeemergencia.unique' => 'Este número de teléfono ya está registrado',
        ];

        $validated = $request->validate($rules, $messages);
        $alergias = $validated['alergias'];
        $errores = [];
        if (in_array('Otros', $alergias) && empty($validated['alergiaOtros'])) {
            $errores['alergiaOtros'] = 'Debe especificar la alergia en "Otros".';
        }
        if (in_array('Alimentos', $alergias) && empty($validated['alergiaAlimentos'])) {
            $errores['alergiaAlimentos'] = 'Debe especificar qué alimento.';
        }
        if (in_array('Medicamentos', $alergias) && empty($validated['alergiaMedicamentos'])) {
            $errores['alergiaMedicamentos'] = 'Debe especificar qué medicamento.';
        }
        if (!empty($errores)) {
            return back()->withErrors($errores)->withInput();
        }
        if (in_array('Otros', $alergias)) {
            $index = array_search('Otros', $alergias);
            $alergias[$index] = 'Otros: ' . $validated['alergiaOtros'];
        }
        if (in_array('Alimentos', $alergias)) {
            $index = array_search('Alimentos', $alergias);
            $alergias[$index] = 'Alimentos: ' . $validated['alergiaAlimentos'];
        }
        if (in_array('Medicamentos', $alergias)) {
            $index = array_search('Medicamentos', $alergias);
            $alergias[$index] = 'Medicamentos: ' . $validated['alergiaMedicamentos'];
        }

        $validated['alergias'] = empty($alergias) ? ['Ninguno'] : $alergias;
        $validated['alergiaOtros'] = $validated['alergiaOtros'] ?? '';
        $validated['alergiaAlimentos'] = $validated['alergiaAlimentos'] ?? '';
        $validated['alergiaMedicamentos'] = $validated['alergiaMedicamentos'] ?? '';

        Empleado::create($validated);

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

        $rules = [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'direccion' => 'required|string|max:150',
            'email' => 'required|email|max:50|unique:empleados,email,' . $empleado->id,
            'telefono' => 'required|string|max:8|unique:empleados,telefono,' . $empleado->id,
            'identidad' => 'required|string|size:15|unique:empleados,identidad,' . $empleado->id,
            'contactodeemergencia' => 'required|string|max:100',
            'telefonodeemergencia' => 'required|string|max:8',
            'tipodesangre' => 'required|string',
            'alergias' => 'required|array|min:1',
            'alergiaOtros' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
            'alergiaAlimentos' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
            'alergiaMedicamentos' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
        ];

        $messages = [
            'nombre.required' => 'Debe ingresar un nombre',
            'apellido.required' => 'Debe ingresar un apellido',
            'direccion.required' => 'Debe ingresar una dirección',
            'email.required' => 'Debe ingresar un correo electrónico',
            'email.email' => 'Debe ingresar un correo electrónico válido',
            'email.unique' => 'Este correo ya está registrado',
            'telefono.required' => 'Debe ingresar un número de teléfono',
            'telefono.unique' => 'Este número de teléfono ya está registrado',
            'identidad.required' => 'Debe ingresar una identidad',
            'identidad.size' => 'La identidad debe tener exactamente 15 caracteres',
            'identidad.unique' => 'Esta identidad ya está registrada',
            'contactodeemergencia.required' => 'Debe ingresar un nombre con su apellido',
            'telefonodeemergencia.required' => 'Debe ingresar un número de teléfono',
            'tipodesangre.required' => 'Debe seleccionar un tipo de sangre',
            'alergias.required' => 'Debe seleccionar al menos una alergia',
            'alergiaOtros.regex' => 'Solo letras y espacios en el campo de alergia',
            'alergiaAlimentos.regex' => 'Solo letras y espacios en el campo de alimentos',
            'alergiaMedicamentos.regex' => 'Solo letras y espacios en el campo de medicamentos',
        ];

        $validated = $request->validate($rules, $messages);
        $alergias = $validated['alergias'];
        $errores = [];
        if (in_array('Otros', $alergias) && empty($validated['alergiaOtros'])) {
            $errores['alergiaOtros'] = 'Debe especificar la alergia en "Otros".';
        }
        if (in_array('Alimentos', $alergias) && empty($validated['alergiaAlimentos'])) {
            $errores['alergiaAlimentos'] = 'Debe especificar qué alimento.';
        }
        if (in_array('Medicamentos', $alergias) && empty($validated['alergiaMedicamentos'])) {
            $errores['alergiaMedicamentos'] = 'Debe especificar qué medicamento.';
        }
        if (!empty($errores)) {
            return back()->withErrors($errores)->withInput();
        }
        if (in_array('Otros', $alergias)) {
            $index = array_search('Otros', $alergias);
            $alergias[$index] = 'Otros: ' . $validated['alergiaOtros'];
        }
        if (in_array('Alimentos', $alergias)) {
            $index = array_search('Alimentos', $alergias);
            $alergias[$index] = 'Alimentos: ' . $validated['alergiaAlimentos'];
        }
        if (in_array('Medicamentos', $alergias)) {
            $index = array_search('Medicamentos', $alergias);
            $alergias[$index] = 'Medicamentos: ' . $validated['alergiaMedicamentos'];
        }

        $validated['alergias'] = empty($alergias) ? ['Ninguno'] : $alergias;
        $validated['alergiaOtros'] = $validated['alergiaOtros'] ?? '';
        $validated['alergiaAlimentos'] = $validated['alergiaAlimentos'] ?? '';
        $validated['alergiaMedicamentos'] = $validated['alergiaMedicamentos'] ?? '';

        $empleado->update($validated);

        return redirect()->route('empleados.show', $empleado->id)->with('success', 'Empleado actualizado correctamente.');
    }
    public function destroy(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}
