<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Servicio;
use Illuminate\Http\Request;

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
            $request->validate([
                'nombre_servicio' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'direccion' => 'required|string',
                'ciudad' => 'required|string',
                'fecha_inicio' => 'required|date',
                'duracion' => 'required|string',
                'horario' => 'required|string',
                'cantidad_personal' => 'required|integer',
                'tipo_personal' => 'required|string',
                'incluye_equipamiento' => 'nullable|boolean',
                'fecha_solicitud' => 'required|date',
            ]);

        Servicio::create($request->all());

        return redirect()->route('servicios.index')->with('success', 'Servicio registrado correctamente.');
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

    public function catalogo()
    {
        $servicios = Servicio::all();
        return view('servicios.catalogo', compact('servicios'));
    }

}
