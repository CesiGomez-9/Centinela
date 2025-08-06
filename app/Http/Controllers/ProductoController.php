<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Impuesto;
use App\Models\PrecioCompra;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with('impuesto');

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

    public function create()
    {
        $impuestos = Impuesto::all();
        return view('productos.formulario', compact('impuestos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'serie' => [
                'required',
                'min:1',
                'max:12',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/',
                'not_regex:/^0+$/',
                'not_regex:/^[^A-Za-z0-9]/',
                Rule::unique('productos', 'serie')
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
            'impuesto_id' => 'required|exists:impuestos,id',
            'descripcion' => [
                'required',
                'min:1',
                'max:255',
                'regex:/^[\pL][\pL0-9\s,.\-#()]*$/u',
                'regex:/.*\S.*/',
                'not_regex:/^0+$/'
            ],
        ], [
            'serie.unique' => 'La serie ingresada ya está registrada.',
            'codigo.unique' => 'El código ingresado ya está registrada.',
            'marca.required' => 'La marca del producto es obligatoria.',
            'modelo.required' => 'El modelo del producto es obligatoria.',
            'impuesto_id.required' => 'Debe seleccionar un tipo de impuesto para el producto.',
            'impuesto_id.exists' => 'El tipo de impuesto seleccionado no es válido.',
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'nombre.max' => 'El nombre no debe exceder los :max caracteres.',
            'nombre.regex' => 'El nombre contiene caracteres no permitidos o es solo espacios.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos :min caracteres.',
            'descripcion.max' => 'La descripción no debe exceder los :max caracteres.',
            'descripcion.regex' => 'La descripción contiene caracteres no permitidos o es solo ceros/espacios.'
        ]);

        $producto = new Producto($validated);
        $producto->cantidad = 0;
        $producto->precio_compra = 0.00;
        $producto->precio_venta = 0.00;

        if ($producto->save()) {
            return redirect()->route('productos.index')->with('status', 'Producto registrado correctamente');
        } else {
            return back()->withInput()->with('error', 'Error al guardar el producto');
        }
    }

    public function show(string $id)
    {
        $producto = Producto::with('impuesto')->findOrFail($id);

        // Obtener todo el historial de precios de compra, ordenado de más antiguo a más reciente
        $allPrecioCompras = $producto->precioCompras()->orderBy('created_at', 'asc')->get();

        // Procesar la colección para añadir el 'previous_price' a cada elemento
        $processedPrecioCompras = $allPrecioCompras->map(function ($precioHistorial, $key) use ($allPrecioCompras) {
            $previousPrice = null;
            if ($key > 0) {
                // Si no es el primer elemento, el precio anterior es el del índice anterior
                $previousPrice = $allPrecioCompras->get($key - 1)->precio_compra;
            }
            // Añadir el previous_price como un atributo temporal al objeto
            $precioHistorial->previous_price = $previousPrice;
            return $precioHistorial;
        });

        // Paginación manual de la colección procesada
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $processedPrecioCompras->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $precioComprasPaginadas = new LengthAwarePaginator(
            $currentPageItems,
            $processedPrecioCompras->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('productos.show', compact('producto', 'precioComprasPaginadas'));
    }


    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        $impuestos = Impuesto::all();
        return view('productos.formulario', compact('producto', 'impuestos'));
    }

    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        $validated = $request->validate([
            'serie' => [
                'required',
                'min:1',
                'max:12',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/',
                'not_regex:/^0+$/',
                'not_regex:/^[^A-Za-z0-9]/',
                Rule::unique('productos', 'serie')->ignore($producto->id)
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
            'impuesto_id' => 'required|exists:impuestos,id',
            'descripcion' => [
                'required',
                'min:1',
                'max:255',
                'regex:/^[\pL][\pL0-9\s,.\-#()]*$/u',
                'regex:/.*\S.*/',
                'not_regex:/^0+$/'
            ],
        ], [
            'serie.unique' => 'La serie ingresada ya está registrada.',
            'codigo.unique' => 'El código ingresado ya está registrada.',
            'marca.required' => 'La marca del producto es obligatoria.',
            'modelo.required' => 'El modelo del producto es obligatoria.',
            'impuesto_id.required' => 'Debe seleccionar un tipo de impuesto para el producto.',
            'impuesto_id.exists' => 'El tipo de impuesto seleccionado no es válido.',
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'nombre.max' => 'El nombre no debe exceder los :max caracteres.',
            'nombre.regex' => 'El nombre contiene caracteres no permitidos o es solo espacios.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos :min caracteres.',
            'descripcion.max' => 'La descripción no debe exceder los :max caracteres.',
            'descripcion.regex' => 'La descripción contiene caracteres no permitidos o es solo ceros/espacios.'
        ]);

        if ($producto->precio_compra != $request->precio_compra) {
            $producto->precioCompras()->create([
                'precio_compra' => $request->precio_compra,
            ]);
        }

        $producto->update($validated);

        return redirect()->route('productos.index')->with('status', 'Producto actualizado correctamente');
    }
}
