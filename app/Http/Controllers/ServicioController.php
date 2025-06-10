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
        $validated = $request->validate([
            'nombre' => 'required|string',
            'categoria' => 'required|string',
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'descripcion' => 'nullable|string',
            'codigo_interno' => 'required|unique:servicios',
            'fecha_ingreso' => 'required|date',
            'proveedor' => 'nullable|string',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'unidades_stock' => 'required|integer',
        ]);

        Servicio::create($validated);
        return redirect()->back()->with('success', 'Articulo guardado correctamente.');
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
        return view('servicios.catalogo', compact('servicios')); // Asegúrate que esto coincide con el archivo en views/
    }

}
