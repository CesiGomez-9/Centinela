<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Producto::query();

        // Si hay un término de búsqueda, aplicarlo a la consulta
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('serie', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('codigo', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('nombre', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('categoria', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $productos = $query->paginate(10);

        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.formulario');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'serie' => [
                'required',
                'min:1',
                'max:12',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/', // Asegura que no sea solo espacios
                'not_regex:/^0+$/', // No puede ser solo ceros
                'not_regex:/^[^A-Za-z0-9]/', // No puede empezar con caracteres especiales
                Rule::unique('productos', 'serie') // Debe ser único en la tabla productos
            ],
            'codigo' => [
                'required',
                'min:1',
                'max:12',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/',
                'not_regex:/^0+$/',
                'not_regex:/^[^A-Za-z0-9]/',
                Rule::unique('productos', 'codigo')
            ],
            'nombre' => [
                'required',
                'min:3',
                'max:30',
                'regex:/^[\pL0-9\s\-.,#]+$/u', // Permite letras Unicode, números, espacios, guiones, puntos, comas, almohadillas
                'regex:/.*\S.*/' // Asegura que no sea solo espacios
            ],
            'marca' => [
                'required', // Ahora es requerido
                'string',
                'max:50',
                'regex:/^[\pL0-9\s\-.,#()]*$/u',
            ],
            'modelo' => [
                'required', // Ahora es requerido
                'string',
                'max:50',
                'regex:/^[\pL0-9\s\-.,#()]*$/u',
            ],
            'categoria' => [
                'required',
                'string',
                'max:50',

            ],
            // 'cantidad' no se valida aquí porque se inicializa en 0 al crear
            'es_exento' => 'required|boolean', // 0 para no exento (15%), 1 para exento (0%)
            'descripcion' => [
                'required',
                'min:1',
                'max:255',
                'regex:/^[\pL][\pL0-9\s,.\-#()]*$/u', // Debe empezar con letra, permite letras Unicode, números, espacios, etc.
                'regex:/.*\S.*/', // Asegura que no sea solo espacios
                'not_regex:/^0+$/' // No puede ser solo ceros
            ],
        ], [
            // Mensajes de error personalizados
            'serie.unique' => 'La serie ingresada ya está registrada.',
            'codigo.unique' => 'El código ingresado ya está registrado.',
            'marca.required' => 'La marca del producto es obligatoria.',
            'modelo.required' => 'El modelo del producto es obligatoria.',
            'es_exento.required' => 'Debe especificar si el producto es exento de IVA.',
            'es_exento.boolean' => 'El valor de exento de IVA no es válido.',
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'nombre.max' => 'El nombre no debe exceder los :max caracteres.',
            'nombre.regex' => 'El nombre contiene caracteres no permitidos o es solo espacios.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos :min caracteres.',
            'descripcion.max' => 'La descripción no debe exceder los :max caracteres.',
            'descripcion.regex' => 'La descripción contiene caracteres no permitidos o es solo ceros/espacios.'
        ]);

        // Crear el producto con los datos validados
        $producto = new Producto($validated);
        // Asegurar que la cantidad se inicialice en 0 al crear un nuevo producto
        $producto->cantidad = 0;


        if ($producto->save()) {
            return redirect()->route('productos.index')->with('status', 'Producto registrado correctamente');
        } else {
            return back()->withInput()->with('error', 'Error al guardar el producto');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.formulario', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        // Validar los datos de entrada para la actualización
        $validated = $request->validate([
            'serie' => [
                'required',
                'min:1',
                'max:12',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/',
                'not_regex:/^0+$/',
                'not_regex:/^[^A-Za-z0-9]/',
                Rule::unique('productos', 'serie')->ignore($producto->id) // Ignora el propio ID al validar unicidad
            ],
            'codigo' => [
                'required',
                'min:1',
                'max:12',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/',
                'not_regex:/^0+$/',
                'not_regex:/^[^A-Za-z0-9]/',
                Rule::unique('productos', 'codigo')->ignore($producto->id)
            ],
            'nombre' => [
                'required',
                'min:3',
                'max:30',
                'regex:/^[\pL0-9\s\-.,#]+$/u',
                'regex:/.*\S.*/'
            ],
            'marca' => [
                'required',
                'string',
                'max:50',
                'regex:/^[\pL0-9\s\-.,#()]*$/u',
            ],
            'modelo' => [
                'required',
                'string',
                'max:50',
                'regex:/^[\pL0-9\s\-.,#()]*$/u',
            ],
            'categoria' => [
                'required',
                'string',
                'max:50',

            ],
            // 'cantidad' no se actualiza desde este formulario, solo desde FacturaController
            'es_exento' => 'required|boolean',
            'descripcion' => [
                'required',
                'min:1',
                'max:255',
                'regex:/^[\pL][\pL0-9\s,.\-#()]*$/u',
                'regex:/.*\S.*/',
                'not_regex:/^0+$/'
            ],
        ], [
            // Mensajes de error personalizados para la actualización
            'serie.unique' => 'La serie ingresada ya está registrada.',
            'codigo.unique' => 'El código ingresado ya está registrado.',
            'marca.required' => 'La marca del producto es obligatoria.',
            'modelo.required' => 'El modelo del producto es obligatoria.',
            'es_exento.required' => 'Debe especificar si el producto es exento de IVA.',
            'es_exento.boolean' => 'El valor de exento de IVA no es válido.',
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'nombre.max' => 'El nombre no debe exceder los :max caracteres.',
            'nombre.regex' => 'El nombre contiene caracteres no permitidos o es solo espacios.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos :min caracteres.',
            'descripcion.max' => 'La descripción no debe exceder los :max caracteres.',
            'descripcion.regex' => 'La descripción contiene caracteres no permitidos o es solo ceros/espacios.'
        ]);

        // Actualizar el producto con los datos validados
        // No se incluye 'cantidad' en el update para que no sea modificada por este formulario
        if ($producto->update($validated)) {
            return redirect()->route('productos.index')->with('status', 'Producto actualizado correctamente');
        } else {
            return back()->withInput()->with('error', 'Error al actualizar el producto');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return redirect()->route('productos.index')->with('status', 'Producto eliminado correctamente');
    }
}


