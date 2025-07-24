<?php
namespace App\Http\Controllers;

use App\Models\DetalleFactura;
use App\Models\FacturaVenta;
use App\Models\DetalleFacturaVenta;
use App\Models\Cliente;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Empleado;


class FacturaVentaController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Validar que las fechas estén dentro del mes y año actual
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $mesActual = Carbon::now()->format('m');
            $anioActual = Carbon::now()->format('Y');

            if (
                Carbon::parse($request->fecha_inicio)->format('Y') !== $anioActual ||
                Carbon::parse($request->fecha_fin)->format('Y') !== $anioActual ||
                Carbon::parse($request->fecha_inicio)->format('m') !== $mesActual ||
                Carbon::parse($request->fecha_fin)->format('m') !== $mesActual
            ) {
                return back()->with('status', 'Solo puedes buscar facturas del mes y año actual.');
            }
        }

        $query = FacturaVenta::query();

        // 🔍 Filtro por texto (número o fecha exacta)
        if ($request->filled('searchInput')) {
            $search = $request->searchInput;
            $query->where('numero', 'like', "%$search%")
                ->orWhereDate('fecha', $search);
        }

        // 📅 Filtros por fechas
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        // 📄 Paginación de resultados
        $facturas = $query->orderByDesc('fecha')->paginate(10);

        return view('facturas_ventas.index', compact('facturas'));
    }


    public function create()
    {

        $productos = Producto::with('ultimoDetalleFactura')->get();

        // Obtener clientes reales desde la base de datos
        $clientes = Cliente::orderBy('nombre')->get();

        // Obtener empleados ordenados
        $empleados = Empleado::orderBy('nombre')->get();

        // Lista de formas de pago (siempre fija)
        $formasPago = ['Efectivo', 'Cheque', 'Transferencia'];

        $categorias = Producto::distinct()->pluck('categoria'); // trae todas las categorías únicas

// Obtener el último número de factura
        $ultimoNumero = FacturaVenta::orderBy('id', 'desc')->value('numero');

        // Extraer el número y sumarle 1
        if ($ultimoNumero) {
            // Suponiendo formato: F000001
            $numero = 'F' . str_pad((intval(substr($ultimoNumero, 1)) + 1), 6, '0', STR_PAD_LEFT);
        } else {
            // Primer número si no hay facturas
            $numero = 'F000001';
        }

        $clienteNombre = '';
        if (old('cliente_id')) {
            $cliente = Cliente::find(old('cliente_id'));
            if ($cliente) {
                $clienteNombre = $cliente->nombre . ' ' . $cliente->apellido;
            }
        }


        return view('facturas_ventas.create', compact(
            'productos',
            'clientes',
            'empleados',
            'formasPago', 'categorias', 'numero', 'clienteNombre'
        ));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
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
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.nombre' => 'required|string',
            'productos.*.categoria' => 'nullable|string',
            'productos.*.precioVenta' => 'required|numeric|min:0',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.iva' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generar número automático:
            $ultimoNumero = FacturaVenta::orderBy('id', 'desc')->value('numero');

            if ($ultimoNumero) {
                // Extraer parte numérica (asumiendo formato "F000001")
                $numeroInt = intval(substr($ultimoNumero, 1)) + 1;
            } else {
                $numeroInt = 1;
            }
            $nuevoNumero = 'F' . str_pad($numeroInt, 6, '0', STR_PAD_LEFT);

            $factura = FacturaVenta::create([
                'numero' => $nuevoNumero,
                'cliente_id' => $validatedData['cliente_id'],
                'fecha' => $validatedData['fecha'],
                'subtotal' => $validatedData['subtotal'],
                'impuestos' => $validatedData['impuestos'],
                'total' => $validatedData['total'],
                'forma_pago' => $validatedData['forma_pago'],
                'responsable_id' => $validatedData['responsable_id'],
            ]);

            foreach ($validatedData['productos'] as $productoData) {
                DetalleFacturaVenta::create([
                    'factura_venta_id' => $factura->id,
                    'producto_id' => $productoData['producto_id'],
                    'nombre' => $productoData['nombre'],
                    'categoria' => $productoData['categoria'] ?? null,
                    'precio_venta' => $productoData['precioVenta'],
                    'cantidad' => $productoData['cantidad'],
                    'iva' => $productoData['iva'],
                    'subtotal' => ($productoData['precioVenta'] * $productoData['cantidad']) * (1 + $productoData['iva'] / 100),
                    'responsable_id' => $validatedData['responsable_id'],
                ]);

                $producto = Producto::find($productoData['producto_id']);
                if ($producto) {
                    $nuevaCantidad = $producto->cantidad - $productoData['cantidad'];
                    if ($nuevaCantidad < 0) {
                        throw new \Exception("No hay suficiente stock para el producto: {$producto->nombre}");
                    }
                    $producto->cantidad = $nuevaCantidad;
                    $producto->save();
                }
            }

            DB::commit();

            return redirect()->route('facturas_ventas.index')->with('success', 'Factura de venta creada correctamente con número ' . $nuevoNumero);

        } catch (\Exception $e) {
            DB::rollBack();
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
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'impuestos' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:producto_id',
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
                    'producto_id' => $producto['producto_id'],
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
