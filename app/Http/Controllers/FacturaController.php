<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Proveedor; // Importar el modelo Proveedor
use App\Models\Empleado;  // Importar el modelo Empleado
use App\Models\Producto;  // Importar el modelo Producto
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule; // Importar la clase Rule para validación única

class FacturaController extends Controller
{
    /**
     * Muestra una lista de los recursos.
     */
    public function index(Request $request)
    {
        // Cargar las relaciones 'detalles', 'proveedor' y 'empleado'
        $query = Factura::with(['detalles', 'proveedor', 'empleado']);

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            // Buscar por número de factura
            $query->where('numero_factura', 'LIKE', '%' . $searchTerm . '%');
        }

        $facturas = $query->paginate(10);

        return view('facturas.index', compact('facturas'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        // Obtener proveedores y empleados de la base de datos
        $proveedores = Proveedor::orderBy('nombreEmpresa')->get();
        $empleados = Empleado::orderBy('nombre')->get(); // O Empleado::all();

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
            'numero_factura' => ['required', 'string', 'max:20', Rule::unique('facturas', 'numero_factura')], // Valida que el número de factura sea único
            'fecha' => ['required', 'date', 'after_or_equal:2025-01-01', 'before_or_equal:2099-12-31'], // Valida rango de fecha
            'proveedor_id' => ['required', 'exists:proveedores,id'], // Valida que el ID del proveedor exista en la tabla 'proveedores'
            'forma_pago' => ['required', 'in:Efectivo,Cheque,Transferencia'], // Valida que la forma de pago sea una de las opciones
            'responsable_id' => ['required', 'exists:empleados,id'], // Valida que el ID del empleado exista en la tabla 'empleados'
            'productos' => ['required', 'array', 'min:1'], // Debe haber al menos un producto
            'productos.*.product_id' => ['required', 'exists:productos,id'], // Nuevo: Valida que el ID del producto exista
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
            'fecha.after_or_equal' => 'La fecha no puede ser anterior al 1 de enero de 2025.',
            'fecha.before_or_equal' => 'La fecha no puede ser posterior al 31 de diciembre de 2099.',
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
                    'proveedor_id' => $request->proveedor_id, // Usar el ID del proveedor
                    'forma_pago' => $request->forma_pago,
                    'responsable_id' => $request->responsable_id, // Usar el ID del empleado
                    'subtotal' => 0, // Se actualizará al final
                    'impuestos' => 0, // Se actualizará al final
                    'totalF' => 0,    // Se actualizará al final
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
                            'product_id' => $productoData['product_id'], // Guardar el product_id en detalles
                            'producto' => $productoData['nombre'],
                            'categoria' => $productoData['categoria'],
                            'precio_compra' => $productoData['precioCompra'],
                            'precio_venta' => $productoData['precioVenta'],
                            'cantidad' => $productoData['cantidad'],
                            'iva' => $productoData['iva'],
                            'total' => $totalProducto,
                        ]);

