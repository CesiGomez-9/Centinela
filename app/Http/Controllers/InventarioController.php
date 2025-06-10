<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::paginate(10);
        return view('inventarios.index', compact('inventarios'));
    }


    public function create()
    {
        return view('inventarios.formulario');
    }


    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'codigo' => 'required|unique:inventarios|max:10',
            'nombre' => 'required|max:25|min:3',
            'descripcion' => 'required|max:255|min:5',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        // Crear un nuevo objeto inventarios
        $inventario = new Inventario();
        $inventario->codigo = $request->input("codigo");
        $inventario->nombre = $request->input('nombre');
        $inventario->descripcion = $request->input('descripcion');
        $inventario->cantidad = $request->input('cantidad');
        $inventario->precio_unitario = $request->input('precio_unitario');
        #$inventarios->user_id = Auth::id() ?? 1;

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
