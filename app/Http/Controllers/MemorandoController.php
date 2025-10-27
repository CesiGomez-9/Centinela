<?php

namespace App\Http\Controllers;

use App\Models\Memorando;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemorandoController extends Controller
{
    public function index(Request $request)
    {
        $query = Memorando::with(['destinatario', 'autor']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('destinatario', function ($q2) use ($search) {
                    $q2->where('nombre', 'like', "%$search%")
                        ->orWhere('apellido', 'like', "%$search%");
                })
                    ->orWhereHas('autor', function ($q2) use ($search) {
                        $q2->where('nombre', 'like', "%$search%")
                            ->orWhere('apellido', 'like', "%$search%");
                    })
                    ->orWhere('tipo', 'like', "%$search%");
            });
        }

        if ($request->filled('tipo_memorandum')) {
            $query->where('tipo', $request->tipo_memorandum);
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        $memorandos = $query->orderBy('created_at', 'asc')->paginate(10)->withQueryString();

        return view('memorandos.index', compact('memorandos'));
    }

    public function create()
    {
        $autores = Empleado::where('categoria', 'Administracion')->get();
        $destinatarios = Empleado::all();

        return view('memorandos.create', compact('autores', 'destinatarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destinatario_id' => 'required|exists:empleados,id|different:autor_id',
            'autor_id'        => 'required|exists:empleados,id|different:destinatario_id',
            'titulo' => ['required','string','max:100','regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]+$/'],
            'contenido' => ['required','string','max:250','regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ .,;:()-]+$/'],
            'fecha' => 'required|date|before_or_equal:today|after_or_equal:' . now()->subMonth()->format('Y-m-d'),
            'tipo' => 'required|in:leve,media,grave',
            'sancion' => ['required','string','max:250','regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ .,;:()-]+$/'],
            'observaciones' => ['nullable','string','max:250','regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ .,;:()-]+$/'],
            'adjunto' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ], [
            'destinatario_id.required' => 'Debe seleccionar un empleado sancionado',
            'destinatario_id.different' => 'El empleado sancionado no puede ser el mismo que el creador del memorandum',
            'autor_id.required' => 'Debe seleccionar un creador del memorandum',
            'autor_id.different' => 'El creador del memorandum no puede ser el mismo que el empleado sancionado',
            'titulo.required' => 'Debe ingresar un asunto',
            'titulo.string' => 'El asunto debe ser texto válido',
            'titulo.max' => 'El asunto no puede exceder 100 letras',
            'titulo.regex' => 'El asunto solo puede contener letras, números y espacios',
            'contenido.required' => 'Debe ingresar un motivo',
            'contenido.string' => 'El motivo debe ser texto válido',
            'contenido.max' => 'El motivo no puede exceder 250 letras',
            'contenido.regex' => 'El motivo contiene caracteres no permitidos',
            'fecha.required' => 'Debe seleccionar una fecha',
            'fecha.date' => 'La fecha debe ser válida',
            'fecha.before_or_equal' => 'La fecha no puede ser futura',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior a un mes',
            'tipo.required' => 'Debe seleccionar un tipo de memorandum',
            'tipo.in' => 'El tipo seleccionado no es válido',
            'sancion.required' => 'Debes especificar la sanción',
            'sancion.string' => 'La sanción debe ser texto válido',
            'sancion.max' => 'La sanción no puede exceder 250 letras',
            'sancion.regex' => 'La sanción contiene caracteres no permitidos',
            'observaciones.string' => 'Las observaciones deben ser texto válido',
            'observaciones.max' => 'Las observaciones no pueden exceder 250 letras',
            'observaciones.regex' => 'Las observaciones contiene caracteres no permitidos',
            'adjunto.file' => 'El archivo adjunto debe ser un archivo válido',
            'adjunto.mimes' => 'El archivo adjunto debe ser pdf, doc, docx, jpg o png',
            'adjunto.max' => 'El archivo adjunto no puede superar 2MB',
        ]);

        $adjuntoPath = null;
        if ($request->hasFile('adjunto')) {
            $adjuntoPath = $request->file('adjunto')->store('adjuntos', 'public');
        }

        Memorando::create([
            'destinatario_id' => $request->destinatario_id,
            'autor_id' => $request->autor_id,
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'fecha' => $request->fecha,
            'tipo' => $request->tipo,
            'sancion' => $request->sancion,
            'observaciones' => $request->observaciones,
            'adjunto' => $adjuntoPath,
        ]);

        return redirect()->route('memorandos.index')->with('success', '¡Memorándum guardado correctamente!');
    }


    public function show(Memorando $memorando)
    {

        $memorando->load(['autor', 'destinatario']);
        $memNumeros = $memorando->destinatario->memorandosRecibidos
            ->sortBy('created_at')
            ->values();
        $numeroPorEmpleado = $memNumeros->search(function($m) use ($memorando) {
                return $m->id === $memorando->id;
            }) + 1;

        return view('memorandos.show', compact('memorando', 'numeroPorEmpleado'));
    }

    public function descargarAdjunto($filename)
    {
        $path = storage_path('app/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }

}
