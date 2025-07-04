<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Proveedor; // Importar el modelo Proveedor
use App\Models\Empleado;  // Importar el modelo Empleado
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
                foreach ($request->productos as $producto) {
                    // Calcula la base imponible del producto
                    $baseProducto = $producto['precioCompra'] * $producto['cantidad'];
                    // Calcula el IVA del producto
                    $ivaProducto = ($producto['iva'] / 100) * $baseProducto;
                    // Calcula el total del producto
                    $totalProducto = $baseProducto + $ivaProducto;

                    // Acumula los subtotales e impuestos generales
                    $subtotalGeneral += $baseProducto;
                    $impuestosGeneral += $ivaProducto;

                    // Crea un detalle de factura asociado a la factura actual
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
        ]);

        try {
            DB::transaction(function () use ($request, $factura) {
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
                foreach ($request->productos as $producto) {
                    // Calcula la base imponible del producto
                    $baseProducto = $producto['precioCompra'] * $producto['cantidad'];
                    // Calcula el IVA del producto
                    $ivaProducto = ($producto['iva'] / 100) * $baseProducto;
                    // Calcula el total del producto
                    $totalProducto = $baseProducto + $ivaProducto;

                    // Acumula los subtotales e impuestos generales
                    $subtotalGeneral += $baseProducto;
                    $impuestosGeneral += $ivaProducto;

                    // Crea un nuevo detalle de factura asociado a la factura actual
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
