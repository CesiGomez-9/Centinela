<?php

namespace App\Http\Controllers;

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
        return view('servicios.index')->with('servicios', $servicios);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'costo' => ['required', 'digits_between:3,4', 'regex:/^[1-9][0-9]{0,3}$/'], // no puede empezar en 0
            'duracion_cantidad' => ['required', 'integer', 'min:1', 'max:99'],
            'duracion_tipo' => ['required', 'in:horas,dias,meses,años'],
            'productos_categoria' => ['required', 'in:vigilancia,tecnico'],
            'productos_vigilancia' => ['nullable', 'array'],
            'productos_tecnico' => ['nullable', 'array'],
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

        if ($request->productos_categoria === 'vigilancia') {
            $servicio->productos_vigilancia = $request->productos_vigilancia ?? [];
            $servicio->productos_tecnico = null;
        } else {
            $servicio->productos_tecnico = $request->productos_tecnico ?? [];
            $servicio->productos_vigilancia = null;
        }

        $servicio->save();

        return redirect()->route('servicios.catalogo')->with('success', 'Servicio registrado correctamente.');
    }





    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $servicio = Servicio::findOrFail($id);

        // Determinar productos según la categoría
        $productos = [];

        if ($servicio->categoria === 'técnico' && $servicio->productos_tecnico) {
            $productos = json_decode($servicio->productos_tecnico, true);
        } elseif ($servicio->categoria === 'vigilancia' && $servicio->productos_vigilancia) {
            $productos = json_decode($servicio->productos_vigilancia, true);
        }

        return view('servicios.show', compact('servicio', 'productos'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);

        // Listas de productos (puedes moverlos a config o BD si prefieres)
        $productosVigilancia = [
            'Cinturón táctico', 'Radio de comunicación (walkie-talkie)', 'Linterna',
            'Cuaderno o libreta de bitácora', 'Bolígrafo o lápiz', 'Silbato', 'Toner o bastón',
            'Esposas', 'Chaleco antibalas', 'Botas reforzadas'
        ];

        $productosTecnicos = [
            'Cámara IP Full HD', 'Cámara Bullet 4K', 'Cámara domo PTZ', 'Cámara térmica portátil', 'Cámara con visión nocturna',
            'Alarma inalámbrica', 'Alarma con sirena', 'Alarma de puerta y ventana', 'Sistema de alarma GSM', 'Alarma con detector de humo',
            'Cerradura biométrica', 'Cerradura con teclado', 'Cerradura Bluetooth', 'Cerradura con control remoto', 'Cerradura electrónica para puertas',
            'Sensor PIR inalámbrico', 'Sensor de movimiento con cámara', 'Sensor de movimiento para interiores', 'Sensor de movimiento con alarma', 'Sensor doble tecnología',
            'Luz LED con sensor', 'Luz solar con sensor', 'Foco exterior con sensor', 'Luz para jardín con sensor', 'Lámpara de seguridad con sensor',
            'Reja metálica reforzada', 'Puerta de seguridad con cerradura', 'Reja plegable de acero', 'Puerta blindada residencial', 'Reja corrediza automática',
            'Casco de seguridad', 'Guantes tácticos', 'Botas reforzadas', 'Escalera', 'Caja de herramientas'
        ];

        $productosSeleccionados = json_decode($servicio->productos, true) ?? [];

        $productosVigilanciaSeleccionados = array_intersect($productosSeleccionados, $productosVigilancia);
        $productosTecnicosSeleccionados = array_intersect($productosSeleccionados, $productosTecnicos);

        return view('servicios.edit', compact(
            'servicio',
            'productosVigilancia',
            'productosTecnicos',
            'productosVigilanciaSeleccionados',
            'productosTecnicosSeleccionados'
        ));

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreServicio' => 'required|string|max:50|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'descripcionServicio' => 'required|string|max:125|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'costo' => 'required|numeric|min:1|max:9999',
            'duracion_cantidad' => 'required|numeric|min:1|max:99',
            'duracion_tipo' => 'required|in:horas,días,meses,años',
            'categoria' => 'required|in:vigilancia,tecnico',
            'productos_categoria' => 'required|in:vigilancia,tecnico'
        ]);

        $servicio = Servicio::findOrFail($id);

        // Recoger productos seleccionados según la categoría
        $productosSeleccionados = $request->categoria === 'vigilancia'
            ? $request->input('productos_vigilancia', [])
            : $request->input('productos_tecnico', []);

        $servicio->nombre = $request->nombreServicio;
        $servicio->descripcion = $request->descripcionServicio;
        $servicio->costo = $request->costo;
        $servicio->duracion_estimada = $request->duracion_cantidad . ' ' . $request->duracion_tipo;
        $servicio->categoria = $request->categoria;
        $servicio->productos = json_encode($productosSeleccionados);
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
        $query = $request->input('search');

        if ($query) {
            $servicios = Servicio::where('nombre', 'like', "%$query%")->paginate(10);
        } else {
            $servicios = Servicio::paginate(10); // sin filtro
        }

        return view('servicios.catalogo', compact('servicios'));
    }




}
