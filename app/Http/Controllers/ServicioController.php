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
        $validatedData = $request->validate([
            'nombreServicio' => 'required|string|max:50',
            'tipoServicio' => 'required|string|max:30',
            'descripcionServicio' => 'required|string|max:125',
            'duracionEstimada' => 'required|string|max:30',
            'requiereProductos' => 'required|in:sí,no',
            'especificarProductos' => 'nullable|string|max:100',
        ]);

        $requiereProductos = $request->requiereProductos === 'sí' ? 1 : 0;

        Servicio::create([
            'nombre' => $request->nombreServicio,
            'tipo' => $request->tipoServicio,
            'descripcion' => $request->descripcionServicio,
            'duracion_estimada' => $request->duracionEstimada,  // <-- aquí
            'requiere_productos' => $request->requiereProductos === 'sí' ? 1 : 0,
            'productos_especificos' => 'nullable|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9,\s]*$/',
        ]);

        return redirect()->route('servicios.catalogo')->with('success', 'Servicio registrado exitosamente.');
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
