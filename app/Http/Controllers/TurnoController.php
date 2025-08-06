<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Turno;
use App\Models\Empleado;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TurnoController extends Controller
{
    /**
     * Muestra una lista de todos los turnos con funcionalidad de búsqueda.
     */
    public function index(Request $request)
    {
        $query = Turno::with(['empleado', 'servicio']);

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                // Búsqueda por nombre/apellido del empleado
                $q->whereHas('empleado', function ($sq) use ($searchTerm) {
                    $sq->where('nombre', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('apellido', 'LIKE', '%' . $searchTerm . '%');
                })
                    // Búsqueda por nombre del servicio
                    ->orWhereHas('servicio', function ($sq) use ($searchTerm) {
                        $sq->where('nombre', 'LIKE', '%' . $searchTerm . '%');
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
        $validated = $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'servicio_id' => 'required|exists:servicios,id',
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'tipo_turno' => [
                'required',
                'string',
                'max:50',
                'regex:/^[\pL0-9\s\-]+$/u',
                'regex:/.*\S.*/',
            ],
            'observaciones' => [
                'required',
                'string',
                'max:500',
                'regex:/^[\pL0-9\s,.\-#()]*$/u',
            ],
        ], [
            'empleado_id.required' => 'Debe seleccionar un empleado para el turno.',
            'empleado_id.exists' => 'El empleado seleccionado no es válido.',
            'servicio_id.required' => 'Debe seleccionar un servicio para el turno.',
            'servicio_id.exists' => 'El servicio seleccionado no es válido.',
            'cliente_id.required' => 'Debe seleccionar un cliente.',
            'cliente_id.exists' => 'El cliente seleccionado no es válido.',
            'fecha_inicio.required' => 'La fecha de inicio del turno es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio del turno debe ser una fecha válida.',
            'fecha_fin.required' => 'La fecha de fin del turno es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin del turno debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'hora_fin.required' => 'La hora de fin es obligatoria.',
            'hora_fin.date_format' => 'La hora de fin debe tener el formato HH:MM.',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'tipo_turno.required' => 'El tipo de turno es obligatorio.',
            'tipo_turno.string' => 'El tipo de turno debe ser una cadena de texto.',
            'tipo_turno.max' => 'El tipo de turno no debe exceder los :max caracteres.',
            'tipo_turno.regex' => 'El tipo de turno contiene caracteres no permitidos o es solo espacios.',
            'observaciones.string' => 'Las observaciones deben ser una cadena de texto.',
            'observaciones.max' => 'Las observaciones no deben exceder los :max caracteres.',
            'observaciones.regex' => 'Las observaciones contienen caracteres no permitidos.',
            'observaciones.required' => 'Las observaciones son obligatorias.',

        ]);

        $turno = new Turno($validated);

        if ($turno->save()) {
            return redirect()->route('turnos.index')->with('success', 'Turno creado exitosamente.');
        } else {
            return back()->withInput()->with('error', 'Error al guardar el turno');
        }
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
