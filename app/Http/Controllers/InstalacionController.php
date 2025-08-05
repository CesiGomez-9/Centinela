<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Instalacion;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InstalacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        $tecnicos = Empleado::all();
        $servicios = Servicio::all();

        return view('instalaciones.formulario', compact('clientes', 'tecnicos', 'servicios'));
    }


    /**
     * Endpoint para cargar eventos en el calendario.
     */
    public function obtenerEventos()
    {
        $instalaciones = Instalacion::with(['cliente', 'empleado', 'servicio'])->get();

        $eventos = $instalaciones->map(function ($i) {
            return [
                'title' => $i->cliente->nombre,
                'start' => $i->fecha_instalacion,
                'extendedProps' => [
                    'cliente' => $i->cliente->nombre,
                    'tecnico' => $i->empleado->nombre,
                    'servicio' => $i->servicio->nombre,
                    'estado' => ucfirst($i->estado),
                    'descripcion' => $i->descripcion,
                    'direccion' => $i->direccion,
                ]
            ];
        });

        return response()->json($eventos);
    }




    /**
     * Elimina instalaciones vencidas.
     * Vencidas = fecha_instalacion + 5 horas < ahora.
     */
    private function eliminarInstalacionesVencidas()
    {
        Instalacion::where('fecha_instalacion', '<', Carbon::now()->subHours(5))->delete();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $tecnicos = Empleado::all();
        $servicios = Servicio::all();

        return view('instalaciones.formulario', compact('clientes', 'tecnicos', 'servicios'));
    }

    // Guardar instalación
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tecnico_id' => 'required|exists:empleados,id',
            'servicio_id' => 'required|exists:servicios,id',
            'descripcion' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^\s+/', $value)) {
                        $fail('La descripción no puede comenzar con espacios.');
                    }
                },
            ],
            'direccion' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^\s+/', $value)) {
                        $fail('La dirección no puede comenzar con espacios.');
                    }
                },
            ],
            'fecha_instalacion' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $fecha = strtotime($value);
                    $inicio = strtotime('2025-07-01');
                    $fin = strtotime('2025-08-31');
                    if ($fecha < $inicio || $fecha > $fin) {
                        $fail('La fecha debe estar entre julio y agosto.');
                    }
                },
            ],
            'estado' => 'required|in:pendiente,terminado',
        ]);

        // Crear registro
        Instalacion::create($request->all());

        return redirect()->route('instalaciones.index')->with('success', 'Instalación registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
