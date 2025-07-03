<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\DetalleFactura; // Make sure this model is imported

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Factura::with('detalles');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $query->where('numero_factura', 'LIKE', '%' . $searchTerm . '%');
        }

        $facturas = $query->paginate(10);

        return view('facturas.index', compact('facturas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('facturas.formulario');
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        // Validation of data
        $validated = $request->validate([
            'numero_factura' => [
                'required', 'min:3', 'max:15',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/',
                Rule::unique('facturas', 'numero_factura')
            ],
            'fecha' => ['required', 'date', 'after_or_equal:2000-01-01', 'before_or_equal:2099-12-31'],
            'proveedor' => ['required', 'min:3', 'max:30', 'regex:/^[\pL0-9\s\-.,#]+$/u', 'regex:/.*\S.*/'],
            'forma_pago' => ['required', 'in:Efectivo,Cheque,Transferencia'],
            'responsable' => ['required', 'string', 'min:3', 'max:30', 'regex:/^[\pL0-9\s\-.,#]+$/u', 'regex:/.*\S.*/'],

            'productos' => ['required', 'array', 'min:1'],
            'productos.*.nombre' => ['required', 'string', 'max:100'],
            'productos.*.categoria' => ['nullable', 'string', 'max:50'],
            'productos.*.precioCompra' => ['required', 'numeric', 'min:0', 'max:9999'],
            'productos.*.precioVenta' => ['required', 'numeric', 'min:0', 'max:9999'],
            'productos.*.cantidad' => ['required', 'integer', 'min:1', 'max:999'],
            'productos.*.iva' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Secure Transaction
        DB::transaction(function () use ($request) {
            $subtotalGeneral = 0; // For the sum of the taxable bases
            $impuestosGeneral = 0; // For the sum of calculated taxes

            $factura = Factura::create([
                'numero_factura' => $request->numero_factura,
                'fecha' => $request->fecha,
                'proveedor' => $request->proveedor,
                'forma_pago' => $request->forma_pago,
                'responsable' => $request->responsable,
                'subtotal' => 0, // Will be updated at the end
                'impuestos' => 0, // Will be updated at the end
                'totalF' => 0, // Will be updated at the end
            ]);

            foreach ($request->productos as $producto) {
                $baseProducto = $producto['precioCompra'] * $producto['cantidad'];
                $ivaProducto = ($producto['iva'] / 100) * $baseProducto;
                $totalProducto = $baseProducto + $ivaProducto; // Total of this product including its VAT

                $subtotalGeneral += $baseProducto; // Sums the taxable base to the general subtotal
                $impuestosGeneral += $ivaProducto; // Sums the tax of this product to the total taxes

                $factura->detalles()->create([
                    'producto' => $producto['nombre'],
                    'categoria' => $producto['categoria'],
                    'precioCompra' => $producto['precioCompra'],
                    'precioVenta' => $producto['precioVenta'],
                    'cantidad' => $producto['cantidad'],
                    'iva' => $producto['iva'],
                    'total' => $totalProducto, // Save the product total with its VAT
                ]);
            }

            $totalFinal = $subtotalGeneral + $impuestosGeneral;

            $factura->update([
                'subtotal' => $subtotalGeneral,
                'impuestos' => $impuestosGeneral,
                'totalF' => $totalFinal,
            ]);
        });

        return redirect()->route('facturas.index')->with('status', 'Factura registrada correctamente');
    }

    public function obtenerProductosProveedor($nombre)
    {
        // Busca facturas con ese proveedor
        $factura = Factura::where('proveedor', $nombre)
            ->with('detalles')
            ->latest()
            ->first();

        if (!$factura) {
            return response()->json([
                'error' => 'No se encontraron facturas para este proveedor.'
            ], 404);
        }

        // Retorna los productos relacionados
        return response()->json([
            'productos' => $factura->detalles->map(function ($detalle) {
                return [
                    'producto' => $detalle->producto,
                    'precio' => $detalle->precio, // This 'precio' might refer to precioCompra or precioVenta depending on frontend
                    'cantidad' => $detalle->cantidad,
                    'total' => $detalle->total,
                    'categoria' => $detalle->categoria ?? 'Desconocida',
                ];
            }),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $factura = Factura::with('detalles')->findOrFail($id);
        return view('facturas.show', compact('factura'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $factura = Factura::with('detalles')->findOrFail($id);
        return view('facturas.formulario', compact('factura'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $factura = Factura::findOrFail($id);

        $validated = $request->validate([
            'numero_factura' => [
                'required', 'min:3', 'max:15',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/',
                Rule::unique('facturas', 'numero_factura')->ignore($factura->id)
            ],
            'fecha' => ['required', 'date', 'after_or_equal:2000-01-01', 'before_or_equal:2099-12-31'],
            'proveedor' => ['required', 'min:3', 'max:30', 'regex:/^[\pL0-9\s\-.,#]+$/u', 'regex:/.*\S.*/'],
            'forma_pago' => ['required', 'in:Efectivo,Cheque,Transferencia'],
            'responsable' => ['required', 'string', 'min:3', 'max:30', 'regex:/^[\pL0-9\s\-.,#]+$/u', 'regex:/.*\S.*/'],

            'productos' => ['required', 'array', 'min:1'],
            'productos.*.nombre' => ['required', 'string', 'max:100'],
            'productos.*.categoria' => ['nullable', 'string', 'max:50'],
            'productos.*.precioCompra' => ['required', 'numeric', 'min:0', 'max:9999'],
            'productos.*.precioVenta' => ['required', 'numeric', 'min:0', 'max:9999'],
            'productos.*.cantidad' => ['required', 'integer', 'min:1', 'max:999'],
            'productos.*.iva' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($request, $factura) {
            // Update main invoice fields
            $factura->update([
                'numero_factura' => $request->numero_factura,
                'fecha' => $request->fecha,
                'proveedor' => $request->proveedor,
                'forma_pago' => $request->forma_pago,
                'responsable_id' => $request->responsableId,
            ]);

            // Sync invoice details
            // 1. Delete existing details for this invoice
            $factura->detalles()->delete();

            $subtotalGeneral = 0;
            $impuestosGeneral = 0;

            // 2. Recreate details with new data
            foreach ($request->productos as $producto) {
                $baseProducto = $producto['precioCompra'] * $producto['cantidad'];
                $ivaProducto = ($producto['iva'] / 100) * $baseProducto;
                $totalProducto = $baseProducto + $ivaProducto;

                $subtotalGeneral += $baseProducto;
                $impuestosGeneral += $ivaProducto;

                $factura->detalles()->create([
                    'producto' => $producto['nombre'],
                    'categoria' => $producto['categoria'],
                    'precioCompra' => $producto['precioCompra'],
                    'precioVenta' => $producto['precioVenta'],
                    'cantidad' => $producto['cantidad'],
                    'iva' => $producto['iva'],
                    'total' => $totalProducto,
                ]);
            }

            $totalFinal = $subtotalGeneral + $impuestosGeneral;

            $factura->update([
                'subtotal' => $subtotalGeneral,
                'impuestos' => $impuestosGeneral,
                'totalF' => $totalFinal,
            ]);
        });

        return redirect()->route('facturas.index')->with('status', 'Factura actualizada correctamente!');
    }
}
