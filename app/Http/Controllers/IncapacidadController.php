<?php

namespace App\Http\Controllers;

use App\Models\Incapacidad;
use App\Models\Empleado;
use Illuminate\Http\Request;

class IncapacidadController extends Controller
{
    public function index(Request $request)
    {
        $query = Incapacidad::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->whereHas('empleado', function($q2) use ($search) {
                    $q2->where('nombre', 'like', "%{$search}%")
                        ->orWhere('apellido', 'like', "%{$search}%");
                })
                    ->orWhere('institucion_medica', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_inicio', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_inicio', '<=', $request->fecha_fin);
        }

        if ($request->filled('estado')) {
            $hoy = now()->toDateString();
            if ($request->estado == 'vigente') {
                $query->whereDate('fecha_fin', '>=', $hoy);
            } elseif ($request->estado == 'finalizado') {
                $query->whereDate('fecha_fin', '<', $hoy);
            }
        }

        $incapacidades = $query->orderBy('created_at','asc')
            ->paginate(10)
            ->withQueryString();

        return view('incapacidades.index', compact('incapacidades'));
    }


    public function create()
    {
        $empleados = Empleado::orderBy('nombre')->get();
        return view('incapacidades.create', compact('empleados'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'motivo' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:250',
            'institucion_medica' => 'required|string|max:150',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'documento' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'empleado_id.required' => 'Debe seleccionar un empleado para la incapacidad.',
            'empleado_id.exists' => 'El empleado seleccionado no existe en el sistema.',

            'motivo.required' => 'Debe ingresar el motivo de la incapacidad.',
            'motivo.max' => 'El motivo no puede exceder los 150 caracteres.',

            'institucion_medica.required' => 'Debe ingresar la institución médica.',
            'institucion_medica.max' => 'La institución médica no puede exceder los 150 .',

            'descripcion.max' => 'La descripción no puede exceder los 250 caracteres.',

            'fecha_inicio.required' => 'Debe seleccionar una fecha.',
            'fecha_inicio.date' => 'La fecha no tiene un formato válido.',

            'fecha_fin.required' => 'Debe seleccionar una fecha.',
            'fecha_fin.date' => 'La fecha no tiene un formato válido.',
            'fecha_fin.after_or_equal' => 'La fecha debe ser igual o posterior a la fecha de inicio.',

            'documento.file' => 'El campo documento debe ser un archivo.',
            'documento.mimes' => 'El documento debe ser de tipo: PDF, JPG, JPEG o PNG.',
            'documento.max' => 'El tamaño del documento no debe ser superior a 2MB.',
        ]);


        if ($request->hasFile('documento')) {
            $validated['documento'] = $request->file('documento')->store('incapacidades', 'public');
        }

        Incapacidad::create($validated);

        return redirect()->route('incapacidades.index')->with('success', 'Incapacidad registrada correctamente.');
    }


    public function show($id)
    {
        $incapacidad = Incapacidad::with('empleado')->find($id);

        if (!$incapacidad) {
            return redirect()->route('incapacidades.index')->with('error', 'Incapacidad no encontrada');
        }

        return view('incapacidades.show', compact('incapacidad'));
    }

}
