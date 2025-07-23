<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Proveedor;
use App\Models\Empleado;
use App\Models\Producto;
use App\Models\Impuesto;
use App\Models\PrecioCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class FacturaCompraController extends Controller
{
    public function index(Request $request)
    {
        $query = Factura::with(['detalles', 'proveedor', 'empleado']);

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

        $facturas = $query->orderBy('fecha', 'desc')->paginate(10);
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $proveedores = Proveedor::orderBy('nombreEmpresa')->get();
        $empleados = Empleado::orderBy('nombre')->get();
        $formasPago = ['Efectivo', 'Cheque', 'Transferencia'];

        return view('facturas.formulario', compact('proveedores', 'formasPago', 'empleados'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'numero_factura' => ['required', 'string', 'max:20', Rule::unique('facturas', 'numero_factura')],
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
            'productos.*.nombre' => ['required', 'string', 'max:255'], // Se mantiene para lógica de negocio
            'productos.*.categoria' => ['required', 'string', 'max:255'], // Se mantiene para lógica de negocio
            'productos.*.precioCompra' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],
            'productos.*.precioVenta' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1];
                    $precioCompra = $request->input("productos.{$index}.precioCompra");
                    if ($value <= $precioCompra) {
                        $fail("El precio de venta ({$value}) no puede ser menor o igual al precio de compra ({$precioCompra}).");
                    }
                },
            ],
            'productos.*.cantidad' => [
                'required',
                'integer',
                'min:1',
                'max:999',
                'digits_between:1,3',
            ],
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
            'productos.*.precioCompra.integer' => 'El precio de compra debe ser un número entero.',
            'productos.*.precioCompra.min' => 'El precio de compra no puede ser negativo.',
            'productos.*.precioCompra.max' => 'El precio de compra no debe exceder 9999.',
            'productos.*.precioVenta.integer' => 'El precio de venta debe ser un número entero.',
            'productos.*.precioVenta.min' => 'El precio de venta no puede ser negativo.',
            'productos.*.precioVenta.max' => 'El precio de venta no debe exceder 9999.',
            'productos.*.cantidad.min' => 'La cantidad debe ser al menos 1.',
            'productos.*.cantidad.max' => 'La cantidad no debe exceder 999.',
            'productos.*.cantidad.digits_between' => 'La cantidad debe tener entre 1 y 3 dígitos.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $importeGravado = 0;
                $importeExento = 0;
                $importeExonerado = 0;
                $isv15 = 0;
                $isv18 = 0;
                $subtotalGeneral = 0;
                $impuestosGeneral = 0;
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
                    'subtotal' => 0,
                    'impuestos' => 0,
                    'totalF' => 0,
                ]);

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
                            'precio_compra' => $productoData['precioCompra'],
                            'precio_venta' => $productoData['precioVenta'],
                            'cantidad' => $productoData['cantidad'],

                        ]);

                        $oldPrecioCompra = $producto->precio_compra;
                        $newPrecioCompra = $productoData['precioCompra'];
                        $newPrecioVenta = $productoData['precioVenta'];

                        $producto->cantidad += $productoData['cantidad'];

                        $producto->precio_venta = $newPrecioVenta;

                        if (abs($newPrecioCompra - $oldPrecioCompra) > 0.001) {
                            $producto->precio_compra = $newPrecioCompra;
                            PrecioCompra::create([
                                'producto_id' => $producto->id,
                                'precio_compra' => $newPrecioCompra,
                            ]);
                        } else {
                            $producto->precio_compra = $newPrecioCompra;
                        }

                        $producto->save();
                    } else {
                        Log::warning("Producto o Impuesto asociado no encontrado para ID {$productoData['product_id']} al crear factura.");
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

            return redirect()->route('facturas.index')->with('status', 'Factura registrada correctamente');

        } catch (\Throwable $e) {
            Log::error("Error al guardar factura: " . $e->getMessage() . " en " . $e->getFile() . " línea " . $e->getLine());
            return back()->withInput()->with('error', 'Error al guardar la factura: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $factura = Factura::with(['detalles.productoInventario.impuesto', 'proveedor', 'empleado'])->findOrFail($id);
        return view('facturas.show', compact('factura'));
    }

    public function edit(string $id)
    {
        $factura = Factura::with(['detalles.productoInventario.impuesto', 'proveedor', 'empleado'])->findOrFail($id);
        $proveedores = Proveedor::orderBy('nombreEmpresa')->get();
        $empleados = Empleado::orderBy('nombre')->get();
        $formasPago = ['Efectivo', 'Cheque', 'Transferencia'];

        $factura->fecha = Carbon::parse($factura->fecha)->format('Y-m-d');

        return view('facturas.formulario', compact('factura', 'proveedores', 'formasPago', 'empleados'));
    }

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
            'productos.*.precioCompra' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],
            'productos.*.precioVenta' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1];
                    $precioCompra = $request->input("productos.{$index}.precioCompra");
                    if ($value <= $precioCompra) {
                        $fail("El precio de venta ({$value}) no puede ser menor o igual al precio de compra ({$precioCompra}).");
                    }
                },
            ],
            'productos.*.cantidad' => [
                'required',
                'integer',
                'min:1',
                'max:999',
                'digits_between:1,3',
            ],
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
            'productos.*.precioCompra.integer' => 'El precio de compra debe ser un número entero.',
            'productos.*.precioCompra.min' => 'El precio de compra no puede ser negativo.',
            'productos.*.precioCompra.max' => 'El precio de compra no debe exceder 9999.',
            'productos.*.precioVenta.integer' => 'El precio de venta debe ser un número entero.',
            'productos.*.precioVenta.min' => 'El precio de venta no puede ser negativo.',
            'productos.*.precioVenta.max' => 'El precio de venta no debe exceder 9999.',
            'productos.*.cantidad.min' => 'La cantidad debe ser al menos 1.',
            'productos.*.cantidad.max' => 'La cantidad no debe exceder 999.',
            'productos.*.cantidad.digits_between' => 'La cantidad debe tener entre 1 y 3 dígitos.',
        ]);

        try {
            DB::transaction(function () use ($request, $factura) {
                foreach ($factura->detalles as $originalDetail) {
                    $productoOriginal = Producto::find($originalDetail->product_id);
                    if ($productoOriginal) {
                        $productoOriginal->cantidad -= $originalDetail->cantidad;
                        $productoOriginal->save();
                    }
                }
                $factura->detalles()->delete();

                $importeGravado = 0;
                $importeExento = 0;
                $importeExonerado = 0;
                $isv15 = 0;
                $isv18 = 0;
                $subtotalGeneral = 0;
                $impuestosGeneral = 0;
                $totalFinal = 0;

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
                            'precio_compra' => $productoData['precioCompra'],
                            'precio_venta' => $productoData['precioVenta'],
                            'cantidad' => $productoData['cantidad'],
                        ]);

                        $oldPrecioCompra = $producto->precio_compra;
                        $newPrecioCompra = $productoData['precioCompra'];
                        $newPrecioVenta = $productoData['precioVenta'];

                        $producto->cantidad += $productoData['cantidad'];

                        $producto->precio_venta = $newPrecioVenta;

                        if (abs($newPrecioCompra - $oldPrecioCompra) > 0.001) {
                            $producto->precio_compra = $newPrecioCompra;
                            PrecioCompra::create([
                                'producto_id' => $producto->id,
                                'precio_compra' => $newPrecioCompra,
                            ]);
                        } else {
                            $producto->precio_compra = $newPrecioCompra;
                        }

                        $producto->save();
                    } else {
                        Log::warning("Producto o Impuesto asociado no encontrado para ID {$productoData['product_id']} al actualizar factura.");
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
            Log::error("Error al actualizar factura: " . $e->getMessage() . " en " . $e->getFile() . " línea " . $e->getLine());
            return back()->withInput()->with('error', 'Error al actualizar la factura: ' . $e->getMessage());
        }
    }

}
