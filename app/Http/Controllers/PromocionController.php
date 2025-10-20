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

        if ($search = $request->input('search')) {
            $query->where('nombre', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%");
        }

        if ($request->fecha_inicio) {
            $query->whereDate('fecha_inicio', '>=', $request->fecha_inicio);
        }

        if ($request->fecha_fin) {
            $query->whereDate('fecha_fin', '<=', $request->fecha_fin);
        }

        $promociones = $query->orderBy('fecha_inicio', 'asc')->paginate(10);

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
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'nombre.required' => 'Debe ingresar el nombre de la promoción',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'descripcion.required' => 'Debe ingresar una descripción',
            'descripcion.regex' => 'La descripción solo puede contener letras y espacios',
            'fecha_inicio.required' => 'Debe seleccionar una fecha',
            'fecha_fin.required' => 'Debe seleccionar una fecha',
            'fecha_fin.after_or_equal' => 'La fecha fin debe ser igual o posterior a la fecha inicio',
            'imagen.image' => 'El archivo debe ser una imagen válida (jpg, jpeg o png)',
        ]);

        $nombreImagen = null;
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');

            if ($file->isValid()) {
                $nombreImagen = $file->store('promociones', 'public');
            } else {
                return back()->withErrors(['imagen' => 'El archivo no se pudo subir.'])->withInput();
            }
        }

        Promocion::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'imagen' => $nombreImagen,
        ]);

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
