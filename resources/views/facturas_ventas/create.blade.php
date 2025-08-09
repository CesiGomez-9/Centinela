<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturas de Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body style="background-color: #e6f0ff;">
<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('seguridad/logo.jpg') }}" style="height:80px; margin-right: 10px;">
            Grupo Centinela
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="#">Registrate</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Servicios</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Nosotros</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<style>
    body { background-color: #e6f0ff; margin: 0; }
    .error-message { color: #dc3545; font-size: 0.875em; margin-top: 0.25rem; display: none; }
    .field-error, .form-control.invalid { border-color: #dc3545; }
    #tablaFacturaBody td { color: black !important; font-size: 1rem !important; background-color: #ffffff !important; min-width: 50px; padding: 8px; }
    #tablaFacturaBody td input[type="hidden"] + * { margin-left: 5px; }
    .modal:not(.show), .modal-backdrop:not(.show) { display: none !important; opacity: 0 !important; }


     body {
         font-family: 'Inter', sans-serif;
         background: url('https://www.transparenttextures.com/patterns/beige-paper.png') repeat fixed #f8f4ec;
         font-size: 16px;
     }

    .card {
        border: none;
        border-radius: 1.25rem;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        background: #ffffff;
        min-height: 400px;
        max-width: 100%;
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: scale(1.01);
    }

    .card-header {
        background-color: #0d1b2a;
        padding: 1.75rem 1.75rem;
        border-bottom: 4px solid #cda34f;
    }

    .card-header h5 {
        color: #ffffff;
        font-weight: 700;
        font-size: 1.4rem;
    }

    .card-header small {
        color: #f0e6d2;
        color: #e0e0e0;
        font-size: 0.9rem;
    }

    .card-body {
        padding: 2.25rem 1.75rem;
        font-size: 1rem;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .card-body p {
        margin-bottom: 1.3rem;
        border-left: 4px solid #cda34f;
        padding-left: 0.75rem;
    }

    .card-body i {
        color: #1b263b;
    }

    .card-body strong {
        color: #0d1b2a;
        font-weight: 600;
    }

    .card-footer {
        background-color: #1b263b;
        padding: 0.9rem 1.5rem;
        border-top: 1px solid #cda34f;
        font-size: 0.9rem;
    }

    .card-footer small {
        color: #f5f5f5;
        color: #dcdcdc;
    }

    .btn-return {
        background-color: #cda34f;
        color: #ffffff;
        border: none;
        padding: 0.7rem 1.6rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        font-size: 1rem;
        margin: 0 0.5rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-return:hover, .btn-return:focus {
        background-color: #0d1b2a;
        color: #ffffff;
        text-decoration: none;
    }

    @media (max-width: 767.98px) {
        .card-body {
            padding: 1.75rem 1rem;
            font-size: 0.95rem;
        }

        .btn-return {
            display: block;
            width: 100%;
            margin: 0.5rem 0;
            font-size: 1.05rem;
        }
    }

    .section-header {
        margin-top: 2rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #cda34f;
        color: #0d1b2a;
        font-weight: 700;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-white p-5 rounded shadow-lg position-relative">
                <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                    <i class="bi bi-cash-coin" style="font-size: 4rem;"></i>
                </div>
                <h3 class="text-center mb-4" style="color: #09457f;">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    Registrar nueva factura de venta
                </h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" id="formFacturaVenta" action="{{ route('facturas_ventas.store') }}" novalidate>
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="numero" class="form-label">Número de Factura</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                <input type="text" name="numero" id="numero"
                                       class="form-control @error('numero') is-invalid @enderror"
                                       value="{{ old('numero', $numero) }}"
                                       maxlength="12" readonly />
                            </div>
                            @error('numero')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                <span class="form-control">{{ date('d-m-Y') }}</span>
                                <input type="hidden" name="fecha" value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="searchInput" class="form-label">Cliente</label>
                            <div class="input-group has-validation mb-2">
                                <input
                                    type="text"
                                    id="searchInput"
                                    class="form-control @error('cliente_id') is-invalid @enderror"
                                    placeholder="Buscar cliente por nombre"
                                    autocomplete="off"
                                    value="{{ old('cliente_id') ? $clienteNombre : '' }}"
                                >
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <div class="invalid-feedback" id="error_cliente_id">
                                    @error('cliente_id'){{ $message }}@else Debe seleccionar un cliente. @enderror
                                </div>
                            </div>
                            <div id="searchResults" class="list-group" style="max-height: 200px; overflow-y: auto;"></div>
                            <input type="hidden" name="cliente_id" id="cliente_id" value="{{ old('cliente_id') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="formaPago" class="form-label">Forma de Pago</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-wallet-fill"></i></span>
                                <select name="forma_pago" id="formaPago"
                                        class="form-select @error('forma_pago') is-invalid @enderror" required>
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($formasPago as $forma)
                                        <option value="{{ $forma }}" {{ (old('forma_pago', isset($factura) ? $factura->forma_pago : '') === $forma) ? 'selected' : '' }}>
                                            {{ $forma }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-danger mt-1 small error-mensaje-js"></div>
                            <div id="error_forma_pago" class="text-danger small mt-1">
                                @error('forma_pago'){{ $message }}@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex justify-content-start mb-4 mt-3">
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#productosModal">
                                <i class="bi bi-search"></i> Buscar Productos
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center" id="tablaFactura">
                            <thead class="table-light small">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Precio Venta (Lps)</th>
                                <th>Cantidad</th>
                                <th>IVA %</th>
                                <th>Subtotal</th>
                                <th>Eliminar</th>
                            </tr>
                            </thead>
                            <tbody id="tablaFacturaBody">
                            <tr id="filaVacia">
                                <td colspan="8" class="text-center text-muted py-4" style="border: 1px dashed #dee2e6; background-color: #f8f9fa;">
                                    <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i><br />
                                    <span >No hay productos agregados</span><br />
                                    <small>Use el botón "Buscar Productos" para agregarlos</small>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div id="errorProductos" class="text-danger small mt-2 d-none">
                            Debe agregar al menos un producto a la factura.
                        </div>
                    </div>
                    <div class="row mt-4 justify-content-end">
                        <div class="col-md-6 col-lg-4">
                            <div class="row g-1">
                                <div class="col-8 text-start"><label class="form-label mb-0">Importe Gravado (Lps)</label></div>
                                <div class="col-4 text-end"><label class="form-control summary-value-box" id="importeGravadoLabel">0.00</label></div>

                                <div class="col-8 text-start"><label class="form-label mb-0">Importe Exento (Lps)</label></div>
                                <div class="col-4 text-end"><label class="form-control summary-value-box" id="importeExentoLabel">0.00</label></div>

                                <div class="col-8 text-start"><label class="form-label mb-0">ISV 15% (Lps)</label></div>
                                <div class="col-4 text-end"><label class="form-control summary-value-box" id="isv15Label">0.00</label></div>

                                <div class="col-8 text-start"><label class="form-label mb-0">ISV 18% (Lps)</label></div>
                                <div class="col-4 text-end"><label class="form-control summary-value-box" id="isv18Label">0.00</label></div>

                                <div class="col-8 text-start fw-bold"><label class="form-label mb-0">Subtotal</label></div>
                                <div class="col-4 text-end fw-bold"><label class="form-control" id="subtotalGeneralLabel">0.00</label></div>

                                <div class="col-8 text-start fw-bold"><label class="form-label mb-0">Total</label></div>
                                <div class="col-4 text-end fw-bold"><label class="form-control" id="totalGeneralLabel">0.00</label></div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="subtotal" id="inputSubtotalGeneral">
                    <input type="hidden" name="impuestos" id="inputImpuestosGeneral">
                    <input type="hidden" name="total" id="inputTotalGeneral">

                    <div class="col-md-6">
                        <label for="responsable_id" class="form-label">Responsable</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-check-fill"></i></span>
                            <select name="responsable_id" id="responsable_id"
                                    class="form-select @error('responsable_id') is-invalid @enderror" required>
                                <option value="">Seleccione un empleado</option>
                                @foreach ($empleados as $empleado)
                                    <option value="{{ $empleado->id }}" {{ (old('responsable_id', isset($factura) ? $factura->responsable_id : '') == $empleado->id) ? 'selected' : '' }}>
                                        {{ $empleado->nombre }} {{ $empleado->apellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-danger mt-1 small error-mensaje-js"></div>
                        <div id="error_responsable_id" class="text-danger small mt-1">
                            @error('responsable_id'){{ $message }}@enderror
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <a href="{{ route('facturas_ventas.index') }}" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                        <button type="reset" class="btn btn-warning me-2">
                            <i class="bi bi-eraser-fill me-2"></i>Limpiar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar Factura
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #003366; color: white;">
                <h5 class="modal-title" id="productosModalLabel"><i class="bi bi-box-seam"></i> Lista de productos</h5>
            </div>
            <div class="modal-body">
                <div class="row mb-3 align-items-end">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="searchProductoInput" class="form-control" placeholder="Buscar producto por nombre...">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <label class="input-group-text" for="categoriaFiltro"><i class="bi bi-funnel-fill"></i></label>
                            <select id="categoriaFiltro" class="form-select">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria }}">{{ $categoria }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div id="mensajeCoincidencias" class="text-muted mt-2" style="font-size: 14px;"></div>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered table-hover text-center" id="tablaProductos">
                        <thead class="table-light sticky-top">
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio (Lps)</th>
                            <th>Cantidad Disponible</th>
                            <th>IVA %</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody id="tablaProductosBody">

                        @foreach ($productos as $producto)
                            @php
                                $detalle = $producto->ultimoDetalleFactura;
                                $precioVenta = $detalle ? number_format($detalle->precio_venta, 2, '.', '') : '0.00';
                                $cantidad = $detalle ? $detalle->cantidad : 'N/A';
                                $iva = $detalle ? $detalle->iva : 0;
                            @endphp
                            <tr>
                            <tr data-id="{{ $producto->id }}">
                            <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->categoria }}</td>
                                <td>{{ number_format($producto->precio_venta, 2) }}</td>
                                <td class="celda-cantidad">{{ $producto->cantidad }}</td>
                                <td>{{ $producto->impuesto ? $producto->impuesto->porcentaje . '%' : 'N/A' }}</td>
                                <td>
                                    <div class="d-flex gap-2 align-items-center">
                                        <button type="button" class="btn btn-sm btn-info btnSeleccionarProducto d-inline-flex align-items-center"
                                                data-id="{{ $producto->id }}"
                                                data-nombre="{{ $producto->nombre }}"
                                                data-categoria="{{ $producto->categoria }}"
                                                data-precioventa="{{ $producto->precio_venta }}"
                                                data-iva="{{ $producto->impuesto->porcentaje ?? 0 }}"
                                                data-cantidad="{{ $producto->cantidad }}">
                                            <i class="bi bi-check-circle me-1"></i>
                                            <span>Seleccionar</span>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-primary d-flex align-items-center btnVerDetalleProducto"
                                                data-nombre="{{ $producto->nombre }}"
                                                data-categoria="{{ $producto->categoria }}"
                                                data-precio="{{ number_format($producto->precio_venta, 2) }}"
                                                data-iva="{{ $producto->impuesto->porcentaje ?? '0' }}"
                                                data-cantidad="{{ $producto->cantidad }}"
                                                data-descripcion="{{ $producto->descripcion ?? 'Sin descripción disponible' }}">
                                            <i class="bi bi-eye me-1"></i> <span>Detalle</span>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <small id="alertaProductoDuplicado" class="text-danger d-none"></small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detalleProductoModal" tabindex="-1" aria-labelledby="detalleProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 p-0 bg-transparent">
            <div class="card w-100">
                <div class="card-header">
                    <h5 class="modal-title ">Detalle del Producto</h5>
                    <small class="text-light ms-1" style="opacity: 0.8;">Información completa del producto seleccionado</small>
                </div>
                <div class="card-body">
                    <h3 id="detalleProductoNombre" class="mb-4 fw-bold text-center" style="color: #003366;"></h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="bi bi-tags-fill me-2"></i>Categoría:</strong> <span id="detalleProductoCategoria"></span></p>
                            <p><strong><i class="bi bi-cash-coin me-2"></i>Precio:</strong> Lps. <span id="detalleProductoPrecio"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="bi bi-percent me-2"></i>IVA:</strong> <span id="detalleProductoIVA"></span>%</p>
                            <p><strong><i class="bi bi-box-seam me-2"></i>Cantidad Disponible:</strong> <span id="detalleProductoCantidad"></span></p>
                        </div>
                    </div>
                    <div class="mt-1">
                        <hr class="mb-2 mt-2">
                        <p class="mb-1 fw-semibold"><i class="bi bi-file-text-fill me-2"></i>Descripción:</p>
                        <p id="detalleProductoDescripcion" class="text-bold mb-0" style="line-height: 1.6;"></p>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="button" class="btn-return" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left me-2"></i>Volver
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // ------------------ Buscar los clientes ------------------
        const inputCliente = document.getElementById('searchInput');
        const resultsContainer = document.getElementById('searchResults');
        const clienteIdInput = document.getElementById('cliente_id');

        const soloLetras = (input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            });
        };

        const searchCliente = document.getElementById("searchInput");
        const searchProducto = document.getElementById("searchProductoInput");

        if (searchCliente) soloLetras(searchCliente);

        const tabla = document.getElementById('tablaProductosBody');

        if (tabla) {
            tabla.addEventListener('click', function (e) {
                const btn = e.target.closest('.btnVerDetalleProducto');
                if (btn) {
                    const nombre = btn.getAttribute('data-nombre');
                    const categoria = btn.getAttribute('data-categoria');
                    const precio = btn.getAttribute('data-precio');
                    const iva = btn.getAttribute('data-iva');
                    const cantidad = btn.getAttribute('data-cantidad');
                    const descripcion = btn.getAttribute('data-descripcion');

                    //------------- Rellenar campos del modal-----------//
                    document.getElementById('detalleProductoNombre').textContent = nombre;
                    document.getElementById('detalleProductoCategoria').textContent = categoria;
                    document.getElementById('detalleProductoPrecio').textContent = precio;
                    document.getElementById('detalleProductoIVA').textContent = iva;
                    document.getElementById('detalleProductoCantidad').textContent = cantidad;
                    document.getElementById('detalleProductoDescripcion').textContent = descripcion;

                    // ------------------Mostrar el modal---------//
                    const modal = new bootstrap.Modal(document.getElementById('detalleProductoModal'));
                    modal.show();
                }
            });
        }

        inputCliente.addEventListener('input', function () {
            const query = inputCliente.value.trim();
            if (query.length >= 1) {
                fetch(`/clientes/buscar?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(clientes => {
                        resultsContainer.innerHTML = '';
                        if (clientes.length === 0) {
                            resultsContainer.innerHTML = '<div class="list-group-item text-muted">Sin resultados</div>';
                            return;
                        }
                        clientes.forEach(cliente => {
                            const item = document.createElement('button');
                            item.type = 'button';
                            item.classList.add('list-group-item', 'list-group-item-action');
                            item.textContent = `${cliente.nombre} ${cliente.apellido} - ${cliente.identidad}`;
                            item.dataset.id = cliente.id;
                            item.addEventListener('click', () => {
                                inputCliente.value = `${cliente.nombre} ${cliente.apellido}`;
                                clienteIdInput.value = cliente.id;
                                resultsContainer.innerHTML = '';
                                inputCliente.classList.remove('is-invalid');
                                document.getElementById('error_cliente_id')?.classList.add('d-none');
                            });
                            resultsContainer.appendChild(item);
                        });
                    });
            } else {
                resultsContainer.innerHTML = '';
            }
        });

        // ------------------ Modal de los productos ------------------//
        const productosModalEl = document.getElementById('productosModal');
        const productosModal = bootstrap.Modal.getOrCreateInstance(productosModalEl);
        productosModalEl.addEventListener('hidden.bs.modal', function () {
            inputBuscar.value = '';
            selectCategoria.value = '';
            filtrarProductos();

            const filaCantidad = document.querySelector('.fila-cantidad');
            if (filaCantidad) filaCantidad.remove();

            document.querySelectorAll('.btnSeleccionarProducto').forEach(btn => {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-info');
                btn.querySelector('span').textContent = 'Seleccionar';
            });
            mensaje.textContent = '';
        });

        const tablaProductosBody = document.getElementById('tablaProductosBody');
        const formCantidadContainer = document.getElementById('formCantidadContainer');
        const tablaFactura = document.getElementById('tablaFacturaBody');

        let productoSeleccionado = null;

        tablaProductosBody.addEventListener('click', function (e) {
            const btn = e.target.closest('.btnSeleccionarProducto');
            if (!btn) return;

            const filaCantidadExistente = document.querySelector('.fila-cantidad');
            if (filaCantidadExistente) filaCantidadExistente.remove();

            document.querySelectorAll('.btnSeleccionarProducto').forEach(b => {
                b.classList.remove('btn-success');
                b.classList.add('btn-info');
                b.querySelector('span').textContent = 'Seleccionar';
            });

            btn.classList.remove('btn-info');
            btn.classList.add('btn-success');
            btn.querySelector('span').textContent = 'Seleccionado';

            productoSeleccionado = {
                id: btn.dataset.id,
                nombre: btn.dataset.nombre,
                categoria: btn.dataset.categoria,
                precioVenta: btn.dataset.precioventa,
                iva: btn.dataset.iva,
                cantidadDisponible: parseInt(btn.dataset.cantidad) || 0
            };

            const filaProducto = btn.closest('tr');
            const filaCantidad = document.createElement('tr');
            filaCantidad.classList.add('fila-cantidad');

            filaCantidad.innerHTML = `
    <td colspan="6">
       <div class="d-flex flex-column align-items-center justify-content-center gap-1">
    <div class="d-flex gap-2 align-items-center justify-content-center">
        <label class="me-2">Cantidad:</label>
        <input
            type="number"
            min="1"
            max="${productoSeleccionado.cantidadDisponible}"
           step="1"
           class="form-control w-auto cantidad-input"
            required
             placeholder="Ej. 1"
        >
        <button class="btn btn-primary btn-sm btnAgregarCantidad">
            <i class="bi bi-plus-circle"></i> Agregar
        </button>
        <button class="btn btn-warning btn-sm btnCancelarCantidad">
            <i class="bi bi-x-circle"></i> Limpiar
        </button>
        <div class="error-message text-danger ms-2"></div>
    </div>
<small class="text-muted">Cantidad disponible: ${productoSeleccionado.cantidadDisponible}</small>
</div>

    </td>
`;
            filaProducto.parentNode.insertBefore(filaCantidad, filaProducto.nextSibling);
        });

        tablaProductosBody.addEventListener('click', function (e) {
            if (e.target.closest('.btnAgregarCantidad')) {
                e.preventDefault();
                const filaCantidad = e.target.closest('tr');
                const input = filaCantidad.querySelector('.cantidad-input');
                const cantidad = parseInt(input.value);
                const errorDiv = filaCantidad.querySelector('.error-message');

                if (!cantidad || cantidad < 1 || cantidad > productoSeleccionado.cantidadDisponible) {
                    errorDiv.textContent = `Ingrese una cantidad válida (1 - ${productoSeleccionado.cantidadDisponible}).`;
                    input.classList.add('is-invalid');
                    return;
                }

                input.classList.remove('is-invalid');
                errorDiv.textContent = '';

                if (typeof agregarProductoAFactura === 'function') {
                    const agregado = agregarProductoAFactura(productoSeleccionado, cantidad);
                    if (agregado) {
                        filaCantidad.remove();

                        const btnSeleccionado = document.querySelector(`.btnSeleccionarProducto[data-id="${productoSeleccionado.id}"]`);
                        if (btnSeleccionado) {
                            btnSeleccionado.classList.remove('btn-success');
                            btnSeleccionado.classList.add('btn-info');
                            btnSeleccionado.querySelector('span').textContent = 'Seleccionar';
                        }

                        productoSeleccionado = null;
                        bootstrap.Modal.getInstance(document.getElementById('productosModal'))?.hide();
                    } else {
                        errorDiv.textContent = 'No se pudo agregar el producto a la factura.';
                    }
                }
            }

            if (e.target.closest('.btnCancelarCantidad')) {
                e.preventDefault();
                const filaCantidad = e.target.closest('tr');
                filaCantidad.remove();

                if (productoSeleccionado) {
                    const btn = document.querySelector(`.btnSeleccionarProducto[data-id="${productoSeleccionado.id}"]`);
                    if (btn) {
                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-info');
                        btn.querySelector('span').textContent = 'Seleccionar';
                    }
                }

                productoSeleccionado = null;
            }
        });

        // ------------------ Busqueda por categoria ------------------//
        const inputBuscar = document.getElementById('searchProductoInput');
        const selectCategoria = document.getElementById('categoriaFiltro');
        const mensaje = document.getElementById('mensajeCoincidencias');

        function filtrarProductos() {
            const texto = inputBuscar.value.toLowerCase().trim();
            const categoria = selectCategoria.value.toLowerCase();

            let coincidencias = 0;
            const filas = document.querySelectorAll('#tablaProductosBody tr:not(.fila-cantidad)');

            filas.forEach(fila => {
                const nombre = fila.cells[0]?.textContent.toLowerCase() || '';
                const cat = fila.cells[1]?.textContent.toLowerCase() || '';
                const coincideTexto = nombre.includes(texto);
                const coincideCategoria = categoria === '' || cat === categoria;
                const mostrar = coincideTexto && coincideCategoria;
                fila.style.display = mostrar ? '' : 'none';
                const siguienteFila = fila.nextElementSibling;
                if (siguienteFila && siguienteFila.classList.contains('fila-cantidad')) {
                    siguienteFila.style.display = mostrar ? '' : 'none';
                }

                if (mostrar) coincidencias++;
            });
            mensaje.textContent = coincidencias === 0
                ? 'No se encontraron productos.'
                : `Se encontraron ${coincidencias} producto(s).`;
        }
        inputBuscar?.addEventListener('input', filtrarProductos);
        selectCategoria?.addEventListener('change', filtrarProductos);

        // ------------------ Limpiar el formulario ------------------//
        const btnLimpiar = document.querySelector('button[type="reset"]');
        if (btnLimpiar) {
            btnLimpiar.addEventListener('click', function () {
                setTimeout(() => {
                    const form = document.getElementById('formFacturaVenta');

                    form.querySelectorAll('.is-invalid, .is-valid').forEach(el => el.classList.remove('is-invalid', 'is-valid'));
                    document.querySelectorAll('.text-danger, .invalid-feedback, .error-mensaje-js').forEach(el => {
                        el.textContent = '';
                        el.classList.add('d-none');
                    });

                    document.querySelectorAll('.alert.alert-danger').forEach(el => el.remove());

                    if (tablaFactura) {
                        tablaFactura.innerHTML = '';
                        actualizarFilaVacia();
                    }

                    const idsTotales = [
                        'importeGravadoLabel', 'importeExentoLabel', 'isv15Label', 'isv18Label',
                        'subtotalGeneralLabel', 'totalGeneralLabel',
                        'inputSubtotalGeneral', 'inputImpuestosGeneral', 'inputTotalGeneral'
                    ];
                    idsTotales.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.tagName === 'INPUT' ? el.value = '0.00' : el.textContent = '0.00';
                    });
                    document.getElementById('formaPago').value = '';
                    document.getElementById('responsable_id').value = '';
                    if (typeof $ !== 'undefined') {
                        $('#formaPago').trigger('change');
                        $('#responsable_id').trigger('change');
                    }

                    inputCliente.value = '';
                    clienteIdInput.value = '';
                    document.getElementById('searchResults').innerHTML = '';
                    document.getElementById('error_cliente_id')?.classList.add('d-none');
                    document.getElementById('errorProductos')?.classList.add('d-none');

                    form.classList.remove('was-validated');
                }, 50);
            });
        }
        // ------------------ Validacion final ------------------//
        const form = document.getElementById('formFacturaVenta');
        const btnGuardar = form.querySelector('button[type="submit"]');
        const errorProductos = document.getElementById('errorProductos');

        form.addEventListener('submit', function (e) {
            console.log('Intentando enviar formulario');

            let errores = false;
            const inputCliente = document.getElementById('searchInput');
            const clienteIdInput = document.getElementById('cliente_id');
            const productos = document.querySelectorAll('#tablaFacturaBody tr:not(#filaVacia)');
            if (productos.length === 0) {
                errorProductos.textContent = 'Debe seleccionar al menos un producto antes de guardar.';
                errorProductos.classList.remove('d-none');
                errores = true;
            } else {
                errorProductos.classList.add('d-none');
                errorProductos.textContent = '';
            }
            const errorClienteId = document.getElementById('error_cliente_id');
            if (!inputCliente.value.trim() || !clienteIdInput.value.trim()) {
                inputCliente.classList.add('is-invalid');
                errorClienteId.classList.remove('d-none');
                errorClienteId.textContent = 'Debe seleccionar un cliente.';
                errores = true;
            } else {
                inputCliente.classList.remove('is-invalid');
                errorClienteId.classList.add('d-none');
                errorClienteId.textContent = '';
            }
            const formaPago = document.getElementById('formaPago');
            const errorFormaPago = document.getElementById('error_forma_pago');
            if (!formaPago.value) {
                formaPago.classList.add('is-invalid');
                errorFormaPago.textContent = 'Debe seleccionar una forma de pago.';
                errorFormaPago.classList.remove('d-none');
                errores = true;
            } else {
                formaPago.classList.remove('is-invalid');
                errorFormaPago.textContent = '';
                errorFormaPago.classList.add('d-none');
            }
            const responsable = document.getElementById('responsable_id');
            const errorResponsable = document.getElementById('error_responsable_id');
            if (!responsable.value) {
                responsable.classList.add('is-invalid');
                errorResponsable.textContent = 'Debe seleccionar un responsable.';
                errorResponsable.classList.remove('d-none');
                errores = true;
            } else {
                responsable.classList.remove('is-invalid');
                errorResponsable.textContent = '';
                errorResponsable.classList.add('d-none');
            }
            if (errores) {
                console.log('Se encontro errores. Formulario no se puede envía.');
                e.preventDefault();
            } else {
                console.log('Sin errores. Enviando formulario...');
                btnGuardar.disabled = true;
                btnGuardar.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...`;
            }
        });
    });
    // ------------------ Funciones auxiliares ------------------//

    function agregarProductoAFactura(producto, cantidad = 1) {
        const tablaFactura = document.getElementById('tablaFacturaBody');
        const productosExistentes = Array.from(tablaFactura.querySelectorAll('input[name$="[producto_id]"]'))
            .map(input => input.value);

        if (productosExistentes.includes(producto.id)) {
            mostrarAlertaProductoDuplicado('Este producto ya fue agregado a la factura.');
            return false;
        }

        ocultarAlertaProductoDuplicado();
        document.getElementById('filaVacia')?.remove();

        const index = tablaFactura.querySelectorAll('tr').length;
        const base = parseFloat(producto.precioVenta);
        const iva = parseFloat(producto.iva);
        const impuesto = (iva / 100) * base * cantidad;
        const subtotal = base * cantidad + impuesto;
        const fila = document.createElement('tr');
        fila.innerHTML = `
        <td>${index + 1}</td>
        <td><input type="hidden" name="productos[${index}][producto_id]" value="${producto.id}"><input type="hidden" name="productos[${index}][nombre]" value="${producto.nombre}">${producto.nombre}</td>
       <input type="hidden" name="productos[${index}][categoria]" value="${producto.categoria ?? ''}">
        <td><input type="hidden" name="productos[${index}][precioVenta]" value="${base.toFixed(2)}">${base.toFixed(2)}</td>
        <td><input type="hidden" name="productos[${index}][cantidad]" value="${cantidad}">${cantidad}</td>
        <td><input type="hidden" name="productos[${index}][iva]" value="${iva}">${iva}%</td>
        <td class="subtotal-producto">${subtotal.toFixed(2)}</td>
        <td><button type="button" class="btn btn-danger btn-sm btn-eliminar-producto"><i class="bi bi-trash"></i></button></td>
    `;
        tablaFactura.appendChild(fila);

        fila.querySelector('.btn-eliminar-producto').addEventListener('click', function () {
            fila.remove();
            actualizarNumeracionFilas();
            calcularTotalesGenerales();
            actualizarFilaVacia();
        });

        actualizarNumeracionFilas();
        calcularTotalesGenerales();
        actualizarFilaVacia();
        return true;
    }

    function mostrarAlertaProductoDuplicado(mensaje) {
        const alerta = document.getElementById('alertaProductoDuplicado');
        if (alerta) {
            alerta.textContent = mensaje;
            alerta.classList.remove('d-none');
        }
    }

    function ocultarAlertaProductoDuplicado() {
        const alerta = document.getElementById('alertaProductoDuplicado');
        if (alerta) {
            alerta.textContent = '';
            alerta.classList.add('d-none');
        }
    }

    function actualizarNumeracionFilas() {
        const filas = document.querySelectorAll('#tablaFacturaBody tr');
        filas.forEach((fila, i) => {
            fila.cells[0].textContent = i + 1;
            fila.dataset.index = i;
            fila.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/productos\[\d+\]/, `productos[${i}]`);
            });
        });
    }

    function actualizarFilaVacia() {
        const body = document.getElementById('tablaFacturaBody');
        const filaVacia = document.getElementById('filaVacia');
        if (!body.querySelector('tr')) {
            if (!filaVacia) {
                const row = document.createElement('tr');
                row.id = 'filaVacia';
                row.innerHTML = `<td colspan="8" class="text-center text-muted">No hay productos agregados</td>`;
                body.appendChild(row);
            } else {
                filaVacia.style.display = 'table-row';
            }
        } else {
            filaVacia?.remove();
        }
    }

    function calcularTotalesGenerales() {
        let subtotal = 0, impuesto15 = 0, impuesto18 = 0;
        const filas = document.querySelectorAll('#tablaFacturaBody tr');

        filas.forEach(fila => {
            const precio = parseFloat(fila.querySelector('input[name$="[precioVenta]"]')?.value || 0);
            const cantidad = parseFloat(fila.querySelector('input[name$="[cantidad]"]')?.value || 0);
            const iva = parseFloat(fila.querySelector('input[name$="[iva]"]')?.value || 0);
            const base = precio * cantidad;
            const impuesto = (iva / 100) * base;

            subtotal += base;
            if (iva === 15) impuesto15 += impuesto;
            if (iva === 18) impuesto18 += impuesto;

            fila.querySelector('.subtotal-producto').textContent = (base + impuesto).toFixed(2);
        });

        const total = subtotal + impuesto15 + impuesto18;

        document.getElementById('inputSubtotalGeneral').value = subtotal.toFixed(2);
        document.getElementById('inputImpuestosGeneral').value = (impuesto15 + impuesto18).toFixed(2);
        document.getElementById('inputTotalGeneral').value = total.toFixed(2);

        document.getElementById('subtotalGeneralLabel').textContent = subtotal.toFixed(2);
        document.getElementById('isv15Label').textContent = impuesto15.toFixed(2);
        document.getElementById('isv18Label').textContent = impuesto18.toFixed(2);
        document.getElementById('totalGeneralLabel').textContent = total.toFixed(2);
    }

    document.getElementById('tablaProductosBody').addEventListener('input', function(e) {
        if (e.target.classList.contains('cantidad-input')) {
            const input = e.target;
            const filaCantidad = input.closest('tr');
            const cantidadDisponibleElem = filaCantidad.querySelector('small.text-muted');
            const cantidadDisponible = parseInt(cantidadDisponibleElem.textContent.replace(/\D/g, ''), 10);
            const cantidadIngresada = parseInt(input.value, 10);

            if (isNaN(cantidadIngresada) || cantidadIngresada <= 0) {
                cantidadDisponibleElem.innerHTML = `<span style="color:#dc3545;">Cantidad disponible: ${cantidadDisponible}. La cantidad debe ser mayor que cero.</span>`;
            } else if (cantidadIngresada > cantidadDisponible) {
                cantidadDisponibleElem.innerHTML = `<span style="color:#dc3545;">Cantidad disponible: ${cantidadDisponible}. La cantidad ingresada no está disponible.</span>`;
            } else {
                cantidadDisponibleElem.textContent = `Cantidad disponible: ${cantidadDisponible}`;
                cantidadDisponibleElem.style.color = '';
            }
        }
    });

</script>
<script src="{{ asset('js/tu-script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
