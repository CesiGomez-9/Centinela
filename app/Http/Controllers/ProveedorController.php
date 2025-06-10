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
        $proveedores= Proveedor::all();
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
            'nombres' => 'required|max:255|regex:/[a-zA-Z0-9 ]+/',
            'apellidos' => 'required|max:255|regex:/[a-zA-Z0-9 ]+/',
            'direccion'=>'required|max:255|regex:/[a-zA-Z0-9 ]+/',
            'telefono'=>'required|regex:/^[\d\s\-\+]{8,15}$/',
            'correo' => 'required|email|max:200',
            'identificacion' =>'required|regex:/^[0-9-]{15}$/',
            'cargocontacto' => 'required|max:255|regex:/[a-zA-Z0-9 ]+/',
            'categoriarubro' => 'required',

        ]);


        $proveedor = new Proveedor();
        $proveedor->nombres = $request->input('nombres');
        $proveedor->apellidos = $request->input('apellidos');
        $proveedor->direccion= $request->input('direccion');
        $proveedor->telefono=$request->input('telefono');
        $proveedor->correo = $request->input('correo');
        $proveedor->identificacion = $request->input('identificacion');
        $proveedor->cargocontacto= $request->input('cargocontacto');
        $proveedor->categoriarubro= $request->input('categoriarubro');


        if ($proveedor->save()){
            return redirect()->route('Proveedores.indexProveedor')->with('exito', 'El proveedor se guardo correctamente.');
        }else{
            return redirect()->route('Proveedores.indexProveedor')->with('fracaso', 'El proveedor no se guardo correctamente.');
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