                        // Decrementar la cantidad del producto en el inventario
                        $producto->cantidad -= $productoData['cantidad'];
                        $producto->save();
                    } else {
                        // Manejar el caso donde el producto no se encuentra (opcional: lanzar excepción, loggear)
                        // Por ahora, simplemente lo ignoramos si no se encuentra
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
            // Manejo de errores: imprime el error directamente en la pantalla para depuración
            echo "<h1>Error Fatal en el Servidor</h1>";
            echo "<p>Mensaje: " . $e->getMessage() . "</p>";
            echo "<p>Archivo: " . $e->getFile() . "</p>";
            echo "<p>Línea: " . $e->getLine() . "</p>";
            echo "<h2>Rastreo de la Pila:</h2>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
            exit; // Detiene la ejecución para evitar redirecciones o más procesamiento
        }
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(string $id)
    {
        // Cargar las relaciones 'detalles', 'proveedor' y 'empleado'
        $factura = Factura::with(['detalles', 'proveedor', 'empleado'])->findOrFail($id);
        return view('facturas.show', compact('factura'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(string $id)
    {
        // Busca la factura por ID, incluyendo sus detalles, proveedor y empleado
        $factura = Factura::with(['detalles', 'proveedor', 'empleado'])->findOrFail($id);

        // Obtener proveedores y empleados de la base de datos
        $proveedores = Proveedor::orderBy('nombreEmpresa')->get();
        $empleados = Empleado::orderBy('nombre')->get(); // O Empleado::all();

        // Lista de formas de pago
        $formasPago = ['Efectivo', 'Cheque', 'Transferencia'];

        // Formatear la fecha para el input type="date"
        $factura->fecha = \Carbon\Carbon::parse($factura->fecha)->format('Y-m-d');

        return view('facturas.formulario', compact('factura', 'proveedores', 'formasPago', 'empleados'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, string $id)
    {
        // Busca la factura por ID o lanza un 404 si no se encuentra
        $factura = Factura::findOrFail($id);

        // Validar los datos de entrada para la actualización
        $request->validate([
            // Valida que el número de factura sea único, excepto para la factura actual
            'numero_factura' => ['required', 'string', 'max:20', Rule::unique('facturas', 'numero_factura')->ignore($factura->id)],
            'fecha' => ['required', 'date', 'after_or_equal:2025-01-01', 'before_or_equal:2099-12-31'],
            'proveedor_id' => ['required', 'exists:proveedores,id'],
            'forma_pago' => ['required', 'in:Efectivo,Cheque,Transferencia'],
            'responsable_id' => ['required', 'exists:empleados,id'],
            'productos' => ['required', 'array', 'min:1'], // Debe haber al menos un producto
            'productos.*.product_id' => ['required', 'exists:productos,id'], // Nuevo: Valida que el ID del producto exista
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
            'fecha.after_or_equal' => 'La fecha no puede ser anterior al 1 de enero de 2025.',
            'fecha.before_or_equal' => 'La fecha no puede ser posterior al 31 de diciembre de 2099.',
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
            DB::transaction(function () use ($request, $factura) {
                // Para manejar la reversión de cantidades en caso de edición:
                // 1. Obtener las cantidades originales de los productos en esta factura
                $originalDetails = $factura->detalles()->get()->keyBy('product_id');

                // Actualiza los campos principales de la factura
                $factura->update([
                    'numero_factura' => $request->numero_factura,
                    'fecha' => $request->fecha,
                    'proveedor_id' => $request->proveedor_id, // Usar el ID del proveedor
                    'forma_pago' => $request->forma_pago,
                    'responsable_id' => $request->responsable_id, // Usar el ID del empleado
                ]);

                // Elimina los detalles de factura existentes para sincronizarlos con los nuevos
                $factura->detalles()->delete();

                $subtotalGeneral = 0;
                $impuestosGeneral = 0;

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

                        // Crea un nuevo detalle de factura asociado a la factura actual
                        $factura->detalles()->create([
                            'product_id' => $productoData['product_id'], // Guardar el product_id en detalles
                            'producto' => $productoData['nombre'],
                            'categoria' => $productoData['categoria'],
                            'precio_compra' => $productoData['precioCompra'],
                            'precio_venta' => $productoData['precioVenta'],
                            'cantidad' => $productoData['cantidad'],
                            'iva' => $productoData['iva'],
                            'total' => $totalProducto,
                        ]);

                        // Ajustar la cantidad del producto en el inventario:
                        // Si el producto existía en los detalles originales, sumar su cantidad original
                        if (isset($originalDetails[$productoData['product_id']])) {
                            $producto->cantidad += $originalDetails[$productoData['product_id']]->cantidad;
                        }
                        // Luego, restar la nueva cantidad
                        $producto->cantidad -= $productoData['cantidad'];
                        $producto->save();
                    } else {
                        \Log::warning("Producto con ID {$productoData['product_id']} no encontrado al actualizar factura.");
                    }
                }

                // Para productos que estaban en la factura original pero no en la nueva, revertir su cantidad
                foreach ($originalDetails as $originalDetail) {
                    $foundInNewRequest = false;
                    foreach ($request->productos as $newProductData) {
                        if ($newProductData['product_id'] == $originalDetail->product_id) {
                            $foundInNewRequest = true;
                            break;
                        }
                    }
                    if (!$foundInNewRequest) {
                        $productToRevert = Producto::find($originalDetail->product_id);
                        if ($productToRevert) {
                            $productToRevert->cantidad += $originalDetail->cantidad;
                            $productToRevert->save();
                        }
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
            return redirect()->route('facturas.index')->with('status', 'Factura actualizada correctamente!');

        } catch (\Throwable $e) {
            // Manejo de errores: imprime el error directamente en la pantalla para depuración
            echo "<h1>Error Fatal en el Servidor (Actualización)</h1>";
            echo "<p>Mensaje: " . $e->getMessage() . "</p>";
            echo "<p>Archivo: " . $e->getFile() . "</p>";
            echo "<p>Línea: " . $e->getLine() . "</p>";
            echo "<h2>Rastreo de la Pila:</h2>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
            exit; // Detiene la ejecución
        }
    }
}
