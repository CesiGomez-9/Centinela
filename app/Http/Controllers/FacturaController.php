<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Proveedor;
use App\Models\Empleado;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // Importa Carbon para mejor manejo de fechas

class FacturaController extends Controller
{
    /**
     * Muestra una lista de los recursos.
     */
    public function index(Request $request)
    {
        // Tu lógica actual de index parece tener una duplicidad.
        // Me quedo con la primera parte que es más directa. Si necesitas la búsqueda,
        // la segunda parte debería ser la única activa.
        $facturas = Factura::with(['detalles', 'empleado'])->orderBy('numero_factura')->paginate(10);
        return view('facturas.index', compact('facturas'));


        // Si quisieras la búsqueda, este sería el bloque activo:
        /*
        $query = Factura::with(['detalles', 'proveedor', 'empleado']);

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('numero_factura', 'LIKE', '%' . $searchTerm . '%');
        }

        $facturas = $query->paginate(10);
        return view('facturas.index', compact('facturas'));
        */
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        // Obtener proveedores y empleados de la base de datos
        $proveedores = Proveedor::orderBy('nombreEmpresa')->get();
        $empleados = Empleado::orderBy('nombre')->get();

        // Lista de formas de pago (siempre fija)
        $formasPago = ['Efectivo', 'Cheque', 'Transferencia'];

        return view('facturas.formulario', compact('proveedores', 'formasPago', 'empleados'));
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'numero_factura' => ['required', 'string', 'max:20', Rule::unique('facturas', 'numero_factura')],
            'fecha' => [
                'required',
                'date', // Asegura que sea un formato de fecha válido
                'after_or_equal:' . Carbon::now()->subMonth()->toDateString(), // Desde hace un mes
                'before_or_equal:today' // Hasta hoy
            ],
            'proveedor_id' => ['required', 'exists:proveedores,id'],
            'forma_pago' => ['required', 'in:Efectivo,Cheque,Transferencia'],
            'responsable_id' => ['required', 'exists:empleados,id'],
            'productos' => ['required', 'array', 'min:1'],
            'productos.*.product_id' => ['required', 'exists:productos,id'],
            'productos.*.nombre' => ['required', 'string', 'max:255'],
            'productos.*.categoria' => ['required', 'string', 'max:255'],
            'productos.*.precioCompra' => ['required', 'numeric', 'min:0'],
            'productos.*.precioVenta' => ['required', 'numeric', 'min:0'],
            'productos.*.cantidad' => ['required', 'integer', 'min:1'],
            'productos.*.iva' => ['required', 'numeric', 'min:0', 'max:100'],
        ], [
            'numero_factura.unique' => 'El número de factura ingresado ya existe. Por favor, ingrese uno diferente.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser un formato de fecha válido (YYYY-MM-DD).',
            'fecha.after_or_equal' =>  'La fecha debe ser como mínimo un mes antes del día actual.',
            'fecha.before_or_equal' => 'La fecha no puede ser futura.',
            'proveedor_id.required' => 'El proveedor es obligatorio.',
            'proveedor_id.exists' => 'El proveedor seleccionado no es válido.',
            'responsable_id.required' => 'El responsable es obligatorio.',
            'responsable_id.exists' => 'El empleado responsable seleccionado no es válido.',
            'productos.required' => 'Debe agregar al menos un producto a la factura.',
            'productos.min' => 'Debe agregar al menos un producto a la factura.',
            'productos.*.product_id.required' => 'El ID del producto es obligatorio para cada producto.',
            'productos.*.product_id.exists' => 'Uno o más productos seleccionados no son válidos.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $subtotalGeneral = 0;
                $impuestosGeneral = 0;

                $factura = Factura::create([
                    'numero_factura' => $request->numero_factura,
                    'fecha' => $request->fecha,
                    'proveedor_id' => $request->proveedor_id,
                    'forma_pago' => $request->forma_pago,
                    'responsable_id' => $request->responsable_id,
                    'subtotal' => 0,
                    'impuestos' => 0,
                    'totalF' => 0,
                ]);

                // Itera sobre los productos enviados en la solicitud
                foreach ($request->productos as $productoData) {
                    // Busca el producto en la base de datos para actualizar su cantidad
                    $producto = Producto::find($productoData['product_id']);

                    if ($producto) {
                        // Calcula la base imponible del producto
                        $baseProducto = $productoData['precioCompra'] * $productoData['cantidad'];
                        // Calcula el IVA del producto
                        $ivaProducto = ($productoData['iva'] / 100) * $baseProducto;
                        // Calcula el total del producto
                        $totalProducto = $baseProducto + $ivaProducto;

                        // Acumula los subtotales e impuestos generales
                        $subtotalGeneral += $baseProducto;
                        $impuestosGeneral += $ivaProducto;

                        // Crea un detalle de factura asociado a la factura actual
                        $factura->detalles()->create([
                            'product_id' => $productoData['product_id'],
                            'producto' => $productoData['nombre'],
                            'categoria' => $productoData['categoria'],
                            'precio_compra' => $productoData['precioCompra'],
                            'precio_venta' => $productoData['precioVenta'],
                            'cantidad' => $productoData['cantidad'],
                            'iva' => $productoData['iva'],
                            'total' => $totalProducto,
                        ]);

                        // SUMAR la cantidad al inventario para una factura de compra
                        $producto->cantidad += $productoData['cantidad'];
                        $producto->save();
                    } else {
                        \Log::warning("Producto con ID {$productoData['product_id']} no encontrado al crear factura.");
                    }
                }

                // Calcula el total final de la factura
                $totalFinal = $subtotalGeneral + $impuestosGeneral;

                // Actualiza los campos de subtotal, impuestos y totalF en la factura
                $factura->update([
                    'subtotal' => $subtotalGeneral,
                    'impuestos' => $impuestosGeneral,
                    'totalF' => $totalFinal,
                ]);
            });

            // Si la transacción es exitosa, redirige con un mensaje de estado
            return redirect()->route('facturas.index')->with('status', 'Factura registrada correctamente');

        } catch (\Throwable $e) {
            // Manejo de errores para depuración
            echo "<h1>Error Fatal en el Servidor</h1>";
            echo "<p>Mensaje: " . $e->getMessage() . "</p>";
            echo "<p>Archivo: " . $e->getFile() . "</p>";
            echo "<p>Línea: " . $e->getLine() . "</p>";
            echo "<h2>Rastreo de la Pila:</h2>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
            exit;
        }
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(string $id)
    {
        $factura = Factura::with(['detalles', 'proveedor', 'empleado'])->findOrFail($id);
        return view('facturas.show', compact('factura'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(string $id)
    {
        $factura = Factura::with(['detalles', 'proveedor', 'empleado'])->findOrFail($id);
        $proveedores = Proveedor::orderBy('nombreEmpresa')->get();
        $empleados = Empleado::orderBy('nombre')->get();
        $formasPago = ['Efectivo', 'Cheque', 'Transferencia'];

        // Formatear la fecha para el input type="date"
        $factura->fecha = Carbon::parse($factura->fecha)->format('Y-m-d');

        return view('facturas.formulario', compact('factura', 'proveedores', 'formasPago', 'empleados'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, string $id)
    {
        $factura = Factura::findOrFail($id);

        $request->validate([
            'numero_factura' => ['required', 'string', 'max:20', Rule::unique('facturas', 'numero_factura')->ignore($factura->id)],
            'fecha' => [
                'required',
                'date',
                'after_or_equal:' . Carbon::now()->subMonth()->toDateString(),
                'before_or_equal:today'
            ],
            'proveedor_id' => ['required', 'exists:proveedores,id'],
            'forma_pago' => ['required', 'in:Efectivo,Cheque,Transferencia'],
            'responsable_id' => ['required', 'exists:empleados,id'],
            'productos' => ['required', 'array', 'min:1'],
            'productos.*.product_id' => ['required', 'exists:productos,id'],
            'productos.*.nombre' => ['required', 'string', 'max:255'],
            'productos.*.categoria' => ['required', 'string', 'max:255'],
            'productos.*.precioCompra' => ['required', 'numeric', 'min:0'],
            'productos.*.precioVenta' => ['required', 'numeric', 'min:0'],
            'productos.*.cantidad' => ['required', 'integer', 'min:1'],
            'productos.*.iva' => ['required', 'numeric', 'min:0', 'max:100'],
        ], [
            'numero_factura.unique' => 'El número de factura ingresado ya existe. Por favor, ingrese uno diferente.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser un formato de fecha válido (YYYY-MM-DD).',
            'fecha.after_or_equal' =>  'La fecha debe ser como mínimo un mes antes del día actual.',
            'fecha.before_or_equal' => 'La fecha no puede ser futura.',
            'proveedor_id.required' => 'El proveedor es obligatorio.',
            'proveidor_id.exists' => 'El proveedor seleccionado no es válido.',
            'responsable_id.required' => 'El responsable es obligatorio.',
            'responsable_id.exists' => 'El empleado responsable seleccionado no es válido.',
            'productos.required' => 'Debe agregar al menos un producto a la factura.',
            'productos.min' => 'Debe agregar al menos un producto a la factura.',
            'productos.*.product_id.required' => 'El ID del producto es obligatorio para cada producto.',
            'productos.*.product_id.exists' => 'Uno o más productos seleccionados no son válidos.',
        ]);

        try {
            DB::transaction(function () use ($request, $factura) {
                // 1. Revertir las cantidades de los productos de la factura ORIGINAL al inventario
                // Esto se hace ANTES de procesar los nuevos detalles.
                foreach ($factura->detalles as $originalDetail) {
                    $productoOriginal = Producto::find($originalDetail->product_id); // Usar product_id
                    if ($productoOriginal) {
                        $productoOriginal->cantidad -= $originalDetail->cantidad; // Restar la cantidad original
                        $productoOriginal->save();
                    }
                }

                // 2. Eliminar todos los detalles de la factura existente (para reemplazarlos por los nuevos)
                $factura->detalles()->delete();

                $subtotalGeneral = 0;
                $impuestosGeneral = 0;

                // 3. Itera sobre los productos enviados en la solicitud (los nuevos detalles)
                foreach ($request->productos as $productoData) {
                    $producto = Producto::find($productoData['product_id']);

                    if ($producto) {
                        $baseProducto = $productoData['precioCompra'] * $productoData['cantidad'];
                        $ivaProducto = ($productoData['iva'] / 100) * $baseProducto;
                        $totalProducto = $baseProducto + $ivaProducto;

                        $subtotalGeneral += $baseProducto;
                        $impuestosGeneral += $ivaProducto;

                        $factura->detalles()->create([
                            'product_id' => $productoData['product_id'],
                            'producto' => $productoData['nombre'],
                            'categoria' => $productoData['categoria'],
                            'precio_compra' => $productoData['precioCompra'],
                            'precio_venta' => $productoData['precioVenta'],
                            'cantidad' => $productoData['cantidad'],
                            'iva' => $productoData['iva'],
                            'total' => $totalProducto,
                        ]);

                        // SUMAR la nueva cantidad al inventario
                        $producto->cantidad += $productoData['cantidad'];
                        $producto->save();
                    } else {
                        \Log::warning("Producto con ID {$productoData['product_id']} no encontrado al actualizar factura.");
                    }
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
            echo "<h1>Error Fatal en el Servidor (Actualización)</h1>";
            echo "<p>Mensaje: " . $e->getMessage() . "</p>";
            echo "<p>Archivo: " . $e->getFile() . "</p>";
            echo "<p>Línea: " . $e->getLine() . "</p>";
            echo "<h2>Rastreo de la Pila:</h2>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
            exit;
        }
    }

}
