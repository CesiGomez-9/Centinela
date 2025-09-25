<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Empleado;
use App\Models\Turno;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $asistencias = Asistencia::with('turno')
            ->when($search, function ($query, $search) {
                $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('identidad', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('asistencias.index', compact('asistencias'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('asistencias.crear'); // crea un archivo create.blade.php
    }



    /**
     * Guardar instalación
     */

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellido' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'identidad' => 'required|digits:13',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            $empleado = Empleado::where('nombre', $request->nombre)
                ->where('apellido', $request->apellido)
                ->where('identidad', $request->identidad)
                ->first();

            if (!$empleado) {
                return response()->json(['error' => "⚠️ El empleado no está registrado"], 404);
            }

            // Turno del día (puede ser null)
            $turno = Turno::where('empleado_id', $empleado->id)
                ->whereDate('fecha_inicio', Carbon::today())
                ->first();

            $turno_id = $turno ? $turno->id : null;

            // Buscar asistencia del día
            $asistencia = Asistencia::where('identidad', $request->identidad)
                ->whereDate('created_at', Carbon::today())
                ->first();

            if (!$asistencia) {
                // Registrar entrada
                $asistencia = Asistencia::create([
                    'nombre' => $request->nombre,
                    'apellido' => $request->apellido,
                    'identidad' => $request->identidad,
                    'turno_id' => $turno_id,
                    'hora_entrada' => Carbon::now(),
                    'hora_salida' => null,
                ]);


                return response()->json([
                    'mensaje' => "✅ {$request->nombre} {$request->apellido}, tu hora de llegada fue a " . $asistencia->hora_entrada->format('H:i:s')
                ]);
            } else {
                if (!$asistencia->hora_salida) {
                    $asistencia->hora_salida = Carbon::now();
                    $asistencia->save();

                    return response()->json([
                        'mensaje' => "👋 {$request->nombre} {$request->apellido}, tu hora de salida fue a " . $asistencia->hora_salida->format('H:i:s')
                    ]);
                } else {
                    return response()->json([
                        'mensaje' => "⚠️ Ya registraste entrada y salida hoy."
                    ]);
                }
            }
        }  catch (\Exception $e) {
            \Log::error('Error store asistencia', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => "❌ Ocurrió un error interno: " . $e->getMessage()
            ], 500);
        }

    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {

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

