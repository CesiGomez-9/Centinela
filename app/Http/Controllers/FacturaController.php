<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Proveedor;
use App\Models\Empleado;
use App\Models\Producto;
use App\Models\Impuesto; // Importar el modelo Impuesto
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
        // Cargar las relaciones necesarias para la vista
        $query = Factura::with(['detalles', 'proveedor', 'empleado']);

        // Si hay un término de búsqueda, aplicarlo a la consulta
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('numero_factura', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('proveedor', function ($q) use ($searchTerm) {
                        $q->where('nombreEmpresa', 'LIKE', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('empleado', function ($q) use ($searchTerm) {
                        $q->where('nombre', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }

        $facturas = $query->orderBy('fecha', 'desc')->paginate(10); // Ordenar por fecha descendente

        return view('facturas.index', compact('facturas'));
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
            'productos.*.precioVenta' => [
                'required',
                'numeric',
                'min:0',
                // Validación: precioVenta no debe ser menor o igual al precioCompra
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1]; // Obtiene el índice del producto
                    $precioCompra = $request->input("productos.{$index}.precioCompra");
                    if ($value <= $precioCompra) {
                        $fail("El precio de venta ({$value}) no puede ser menor o igual al precio de compra ({$precioCompra}).");
                    }
                },
            ],
            'productos.*.cantidad' => ['required', 'integer', 'min:1'],
            // 'productos.*.iva' ya no se valida directamente, se obtiene del producto
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
            'productos.*.precioCompra.min' => 'El precio de compra no puede ser negativo.',
            'productos.*.precioVenta.min' => 'El precio de venta no puede ser negativo.',
            'productos.*.cantidad.min' => 'La cantidad debe ser al menos 1.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $importeGravado = 0;
                $importeExento = 0;
                $importeExonerado = 0; // Se mantiene, pero su lógica específica dependerá de un flag en Producto/Impuesto
                $isv15 = 0;
                $isv18 = 0;
                $subtotalGeneral = 0; // Suma de importeGravado + importeExento + importeExonerado
                $impuestosGeneral = 0; // Suma de isv15 + isv18
                $totalFinal = 0;

                $factura = Factura::create([
                    'numero_factura' => $request->numero_factura,
                    'fecha' => $request->fecha,
                    'proveedor_id' => $request->proveedor_id,
                    'forma_pago' => $request->forma_pago,
                    'responsable_id' => $request->responsable_id,
                    'importe_gravado' => 0,
                    'importe_exento' => 0,
                    'importe_exonerado' => 0,
                    'isv_15' => 0,
                    'isv_18' => 0,
                    'subtotal' => 0, // Se actualizará al final
                    'impuestos' => 0, // Se actualizará al final
                    'totalF' => 0,   // Se actualizará al final
                ]);

                // Itera sobre los productos enviados en la solicitud
                foreach ($request->productos as $productoData) {
                    // Busca el producto en la base de datos para obtener su impuesto y actualizar cantidad
                    $producto = Producto::with('impuesto')->find($productoData['product_id']);

                    if ($producto && $producto->impuesto) {
                        $baseProducto = $productoData['precioCompra'] * $productoData['cantidad'];
                        $porcentajeIVA = $producto->impuesto->porcentaje; // Usar el porcentaje del impuesto del producto

                        // Calcular importes gravados/exentos
                        if ($porcentajeIVA > 0) {
                            $importeGravado += $baseProducto;
                        } else {
                            // Asumimos que 0% es exento. Si 'Exonerado' es distinto, necesita un flag.
                            $importeExento += $baseProducto;
                        }

                        // Calcular IVA específico
                        $ivaProducto = ($porcentajeIVA / 100) * $baseProducto;
                        if ($porcentajeIVA == 15) {
                            $isv15 += $ivaProducto;
                        } elseif ($porcentajeIVA == 18) {
                            $isv18 += $ivaProducto;
                        }
                        // Si hubiera otros porcentajes, se añadirían aquí

                        $totalProducto = $baseProducto + $ivaProducto;

                        // Acumula los subtotales e impuestos generales para los campos antiguos (subtotal, impuestos)
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
                            'iva' => $porcentajeIVA, // Guardar el porcentaje de IVA real
                            'total' => $totalProducto,
                        ]);

                        // SUMAR la cantidad al inventario para una factura de compra
                        $producto->cantidad += $productoData['cantidad'];
                        $producto->save();
                    } else {
                        // Esto debería ser capturado por la validación 'exists', pero es un buen fallback
                        \Log::warning("Producto o Impuesto asociado no encontrado para ID {$productoData['product_id']} al crear factura.");
                        // Podrías lanzar una excepción aquí o manejarlo de otra forma si es un error crítico
                    }
                }

                // Calcular el total final de la factura
                $totalFinal = $importeGravado + $importeExento + $importeExonerado + $isv15 + $isv18;

                // Actualiza los campos de resumen y los campos antiguos en la factura
                $factura->update([
                    'importe_gravado' => $importeGravado,
                    'importe_exento' => $importeExento,
                    'importe_exonerado' => $importeExonerado,
                    'isv_15' => $isv15,
                    'isv_18' => $isv18,
                    'subtotal' => $subtotalGeneral, // Mantengo por compatibilidad, es la suma de bases
                    'impuestos' => $impuestosGeneral, // Mantengo por compatibilidad, es la suma de ISVs
                    'totalF' => $totalFinal,
                ]);
            });

            // Si la transacción es exitosa, redirige con un mensaje de estado
            return redirect()->route('facturas.index')->with('status', 'Factura registrada correctamente');

        } catch (\Throwable $e) {
            // Manejo de errores para depuración. En producción, esto debería ser un log y un mensaje amigable.
            \Log::error("Error al guardar factura: " . $e->getMessage() . " en " . $e->getFile() . " línea " . $e->getLine());
            return back()->withInput()->with('error', 'Error al guardar la factura: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(string $id)
    {
        // Cargar las relaciones necesarias para mostrar los detalles completos
        $factura = Factura::with(['detalles.productoInventario.impuesto', 'proveedor', 'empleado'])->findOrFail($id);
        return view('facturas.show', compact('factura'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(string $id)
    {
        // Cargar la factura con sus detalles y las relaciones de productos e impuestos
        $factura = Factura::with(['detalles.productoInventario.impuesto', 'proveedor', 'empleado'])->findOrFail($id);
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
            'productos.*.precioVenta' => [
                'required',
                'numeric',
                'min:0',
                // Validación: precioVenta no debe ser menor o igual al precioCompra
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1]; // Obtiene el índice del producto
                    $precioCompra = $request->input("productos.{$index}.precioCompra");
                    if ($value <= $precioCompra) {
                        $fail("El precio de venta ({$value}) no puede ser menor o igual al precio de compra ({$precioCompra}).");
                    }
                },
            ],
            'productos.*.cantidad' => ['required', 'integer', 'min:1'],
            // 'productos.*.iva' ya no se valida directamente, se obtiene del producto
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
            'productos.*.precioCompra.min' => 'El precio de compra no puede ser negativo.',
            'productos.*.precioVenta.min' => 'El precio de venta no puede ser negativo.',
            'productos.*.cantidad.min' => 'La cantidad debe ser al menos 1.',
        ]);

        try {
            DB::transaction(function () use ($request, $factura) {
                // 1. Revertir las cantidades de los productos de la factura ORIGINAL al inventario
                foreach ($factura->detalles as $originalDetail) {
                    $productoOriginal = Producto::find($originalDetail->product_id);
                    if ($productoOriginal) {
                        $productoOriginal->cantidad -= $originalDetail->cantidad;
                        $productoOriginal->save();
                    }
                }

                // 2. Eliminar todos los detalles de la factura existente (para reemplazarlos por los nuevos)
                $factura->detalles()->delete();

                $importeGravado = 0;
                $importeExento = 0;
                $importeExonerado = 0;
                $isv15 = 0;
                $isv18 = 0;
                $subtotalGeneral = 0;
                $impuestosGeneral = 0;
                $totalFinal = 0;

                // 3. Itera sobre los productos enviados en la solicitud (los nuevos detalles)
                foreach ($request->productos as $productoData) {
                    $producto = Producto::with('impuesto')->find($productoData['product_id']);

                    if ($producto && $producto->impuesto) {
                        $baseProducto = $productoData['precioCompra'] * $productoData['cantidad'];
                        $porcentajeIVA = $producto->impuesto->porcentaje;

                        if ($porcentajeIVA > 0) {
                            $importeGravado += $baseProducto;
                        } else {
                            $importeExento += $baseProducto;
                        }

                        $ivaProducto = ($porcentajeIVA / 100) * $baseProducto;
                        if ($porcentajeIVA == 15) {
                            $isv15 += $ivaProducto;
                        } elseif ($porcentajeIVA == 18) {
                            $isv18 += $ivaProducto;
                        }

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
                            'iva' => $porcentajeIVA,
                            'total' => $totalProducto,
                        ]);

                        // SUMAR la nueva cantidad al inventario
                        $producto->cantidad += $productoData['cantidad'];
                        $producto->save();
                    } else {
                        \Log::warning("Producto o Impuesto asociado no encontrado para ID {$productoData['product_id']} al actualizar factura.");
                    }
                }

                $totalFinal = $importeGravado + $importeExento + $importeExonerado + $isv15 + $isv18;

                $factura->update([
                    'importe_gravado' => $importeGravado,
                    'importe_exento' => $importeExento,
                    'importe_exonerado' => $importeExonerado,
                    'isv_15' => $isv15,
                    'isv_18' => $isv18,
                    'subtotal' => $subtotalGeneral,
                    'impuestos' => $impuestosGeneral,
                    'totalF' => $totalFinal,
                ]);
            });

            return redirect()->route('facturas.index')->with('status', 'Factura actualizada correctamente!');

        } catch (\Throwable $e) {
            \Log::error("Error al actualizar factura: " . $e->getMessage() . " en " . $e->getFile() . " línea " . $e->getLine());
            return back()->withInput()->with('error', 'Error al actualizar la factura: ' . $e->getMessage());
        }
    }

}

