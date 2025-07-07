<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $search = $request->input('search');

        $proveedores = Proveedor::query();

        if ($search) {
            $proveedores = $proveedores->where(function ($q) use ($search) {
                $q->where('nombreEmpresa',  'like', "%{$search}%")
                    ->orWhere('categoriarubro', 'like', "%{$search}%")
                    ->orWhere('departamento',   'like', "%{$search}%");
            });
        }



        $proveedores = $proveedores->paginate(10);


        return view('Proveedores.indexProveedor', compact('proveedores'));
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

            'nombreEmpresa' => ['required', 'string', 'max:50', 'regex:/^[\p{L}\s]+$/u'],
            'direccion' => ['required', 'string','max:250'],
            'telefonodeempresa' => ['required', 'regex:/^[2389][0-9]{7}$/', 'size:8', 'unique:proveedores,telefonodeempresa'],
            'correoempresa' => ['required', 'string', 'email', 'max:50', 'unique:proveedores,correoempresa'],
            'nombrerepresentante' => ['required', 'string', 'max:50', 'regex:/^[\p{L}\s]+$/u'],
            'telefonoderepresentante' => ['required', 'regex:/^[2389][0-9]{7}$/', 'size:8', 'unique:proveedores,telefonoderepresentante'],
            'categoriarubro' => ['required', 'string'],
            'departamento' => ['required', 'string'],

        ], [
            'nombreEmpresa.required' => 'Debe ingresar el nombre de la empresa.',
            'nombreEmpresa.regex' => 'El nombre de la empresa solo debe contener letras, espacios y tildes.',
            'direccion.required' => 'Debe ingresar la dirección.',

            'telefonodeempresa.required' => 'Debe ingresar el teléfono de la empresa.',
            'telefonodeempresa.regex' => 'El teléfono debe comenzar con 2, 3, 8 o 9 y tener 8 dígitos.',
            'telefonodeempresa.size' => 'El teléfono debe tener exactamente 8 dígitos.',
            'telefonodeempresa.unique' => 'Este número de teléfono ya está registrado.',

            'correoempresa.required' => 'Debe ingresar el correo electrónico.',
            'correoempresa.email' => 'Debe ingresar un correo electrónico válido.',
            'correoempresa.unique' => 'Este correo ya está registrado.',

            'nombrerepresentante.required' => 'Debe ingresar el nombre del representante.',
            'nombrerepresentante.regex' => 'El nombre del representante solo debe contener letras y espacios y tildes.',

            'telefonoderepresentante.required' => 'Debe ingresar el teléfono del representante.',
            'telefonoderepresentante.regex' => 'El teléfono debe comenzar con 2, 3, 8 o 9 y tener 8 dígitos.',
            'telefonoderepresentante.size' => 'El teléfono debe tener exactamente 8 dígitos.',
            'telefonoderepresentante.unique' => 'Este número de teléfono ya está registrado.',

            'categoriarubro.required' => 'Debe seleccionar una categoría o rubro.',
            'departamento.required' => 'Debe seleccionar una categoría o rubro.'
        ], [
            'nombreEmpresa' => 'nombre de la empresa',
            'direccion' => 'dirección',
            'telefonodeempresa' => 'teléfono de la empresa',
            'correoempresa' => 'correo electrónico',
            'nombrerepresentante' => 'nombre del representante',
            'identificacion' => 'identificación',
            'categoriarubro' => 'categoría o rubro',
            'departamento'=>'departamento'

        ]);


        $proveedor = new Proveedor();
        $proveedor->nombreEmpresa = $request->input('nombreEmpresa');
        $proveedor->direccion = $request->input('direccion');
        $proveedor->telefonodeempresa = $request->input('telefonodeempresa');
        $proveedor->correoempresa = $request->input('correoempresa');
        $proveedor->nombrerepresentante = $request->input('nombrerepresentante');
        $proveedor->telefonoderepresentante = $request->input('telefonoderepresentante');
        $proveedor->categoriarubro = $request->input('categoriarubro');
        $proveedor->departamento = $request->input('departamento');

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

        $proveedor = Proveedor::findOrFail($id);
        return view('Proveedores.detalle', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $proveedor = Proveedor::findOrFail($id);
        return view('Proveedores.edit', compact('proveedor'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'nombreEmpresa' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/u'],
            'direccion' => ['required', 'string', 'max:250'],
            'telefonodeempresa' => [
                'required',
                'regex:/^[2389][0-9]{7}$/',
                'size:8',
                Rule::unique('proveedores', 'telefonodeempresa')->ignore($id)
            ],
            'correoempresa' => [
                'required',
                'string',
                'email',
                'max:50',
                Rule::unique('proveedores', 'correoempresa')->ignore($id)
            ],
            'nombrerepresentante' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/u'],
            'telefonoderepresentante' => [
                'required',
                'regex:/^[2389][0-9]{7}$/',
                'size:8',
                Rule::unique('proveedores', 'telefonoderepresentante')->ignore($id)
            ],
            'categoriarubro' => ['required', 'string'],
            'departamento' => ['required', 'string'],
        ], [
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
            'telefonoderepresentante.required' => 'Debe ingresar el teléfono del representante.',
            'telefonoderepresentante.regex' => 'El teléfono debe comenzar con 2, 3, 8 o 9 y tener 8 dígitos.',
            'telefonoderepresentante.size' => 'El teléfono debe tener exactamente 8 dígitos.',
            'telefonoderepresentante.unique' => 'Este número de teléfono ya está registrado.',
            'categoriarubro.required' => 'Debe seleccionar una categoría o rubro.',
            'departamento.required' => 'Debe seleccionar una categoría o rubro.',
        ]);

        $proveedor = Proveedor::findOrFail($id); // ✅ Actualizar el existente
        $proveedor->nombreEmpresa = $request->input('nombreEmpresa');
        $proveedor->direccion = $request->input('direccion');
        $proveedor->telefonodeempresa = $request->input('telefonodeempresa');
        $proveedor->correoempresa = $request->input('correoempresa');
        $proveedor->nombrerepresentante = $request->input('nombrerepresentante');
        $proveedor->telefonoderepresentante = $request->input('telefonoderepresentante');
        $proveedor->categoriarubro = $request->input('categoriarubro');
        $proveedor->departamento = $request->input('departamento');

        if ($proveedor->save()) {
            return redirect()->route('Proveedores.indexProveedor')->with('exito', 'El proveedor se editó correctamente.');
        } else {
            return redirect()->route('Proveedores.indexProveedor')->with('fracaso', 'El proveedor no se editó correctamente.');
        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
