<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\FacturaVenta;
use App\Models\Instalacion;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InstalacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Muestra la vista del calendario
    public function index(Request $request)
    {
        // Consulta base con relaciones necesarias para el calendario
        $query = Instalacion::with(['cliente', 'servicio'])
            ->select('id', 'cliente_id', 'servicio_id', 'direccion', 'fecha_instalacion');

        // Si hay búsqueda, aplicar filtro
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%");
            })
                ->orWhereHas('servicio', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%");
                })
                ->orWhere('direccion', 'like', "%{$search}%");
        }

        // Obtener instalaciones filtradas o no
        $instalaciones = $query->get();

        // Si la petición es AJAX (para el calendario o buscador)
        if ($request->ajax()) {
            return response()->json($instalaciones);
        }

        // Cargar la vista con los datos
        return view('instalaciones.index', compact('instalaciones'));
    }


// Devuelve eventos para FullCalendar
    public function eventos(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $q = $request->input('q');

        $instalaciones = Instalacion::with(['cliente', 'servicio', 'factura', 'tecnicos'])
            ->whereBetween('fecha_instalacion', [$start, $end])
            ->when($q, function($query) use ($q) {
                $query->where(function($sub) use ($q) {
                    $sub->whereHas('cliente', function($q1) use ($q) {
                        $q1->where('nombre', 'like', "%{$q}%");
                    })
                        ->orWhereHas('servicio', function($q2) use ($q) {
                            $q2->where('nombre', 'like', "%{$q}%");
                        })
                        ->orWhere('direccion', 'like', "%{$q}%");
                });
            })
            ->get();

        $eventos = $instalaciones->map(function ($instalacion) {
            return [
                'id' => $instalacion->id,
                'title' => $instalacion->cliente->nombre . ' - ' . $instalacion->servicio->nombre,
                'start' => $instalacion->fecha_instalacion,
                'extendedProps' => [
                    'cliente' => $instalacion->cliente->nombre,
                    'servicio' => $instalacion->servicio->nombre,
                    'descripcion' => $instalacion->descripcion,
                    'direccion' => $instalacion->direccion,
                    'costo' => $instalacion->costo_instalacion,
                    'factura' => $instalacion->factura?->numero ?? 'No aplica',
                    'tecnicos' => $instalacion->tecnicos->pluck('nombre')->toArray(),
                ]
            ];
        });

        return response()->json($eventos);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $tecnicos = Empleado::where('categoria', 'Tecnico')->get(); // Filtrar empleados por categoría 'tecnico'
        $servicios = Servicio::where('categoria', 'tecnico')->get(); // Filtrar servicios por categoría 'tecnico'
        $facturas = FacturaVenta::all();

        return view('instalaciones.formulario', compact('clientes', 'tecnicos', 'servicios', 'facturas'));
    }


    /**
     * Guardar instalación
     */

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'empleado_id' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $id) {
                        if (!Empleado::where('id', $id)->where('categoria', 'Tecnico')->exists()) {
                            $fail('Uno o más empleados seleccionados no son técnicos.');
                        }
                    }
                }
            ],
            'servicio_id' => [
                'required',
                Rule::exists('servicios', 'id')->where(function ($query) {
                    $query->where('categoria', 'tecnico');
                })
            ],
            'fecha_instalacion' => 'required|date|after_or_equal:today',
            'costo_instalacion' => [
                'required',
                'numeric',
                'min:1',
                'regex:/^\d{1,4}(\.\d{1,2})?$/'
            ],
            'descripcion' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'factura_id' => 'nullable|exists:facturas,id'
        ], [
            'cliente_id.required' => 'Debe seleccionar un cliente.',
            'empleado_id.required' => 'Debe seleccionar al menos un técnico.',
            'servicio_id.required' => 'Debe seleccionar un servicio.',
            'fecha_instalacion.required' => 'Debe ingresar una fecha de instalación.',
            'costo_instalacion.required' => 'El costo de instalación es obligatorio.',
            'costo_instalacion.min' => 'El costo debe ser mayor a 0.',
            'costo_instalacion.regex' => 'El costo debe tener como máximo 4 cifras.',
            'descripcion.required' => 'Debe ingresar una descripción.',
            'direccion.required' => 'Debe ingresar una dirección.'
        ]);

        // 🔹 Verificar que el técnico no tenga otra instalación ese mismo día
        foreach ($request->empleado_id as $tecnicoId) {
            $existe = Instalacion::whereDate('fecha_instalacion', $request->fecha_instalacion)
                ->whereHas('tecnicos', function ($q) use ($tecnicoId) {
                    $q->where('empleado_id', $tecnicoId);
                })
                ->exists();

            if ($existe) {
                return back()
                    ->withErrors(['empleado_id' => "El técnico con ID {$tecnicoId} ya tiene una instalación en esa fecha."])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($request) {
            $instalacion = Instalacion::create([
                'cliente_id' => $request->cliente_id,
                'servicio_id' => $request->servicio_id,
                'descripcion' => $request->descripcion,
                'direccion' => $request->direccion,
                'fecha_instalacion' => $request->fecha_instalacion,
                'costo_instalacion' => $request->costo_instalacion,
                'factura_id' => $request->factura_id,
            ]);

            $instalacion->tecnicos()->attach($request->empleado_id);
        });

        return redirect()->route('instalaciones.index')->with('success', 'Instalación registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $instalacion = Instalacion::with(['cliente', 'servicio', 'empleado'])->findOrFail($id);
        return view('instalaciones.detalle', compact('instalacion'));
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
