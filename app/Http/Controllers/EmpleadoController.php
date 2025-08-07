<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class EmpleadoController extends Controller
{
    public function index(Request $request)
    {

        $request->validate([
            'search' => ['nullable', 'string', 'max:25'],
        ], [
            'search.string' => 'Ingresa texto válido para buscar por nombre, departamento o identidad.'
        ]);

        $search = $request->input('search');

        $empleados = Empleado::query();

        if ($search) {
            $empleados->where(function ($query) use ($search) {
                $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('departamento', 'like', "%{$search}%")
                    ->orWhere('identidad', 'like', "%{$search}%");
            });
        }

        $empleados = $empleados->paginate(10)->withQueryString();

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

        $codigosDep = [
            '01', '02', '03', '04', '05', '06', '07', '08', '09',
            '10', '11', '12', '13', '14', '15', '16', '17', '18'
        ];

        $municipiosPorDepartamento = [
            '01'=> [ "01", "02", "03", "04", "05", "06", "07", "08" ], // Atlántida
            '02' => [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16" ], // Choluteca
            '03'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10" ], // Colón
            '04'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20","21" ], // Comayagua
            '05'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14","15", "16", "17", "18", "19", "20","21", "22", "23" ], // Copán
            '06'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12" ], // Cortés
            '07'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19" ], // El Paraíso
            '08'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18","19","20","21", "22", "23", "24", "25", "26", "27", "28" ], // Francisco Morazán
            '09'=> [ "01", "02", "03", "04", "05", "06" ], // Gracias a Dios
            '10'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17" ], // Intibucá
            '11'=> [ "01", "02", "03", "04" ], // Islas de la Bahía
            '12'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19" ], // La Paz
            '13'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26","27","28" ], // Lempira
            '14'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14","15", "16" ], // Ocotepeque
            '15'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"], // Olancho
            '16'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19","20","21", "22", "23", "24", "25", "26", "27", "28" ], // Santa Bárbara
            '17'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09" ], // Valle
            '18'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11"] // Yoro
        ];

        $rules = [
            'nombre' => 'required|string|max:50|regex:/^[\p{L}\s]+$/u',
            'apellido' => 'required|string|max:50|regex:/^[\p{L}\s]+$/u',
            'identidad' => ['required', 'string', 'size:13', 'regex:/^\d{13}$/', 'unique:empleados,identidad',
                function ($attribute, $value, $fail) use ($codigosDep, $municipiosPorDepartamento) {
                    $departamento = substr($value, 0, 2);
                    $municipio = substr($value, 2, 2);

                    if (!in_array($departamento, $codigosDep)) {
                        $fail('Código de departamento inválido en la identidad.');
                    } elseif (!isset($municipiosPorDepartamento[$departamento]) || !in_array($municipio, $municipiosPorDepartamento[$departamento])) {
                        $fail('Código de municipio inválido para el departamento seleccionado en la identidad.');
                    }
                },
                function ($attribute, $value, $fail) {
                    $anio = (int) substr($value, 4, 4);
                    if ($anio < 1940 || $anio > 2007) {
                        $fail('El año de la identidad debe ser entre 1940 y 2007.');
                    }
                }
            ],


            'direccion' => 'required|string|max:150|regex:/^[\p{L}0-9\s.,;#\-]+$/u',
            'email' => 'required|email|max:50|unique:empleados,email',
            'telefono' => ['required', 'string', 'size:8', 'regex:/^[2389][0-9]{7}$/', 'not_regex:/^(\d)\1{7}$/', 'unique:empleados,telefono',],
            'contactodeemergencia' => 'required|string|max:100|regex:/^[\p{L}\s]+$/u',
            'telefonodeemergencia' => ['required', 'string', 'regex:/^[2389][0-9]{7}$/', 'unique:empleados,telefonodeemergencia',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^(\d)\1{7}$/', $value)) {
                        $fail('El teléfono de emergencia no puede tener todos los dígitos iguales.');
                    }
                },
            ],
            'tipodesangre' => 'required|string',
            'departamento'=> 'required|string',
            'alergias' => 'required|array|min:1',
            'alergiaOtros' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
            'alergiaAlimentos' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
            'alergiaMedicamentos' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
            'categoria' => 'required|in:Administracion,Tecnico,Vigilancia',

        ];

        $messages = [
            'nombre.required' => 'Debe ingresar un nombre',
            'apellido.required' => 'Debe ingresar un apellido',
            'identidad.required' => 'Debe ingresar una identidad',
            'identidad.size' => 'La identidad debe tener exactamente 13 digitos',
            'identidad.unique' => 'Esta identidad ya está registrada',
            'direccion.required' => 'Debe ingresar una dirección',
            'telefono.required' => 'Debe ingresar un número de teléfono',
            'telefono.regex' => 'El teléfono debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.',
            'telefono.unique' => 'Este número de teléfono ya está registrado',
            'telefono.max' => 'El teléfono no debe tener más de 8 dígitos.',
            'email.required' => 'Debe ingresar un correo electrónico',
            'email.email' => 'Debe ingresar un correo electrónico válido',
            'email.unique' => 'Este correo ya está registrado',
            'tipodesangre.required' => 'Debe seleccionar un tipo de sangre',
            'departamento.required' => 'Debe seleccionar un departamento',
            'alergias.required' => 'Debe seleccionar al menos una alergia',
            'alergiaOtros.regex' => 'Solo letras y espacios en el campo de alergia',
            'alergiaAlimentos.regex' => 'Solo letras y espacios en el campo de alimentos',
            'alergiaMedicamentos.regex' => 'Solo letras y espacios en el campo de medicamentos',
            'contactodeemergencia.required' => 'Debe ingresar un nombre con su apellido',
            'telefonodeemergencia.required' => 'Debe ingresar un número de teléfono',
            'telefonodeemergencia.regex' => 'El teléfono de emergencia debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.',
            'telefonodeemergencia.unique' => 'Este número de teléfono ya está registrado',
            'telefonodeemergencia.max' => 'El teléfono de emergencia no debe tener más de 8 dígitos.',
            'categoria.required' => 'Debe seleccionar un puesto'
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

        $codigosDep = [
            '01', '02', '03', '04', '05', '06', '07', '08', '09',
            '10', '11', '12', '13', '14', '15', '16', '17', '18'
        ];

        $municipiosPorDepartamento = [
            '01'=> [ "01", "02", "03", "04", "05", "06", "07", "08" ], // Atlántida
            '02' => [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16" ], // Choluteca
            '03'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10" ], // Colón
            '04'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20","21" ], // Comayagua
            '05'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14","15", "16", "17", "18", "19", "20","21", "22", "23" ], // Copán
            '06'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12" ], // Cortés
            '07'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19" ], // El Paraíso
            '08'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18","19","20","21", "22", "23", "24", "25", "26", "27", "28" ], // Francisco Morazán
            '09'=> [ "01", "02", "03", "04", "05", "06" ], // Gracias a Dios
            '10'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17" ], // Intibucá
            '11'=> [ "01", "02", "03", "04" ], // Islas de la Bahía
            '12'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19" ], // La Paz
            '13'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26","27","28" ], // Lempira
            '14'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14","15", "16" ], // Ocotepeque
            '15'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"], // Olancho
            '16'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19","20","21", "22", "23", "24", "25", "26", "27", "28" ], // Santa Bárbara
            '17'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09" ], // Valle
            '18'=> [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11"] // Yoro
        ];
        $empleado = Empleado::findOrFail($id);
        $request->merge(['alergias' => $request->input('alergias', [])]);

        $rules = [
            'nombre' => 'required|string|max:50|regex:/^[\p{L}\s]+$/u',
            'apellido' => 'required|string|max:50|regex:/^[\p{L}\s]+$/u',
            'direccion' => 'required|string|max:150|regex:/^[\p{L}0-9\s.,;#\-]+$/u',
            'email' => 'required|email|max:50|unique:empleados,email,' . $empleado->id,
            'telefono' => ['required', 'string', 'size:8', 'regex:/^[2389][0-9]{7}$/', 'not_regex:/^(\d)\1{7}$/', Rule::unique('empleados', 'telefono')->ignore($empleado->id),],
            'identidad' => ['required', 'string', 'size:13', 'regex:/^\d{13}$/',
                Rule::unique('empleados', 'identidad')->ignore($empleado->id),
                function ($attribute, $value, $fail) use ($codigosDep, $municipiosPorDepartamento) {
                    $departamento = substr($value, 0, 2);
                    $municipio = substr($value, 2, 2);

                    if (!in_array($departamento, $codigosDep)) {
                        $fail('Código de departamento inválido en la identidad.');
                    } elseif (!isset($municipiosPorDepartamento[$departamento]) || !in_array($municipio, $municipiosPorDepartamento[$departamento])) {
                        $fail('Código de municipio inválido para el departamento seleccionado en la identidad.');
                    }
                },
                function ($attribute, $value, $fail) {
                    $anio = (int) substr($value, 4, 4);
                    if ($anio < 1940 || $anio > 2007) {
                        $fail('El año de la identidad debe ser entre 1940 y 2007.');
                    }
                },
            ],


            'contactodeemergencia' => 'required|string|max:100|regex:/^[\p{L}\s]+$/u',
            'telefonodeemergencia' => [
                'required',
                'string',
                'regex:/^[2389][0-9]{7}$/',
                Rule::unique('empleados', 'telefonodeemergencia')->ignore($empleado->id),
                function ($attribute, $value, $fail) {
                    if (preg_match('/^(\d)\1{7}$/', $value)) {
                        $fail('El teléfono de emergencia no puede tener todos los dígitos iguales.');
                    }
                },
            ],
            'tipodesangre' => 'required|string',
            'departamento' => 'required|string',
            'alergias' => 'required|array|min:1',
            'alergiaOtros' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
            'alergiaAlimentos' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
            'alergiaMedicamentos' => 'nullable|string|max:150|regex:/^[\pL\s]+$/u',
            'categoria' => 'required|in:Administracion,Tecnico,Vigilancia',
        ];

        $messages = [
            'nombre.required' => 'Debe ingresar un nombre',
            'apellido.required' => 'Debe ingresar un apellido',
            'direccion.required' => 'Debe ingresar una dirección',
            'email.required' => 'Debe ingresar un correo electrónico',
            'email.email' => 'Debe ingresar un correo electrónico válido',
            'email.unique' => 'Este correo ya está registrado',
            'telefono.required' => 'Debe ingresar un número de teléfono',
            'telefono.regex' => 'El teléfono debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.',
            'telefono.unique' => 'Este número de teléfono ya está registrado',
            'telefono.max' => 'El teléfono no debe tener más de 8 dígitos.',
            'identidad.required' => 'Debe ingresar una identidad',
            'identidad.size' => 'La identidad debe tener exactamente 13 digitos',
            'identidad.unique' => 'Esta identidad ya está registrada',
            'contactodeemergencia.required' => 'Debe ingresar un nombre con su apellido',
            'telefonodeemergencia.required' => 'Debe ingresar un número de teléfono',
            'telefonodeemergencia.regex' => 'El teléfono de emergencia debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.',
            'telefonodeemergencia.max' => 'El teléfono de emergencia no debe tener más de 8 dígitos.',
            'tipodesangre.required' => 'Debe seleccionar un tipo de sangre',
            'departamento.required' => 'Debe seleccionar un departamento',
            'alergias.required' => 'Debe seleccionar al menos una alergia',
            'alergiaOtros.regex' => 'Solo letras y espacios en el campo de alergia',
            'alergiaAlimentos.regex' => 'Solo letras y espacios en el campo de alimentos',
            'alergiaMedicamentos.regex' => 'Solo letras y espacios en el campo de medicamentos',
            'categoria.required' => 'Debe seleccionar un puesto'
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

        $empleado->fill([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'direccion' => $validated['direccion'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'],
            'identidad' => $validated['identidad'],
            'contactodeemergencia' => $validated['contactodeemergencia'],
            'telefonodeemergencia' => $validated['telefonodeemergencia'],
            'tipodesangre' => $validated['tipodesangre'],
            'departamento' => $validated['departamento'],
            'categoria' => $validated['categoria'],
            'alergias' => $validated['alergias'],
            'alergiaOtros' => $validated['alergiaOtros'],
            'alergiaAlimentos' => $validated['alergiaAlimentos'],
            'alergiaMedicamentos' => $validated['alergiaMedicamentos'],
        ]);
        if (!$empleado->isDirty()) {
            return redirect()->route('empleados.show', $empleado->id)
                ->with('info', 'No se realizaron cambios.');
        }
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
