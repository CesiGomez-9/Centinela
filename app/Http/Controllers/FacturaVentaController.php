<?php
namespace App\Http\Controllers;

use App\Models\DetalleFactura;
use App\Models\FacturaVenta;
use App\Models\DetalleFacturaVenta;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Empleado;


class FacturaVentaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $facturas = FacturaVenta::with(['cliente', 'empleado']) // Asegúrate que la relación sea "empleado" si así se llama en el modelo
        ->when($search, function ($query, $search) {
            $query->where('numero', 'like', "%{$search}%")
                ->orWhere('fecha', 'like', "%{$search}%")
                ->orWhereHas('cliente', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%");
                })
                ->orWhereHas('empleado', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%");
                });
        })
            ->orderBy('fecha', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]); // para que mantenga el término en la paginación

        return view('facturas_ventas.index', compact('facturas'));
    }


    public function create()
    {
        // Obtener productos con sus detalles relacionados
        $productos = Producto::with('detalleFactura')->get();


        // Obtener clientes reales desde la base de datos
        $clientes = Cliente::orderBy('nombre')->get();

        // Obtener empleados ordenados
        $empleados = Empleado::orderBy('nombre')->get();

        // Lista de formas de pago (siempre fija)
        $formasPago = ['Efectivo', 'Cheque', 'Transferencia'];

        $categorias = Producto::distinct()->pluck('categoria'); // trae todas las categorías únicas



        return view('facturas_ventas.create', compact(
            'productos',
            'clientes',
            'empleados',
            'formasPago', 'categorias'
        ));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'numero' => 'required|unique:facturas_ventas,numero',
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => ['required', 'date', function ($attribute, $value, $fail) {
                $fecha = \Carbon\Carbon::parse($value)->startOfDay();
                $hoy = \Carbon\Carbon::today();

                if (!$fecha->equalTo($hoy)) {
                    $fail('La fecha debe ser la actual.');
                }
            }],
            'forma_pago' => ['required', 'in:Efectivo,Cheque,Transferencia'],
            'responsable_id' => ['required', 'exists:empleados,id'],
            'subtotal' => 'required|numeric|min:0',
            'impuestos' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*.product_id' => 'required|exists:productos,id',
            'productos.*.nombre' => 'required|string',
            'productos.*.categoria' => 'nullable|string',
            'productos.*.precioVenta' => 'required|numeric|min:0',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.iva' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $factura = FacturaVenta::create([
                'numero' => $validatedData['numero'],
                'cliente_id' => $validatedData['cliente_id'],
                'fecha' => $validatedData['fecha'],
                'subtotal' => $validatedData['subtotal'],
                'impuestos' => $validatedData['impuestos'],
                'total' => $validatedData['total'],
            ]);

            foreach ($validatedData['productos'] as $productoData) {
                // Guardar detalle
                DetalleFacturaVenta::create([
                    'factura_venta_id' => $factura->id,
                    'producto_id' => $productoData['product_id'],
                    'nombre' => $productoData['nombre'],
                    'categoria' => $productoData['categoria'] ?? null,
                    'precio_venta' => $productoData['precioVenta'],
                    'cantidad' => $productoData['cantidad'],
                    'iva' => $productoData['iva'],
                    'subtotal' => ($productoData['precioVenta'] * $productoData['cantidad']) * (1 + $productoData['iva'] / 100),
                    'responsable_id' => $validatedData['responsable_id'],
                ]);

                // ✅ Reducir la cantidad del producto
                $producto = Producto::find($productoData['product_id']);
                if ($producto) {
                    $nuevaCantidad = $producto->cantidad - $productoData['cantidad'];

                    // Validación de stock suficiente (opcional pero recomendable)
                    if ($nuevaCantidad < 0) {
                        throw new \Exception("No hay suficiente stock para el producto: {$producto->nombre}");
                    }

                    $producto->cantidad = $nuevaCantidad;
                    $producto->save();
                }
            }

            DB::commit();

            return redirect()->route('facturas_ventas.index')->with('success', 'Factura de venta creada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Al usar $request->validate, para conservar los datos debes hacer return back()->withInput()
            return back()
                ->withErrors(['error' => 'Ocurrió un error al guardar la factura: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show($id)
    {

        $factura = FacturaVenta::with('detalles')->find($id);

        foreach($factura->detalles as $detalle) {
            dd($detalle->iva); // Aquí haces la prueba
        }

        $factura = FacturaVenta::with('cliente', 'detalles.producto', 'empleado')->findOrFail($id);
        return view('facturas_ventas.show', compact('factura'));
    }


    public function edit($id)
    {
        $factura = FacturaVenta::with('detalles')->findOrFail($id);
        $clientes = Cliente::all();
        return view('facturas_ventas.edit', compact('factura', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'numero' => ['required', Rule::unique('facturas_ventas', 'numero')->ignore($id)],
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'impuestos' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*.product_id' => 'required|exists:productos,id',
            'productos.*.nombre' => 'required|string',
            'productos.*.categoria' => 'nullable|string',
            'productos.*.precioVenta' => 'required|numeric|min:0',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.iva' => 'required|numeric|min:0',
            'forma_pago' => ['required', 'in:Efectivo,Cheque,Transferencia'],
            'responsable_id' => ['required', 'exists:empleados,id'],
        ]);

        DB::beginTransaction();
        try {
            $factura = FacturaVenta::findOrFail($id);
            $factura->update([
                'numero' => $validatedData['numero'],
                'cliente_id' => $validatedData['cliente_id'],
                'fecha' => $validatedData['fecha'],
                'subtotal' => $validatedData['subtotal'],
                'impuestos' => $validatedData['impuestos'],
                'total' => $validatedData['total'],
            ]);

            // Eliminar detalles antiguos para reemplazarlos por los nuevos
            $factura->detalles()->delete();

            // Crear nuevos detalles
            foreach ($validatedData['productos'] as $producto) {
                DetalleFacturaVenta::create([
                    'factura_venta_id' => $factura->id,
                    'producto_id' => $producto['product_id'],
                    'responsable_id' => $validatedData['responsable_id'], // ✅ Aquí el fix
                    'nombre' => $producto['nombre'],
                    'categoria' => $producto['categoria'] ?? null,
                    'precio_venta' => $producto['precioVenta'],
                    'cantidad' => $producto['cantidad'],
                    'iva' => $producto['iva'],
                    'subtotal' => ($producto['precioVenta'] * $producto['cantidad']) * (1 + $producto['iva'] / 100),
                ]);
            }


            DB::commit();
            return redirect()->route('facturas_ventas.show', $factura->id)->with('success', 'Factura de venta actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar la factura: ' . $e->getMessage()])->withInput();
        }
    }

}
