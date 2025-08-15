<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Turno;
use App\Models\Empleado;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TurnoController extends Controller
{
    public function index(Request $request)
    {
        $query = Turno::with(['servicio', 'cliente']);

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {

                $q->orWhereHas('servicio', function ($sq) use ($searchTerm) {
                    $sq->where('nombre', 'LIKE', '%' . $searchTerm . '%');
                })
                    ->orWhereHas('cliente', function ($sq) use ($searchTerm) {
                        $sq->where('nombre', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('apellido', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_inicio', [$request->input('fecha_inicio'), $request->input('fecha_fin')]);
        } elseif ($request->filled('fecha_inicio')) {
            $query->where('fecha_inicio', '>=', $request->input('fecha_inicio'));
        }elseif ($request->filled('fecha_fin')) {
            $query->where('fecha_inicio', '<=', $request->input('fecha_fin'));
        }

        $turnos = $query->oldest()->paginate(10);
        return view('turnos.index', compact('turnos'));
    }
    public function create()
    {
        $empleados = Empleado::all();
        $servicios = Servicio::all();
        $clientes = Cliente::all();
        return view('turnos.formulario', compact('empleados', 'servicios', 'clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'observaciones' => [
                'required',
                'string',
                'max:300',
                'regex:/^[\pL0-9\s,.\-#()]*$/u',
            ],
            'turnos_data' => 'required|json',
        ], [
            'turnos_data.required' => 'Debe agregar al menos un empleado a la tabla.',
        ]);

        $turnosData = json_decode($validated['turnos_data'], true);

        if (empty($turnosData)) {
            throw ValidationException::withMessages([
                'turnos_data' => 'Debe agregar al menos un empleado a la tabla.'
            ]);
        }

        foreach ($turnosData as $turnoData) {
            $requestData = new Request($turnoData);
            $requestData->validate([
                'empleado_id' => 'required|exists:empleados,id',
                'tipo_turno' => 'required|string',
                'hora_inicio' => 'required|string',
                'hora_fin' => 'required|string',
                'costo' => 'required|numeric|min:0',
            ]);
        }

        $turno = Turno::create([
            'cliente_id' => $validated['cliente_id'],
            'servicio_id' => $validated['servicio_id'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'observaciones' => $validated['observaciones'],
            'empleados_asignados' => $turnosData,
        ]);

        return redirect()->route('turnos.index')->with('success', 'Turno asignado exitosamente.');
    }

    public function show($id)
    {
        $turno = Turno::with(['cliente', 'servicio'])->findOrFail($id);

        $empleadoIds = collect($turno->empleados_asignados)->pluck('empleado_id')->toArray();
        $empleados = Empleado::whereIn('id', $empleadoIds)->get()->keyBy('id');

        // Se combinan los datos de empleados con los datos del turno
        $detallesEmpleados = collect($turno->empleados_asignados)->map(function ($detalle) use ($empleados) {
            $empleado = $empleados->get($detalle['empleado_id']);
            $detalle['empleado'] = $empleado;
            return $detalle;
        });

        return view('turnos.show', compact('turno', 'detallesEmpleados'));
    }

    public function getEmpleadosPorServicio($servicio_id)
    {
        $servicio = Servicio::find($servicio_id);
        if ($servicio) {
            $empleados = Empleado::where('categoria', $servicio->categoria)->get();
            return response()->json($empleados);
        }

        return response()->json([]);
    }
}
