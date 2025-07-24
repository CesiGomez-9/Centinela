<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturas de Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- CSS de Select2 -->
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
                <form method="POST" id="formFacturaVenta" action="{{ route('facturas_ventas.store') }}" novalidate>
                    @csrf
                    <div class="row g-4">
                        {{-- Número de Factura --}}
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

                        {{-- Fecha (solo texto, no editable) --}}
                        <div class="col-md-6">
                            <label class="form-label">Fecha</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                <span class="form-control">{{ date('d-m-Y') }}</span>
                                <input type="hidden" name="fecha" value="{{ date('d-m-Y') }}">
                            </div>
                        </div>
                        {{-- Cliente --}}
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

                            {{-- Lista de resultados del buscador --}}
                            <div id="searchResults" class="list-group" style="max-height: 200px; overflow-y: auto;"></div>

                            {{-- Input oculto para ID del cliente --}}
                            <input type="hidden" name="cliente_id" id="cliente_id" value="{{ old('cliente_id') }}">
                        </div>


                        {{-- Forma de Pago --}}
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

                    {{-- Botón buscar productos --}}
                    <div class="col-12">
                        <div class="d-flex justify-content-start mb-4 mt-3">
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#productosModal">
                                <i class="bi bi-search"></i> Buscar Productos
                            </button>
                        </div>
                    </div>

                    {{-- Tabla productos --}}
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center" id="tablaFactura">
                            <thead class="table-light small">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
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
                                    <span class="text-danger">No hay productos agregados</span><br />
                                    <small>Use el botón "Buscar Productos" para agregarlos</small>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div id="errorProductos" class="text-danger small mt-2 d-none">
                            Debe agregar al menos un producto a la factura.
                        </div>
                    </div>



                    {{-- Totales --}}
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

                    {{-- Responsable --}}
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

                    {{-- Botones --}}
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

