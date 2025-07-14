<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $clientes = Cliente::paginate(10);
        return view('Clientes.indexCliente', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('Clientes.formulariocliente');


    }

    /**
     * Store a newly created resource in storage.
     */
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


        $request->validate([
            'nombre' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/u'],
            'apellido' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/u'],
            'identidad' => ['required', 'string', 'size:13', 'regex:/^\d{13}$/', 'unique:clientes,identidad', function ($attribute, $value, $fail) use ($codigosDep, $municipiosPorDepartamento) {
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
            'correo' => ['required', 'string', 'email', 'max:50', 'unique:clientes,correo'],
            'telefono' => ['required', 'regex:/^[2389][0-9]{7}$/', 'size:8', 'unique:clientes,telefono'],
            'direccion' => ['required', 'string','max:250'],
            'departamento' => ['required', 'string'],
        ], [
            'nombre.required' => 'Debe ingresar el nombre.',
            'nombre.regex' => 'El nombre solo debe contener letras, espacios y tildes.',
            'direccion.required' => 'Debe ingresar la dirección.',

            'telefono.required' => 'Debe ingresar el teléfono.',
            'telefono.regex' => 'El teléfono debe comenzar con 2, 3, 8 o 9 y tener 8 dígitos.',
            'telefono.size' => 'El teléfono debe tener exactamente 8 dígitos.',
            'telefono.unique' => 'Este número de teléfono ya está registrado.',

            'correo.required' => 'Debe ingresar el correo electrónico.',
            'correo.email' => 'Debe ingresar un correo electrónico válido.',
            'correo.unique' => 'Este correo ya está registrado.',

            'departamento.required' => 'Debe seleccionar un departamento.',
            'apellido.required' => 'Debe ingresar el apellido.',
            'apellido.regex' => 'El apellido solo debe contener letras, espacios y tildes.',
            'identidad.required' => 'Debe ingresar la identidad',
            'identidad.size' => 'La identidad debe tener exactamente 13 digitos',
            'identidad.unique' => 'Esta identidad ya está registrada',





        ]);

        $cliente= new Cliente();
        $cliente->nombre = $request->input('nombre');
        $cliente->apellido = $request->input('apellido');
        $cliente->identidad = $request->input('identidad');
        $cliente->correo = $request->input('correo');
        $cliente->telefono = $request->input('telefono');
        $cliente->direccion = $request->input('direccion');
        $cliente->departamento = $request->input('departamento');

        if ($cliente->save()) {
            return redirect()->route('Clientes.indexCliente')->with('exito', 'El cliente se guardó correctamente.');
        } else {
            return redirect()->route('Clientes.indexCliente')->with('fracaso', 'El cliente no se guardó correctamente.');
        }




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
