<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto; // Importar el modelo Producto
use Illuminate\Http\Request;

class ProductoApiController extends Controller
{
    /**
     * Obtiene una lista de productos.
     * Permite filtrar por nombre o categoría.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Producto::with('impuesto');

        // Si hay un término de búsqueda, filtrar por nombre o categoría
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('categoria', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Obtener los productos
        $productos = $query->get();

        // Retornar los productos como JSON
        return response()->json($productos);
    }
}