<!-- Modal Productos -->
<div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A1F44; color: white;">
                <h5 class="modal-title" id="productosModalLabel">Listado de Productos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 align-items-end">
                    <!-- Buscador por nombre -->
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar producto por nombre...">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                        <!-- Aquí va el mensaje -->
                    </div>

                    <!-- Filtro por categoría -->
                    <div class="col-md-5">
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
                            @endphp
                            @if($detalle)
                                <tr>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->categoria }}</td>
                                    <td>{{ number_format($detalle->precio_venta, 2) }}</td>
                                    <td>{{ $detalle->cantidad ?? 'N/A' }}</td>
                                    <td>{{ $detalle->iva }}</td>
                                    <td>{{ number_format($detalle->precio_venta ?? 0, 2) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary btnSeleccionarProducto"
                                                data-id="{{ $producto->id }}"
                                                data-nombre="{{ $producto->nombre }}"
                                                data-categoria="{{ $producto->categoria }}"
                                                data-precioventa="{{ number_format($detalle->precio_venta, 2, '.', '') }}"
                                                data-iva="{{ $detalle->iva }}">
                                            Seleccionar
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // --- Buscador de clientes ---
        const inputCliente = document.getElementById('searchInput');
        const resultsContainer = document.getElementById('searchResults');
        const clienteIdInput = document.getElementById('cliente_id');
        // Verificar si se debe abrir el modal de productos automáticamente
        const urlParams = new URLSearchParams(window.location.search);
        const abrirModal = urlParams.get('abrir_modal');
        if (abrirModal === 'productos') {
            const modalElement = document.getElementById('productosModal');
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
            modalInstance.show();
        }
        // Buscador de clientes
        inputCliente.addEventListener('input', function (e) {
            const query = inputCliente.value;
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
                            });
                            resultsContainer.appendChild(item);
                        });
                    });
            } else {
                resultsContainer.innerHTML = '';
            }

            if (!clienteIdInput.value) {
                e.preventDefault();
                if (searchInput) {
                    searchInput.classList.add('is-invalid');
                }
                const errorCliente = document.getElementById('error_cliente_id');
                if (errorCliente) {
                    errorCliente.textContent = 'Debe seleccionar un cliente.';
                }
                return false;
            }
        });
        // Cerrar modal desde botón cerrar y al seleccionar producto
        const productosModalEl = document.getElementById('productosModal');
        const productosModal = bootstrap.Modal.getOrCreateInstance(productosModalEl);
        // Evento para botón cerrar manual (por si deseas manipularlo adicionalmente)
        const btnCerrar = document.querySelector('[data-bs-dismiss="modal"]');
        if (btnCerrar) {
            btnCerrar.addEventListener('click', () => {
                productosModal.hide();
            });
        }
        // Evento para seleccionar producto y cerrar modal automáticamente
        const tablaProductosBody = document.getElementById('tablaProductosBody');
        if (tablaProductosBody) {
            tablaProductosBody.addEventListener('click', function (e) {
                const btn = e.target.closest('.btnSeleccionarProducto');
                if (btn) {
                    const producto = {
                        id: btn.dataset.id,
                        nombre: btn.dataset.nombre,
                        categoria: btn.dataset.categoria,
                        precioVenta: btn.dataset.precioventa,
                        iva: btn.dataset.iva
                    };
                    // Función para agregar a la factura (ya deberías tenerla)
                    if (typeof agregarProductoAFactura === 'function') {
                        agregarProductoAFactura(producto);
                    }
                    productosModal.hide(); // ✅ Cierra el modal al seleccionar producto
                }
            });
        }
    });
    // --- Agregar producto a la factura ---
        function agregarProductoAFactura(producto) {
            const tablaFactura = document.getElementById('tablaFacturaBody');
            const productosExistentes = Array.from(tablaFactura.querySelectorAll('tr')).map(tr => {
                const idInput = tr.querySelector('input[name^="productos["][name$="][producto_id]"]');
                return idInput ? idInput.value : null;
            }).filter(id => id !== null);
            if (productosExistentes.includes(producto.id)) {
                mostrarAlertaProductoDuplicado('El producto ya está agregado a la factura.');
                return;
            }
            const filaVacia = document.getElementById('filaVacia');
            if (filaVacia) filaVacia.remove();
            const newRowIndex = tablaFactura.querySelectorAll('tr').length;
            const base = parseFloat(producto.precioVenta);
            const ivaPorcentaje = parseFloat(producto.iva);
            const impuestoCalculado = (ivaPorcentaje / 100) * base;
            const subtotalLinea = base + impuestoCalculado;
            const nuevaFila = document.createElement('tr');
            const mensajeNoProductos = document.getElementById('mensajeNoProductos');
            const subMensajeNoProductos = document.getElementById('subMensajeNoProductos');

            nuevaFila.dataset.index = newRowIndex;
            nuevaFila.innerHTML = `
            <td>${newRowIndex + 1}</td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][product_id]" value="${producto.id}">
                <input type="hidden" name="productos[${newRowIndex}][nombre]" value="${producto.nombre}">
                ${producto.nombre}
            </td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][categoria]" value="${producto.categoria}">
                ${producto.categoria}
            </td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][precioVenta]" value="${base.toFixed(2)}">
                ${base.toFixed(2)}
            </td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][cantidad]" value="1">
                1
            </td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][iva]" value="${ivaPorcentaje}">
                ${ivaPorcentaje}%
            </td>
            <td class="subtotal-producto">${subtotalLinea.toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto" title="Eliminar producto">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
            tablaFactura.appendChild(nuevaFila);
            nuevaFila.querySelector('.btn-eliminar-producto').addEventListener('click', function () {
                this.closest('tr').remove();
                actualizarNumeracionFilas();
                calcularTotalesGenerales();
                actualizarFilaVacia();
            });
            actualizarFilaVacia();
            calcularTotalesGenerales();
            actualizarNumeracionFilas();
            ocultarAlertaProductoDuplicado();
        }
        function mostrarAlertaProductoDuplicado(mensaje) {
            let contenedorAlerta = document.getElementById('alertaProductoDuplicado');
            if (!contenedorAlerta) {
                contenedorAlerta = document.createElement('div');
                contenedorAlerta.id = 'alertaProductoDuplicado';
                contenedorAlerta.className = 'alert alert-danger mt-2';
                const formulario = document.getElementById('formFacturaVenta');
                formulario.insertBefore(contenedorAlerta, formulario.firstChild);
            }
            contenedorAlerta.textContent = mensaje;
            contenedorAlerta.style.display = 'block';
        }
        function ocultarAlertaProductoDuplicado() {
            const contenedorAlerta = document.getElementById('alertaProductoDuplicado');
            if (contenedorAlerta) {
                contenedorAlerta.style.display = 'none';
            }
        }
        // --- Limpiar formulario ---
    document.addEventListener('DOMContentLoaded', function () {
        const btnLimpiar = document.querySelector('button[type="reset"]');
        if (btnLimpiar) {
            btnLimpiar.addEventListener('click', function (e) {
                // No usamos preventDefault para que se ejecute el reset natural del formulario
                setTimeout(() => {
                    const formulario = document.getElementById('formFacturaVenta');

                    // Limpiar alertas de validación visual
                    formulario.querySelectorAll('.is-invalid, .is-valid').forEach(el => {
                        el.classList.remove('is-invalid', 'is-valid');
                    });

                    // Limpiar mensajes de error
                    document.querySelectorAll('.text-danger, .invalid-feedback, .error-mensaje-js').forEach(el => {
                        el.textContent = '';
                        el.classList.add('d-none'); // ✅ mejor que style.display
                    });

                    // Limpiar alertas (duplicados u otros)
                    document.querySelectorAll('.alert.alert-danger').forEach(el => el.remove());

                    // Limpiar tabla de productos
                    const tablaFacturaBody = document.getElementById('tablaFacturaBody');
                    if (tablaFacturaBody) {
                        tablaFacturaBody.innerHTML = '';
                        actualizarFilaVacia();
                    }

                    // Reiniciar totales
                    const idsTotales = [
                        'importeGravadoLabel',
                        'importeExentoLabel',
                        'isv15Label',
                        'isv18Label',
                        'subtotalGeneralLabel',
                        'totalGeneralLabel',
                        'inputSubtotalGeneral',
                        'inputImpuestosGeneral',
                        'inputTotalGeneral'
                    ];
                    idsTotales.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) {
                            if (el.tagName === 'INPUT') el.value = '0.00';
                            else el.textContent = '0.00';
                        }
                    });

                    // Asegurar limpieza total de select de responsable y forma de pago
                    if (typeof $ !== 'undefined') {
                        $('#responsable_id').val('').trigger('change').change();
                        $('#formaPago').val('').trigger('change').change();
                    }

// Quitar manualmente atributos "selected" de opciones marcadas por Laravel
                    document.querySelectorAll('#responsable_id option[selected], #formaPago option[selected]').forEach(opt => {
                        opt.removeAttribute('selected');
                    });


                    // Limpiar cliente y errores
                    const inputCliente = document.getElementById('searchInput');
                    const clienteIdInput = document.getElementById('cliente_id');
                    const errorClienteId = document.getElementById('error_cliente_id');

                    if (inputCliente) inputCliente.value = '';
                    if (clienteIdInput) clienteIdInput.value = '';
                    document.getElementById('searchResults').innerHTML = '';

                    if (errorClienteId) {
                        errorClienteId.textContent = '';
                        errorClienteId.classList.add('d-none');
                    }
                    inputCliente?.classList.remove('is-invalid');

                    // Ocultar error de productos
                    const errorProductos = document.getElementById('errorProductos');
                    if (errorProductos) {
                        errorProductos.textContent = '';
                        errorProductos.classList.add('d-none');
                    }

                    formulario.classList.remove('was-validated');
                }, 10);
            });
        }
    });

    // --- Filtrar productos en modal ---
        const inputBuscar = document.getElementById('searchInput');
        const selectCategoria = document.getElementById('categoriaFiltro');
        const mensaje = document.getElementById('mensajeCoincidencias');

        function filtrarProductos() {
            const texto = inputBuscar.value.toLowerCase().trim();
            const categoria = selectCategoria.value.toLowerCase();
            const filas = document.querySelectorAll('#tablaProductosBody tr');
            let coincidencias = 0;

            filas.forEach(fila => {
                const nombre = fila.cells[0].textContent.toLowerCase();
                const cat = fila.cells[1].textContent.toLowerCase();
                const coincideTexto = nombre.includes(texto);
                const coincideCategoria = categoria === '' || cat === categoria;

                if (coincideTexto && coincideCategoria) {
                    fila.style.display = '';
                    coincidencias++;
                } else {
                    fila.style.display = 'none';
                }
            });

            if (mensaje) {
                mensaje.textContent = coincidencias === 0
                    ? 'No se encontraron productos.'
                    : `Se encontraron ${coincidencias} producto(s).`;
            }
        }
        if (inputBuscar && selectCategoria) {
            inputBuscar.addEventListener('input', filtrarProductos);
            selectCategoria.addEventListener('change', filtrarProductos);
        }
        const tablaProductosBody = document.getElementById('tablaProductosBody');
        const modalProductos = new bootstrap.Modal(document.getElementById('productosModal'));

        tablaProductosBody.addEventListener('click', function (e) {
            const btn = e.target.closest('.btnSeleccionarProducto');
            if (btn) {
                const producto = {
                    id: btn.dataset.id,
                    nombre: btn.dataset.nombre,
                    categoria: btn.dataset.categoria,
                    precioVenta: btn.dataset.precioventa,
                    iva: btn.dataset.iva
                };

                agregarProductoAFactura(producto);
                modalProductos.hide();
            }
        });

        function actualizarNumeracionFilas() {
            const tablaFactura = document.getElementById('tablaFacturaBody');
            if (!tablaFactura) return;
            const filas = tablaFactura.querySelectorAll('tr:not(#filaVacia)');

            filas.forEach((fila, index) => {
                fila.dataset.index = index;
                fila.cells[0].textContent = index + 1;

                fila.querySelectorAll('input').forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/productos\[\d+\]/, `productos[${index}]`);
                    }
                });
            });
        }
        function actualizarFilaVacia() {
            const tablaFactura = document.getElementById('tablaFacturaBody');
            if (!tablaFactura) return;
            let filaVacia = document.getElementById('filaVacia');
            const productosReales = tablaFactura.querySelectorAll('tr:not(#filaVacia)');

            if (productosReales.length === 0) {
                if (!filaVacia) {
                    filaVacia = document.createElement('tr');
                    filaVacia.id = 'filaVacia';
                    filaVacia.className = 'fila-vacia';
                    filaVacia.innerHTML = `
                    <td colspan="8" class="text-center text-muted py-4" style="border: 1px dashed #dee2e6; background-color: #f8f9fa;">
                        <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                        <br>
                        <span style="font-size: 0.9rem;">No hay productos agregados</span>
                        <br>
                        <small style="font-size: 0.8rem; opacity: 0.7;">Haga clic en "Buscar Productos" para agregar productos a la factura</small>
                    </td>
                `;
                    tablaFactura.appendChild(filaVacia);
                } else {
                    filaVacia.style.display = 'table-row';
                }
            } else {
                if (filaVacia) filaVacia.style.display = 'none';
            }
        }

        function calcularTotalesGenerales() {
            let importeGravado = 0, importeExento = 0, isv15 = 0, isv18 = 0, subtotal = 0, total = 0;

            const filas = document.querySelectorAll('#tablaFacturaBody tr');

            filas.forEach(fila => {
                const subtotalCell = fila.querySelector('.subtotal-producto');
                if (!subtotalCell) return;

                const precio = parseFloat(fila.querySelector('input[name$="[precioVenta]"]').value) || 0;
                const cantidad = parseFloat(fila.querySelector('input[name$="[cantidad]"]').value) || 0;
                const iva = parseFloat(fila.querySelector('input[name$="[iva]"]').value) || 0;

                const base = precio * cantidad;
                const impuesto = (iva / 100) * base;
                const totalLinea = base + impuesto;

                if (iva === 0) {
                    importeExento += base;
                } else {
                    importeGravado += base;
                    if (iva === 15) isv15 += impuesto;
                    if (iva === 18) isv18 += impuesto;
                }

                subtotal += base;
                total += totalLinea;

                subtotalCell.textContent = totalLinea.toFixed(2);

                document.getElementById('inputSubtotalGeneral').value = subtotal.toFixed(2);
                document.getElementById('inputImpuestosGeneral').value = (isv15 + isv18).toFixed(2);
                document.getElementById('inputTotalGeneral').value = total.toFixed(2);
            });

            document.getElementById('importeGravadoLabel').textContent = importeGravado.toFixed(2);
            document.getElementById('importeExentoLabel').textContent = importeExento.toFixed(2);
            document.getElementById('isv15Label').textContent = isv15.toFixed(2);
            document.getElementById('isv18Label').textContent = isv18.toFixed(2);
            document.getElementById('subtotalGeneralLabel').textContent = subtotal.toFixed(2);
            document.getElementById('totalGeneralLabel').textContent = total.toFixed(2);
        }

        // --- Validación final antes de enviar el formulario ---
        const form = document.getElementById('formFacturaVenta');
        const btnGuardar = form.querySelector('button[type="submit"]');
        const errorProductos = document.getElementById('errorProductos');

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formFacturaVenta');
        const btnGuardar = form.querySelector('button[type="submit"]');
        const errorProductos = document.getElementById('errorProductos');

        form.addEventListener('submit', function (e) {
            let errores = false;

            // Validar productos
            const productos = document.querySelectorAll('#tablaFacturaBody tr:not(#filaVacia)');
            if (productos.length === 0) {
                errorProductos.textContent = 'Debe agregar al menos un producto antes de guardar.';
                errorProductos.classList.remove('d-none');  // muestra el div
            } else {
                errorProductos.textContent = '';
                errorProductos.classList.add('d-none');  // oculta el div si no hay error
            }

            // Validar cliente
            const inputCliente = document.getElementById('searchInput');
            const clienteIdInput = document.getElementById('cliente_id');
            const errorCliente = document.getElementById('error_cliente_id');
            if (!clienteIdInput.value) {
                e.preventDefault();
                errores = true;
                inputCliente.classList.add('is-invalid');
                errorCliente.textContent = 'Debe seleccionar un cliente.';
                errorCliente.classList.remove('d-none');
            } else {
                inputCliente.classList.remove('is-invalid');
                errorCliente.textContent = '';
                errorCliente.classList.add('d-none');
            }

            // Validar forma de pago
            const formaPagoSelect = document.getElementById('formaPago');
            const errorFormaPago = document.getElementById('error_forma_pago');
            if (!formaPagoSelect.value) {
                e.preventDefault();
                errores = true;
                formaPagoSelect.classList.add('is-invalid');
                errorFormaPago.textContent = 'Forma de pago es obligatoria.';
                errorFormaPago.classList.remove('d-none');
            } else {
                formaPagoSelect.classList.remove('is-invalid');
                errorFormaPago.textContent = '';
                errorFormaPago.classList.add('d-none');
            }

            // Mostrar spinner solo si no hay errores
            if (!errores && btnGuardar) {
                btnGuardar.disabled = true;
                btnGuardar.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...`;
            }
        });
    });

</script>
<script src="{{ asset('js/tu-script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
