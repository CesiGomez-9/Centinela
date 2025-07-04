<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        $proveedores = ['TE seguridad', 'TecnoSeguridad SA', 'Alarmas Prosegur', 'Seguridad Total', 'LockPro Cerraduras', 'VigiTech Honduras', 'Securitas HN', 'AlertaHN', 'MoniSegur', 'RejaMax'];
        $formasPago = ['Efectivo', 'Cheque', 'Transferencia'];

        return view('facturas.formulario', compact('proveedores', 'formasPago'));
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // *** LÍNEA DE DEPURACIÓN: Descomenta para ver la estructura exacta del array de productos ***
                // dd($request->productos);

                $subtotalGeneral = 0;
                $impuestosGeneral = 0;

                $factura = Factura::create([
                    'numero_factura' => $request->numero_factura,
                    'fecha' => $request->fecha,
                    'forma_pago' => $request->forma_pago,
                    'responsable_id' => $request->responsable,
                    'proveedor_id' => $request->proveedor_id, // ESTE CAMPO FALTABA
                    'subtotal' => 0,
                    'impuestos' => 0,
                    'totalF' => 0,
                ]);

                foreach ($request->productos as $producto) {
                    // *** CAMBIO CLAVE: Usar camelCase para acceder a las propiedades del array $producto ***
                    // Esto coincide con cómo el JavaScript envía los datos (ej. productos[0][precioCompra])
                    $baseProducto = $producto['precioCompra'] * $producto['cantidad'];
                    $ivaProducto = ($producto['iva'] / 100) * $baseProducto;
                    $totalProducto = $baseProducto + $ivaProducto;

                    $subtotalGeneral += $baseProducto;
                    $impuestosGeneral += $ivaProducto;

                    $factura->detalles()->create([
                        'producto' => $producto['nombre'],
                        'categoria' => $producto['categoria'],
                        'precio_compra' => $producto['precioCompra'], // Usar camelCase aquí
                        'precio_venta' => $producto['precioVenta'],   // Usar camelCase aquí
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

            // Si la transacción es exitosa, redirige
            return redirect()->route('facturas.index')->with('status', 'Factura registrada correctamente');

        } catch (\Throwable $e) {
            // *** IMPRIME EL ERROR DIRECTAMENTE EN LA PANTALLA ***
            echo "<h1>Error Fatal en el Servidor</h1>";
            echo "<p>Mensaje: " . $e->getMessage() . "</p>";
            echo "<p>Archivo: " . $e->getFile() . "</p>";
            echo "<p>Línea: " . $e->getLine() . "</p>";
            echo "<h2>Stack Trace:</h2>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
            exit; // Detiene la ejecución para que no haya redirección
        }
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
        $proveedores = ['TE seguridad', 'TecnoSeguridad SA', 'Alarmas Prosegur', 'Seguridad Total', 'LockPro Cerraduras', 'VigiTech Honduras', 'Securitas HN', 'AlertaHN', 'MoniSegur', 'RejaMax'];
        $formasPago = ['Efectivo', 'Cheque', 'Transferencia'];

        return view('facturas.formulario', compact('factura', 'proveedores', 'formasPago'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $factura = Factura::findOrFail($id);

        try {
            DB::transaction(function () use ($request, $factura) {
                // Update main invoice fields
                $factura->update([
                    'numero_factura' => $request->numero_factura,
                    'fecha' => $request->fecha,
                    'proveedor_id' => $request->proveedor,
                    'forma_pago' => $request->forma_pago,
                    'responsable_id' => $request->responsable,
                ]);

                // Sync invoice details
                $factura->detalles()->delete();

                $subtotalGeneral = 0;
                $impuestosGeneral = 0;

                foreach ($request->productos as $producto) {
                    // *** CAMBIO CLAVE: Usar camelCase para acceder a las propiedades del array $producto ***
                    $baseProducto = $producto['precioCompra'] * $producto['cantidad'];
                    $ivaProducto = ($producto['iva'] / 100) * $baseProducto;
                    $totalProducto = $baseProducto + $ivaProducto;

                    $subtotalGeneral += $baseProducto;
                    $impuestosGeneral += $ivaProducto;

                    $factura->detalles()->create([
                        'producto' => $producto['nombre'],
                        'categoria' => $producto['categoria'],
                        'precio_compra' => $producto['precioCompra'], // Usar camelCase aquí
                        'precio_venta' => $producto['precioVenta'],   // Usar camelCase aquí
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

        } catch (\Throwable $e) {
            // *** IMPRIME EL ERROR DIRECTAMENTE EN LA PANTALLA ***
            echo "<h1>Error Fatal en el Servidor (Actualización)</h1>";
            echo "<p>Mensaje: " . $e->getMessage() . "</p>";
            echo "<p>Archivo: " . $e->getFile() . "</p>";
            echo "<p>Línea: " . $e->getLine() . "</p>";
            echo "<h2>Stack Trace:</h2>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
            exit; // Detiene la ejecución
        }
    }
}
