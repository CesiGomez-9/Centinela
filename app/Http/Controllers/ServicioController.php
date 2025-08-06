<?php

namespace App\Http\Controllers;

use App\Models\Producto;
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

        $productosVigilancia = Producto::where('categoria', 'Implementos de seguridad')->get();

        $productosTecnico = Producto::whereIn('categoria', [
            'Cámaras de seguridad',
            'Alarmas antirrobo',
            'Cerraduras inteligentes',
            'Sensores de movimiento',
            'Luces con sensor de movimiento',
            'Rejas o puertas de seguridad',
            'Sistema de monitoreo 24/7'
        ])->get();

        return view('servicios.index', compact('servicios', 'productosVigilancia', 'productosTecnico'));
    }

    public function create()
    {
        return redirect()->route('servicios.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombreServicio'       => 'required|string|max:50|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'descripcionServicio'  => 'required|string|max:125|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'categoria'            => 'required|in:vigilancia,tecnico',
            'costo_cantidad'       => 'required|integer|min:1|max:9999',
            'costo_tipo'           => 'required|in:Diurno,Nocturno,Mixto,24 horas',
            'productos_categoria'  => 'required|in:vigilancia,tecnico',
            'productos'            => 'nullable|array',
            'productos.*'          => 'integer|exists:productos,id'
        ], [
            'nombreServicio.regex'      => 'El nombre solo puede contener letras y espacios.',
            'descripcionServicio.regex' => 'La descripción solo puede contener letras y espacios.',
        ]);

        $servicio = new Servicio();
        $servicio->nombre          = $validated['nombreServicio'];
        $servicio->descripcion     = $validated['descripcionServicio'];
        $servicio->categoria       = $validated['categoria'];
        $servicio->costo_cantidad  = $validated['costo_cantidad'];
        $servicio->costo_tipo      = $validated['costo_tipo'];
        $servicio->productos       = json_encode($validated['productos'] ?? []);

        $servicio->save();

        return redirect()->route('servicios.catalogo')->with('success', 'Servicio registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $servicio = Servicio::findOrFail($id);

        $productosIds = json_decode($servicio->productos ?? '[]', true);
        $productos = Producto::whereIn('id', $productosIds)->get();

        return view('servicios.show', compact('servicio', 'productos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);
        $productosSeleccionados = json_decode($servicio->productos, true) ?? [];

        $productosVigilancia = Producto::where(function ($query) use ($productosSeleccionados) {
            $query->where('categoria', 'Implementos de seguridad')
                ->orWhereIn('id', $productosSeleccionados);
        })->get()->unique('id');

        $productosTecnicos = Producto::where(function ($query) use ($productosSeleccionados) {
            $query->whereIn('categoria', [
                'Cámaras de seguridad',
                'Alarmas antirrobo',
                'Cerraduras inteligentes',
                'Sensores de movimiento',
                'Luces con sensor de movimiento',
                'Rejas o puertas de seguridad',
                'Sistema de monitoreo 24/7'
            ])->orWhereIn('id', $productosSeleccionados);
        })->get()->unique('id');

        return view('servicios.edit', [
            'servicio'              => $servicio,
            'productosVigilancia'   => $productosVigilancia,
            'productosTecnicos'     => $productosTecnicos,
            'productosSeleccionados'=> $productosSeleccionados,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombreServicio'       => 'required|string|max:50|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'descripcionServicio'  => 'required|string|max:125|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'categoria'            => 'required|in:vigilancia,tecnico',
            'costo_cantidad'       => 'required|integer|min:1|max:9999',
            'costo_tipo'           => 'required|in:Diurno,Nocturno,Mixto,24 horas',
            'productos'            => 'required|array',
            'productos.*'          => 'integer|exists:productos,id'
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->nombre          = $validated['nombreServicio'];
        $servicio->descripcion     = $validated['descripcionServicio'];
        $servicio->categoria       = $validated['categoria'];
        $servicio->costo_cantidad  = $validated['costo_cantidad'];
        $servicio->costo_tipo      = $validated['costo_tipo'];
        $servicio->productos       = json_encode($validated['productos']);

        $servicio->save();

        return redirect()->route('servicios.catalogo')->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        Servicio::destroy($id);
        return redirect()->back()->with('success', 'Servicio eliminado.');
    }

    public function catalogo(Request $request)
    {
        $query = Servicio::query();

        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        $servicios = $query->paginate(10)->appends(['search' => $request->search]);

        return view('servicios.catalogo', compact('servicios'));
    }
}
