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
            'direccion' => ['required', 'string'],
            'telefonodeempresa' => ['required', 'regex:/^[389][0-9]{7}$/', 'size:8', 'unique:proveedores,telefonodeempresa'],
            'correoempresa' => ['required', 'string', 'email', 'max:100', 'unique:proveedores,correoempresa'],
            'nombrerepresentante' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z\s]+$/'],
            'identificacion' => ['required', 'regex:/^(0[1-18]|1[0-18])[0-18]{11}$/', 'size:13', 'unique:proveedores,identificacion'],
            'categoriarubro' => ['required', 'string'],

        ], [], [
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
