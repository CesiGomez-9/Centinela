<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Capacitacion;
use Illuminate\Http\Request;

class CapacitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //



        $search = $request->input('search');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        $query = Capacitacion::query();


        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('modalidad', 'like', "%{$search}%")
                    ->orWhere('nivel', 'like', "%{$search}%");
            });
        }


        if ($fecha_inicio && $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
        } elseif ($fecha_inicio) {
            $query->where('fecha_inicio', '>=', $fecha_inicio);
        } elseif ($fecha_fin) {
            $query->where('fecha_inicio', '<=', $fecha_fin);
        }


        $query->orderBy('created_at', 'asc');

        // Paginación
        $capacitaciones = $query->paginate(10)->appends([
            'search' => $search,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
        ]);

        // Retornar vista de capacitaciones
        return view('capacitaciones.index', compact('capacitaciones', 'search', 'fecha_inicio', 'fecha_fin'));
    }









    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('capacitaciones.formulario');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([

            'nombre' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s]+$/u'],
            'correo' => ['required', 'string', 'email', 'max:50', 'unique:capacitaciones,correo', 'regex:/^[^@\s]+@[^@\s]+\.[^@\s]+$/'],
            'contacto' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s]+$/u'],
            'telefono' => ['required', 'regex:/^[2389][0-9]{7}$/', 'size:8', 'unique:capacitaciones,telefono'],
            'modalidad' => ['required', 'string'],
            'nivel' => ['required', 'string'],
            'duracion'=>['required','numeric','min:1','max:15'],
            'fecha_inicio' => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d')],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fechaInicio'],
            'descripcion' => ['required', 'string','max:250'],
            'direccion' => ['required', 'string','max:250'],



        ], [
            'nombre.required' => 'Debe ingresar el nombre la institución.',
            'nombre.regex' => 'El nombre de la empresa solo debe contener letras, espacios y tildes.',
            'direccion.required' => 'Debe ingresar la dirección.',

            'telefono.required' => 'Debe ingresar el teléfono de la institución.',
            'telefono.regex' => 'El teléfono debe comenzar con 2, 3, 8 o 9 y tener 8 dígitos.',
            'telefono.size' => 'El teléfono debe tener exactamente 8 dígitos.',
            'telefono.unique' => 'Este número de teléfono ya está registrado.',

            'correo.required' => 'Debe ingresar el correo electrónico.',
            'correo.email' => 'Debe ingresar un correo electrónico válido.',
            'correo.unique' => 'Este correo ya está registrado.',

            'contacto.required' => 'Debe ingresar el nombre del representante.',
            'contacto.regex' => 'El nombre del representante solo debe contener letras y espacios y tildes.',

            'modalidad.required' => 'Debe seleccionar la modalidad.',
            'nivel.required' => 'Debe seleccionar el nivel.',
            'duracion.required' => 'Debe ingresar la duración.',
            'descripcion.required' => 'Debe ingresar la descripción.',
            'fecha_inicio.after_or_equal' => 'La fecha de inicio no puede ser anterior a la fecha actual.',
            'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.',
            'fecha_inicio.required' => 'Debe ingresar la fecha de inicio.',
            'fecha_fin.required' => 'Debe ingresar la fecha de finalización.',
            'duracion.min'=>'La duración no puede ser menor a 1',
            'duracion.max'=>'La duración no puede ser mayor a 15',


        ], [

        ]);


        $capacitacion = new Capacitacion();
        $capacitacion->nombre = $request->input('nombre');
        $capacitacion->correo = $request->input('correo');
        $capacitacion->contacto = $request->input('contacto');
        $capacitacion->telefono = $request->input('telefono');
        $capacitacion->modalidad = $request->input('modalidad');
        $capacitacion->nivel = $request->input('nivel');
        $capacitacion->duracion = $request->input('duracion');
        $capacitacion->fecha_inicio = $request->input('fecha_inicio');
        $capacitacion->fecha_fin = $request->input('fecha_fin');
        $capacitacion->descripcion = $request->input('descripcion');
        $capacitacion->direccion = $request->input('direccion');

        if ($capacitacion->save()) {
            return redirect()->route('capacitaciones.index')->with('exito', 'El curso se registro exitosamente.');
        } else {
            return redirect()->route('capacitaciones.index')->with('fracaso', 'El curso no se pudo registrar.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $capacitacion = Capacitacion::findOrFail($id);
        return view('capacitaciones.detalle', compact('capacitacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Mostrar el formulario de edición
    public function edit($id)
    {
        $capacitacion = Capacitacion::findOrFail($id); // Trae la capacitación o falla
        return view('capacitaciones.edit', compact('capacitacion'));
    }

// Actualizar los datos de la capacitación
    public function update(Request $request, $id)
    {
        $capacitacion = Capacitacion::findOrFail($id);

        $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s]+$/u'],
            'correo' => ['required', 'string', 'email', 'max:50', 'regex:/^[^@\s]+@[^@\s]+\.[^@\s]+$/', 'unique:capacitaciones,correo,' . $capacitacion->id],
            'contacto' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s]+$/u'],
            'telefono' => ['required', 'regex:/^[2389][0-9]{7}$/', 'size:8', 'unique:capacitaciones,telefono,' . $capacitacion->id],
            'modalidad' => ['required', 'string'],
            'nivel' => ['required', 'string'],
            'duracion'=>['required','numeric','min:1','max:15'],
            'fecha_inicio' => ['required', 'date',  'after_or_equal:' . now()->subMonth()->format('Y-m-d')],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
            'descripcion' => ['required', 'string','max:250'],
            'direccion' => ['required', 'string','max:250'],
        ], [
            'nombre.required' => 'Debe ingresar el nombre la institución.',
            'nombre.regex' => 'El nombre de la empresa solo debe contener letras, espacios y tildes.',
            'direccion.required' => 'Debe ingresar la dirección.',

            'telefono.required' => 'Debe ingresar el teléfono de la institución.',
            'telefono.regex' => 'El teléfono debe comenzar con 2, 3, 8 o 9 y tener 8 dígitos.',
            'telefono.size' => 'El teléfono debe tener exactamente 8 dígitos.',
            'telefono.unique' => 'Este número de teléfono ya está registrado.',

            'correo.required' => 'Debe ingresar el correo electrónico.',
            'correo.email' => 'Debe ingresar un correo electrónico válido.',
            'correo.unique' => 'Este correo ya está registrado.',

            'contacto.required' => 'Debe ingresar el nombre del representante.',
            'contacto.regex' => 'El nombre del representante solo debe contener letras y espacios y tildes.',

            'modalidad.required' => 'Debe seleccionar la modalidad.',
            'nivel.required' => 'Debe seleccionar el nivel.',
            'duracion.required' => 'Debe ingresar la duración.',
            'descripcion.required' => 'Debe ingresar la descripción.',
            'fecha_inicio.after_or_equal' => 'La fecha de inicio debe ser como mínimo hace un mes o más reciente.',
            'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.',
            'fecha_inicio.required' => 'Debe ingresar la fecha de inicio.',
            'fecha_fin.required' => 'Debe ingresar la fecha de finalización.',
            'duracion.min'=>'La duración no puede ser menor a 1',
            'duracion.max'=>'La duración no puede ser mayor a 15',

        ]);

        // Asignar valores actualizados
        $capacitacion->nombre = $request->input('nombre');
        $capacitacion->correo = $request->input('correo');
        $capacitacion->contacto = $request->input('contacto');
        $capacitacion->telefono = $request->input('telefono');
        $capacitacion->modalidad = $request->input('modalidad');
        $capacitacion->nivel = $request->input('nivel');
        $capacitacion->duracion = $request->input('duracion');
        $capacitacion->fecha_inicio = $request->input('fecha_inicio');
        $capacitacion->fecha_fin = $request->input('fecha_fin');
        $capacitacion->descripcion = $request->input('descripcion');
        $capacitacion->direccion = $request->input('direccion');

        if ($capacitacion->save()) {
            return redirect()->route('capacitaciones.index')->with('exito', 'Los cambios se guardaron correctamente.');
        } else {
            return redirect()->route('capacitaciones.index')->with('fracaso', 'No se pudieron guardar los cambios.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
