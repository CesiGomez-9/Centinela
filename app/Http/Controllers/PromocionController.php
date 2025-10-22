<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocion;
use Illuminate\Support\Facades\Storage;

class PromocionController extends Controller
{

    public function index(Request $request)
    {
        $query = Promocion::query();
        $hoy = now();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fecha_inicio')) {
            $fecha = $request->fecha_inicio;
            $query->where('fecha_inicio', 'like', "%{$fecha}%");
        }

        if ($request->filled('fecha_fin')) {
            $fecha = $request->fecha_fin;
            $query->where('fecha_inicio', 'like', "%{$fecha}%");
        }

        if ($request->filled('activo')) {
            if ($request->activo == '1') {
                $query->whereDate('fecha_inicio', '<=', $hoy)
                    ->whereDate('fecha_fin', '>=', $hoy);
            } elseif ($request->activo == '0') {
                $query->where(function ($q) use ($hoy) {
                    $q->whereDate('fecha_fin', '<', $hoy)
                        ->orWhereDate('fecha_inicio', '>', $hoy);
                });
            }
        }

        $promociones = $query->orderBy('created_at', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('promociones.index', compact('promociones'));
    }


    public function create()
    {
        return view('promociones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:100|regex:/^[\p{L}\s]+$/u',
            'descripcion' => 'required|max:250|regex:/^[\p{L}\s]+$/u',
            'restriccion' => 'required|max:150|regex:/^[\p{L}\s]+$/u',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'nombre.required' => 'Debe ingresar el nombre de la promoción',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'descripcion.required' => 'Debe ingresar una descripción',
            'descripcion.regex' => 'La descripción solo puede contener letras y espacios',
            'restriccion.required' => 'Debe ingresar una restricción',
            'restriccion.regex' => 'La restricción solo puede contener letras y espacios',
            'fecha_inicio.required' => 'Debe seleccionar una fecha',
            'fecha_fin.required' => 'Debe seleccionar una fecha',
            'fecha_fin.after_or_equal' => 'La fecha fin debe ser igual o posterior a la fecha inicio',
            'imagen.image' => 'El archivo debe ser una imagen válida (jpg, jpeg o png)',
        ]);

        $nombreImagen = null;
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $nombreImagen = $request->file('imagen')->store('promociones', 'public');
        }

        Promocion::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'restriccion' => $validated['restriccion'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'imagen' => $nombreImagen,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '¡Promoción guardada correctamente!'
            ]);
        }

        return redirect()->route('promociones.index')->with('success', '¡Promoción guardada correctamente!');
    }


    public function show(Promocion $promocion)
    {
        return view('promociones.show', compact('promocion'));
    }

    public function edit(Promocion $promocion)
    {
        return view('promociones.edit', compact('promocion'));
    }

}
