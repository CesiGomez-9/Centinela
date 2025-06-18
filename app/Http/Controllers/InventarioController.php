<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventario::query();

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $query->where('nombre', 'LIKE', '%' . $searchTerm . '%');
        }

        $inventarios = $query->paginate(10);


        return view('inventarios.index', compact('inventarios'));
    }


    public function create()
    {
        return view('inventarios.formulario');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => [
                'required',
                'min:1',
                'max:12',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/',
                'not_regex:/^0+$/',
                Rule::unique('inventarios', 'codigo')
            ],
            'nombre' => [
                'required',
                'min:3',
                'max:30',
                'regex:/^[\pL0-9\s\-.,#]+$/u',
                'regex:/.*\S.*/'
            ],
            'cantidad' => [
                'required',
                'integer',
                'min:1',
                'max:999',
                'regex:/^\d{1,3}$/',
                'regex:/.*\S.*/',
                'not_regex:/^0+$/'
            ],
            'precio_unitario' => [
                'required',
                'numeric',
                'min:1',
                'max:9999',
                'regex:/^\d{1,9}(\.\d{1,2})?$/',
                'regex:/.*\S.*/',
                'not_regex:/^0+$/'
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
            'codigo.unique' => 'El código ingresado ya está registrado.'
        ]);

        // Si pasa validación, se guarda
        $inventario = new Inventario($validated);

        if ($inventario->save()) {
            return redirect()->route('inventarios.index')->with('status', 'Producto registrado correctamente');
        } else {
            return back()->withInput()->with('error', 'Error al guardar el producto');
        }
    }

    public function show(string $id)
    {
        $inventario = Inventario::findOrFail($id);
        return view('inventarios.show', compact('inventario'));
    }

/*
    public function edit(string $id)
    {
        $inventarios = inventarios::findOrFail($id);
        return view('inventarios.formulario', compact('inventarios'));
    }


    public function update(Request $request, string $id)
    {
        $inventarios = inventarios::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|max:100|min:3',
            'descripcion' => 'required|max:255|min:5',
            'cantidad' => 'required|integer|min:1',
            'ubicacion' => 'required|max:100|min:3',
        ]);

        $inventarios->nombre = $request->input('nombre');
        $inventarios->descripcion = $request->input('descripcion');
        $inventarios->cantidad = $request->input('cantidad');
        $inventarios->ubicacion = $request->input('ubicacion');

        if ($inventarios->save()) {
            return redirect()->route('inventarios.index')->with('status', 'Producto editado correctamente');
        } else {
            return back()->withInput()->with('error', 'Error al actualizar el producto');
        }
    }


    public function destroy(string $id)
    {
        $inventarios = inventarios::findOrFail($id);

        if ($inventarios->delete()) {
            return redirect()->route('inventarios.index')->with('status', 'Producto eliminado correctamente');
        } else {
            return redirect()->route('inventarios.index')->with('error', 'No se pudo eliminar el producto');
        }
    }
*/
}
