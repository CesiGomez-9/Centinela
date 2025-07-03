<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; // Importar la fachada Auth

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
        // No necesitamos pasar el responsable aquí, ya que se obtiene directamente en la vista con Auth::user()

        return view('facturas.formulario', compact('proveedores', 'formasPago'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // *** VALIDACIÓN (DESCOMENTAR CUANDO LA DEPURACIÓN HAYA TERMINADO) ***
        $validated = $request->validate([
            'numero_factura' => [
                'required', 'min:3', 'max:15',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/',
                Rule::unique('facturas', 'numero_factura')
            ],
            'fecha' => ['required', 'date', 'after_or_equal:2025-01-01', 'before_or_equal:2099-12-31'],
            'proveedor' => ['required', 'min:3', 'max:30', 'regex:/^[\pL0-9\s\-.,#]+$/u', 'regex:/.*\S.*/'],
            'forma_pago' => ['required', 'in:Efectivo,Cheque,Transferencia'],
            // Validar responsable_id en lugar de responsable (ya que es el ID del usuario)
            'responsable_id' => ['required', 'integer', 'exists:empleados,id'], // Asumiendo que el ID existe en la tabla 'users'
            'productos' => ['required', 'array', 'min:1'],
            'productos.*.nombre' => ['required', 'string', 'max:100'],
            'productos.*.categoria' => ['nullable', 'string', 'max:50'],
            'productos.*.precioCompra' => ['required', 'numeric', 'min:0', 'max:9999'],
            'productos.*.precioVenta' => ['required', 'numeric', 'min:0', 'max:9999'],
            'productos.*.cantidad' => ['required', 'integer', 'min:1', 'max:999'],
            'productos.*.iva' => ['nullable', 'numeric', 'min:0'],
        ]);

        try {
            DB::transaction(function () use ($request) {
                $subtotalGeneral = 0;
                $impuestosGeneral = 0;

                $factura = Factura::create([
                    'numero_factura' => $request->numero_factura,
                    'fecha' => $request->fecha,
                    'proveedor' => $request->proveedor,
                    'forma_pago' => $request->forma_pago,
                    'responsable' => $request->responsable_id, // Almacenar el ID del responsable
                    'subtotal' => 0,
                    'impuestos' => 0,
                    'totalF' => 0,
                ]);

                foreach ($request->productos as $producto) {
                    // Usar camelCase para acceder a las propiedades del array $producto
                    $baseProducto = $producto['precioCompra'] * $producto['cantidad'];
                    $ivaProducto = ($producto['iva'] / 100) * $baseProducto;
                    $totalProducto = $baseProducto + $ivaProducto;

                    $subtotalGeneral += $baseProducto;
                    $impuestosGeneral += $ivaProducto;

                    $factura->detalles()->create([
                        'producto' => $producto['nombre'],
                        'categoria' => $producto['categoria'],
                        'precio_compra' => $producto['precioCompra'],
                        'precio_venta' => $producto['precioVenta'],
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

            return redirect()->route('facturas.index')->with('status', 'Factura registrada correctamente');

        } catch (\Throwable $e) {
            // En producción, aquí deberías registrar el error y mostrar un mensaje genérico.
            // Para depuración local, puedes usar dd($e->getMessage()); o logear.
            // dd($e->getMessage(), $e->getTraceAsString()); // Para depuración
            return back()->withInput()->withErrors(['general' => 'Ocurrió un error al guardar la factura. Por favor, inténtelo de nuevo.']);
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

        // *** VALIDACIÓN (DESCOMENTAR CUANDO LA DEPURACIÓN HAYA TERMINADO) ***
        $validated = $request->validate([
            'numero_factura' => [
                'required', 'min:3', 'max:15',
                'regex:/^[A-Za-z0-9\-]+$/',
                'regex:/.*\S.*/',
                Rule::unique('facturas', 'numero_factura')->ignore($factura->id)
            ],
            'fecha' => ['required', 'date', 'after_or_equal:2025-01-01', 'before_or_equal:2099-12-31'],
            'proveedor' => ['required', 'min:3', 'max:30', 'regex:/^[\pL0-9\s\-.,#]+$/u', 'regex:/.*\S.*/'],
            'forma_pago' => ['required', 'in:Efectivo,Cheque,Transferencia'],
            // Validar responsable_id en lugar de responsable
            'responsable_id' => ['required', 'integer', 'exists:users,id'],
            'productos' => ['required', 'array', 'min:1'],
            'productos.*.nombre' => ['required', 'string', 'max:100'],
            'productos.*.categoria' => ['nullable', 'string', 'max:50'],
            'productos.*.precioCompra' => ['required', 'numeric', 'min:0', 'max:9999'],
            'productos.*.precioVenta' => ['required', 'numeric', 'min:0', 'max:9999'],
            'productos.*.cantidad' => ['required', 'integer', 'min:1', 'max:999'],
            'productos.*.iva' => ['nullable', 'numeric', 'min:0'],
        ]);

        try {
            DB::transaction(function () use ($request, $factura) {
                // Update main invoice fields
                $factura->update([
                    'numero_factura' => $request->numero_factura,
                    'fecha' => $request->fecha,
                    'proveedor' => $request->proveedor,
                    'forma_pago' => $request->forma_pago,
                    'responsable' => $request->responsable_id, // Almacenar el ID del responsable
                ]);

                // Sync invoice details
                $factura->detalles()->delete();

                $subtotalGeneral = 0;
                $impuestosGeneral = 0;

                foreach ($request->productos as $producto) {
                    // Usar camelCase para acceder a las propiedades del array $producto
                    $baseProducto = $producto['precioCompra'] * $producto['cantidad'];
                    $ivaProducto = ($producto['iva'] / 100) * $baseProducto;
                    $totalProducto = $baseProducto + $ivaProducto;

                    $subtotalGeneral += $baseProducto;
                    $impuestosGeneral += $ivaProducto;

                    $factura->detalles()->create([
                        'producto' => $producto['nombre'],
                        'categoria' => $producto['categoria'],
                        'precio_compra' => $producto['precioCompra'],
                        'precio_venta' => $producto['precioVenta'],
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
            // En producción, aquí deberías registrar el error y mostrar un mensaje genérico.
            // dd($e->getMessage(), $e->getTraceAsString()); // Para depuración
            return back()->withInput()->withErrors(['general' => 'Ocurrió un error al actualizar la factura. Por favor, inténtelo de nuevo.']);
        }
    }
}

