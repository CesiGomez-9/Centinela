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

        $primeraFactura = FacturaVenta::orderBy('fecha', 'asc')->first();
        $fechaMinima = $primeraFactura ? $primeraFactura->fecha : Carbon::now();
        $fechaActual = Carbon::now()->toDateString();
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            if (
                $request->fecha_inicio < $fechaMinima ||
                $request->fecha_fin > $fechaActual
            ) {
                return back()->with('status', 'Solo puedes buscar facturas desde ' .
                    Carbon::parse($fechaMinima)->format('d/m/Y') .
                    ' hasta hoy (' . Carbon::now()->format('d/m/Y') . ').');
            }
        }
        $query = FacturaVenta::with('cliente');

        if ($request->filled('searchInput')) {
            $search = $request->searchInput;

            $query->where(function ($q) use ($search) {
                $q->where('numero', 'like', "%$search%")
                    ->orWhereHas('cliente', function ($subquery) use ($search) {
                        $subquery->where('nombre', 'like', "%$search%");
                    });
            });
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        $facturas = $query->orderBy('fecha', 'asc')->paginate(10);

        return view('facturas_ventas.index', compact('facturas', 'fechaMinima'));
    }


    public function create()
    {

        $productos = Producto::with('impuesto')->get()->unique('id');
        $clientes = Cliente::orderBy('nombre')->get();
        $empleados = Empleado::orderBy('nombre')->get();
        $formasPago = ['Efectivo', 'Cheque', 'Transferencia'];
        $categorias = Producto::distinct()->pluck('categoria');
        $ultimoNumero = FacturaVenta::orderBy('id', 'desc')->value('numero');

        if ($ultimoNumero) {
            $numero = 'F' . str_pad((intval(substr($ultimoNumero, 1)) + 1), 6, '0', STR_PAD_LEFT);
        } else {
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
        $productosValidos = array_filter($validatedData['productos'], function ($item) {
            return is_array($item) && isset($item['producto_id']);
        });

        if (count($productosValidos) === 0) {
            return back()->withErrors(['error' => 'No se recibieron productos válidos.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $ultimoNumero = FacturaVenta::orderBy('id', 'desc')->value('numero');
            if ($ultimoNumero) {
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

            foreach ($productosValidos as $productoData) {
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
        $factura = FacturaVenta::with('cliente', 'detalles.producto', 'empleado')->findOrFail($id);
        $importe_gravado = 0;
        $importe_exento = 0;
        $importe_exonerado = 0;
        $isv_15 = 0;
        $isv_18 = 0;

        foreach ($factura->detalles as $detalle) {
            $subtotal = $detalle->precio_venta * $detalle->cantidad;

            if ($detalle->iva == 15) {
                $isv_15 += $subtotal * 0.15;
                $importe_gravado += $subtotal;
            } elseif ($detalle->iva == 18) {
                $isv_18 += $subtotal * 0.18;
                $importe_gravado += $subtotal;
            } elseif ($detalle->iva == 0) {
                $importe_exento += $subtotal;
            } else {
                $importe_exonerado += $subtotal;
            }
            $detalle->subtotal = $subtotal;
        }

        $subtotal_total = $importe_gravado + $importe_exento + $importe_exonerado;
        $totalF = $subtotal_total + $isv_15 + $isv_18;
        $factura->importe_gravado = $importe_gravado;
        $factura->importe_exento = $importe_exento;
        $factura->importe_exonerado = $importe_exonerado;
        $factura->subtotal = $subtotal_total;
        $factura->isv_15 = $isv_15;
        $factura->isv_18 = $isv_18;
        $factura->totalF = $totalF;

        return view('facturas_ventas.show', compact('factura'));
    }



    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
}
