<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $query->where('nombre', 'LIKE', '%' . $searchTerm . '%');
        }

        $productos = $query->paginate(10);


        return view('productos.index', compact('productos'));
    }


    public function create()
    {
        return view('productos.formulario');
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
                'nullable',
                'max:50',
                'regex:/^[\pL0-9\s\-.,#()]*$/u',
            ],
            'modelo' => [
                'required',
                'nullable',
                'max:50',
                'regex:/^[\pL0-9\s\-.,#()]*$/u',
            ],
            'categoria' => [
                'required',
                'nullable',
                'max:50',
                'regex:/^[\pL0-9\s\-.,#()]*$/u',
            ],
            'iva' => [
                'required',
                'nullable',
                'max:50',
                'regex:/^[\pL0-9\s\-.,#()]*$/u',
            ],
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
            'codigo.unique' => 'El código ingresado ya está registrado.'
        ]);

        // Si pasa validación, se guarda
        $producto = new Producto($validated);

        if ($producto->save()) {
            return redirect()->route('productos.index')->with('status', 'Producto registrado correctamente');
        } else {
            return back()->withInput()->with('error', 'Error al guardar el producto');
        }
    }

    public function show(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

/*
    public function edit(string $id)
    {
        $productos = productos::findOrFail($id);
        return view('productos.formulario', compact('productos'));
    }


    public function update(Request $request, string $id)
    {
        $productos = productos::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|max:100|min:3',
            'descripcion' => 'required|max:255|min:5',
            'cantidad' => 'required|integer|min:1',
            'ubicacion' => 'required|max:100|min:3',
        ]);

        $productos->nombre = $request->input('nombre');
        $productos->descripcion = $request->input('descripcion');
        $productos->cantidad = $request->input('cantidad');
        $productos->ubicacion = $request->input('ubicacion');

        if ($productos->save()) {
            return redirect()->route('productos.index')->with('status', 'Producto editado correctamente');
        } else {
            return back()->withInput()->with('error', 'Error al actualizar el producto');
        }
    }



*/
}
