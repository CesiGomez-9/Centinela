<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('Proveedores.indexProveedor')->with('proveedores', $proveedores);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Proveedores.nuevo');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'nombreEmpresa' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z\s]+$/'],
            'direccion' => ['required', 'string','max:150'],
            'telefonodeempresa' => ['required', 'regex:/^[2389][0-9]{7}$/', 'size:8', 'unique:proveedores,telefonodeempresa'],
            'correoempresa' => ['required', 'string', 'email', 'max:100', 'unique:proveedores,correoempresa'],
            'nombrerepresentante' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z\s]+$/'],
            'identificacion' => [ 'required', 'regex:/^(0[1-9]|1[0-8])[0-9]{11}$/', 'unique:proveedores,identificacion'],
            'categoriarubro' => ['required', 'string'],
        ], [  // mensajes personalizados aquí (2do parámetro)
            'nombreEmpresa.required' => 'Debe ingresar el nombre de la empresa.',
            'nombreEmpresa.regex' => 'El nombre de la empresa solo debe contener letras y espacios.',
            'direccion.required' => 'Debe ingresar la dirección.',

            'telefonodeempresa.required' => 'Debe ingresar el teléfono de la empresa.',
            'telefonodeempresa.regex' => 'El teléfono debe comenzar con 2, 3, 8 o 9 y tener 8 dígitos.',
            'telefonodeempresa.size' => 'El teléfono debe tener exactamente 8 dígitos.',
            'telefonodeempresa.unique' => 'Este número de teléfono ya está registrado.',

            'correoempresa.required' => 'Debe ingresar el correo electrónico.',
            'correoempresa.email' => 'Debe ingresar un correo electrónico válido.',
            'correoempresa.unique' => 'Este correo ya está registrado.',

            'nombrerepresentante.required' => 'Debe ingresar el nombre del representante.',
            'nombrerepresentante.regex' => 'El nombre del representante solo debe contener letras y espacios.',

            'identificacion.required' => 'Debe ingresar la identificación.',
            'identificacion.regex' => 'La identificación debe comenzar con 01 al 18 y tener 13 dígitos en total.',
            'identificacion.size' => 'La identificación debe tener exactamente 13 dígitos.',
            'identificacion.unique' => 'Esta identificación ya está registrada.',

            'categoriarubro.required' => 'Debe seleccionar una categoría o rubro.'
        ], [  // nombres personalizados (3er parámetro)
            'nombreEmpresa' => 'nombre de la empresa',
            'direccion' => 'dirección',
            'telefonodeempresa' => 'teléfono de la empresa',
            'correoempresa' => 'correo electrónico',
            'nombrerepresentante' => 'nombre del representante',
            'identificacion' => 'identificación',
            'categoriarubro' => 'categoría o rubro',

        ]);


        $proveedor = new Proveedor();
        $proveedor->nombreEmpresa = $request->input('nombreEmpresa'); // <- aquí estaba el error, ponías 'nombres'
        $proveedor->direccion = $request->input('direccion');
        $proveedor->telefonodeempresa = $request->input('telefonodeempresa');
        $proveedor->correoempresa = $request->input('correoempresa');
        $proveedor->nombrerepresentante = $request->input('nombrerepresentante');
        $proveedor->identificacion = $request->input('identificacion');
        $proveedor->categoriarubro = $request->input('categoriarubro');

        if ($proveedor->save()) {
            return redirect()->route('Proveedores.indexProveedor')->with('exito', 'El proveedor se guardó correctamente.');
        } else {
            return redirect()->route('Proveedores.indexProveedor')->with('fracaso', 'El proveedor no se guardó correctamente.');
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
