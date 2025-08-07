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
    /**
     * Muestra una lista de todos los turnos con funcionalidad de búsqueda.
     */
    public function index(Request $request)
    {
        $query = Turno::with(['servicio', 'cliente']);

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                // Búsqueda por nombre/apellido del empleado (usando el JSON)
                $q->where('empleados_asignados', 'like', '%' . $searchTerm . '%');
                // Búsqueda por nombre del servicio
                $q->orWhereHas('servicio', function ($sq) use ($searchTerm) {
                    $sq->where('nombre', 'LIKE', '%' . $searchTerm . '%');
                })
                    // Búsqueda por nombre/apellido del cliente
                    ->orWhereHas('cliente', function ($sq) use ($searchTerm) {
                        $sq->where('nombre', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('apellido', 'LIKE', '%' . $searchTerm . '%');
                    })
                    // Búsqueda por fecha de inicio (si el formato de búsqueda es compatible)
                    ->orWhere('fecha_inicio', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $turnos = $query->latest()->paginate(10); // Ordena por los más recientes

        return view('turnos.index', compact('turnos'));
    }

    /**
     * Muestra el formulario para crear un nuevo turno.
     */
    public function create()
    {
        $empleados = Empleado::all();
        $servicios = Servicio::all();
        $clientes = Cliente::all();
        return view('turnos.formulario', compact('empleados', 'servicios', 'clientes'));
    }

    /**
     * Almacena un nuevo turno en la base de datos con validaciones robustas.
     */
    public function store(Request $request)
    {
        // 1. Validar los campos del formulario principal
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'observaciones' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL0-9\s,.\-#()]*$/u',
            ],
            'turnos_data' => 'required|json',
        ], [
            'turnos_data.required' => 'Debe agregar al menos un empleado a la tabla.',
            // ... (otros mensajes de validación)
        ]);

        // 2. Decodificar los datos del formulario de la tabla
        $turnosData = json_decode($validated['turnos_data'], true);

        if (empty($turnosData)) {
            throw ValidationException::withMessages([
                'turnos_data' => 'Debe agregar al menos un empleado a la tabla.'
            ]);
        }

        // 3. Validar cada item del array de turnos
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

        // 4. Crear un único registro de turno con el array de empleados completo
        $turno = Turno::create([
            'cliente_id' => $validated['cliente_id'],
            'servicio_id' => $validated['servicio_id'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'observaciones' => $validated['observaciones'],
            'empleados_asignados' => $turnosData, // Guardamos el array completo de detalles
        ]);

        return redirect()->route('turnos.index')->with('success', 'Turno asignado exitosamente.');
    }

    /**
     * Muestra los detalles de un turno específico.
     */
    public function show($id)
    {
        // Se carga el turno y sus relaciones
        $turno = Turno::with(['cliente', 'servicio'])->findOrFail($id);

        // Se obtienen los IDs de los empleados asignados desde la columna JSON
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

    /**
     * Devuelve los empleados que coinciden con la categoría de un servicio.
     */
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
