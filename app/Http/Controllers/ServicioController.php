<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::all();
        return view('servicios.index')->with('servicios', $servicios);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombreServicio' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'descripcionServicio' => ['required', 'string', 'max:125', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'categoria' => ['required', 'in:vigilancia,tecnico'],
            'tipo_personal' => ['required', 'in:vigilancia,tecnico'],
            'costo' => ['required', 'digits_between:3,4', 'regex:/^[1-9][0-9]{0,3}$/'], // no puede empezar en 0
            'duracion_cantidad' => ['required', 'integer', 'min:1', 'max:99'],
            'duracion_tipo' => ['required', 'in:horas,dias,meses,años'],
            'productos_categoria' => ['required', 'in:vigilancia,tecnico'],
            'productos_vigilancia' => ['nullable', 'array'],
            'productos_tecnico' => ['nullable', 'array'],
        ], [
            'nombreServicio.regex' => 'El nombre solo puede contener letras y espacios.',
            'descripcionServicio.regex' => 'La descripción solo puede contener letras y espacios.',
            'costo.regex' => 'El costo debe tener hasta 3 cifras y no comenzar con cero.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $servicio = new Servicio();
        $servicio->nombre = $request->nombreServicio;
        $servicio->descripcion = $request->descripcionServicio;
        $servicio->categoria = $request->categoria;
        $servicio->tipo_personal = $request->tipo_personal;
        $servicio->costo = $request->costo;
        $servicio->duracion_cantidad = $request->duracion_cantidad;
        $servicio->duracion_tipo = $request->duracion_tipo;

        if ($request->productos_categoria === 'vigilancia') {
            $servicio->productos_vigilancia = $request->productos_vigilancia ?? [];
            $servicio->productos_tecnico = null;
        } else {
            $servicio->productos_tecnico = $request->productos_tecnico ?? [];
            $servicio->productos_vigilancia = null;
        }

        $servicio->save();

        return redirect()->route('servicios.catalogo')->with('success', 'Servicio registrado correctamente.');
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Servicio::destroy($id);
        return redirect()->back()->with('success', 'Servicio eliminado.');


    }
    public function catalogo(Request $request)
    {
        $query = $request->input('search');

        if ($query) {
            $servicios = Servicio::where('nombre', 'like', "%$query%")->paginate(10);
        } else {
            $servicios = Servicio::paginate(10); // sin filtro
        }

        return view('servicios.catalogo', compact('servicios'));
    }




}
