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
            // *** ESTAS DEBEN SER 'required' Y 'max:9999' ***
            'costo_diurno'         => 'required|numeric|min:1|max:9999',
            'costo_nocturno'       => 'required|numeric|min:1|max:9999',
            'costo_24_horas'       => 'required|numeric|min:1|max:9999',
            'productos_categoria'  => 'required|in:vigilancia,tecnico',
            'productos'            => 'nullable|array',
            'productos.*'          => 'integer|exists:productos,id'
        ], [
            'nombreServicio.regex'      => 'El nombre solo puede contener letras y espacios.',
            'descripcionServicio.regex' => 'La descripción solo puede contener letras y espacios.',
            // *** MENSAJES PERSONALIZADOS PARA LOS COSTOS ***
            'costo_diurno.required'     => 'El costo diurno es obligatorio.',
            'costo_diurno.numeric'      => 'El costo diurno debe ser un número.',
            'costo_diurno.min'          => 'El costo diurno no puede ser 0.',
            'costo_diurno.max'          => 'El costo diurno no puede exceder 9999.',
            'costo_nocturno.required'   => 'El costo nocturno es obligatorio.',
            'costo_nocturno.numeric'    => 'El costo nocturno debe ser un número.',
            'costo_nocturno.min'        => 'El costo nocturno no puede ser 0.',
            'costo_nocturno.max'        => 'El costo nocturno no puede exceder 9999.',
            'costo_24_horas.required'   => 'El costo 24 horas es obligatorio.',
            'costo_24_horas.numeric'    => 'El costo 24 horas debe ser un número.',
            'costo_24_horas.min'        => 'El costo 24 horas no puede ser 0',
            'costo_24_horas.max'        => 'El costo 24 horas no puede exceder 9999.',
        ]);

        $servicio = new Servicio();
        $servicio->nombre          = $validated['nombreServicio'];
        $servicio->descripcion     = $validated['descripcionServicio'];
         $servicio->costo_diurno    = $validated['costo_diurno'] ?? null;
        $servicio->costo_nocturno  = $validated['costo_nocturno'] ?? null;
        $servicio->costo_24_horas  = $validated['costo_24_horas'] ?? null;
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
             // *** ESTAS DEBEN SER 'required' Y 'max:9999' ***
            'costo_diurno'         => 'required|numeric|min:1|max:9999',
            'costo_nocturno'       => 'required|numeric|min:1|max:9999',
            'costo_24_horas'       => 'required|numeric|min:1|max:9999',
            'productos'            => 'nullable|array',
            'productos.*'          => 'integer|exists:productos,id'
        ], [
            'nombreServicio.regex'      => 'El nombre solo puede contener letras y espacios.',
            'descripcionServicio.regex' => 'La descripción solo puede contener letras y espacios.',
            // *** MENSAJES PERSONALIZADOS PARA LOS COSTOS ***
            'costo_diurno.required'     => 'El costo diurno es obligatorio.',
            'costo_diurno.numeric'      => 'El costo diurno debe ser un número.',
            'costo_diurno.min'          => 'El costo diurno no puede ser negativo.',
            'costo_diurno.max'          => 'El costo diurno no puede exceder 9999.',
            'costo_nocturno.required'   => 'El costo nocturno es obligatorio.',
            'costo_nocturno.numeric'    => 'El costo nocturno debe ser un número.',
            'costo_nocturno.min'        => 'El costo nocturno no puede ser negativo.',
            'costo_nocturno.max'        => 'El costo nocturno no puede exceder 9999.',
            'costo_24_horas.required'   => 'El costo 24 horas es obligatorio.',
            'costo_24_horas.numeric'    => 'El costo 24 horas debe ser un número.',
            'costo_24_horas.min'        => 'El costo 24 horas no puede ser negativo.',
            'costo_24_horas.max'        => 'El costo 24 horas no puede exceder 9999.',
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->nombre          = $validated['nombreServicio'];
        $servicio->costo_diurno    = $validated['costo_diurno'] ?? null;
        $servicio->costo_nocturno  = $validated['costo_nocturno'] ?? null;
        $servicio->costo_24_horas  = $validated['costo_24_horas'] ?? null;
        $servicio->productos       = json_encode($validated['productos'] ?? []);

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
