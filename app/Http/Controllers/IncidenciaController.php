<?php

namespace App\Http\Controllers;


use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        $query = Incidencia::with('reportadoPorEmpleado');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('reportadoPorEmpleado', function ($subQuery) use ($search) {
                    $subQuery->where('nombre', 'like', "%{$search}%")
                        ->orWhere('apellido', 'like', "%{$search}%");
                })
                    ->orWhereHas('cliente', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhere('tipo', 'like', "%{$search}%")
                    ->orWhere('estado', 'like', "%{$search}%");
            });
        }

        if ($fecha_inicio) {
            $query->where('fecha', '>=', $fecha_inicio);
        }

        if ($fecha_fin) {
            $query->where('fecha', '<=', $fecha_fin);
        }

        $query->orderBy('fecha', 'asc');

        $incidencias = $query->paginate(10)->appends([
            'search' => $search,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        ]);

        return view('incidencias.index', compact('incidencias', 'search', 'fecha_inicio', 'fecha_fin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empleados = Empleado::all();
        $clientes = Cliente::all();

        return view('incidencias.formulario', compact('empleados', 'clientes'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([

                'fecha' => ['required', 'date', 'before_or_equal:today', // No puede ser futura
                    'after_or_equal:' .  now()->subMonth()->format('Y-m-d'), // No antes de hace un mes
                ],
            'tipo' => ['required'],
            'descripcion' => ['required', 'string', 'max:250'],
            'ubicacion' => ['required', 'string', 'max:150'],
            'agente_id' => 'required|array',
            'agente_id.*' => 'exists:empleados,id',
            'reportado_por' => ['required', 'exists:empleados,id'],
            'cliente_id' => ['required', 'exists:clientes,id'],
            'estado' => ['required', 'in:en proceso,resuelta,cerrada'],


        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
            'fecha.before_or_equal' => 'La fecha no puede ser posterior a hoy.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior a un mes.',
            'tipo.required' => 'Debe seleccionar el tipo.',
            'descripcion.required' => 'Debe ingresar la descripcion de la incidencia.',

            'ubicacion.required' => 'Debe ingresar la ubicación.',
            'reportado_por.required' => 'Debe seleccionar quien reporta la incidencia.',
            'cliente_id.required' => 'Debe seleccionar el cliente afectado.',
            'agente_id.required' =>'Debe seleccionar el agente involucrado.',






        ]);

        $incidencia= new Incidencia();
        $incidencia->fecha = $request->input('fecha');
        $incidencia->tipo = $request->input('tipo');
        $incidencia->descripcion = $request->input('descripcion');
        $incidencia->ubicacion= $request->input('ubicacion');
        $incidencia->reportado_por = $request->input('reportado_por');
        $incidencia->cliente_id = $request->input('cliente_id');
        $incidencia->estado = $request->input('estado');

        if ($incidencia->save()) {

            $incidencia->agentes()->attach($request->input('agente_id'));

            return redirect()->route('incidencias.index')->with('exito', 'La incidencia se guardó correctamente.');
        } else {
            return redirect()->route('incidencias.index')->with('fracaso', 'La incidencia no se guardó correctamente.');
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $incidencia = Incidencia::with(['agentes', 'reportadoPorEmpleado', 'cliente'])->findOrFail($id);
        return view('incidencias.detalle', compact('incidencia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $incidencia = Incidencia::with('cliente', 'agentes', 'reportadoPorEmpleado')->findOrFail($id);
        $empleados = Empleado::all();


        return view('incidencias.edit', compact('incidencia', 'empleados'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $incidencia = Incidencia::findOrFail($id);

        $request->validate([
            'fecha' => ['required', 'date', 'before_or_equal:today'],
            'tipo' => ['required'],
            'descripcion' => ['required', 'string', 'max:250'],
            'ubicacion' => ['required', 'string', 'max:150'],
            'agente_id' => 'required|array',
            'agente_id.*' => 'exists:empleados,id',
            'reportado_por' => ['required', 'exists:empleados,id'],
            'cliente_id' => ['required', 'exists:clientes,id'],
            'estado' => ['required', 'in:en proceso,resuelta,cerrada'],
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
            'fecha.before_or_equal' => 'La fecha no puede ser posterior a hoy.',
            'tipo.required' => 'Debe seleccionar el tipo de incidencia.',
            'descripcion.required' => 'Debe ingresar la descripción.',
            'ubicacion.required' => 'Debe ingresar la ubicación.',
            'reportado_por.required' => 'Debe seleccionar quién reporta la incidencia.',
            'cliente_id.required' => 'Debe seleccionar el cliente afectado.',
            'agente_id.required' => 'Debe seleccionar el agente involucrado.',
        ]);

        $incidencia->fecha = $request->input('fecha');
        $incidencia->tipo = $request->input('tipo');
        $incidencia->descripcion = $request->input('descripcion');
        $incidencia->ubicacion = $request->input('ubicacion');
        $incidencia->reportado_por = $request->input('reportado_por');
        $incidencia->cliente_id = $request->input('cliente_id');
        $incidencia->estado = $request->input('estado'); // ahora se puede editar

        if ($incidencia->save()) {
            // Esto actualiza la tabla pivote correctamente
            $incidencia->agentes()->sync($request->input('agente_id'));

            return redirect()->route('incidencias.index')->with('exito', 'La incidencia se editó correctamente.');
        } else {
            return redirect()->route('incidencias.index')->with('fracaso', 'La incidencia no se editó correctamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function reporte()
    {
        $incidencias = Incidencia::all();

        $pdf = PDF::loadView('incidencias.reportepdf', compact('incidencias'));
        return $pdf->download('reporte_incidencias.pdf');
    }
}
