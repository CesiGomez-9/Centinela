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
        $nombresPorCategoria = [
            'Cámaras de seguridad' => [
                'Cámara IP Full HD', 'Cámara Bullet 4K', 'Cámara domo PTZ',
                'Cámara térmica portátil', 'Cámara con visión nocturna'
            ],
            'Alarmas antirrobo' => [
                'Alarma inalámbrica', 'Alarma con sirena', 'Alarma de puerta y ventana',
                'Sistema de alarma GSM', 'Alarma con detector de humo'
            ],
            'Cerraduras inteligentes' => [
                'Cerradura biométrica', 'Cerradura con teclado', 'Cerradura Bluetooth',
                'Cerradura con control remoto', 'Cerradura electrónica para puertas'
            ],
            'Sensores de movimiento' => [
                'Sensor PIR inalámbrico', 'Sensor de movimiento con cámara',
                'Sensor de movimiento para interiores', 'Sensor de movimiento con alarma',
                'Sensor doble tecnología'
            ],
            'Luces con sensor de movimiento' => [
                'Luz LED con sensor', 'Luz solar con sensor', 'Foco exterior con sensor',
                'Luz para jardín con sensor', 'Lámpara de seguridad con sensor'
            ],
            'Rejas o puertas de seguridad' => [
                'Reja metálica reforzada', 'Puerta de seguridad con cerradura',
                'Reja plegable de acero', 'Puerta blindada residencial', 'Reja corrediza automática'
            ],
            'Sistema de monitoreo 24/7' => [
                'Sistema CCTV avanzado', 'Monitoreo remoto por app',
                'Servicio de vigilancia en tiempo real', 'Sistema con alertas SMS',
                'Monitoreo con sensores integrados'
            ],
            'Implementos de seguridad' => [
                'Chaleco antibalas', 'Casco de seguridad', 'Guantes tácticos',
                'Botas reforzadas', 'Radio comunicador portátil'
            ],
        ];

        return view('facturas.formulario', compact('nombresPorCategoria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_factura' => [
                'required',
                'min:3',
                'max:15',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/',
                Rule::unique('facturas', 'numero_factura')
            ],
            'fecha' => ['required', 'date', 'after_or_equal:2000-01-01', 'before_or_equal:2099-12-31' ],
            'proveedor' => ['required', 'min:3', 'max:30', 'regex:/^[\pL0-9\s\-.,#]+$/u', 'regex:/.*\S.*/'],
            'forma_pago' => ['required', 'in:Efectivo,Cheque,Transferencia'],
            'responsable' => ['required', 'string', 'min:3', 'max:30', 'regex:/^[\pL0-9\s\-.,#]+$/u', 'regex:/.*\S.*/'],

            'productos' => ['required', 'array', 'min:1'],
            'productos.*.nombre' => ['required', 'string', 'max:100'],
            'productos.*.categoria' => ['nullable', 'string', 'max:50'],
            'productos.*.precioCompra' => [
                'required',
                'numeric',
                'min:0',
                'max:9999'
            ],
            'productos.*.precioVenta' => [
                'required',
                'numeric',
                'min:0',
                'max:9999'
            ],
            'productos.*.cantidad' => [
                'required',
                'integer',
                'min:1',
                'max:999' // Hasta 3 dígitos
            ],

            'productos.*.iva' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            $impuestos = 0;

            $factura = Factura::create([
                'numero_factura' => $request->numero_factura,
                'fecha' => $request->fecha,
                'proveedor' => $request->proveedor,
                'forma_pago' => $request->forma_pago,
                'responsable' => $request->responsable,
                'subtotal' => 0,
                'impuestos' => 0,
                'totalF' => 0,
            ]);

            foreach ($request->productos as $producto) {
                $precioCompra = $producto['precioCompra'];
                $cantidad = $producto['cantidad'];
                $iva = $producto['iva'] ?? 0;

                $base = $precioCompra * $cantidad;
                $ivaCalculado = ($iva / 100) * $base;
                $totalProducto = $base + $ivaCalculado;

                $subtotal += $base;
                $impuestos += $ivaCalculado;

                $factura->detalles()->create([
                    'producto' => $producto['nombre'],
                    'categoria' => $producto['categoria'] ?? '',
                    'precioCompra' => $precioCompra,
                    'precioVenta' => $producto['precioCompra'],
                    'cantidad' => $cantidad,
                    'iva' => $iva,
                    'total' => $totalProducto,
                ]);
            }

            $totalFinal = $subtotal + $impuestos;

            $factura->update([
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'totalF' => $totalFinal,
            ]);
        });

        return redirect()->route('facturas.index')->with('status', 'Factura registrada correctamente');

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
