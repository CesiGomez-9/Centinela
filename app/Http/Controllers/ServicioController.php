<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::all();

        $productosVigilancia = Producto::where('categoria', 'Implementos de seguridad')->get();

        $productosTecnico = Producto::whereIn('categoria', [
            'Cámaras de seguridad',
            'Alarmas antirrobo',
            'Cerraduras inteligentes',
            'Sensores de movimiento',
            'Luces con sensor de movimiento',
            'Rejas o puertas de seguridad',
            'Sistema de monitoreo 24/7'
        ])->get();

        return view('servicios.index', compact('servicios', 'productosVigilancia', 'productosTecnico'));
    }

    public function create()
    {
        return redirect()->route('servicios.index');
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombreServicio' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'descripcionServicio' => ['required', 'string', 'max:125', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'categoria' => ['required', 'in:vigilancia,tecnico'],
            'costo' => ['required', 'digits_between:3,4', 'regex:/^[1-9][0-9]{0,3}$/'],
            'duracion_cantidad' => ['required', 'integer', 'min:1', 'max:99'],
            'duracion_tipo' => ['required', 'in:horas,dias,meses,años'],
            'productos_categoria' => ['required', 'in:vigilancia,tecnico'],
            'productos' => ['nullable', 'array'],
        ], [
            'nombreServicio.regex' => 'El nombre solo puede contener letras y espacios.',
            'descripcionServicio.regex' => 'La descripción solo puede contener letras y espacios.',
            'costo.regex' => 'El costo debe tener hasta 3 cifras y no comenzar con cero.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $servicio = new Servicio();
        $servicio->nombre = $request->nombreServicio;
        $servicio->descripcion = $request->descripcionServicio;
        $servicio->categoria = $request->categoria;
        $servicio->costo = $request->costo;
        $servicio->duracion_cantidad = $request->duracion_cantidad;
        $servicio->duracion_tipo = $request->duracion_tipo;
        $servicio->productos = json_encode($request->productos ?? []);

        $servicio->save();

        return redirect()->route('servicios.catalogo')->with('success', 'Servicio registrado correctamente.');
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $servicio = Servicio::findOrFail($id);

        // Decodificar correctamente el JSON a array
        $productosIds = json_decode($servicio->productos ?? '[]', true);

        // Cargar los productos desde la base de datos
        $productos = Producto::whereIn('id', $productosIds)->get();

        return view('servicios.show', compact('servicio', 'productos'));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);

        // Convertir a array si ya está en JSON
        $productosSeleccionados = json_decode($servicio->productos, true) ?? [];

        // Obtener productos vigilancia + los seleccionados
        $productosVigilancia = Producto::where(function ($query) use ($productosSeleccionados) {
            $query->where('categoria', 'vigilancia')
                ->orWhereIn('id', $productosSeleccionados);
        })->get()->unique('id');

        // Obtener productos técnicos + los seleccionados
        $productosTecnicos = Producto::where(function ($query) use ($productosSeleccionados) {
            $query->where('categoria', 'tecnico')
                ->orWhereIn('id', $productosSeleccionados);
        })->get()->unique('id');

        return view('servicios.edit', [
            'servicio' => $servicio,
            'productosVigilancia' => $productosVigilancia,
            'productosTecnicos' => $productosTecnicos,
            'productosSeleccionados' => $productosSeleccionados,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreServicio' => 'required|string|max:50|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'descripcionServicio' => 'required|string|max:125|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'costo' => 'required|numeric|min:1|max:9999',
            'duracion_cantidad' => 'required|numeric|min:1|max:99',
            'duracion_tipo' => 'required|in:horas,dias,meses,años',
            'categoria' => 'required|in:vigilancia,tecnico',
            'productos' => 'required|array',
            'productos.*' => 'integer|exists:productos,id'
        ]);

        $servicio = Servicio::findOrFail($id);

        $servicio->nombre = $request->nombreServicio;
        $servicio->descripcion = $request->descripcionServicio;
        $servicio->costo = $request->costo;
        $servicio->duracion_cantidad . ' ';
        $servicio->duracion_tipo . ' ';
        $servicio->categoria = $request->categoria;
        $servicio->productos = json_encode($request->productos); // Guardar como JSON

        $servicio->save();

        return redirect()->route('servicios.catalogo')->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Servicio::destroy($id);
        return redirect()->back()->with('success', 'Servicio eliminado.');


    }
    public function catalogo(Request $request)
    {
        $query = Servicio::query();

        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        $servicios = $query->paginate(10)->appends(['search' => $request->search]);

        return view('servicios.catalogo', compact('servicios'));
    }






}
