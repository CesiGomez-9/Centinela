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
                                       value="{{ old('numero') }}"
                                       maxlength="12" required />
                            </div>
                            @error('numero')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha --}}
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                <input type="date" name="fecha" id="fecha"
                                       class="form-control @error('fecha') is-invalid @enderror"
                                       value="{{ old('fecha', date('Y-m-d')) }}" required />
                            </div>
                            @error('fecha')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="cliente_id" class="form-label">Cliente</label>
                            <div class="input-group mb-2">
                                <input
                                    type="text"
                                    id="searchInput"
                                    class="form-control"
                                    placeholder="Buscar cliente por nombre"
                                    autocomplete="off"
                                >
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                            </div>
                            <div id="searchResults" class="list-group" style="max-height: 200px; overflow-y: auto;"></div>
                            <input type="hidden" name="cliente_id" id="cliente_id">
                            @error('cliente_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
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
                            @error('forma_pago')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
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
                                    <span>No hay productos agregados</span><br />
                                    <small>Use el botón "Buscar Productos" para agregarlos</small>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="errorProductos" class="text-danger small" style="display: none;">
                        Debe agregar al menos un producto a la factura.
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
                        @error('responsable_id')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
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

                <!-- Modal Detalles del Producto -->
                <div class="modal fade" id="modalDetallesProducto" tabindex="-1" aria-labelledby="modalDetallesProductoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="modalDetallesProductoLabel">Detalles del Producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-2">
                                    <div class="col-md-6"><strong>Nombre:</strong> <span id="detalleNombre"></span></div>
                                    <div class="col-md-6"><strong>Categoría:</strong> <span id="detalleCategoria"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6"><strong>Serie:</strong> <span id="detalleSerie"></span></div>
                                    <div class="col-md-6"><strong>Código:</strong> <span id="detalleCodigo"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6"><strong>Marca:</strong> <span id="detalleMarca"></span></div>
                                    <div class="col-md-6"><strong>Modelo:</strong> <span id="detalleModelo"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6"><strong>Cantidad Disponible:</strong> <span id="detalleCantidad"></span></div>
                                    <div class="col-md-6"><strong>IVA:</strong> <span id="detalleIVA"></span>%</div>
                                </div>
                                <div class="mb-2">
                                    <strong>Descripción:</strong>
                                    <p id="detalleDescripcion" class="mb-0"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


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
                            @foreach ($producto->detallesFactura as $detalle)

                                <tr>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->categoria }}</td>
                                    <td>{{ number_format($detalle->precio_venta, 2) }}</td>
                                    <td>{{ $detalle->cantidad ?? 'N/A' }}</td>
                                    <td>{{ $detalle->iva }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary btnSeleccionarProducto"
                                                data-id="{{ $producto->id }}"
                                                data-nombre="{{ $producto->nombre }}"
                                                data-categoria="{{ $producto->categoria }}"
                                                data-precioventa="{{ $detalle->precio_venta }}"
                                                data-iva="{{ $detalle->iva }}">
                                            Seleccionar
                                        </button>

                                        <button type="button" class="btn btn-sm btn-info btnVerDetalles"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetallesProducto"
                                                data-nombre="{{ $producto->nombre }}"
                                                data-serie="{{ $producto->serie }}"
                                                data-codigo="{{ $producto->codigo }}"
                                                data-marca="{{ $producto->marca ?? 'N/A' }}"
                                                data-modelo="{{ $producto->modelo ?? 'N/A' }}"
                                                data-categoria="{{ $producto->categoria }}"
                                                data-descripcion="{{ $producto->descripcion ?? 'Sin descripción' }}"
                                                data-cantidad="{{ $detalle->cantidad ?? $producto->cantidad }}"
                                                data-iva="{{ $detalle->iva }}">
                                            <i class="bi bi-eye"></i> Detalles
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach

                        </tbody>
                    </table>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cerrarModalProductos">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
            </div>
            </div>

        </div>
    </div>
</div>



<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // --- BUSCADOR CLIENTES ---
        $('#clienteSearchInput').on('input', function() {
            let query = $(this).val();

            if (query.length < 2) {
                $('#clienteSearchResults').empty();
                $('#cliente_id').val('');
                return;
            }

            $.ajax({
                url: "{{ route('clientes.search') }}", // Ruta Laravel para buscar clientes
                type: 'GET',
                data: { q: query },
                success: function(data) {
                    let results = data;
                    let html = '';

                    if (results.length > 0) {
                        results.forEach(cliente => {
                            html += `<button type="button" class="list-group-item list-group-item-action" data-id="${cliente.id}" data-nombre="${cliente.nombre}">
    ${cliente.nombre} - ${cliente.identidad || ''}
</button>`;
                        });
                    } else {
                        html = '<div class="list-group-item disabled">No se encontraron clientes</div>';
                    }

                    $('#clienteSearchResults').html(html);
                },
                error: function() {
                    $('#clienteSearchResults').html('<div class="list-group-item disabled">Error en la búsqueda</div>');
                }
            });
        });

        // Selección cliente
        $('#clienteSearchResults').on('click', 'button', function() {
            let id = $(this).data('id');
            let nombre = $(this).data('nombre');
            $('#cliente_id').val(id);
            $('#clienteSearchInput').val(nombre);
            $('#clienteSearchResults').empty();
        });

        // Limpiar cliente_id si texto se borra
        $('#clienteSearchInput').on('change keyup', function() {
            if ($(this).val().length === 0) {
                $('#cliente_id').val('');
            }
        });


        // --- BUSCADOR PRODUCTOS EN MODAL ---
        const productoSearchInput = document.getElementById('productoSearchInput');
        if (productoSearchInput) {
            productoSearchInput.addEventListener('input', function() {
                const termino = this.value.toLowerCase().trim();
                cargarProductosEnModal(termino); // Implementa esta función para filtrar o buscar productos
            });
        }

        // --- AGREGAR PRODUCTO A LA FACTURA (DESDE MODAL) ---
        function agregarProductoAFactura(producto) {
            const tablaFactura = document.getElementById('tablaFacturaBody');
            const productosExistentes = Array.from(tablaFactura.querySelectorAll('tr')).map(tr => {
                const idInput = tr.querySelector('input[name^="productos["][name$="][product_id]"]');
                return idInput ? idInput.value : null;
            });

            if (productosExistentes.includes(producto.id)) {
                // Mostrar alerta en DOM en lugar de alert()
                mostrarAlertaProductoDuplicado('El producto ya está agregado a la factura.');
                return;
            }

            const newRowIndex = tablaFactura.children.length;
            const base = parseFloat(producto.precioVenta) * 1; // cantidad 1 por defecto
            const ivaPorcentaje = parseFloat(producto.iva);
            const impuestoCalculado = (ivaPorcentaje / 100) * base;
            const subtotalLinea = base + impuestoCalculado;

            const nuevaFila = document.createElement('tr');
            nuevaFila.dataset.index = newRowIndex;
            nuevaFila.innerHTML = `
            <td>${newRowIndex + 1}</td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][product_id]" value="${producto.id}" class="hidden-product-id">
                <input type="hidden" name="productos[${newRowIndex}][nombre]" value="${producto.nombre}" class="hidden-nombre">
                ${producto.nombre}
            </td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][categoria]" value="${producto.categoria}" class="hidden-categoria">
                ${producto.categoria}
            </td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][precioVenta]" value="${parseFloat(producto.precioVenta).toFixed(2)}" class="hidden-precio-venta">
                ${parseFloat(producto.precioVenta).toFixed(2)}
            </td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][cantidad]" value="1" class="hidden-cantidad">
                1
            </td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][iva]" value="${ivaPorcentaje}" class="hidden-iva">
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

            // Evento eliminar producto
            nuevaFila.querySelector('.btn-eliminar-producto').addEventListener('click', function() {
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

        // --- ALERTAS PRODUCTO DUPLICADO ---
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


        // --- BOTÓN LIMPIAR FORMULARIO ---
        document.querySelectorAll('.limpiar-campos').forEach(btn => {
            btn.addEventListener('click', function() {
                const form = this.closest('form');
                if (!form) return;

                form.reset();

                form.querySelectorAll('.form-control, .form-select, textarea').forEach(input => {
                    input.classList.remove('is-valid', 'is-invalid', 'field-error');
                    input.setCustomValidity('');
                });

                form.classList.remove('was-validated');

                form.querySelectorAll('.invalid-feedback, .valid-feedback, .error-message, .text-danger, .text-success').forEach(mensaje => {
                    if (mensaje.classList.contains('error-message')) {
                        mensaje.remove();
                    } else {
                        mensaje.style.display = 'none';
                    }
                });

                // Limpiar tabla productos
                const tablaFacturaBody = document.getElementById('tablaFacturaBody');
                if (tablaFacturaBody) {
                    tablaFacturaBody.innerHTML = '';
                    actualizarFilaVacia();
                }

                // Limpiar cliente seleccionado
                const clienteInput = document.getElementById('clienteSearchInput');
                const clienteId = document.getElementById('cliente_id');
                if (clienteInput) clienteInput.value = '';
                if (clienteId) clienteId.value = '';

                // Limpiar totales
                ['importeGravadoLabel','importeExentoLabel','isv15Label','isv18Label','subtotalGeneralLabel','totalGeneralLabel'].forEach(id => {
                    const el = document.getElementById(id);
                    if(el) el.textContent = '0.00';
                });

                ocultarAlertaProductoDuplicado();
            });
        });


        // --- FUNCIONES DE UTILERÍA ---

        function calcularTotalesGenerales() {
            let importeGravado = 0;
            let importeExento = 0;
            let isv15 = 0;
            let isv18 = 0;
            let subtotal = 0;
            let total = 0;

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
                    if (iva === 15) {
                        isv15 += impuesto;
                    } else if (iva === 18) {
                        isv18 += impuesto;
                    }
                }

                subtotal += base;
                total += totalLinea;

                subtotalCell.textContent = totalLinea.toFixed(2);
            });

            document.getElementById('importeGravadoLabel').textContent = importeGravado.toFixed(2);
            document.getElementById('importeExentoLabel').textContent = importeExento.toFixed(2);
            document.getElementById('isv15Label').textContent = isv15.toFixed(2);
            document.getElementById('isv18Label').textContent = isv18.toFixed(2);
            document.getElementById('subtotalGeneralLabel').textContent = subtotal.toFixed(2);
            document.getElementById('totalGeneralLabel').textContent = total.toFixed(2);
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

    });

    document.addEventListener('DOMContentLoaded', () => {
        const formulario = document.getElementById('formFacturaVenta');
        const btnLimpiar = document.querySelector('.limpiar-campos');

        if (!formulario || !btnLimpiar) {
            console.warn('Formulario o botón Limpiar no encontrados');
            return;
        }

        btnLimpiar.addEventListener('click', (e) => {
            e.preventDefault(); // evitar comportamiento por defecto

            // Limpiar formulario nativo (inputs, selects, textarea)
            formulario.reset();

            // Limpiar manual campos que puedan tener valores "pegados" por Laravel old()
            // Ejemplo campos específicos que no se limpian bien con reset()
            const clienteInput = document.getElementById('clienteSearchInput');
            const clienteIdInput = document.getElementById('cliente_id');
            if(clienteInput) clienteInput.value = '';
            if(clienteIdInput) clienteIdInput.value = '';

            // Limpiar tabla de productos si existe
            const tablaFacturaBody = document.getElementById('tablaFacturaBody');
            if (tablaFacturaBody) {
                tablaFacturaBody.innerHTML = '';
                // Aquí podrías llamar función para poner fila vacía si tienes
                if(typeof actualizarFilaVacia === 'function') actualizarFilaVacia();
            }

            // Limpiar totales
            ['importeGravadoLabel','importeExentoLabel','isv15Label','isv18Label','subtotalGeneralLabel','totalGeneralLabel'].forEach(id => {
                const el = document.getElementById(id);
                if(el) el.textContent = '0.00';
            });

            // Quitar clases de validación bootstrap
            formulario.querySelectorAll('.is-invalid, .is-valid').forEach(el => {
                el.classList.remove('is-invalid', 'is-valid');
            });

            // Quitar mensajes de error visibles
            formulario.querySelectorAll('.invalid-feedback, .text-danger, .error-mensaje-js').forEach(el => {
                el.textContent = '';
                el.style.display = 'none';
            });

            // Quitar clase que Bootstrap añade para validación visual
            formulario.classList.remove('was-validated');

            // Quitar alertas globales si tienes
            document.querySelectorAll('.alert, .alert-danger, .alert-warning').forEach(alerta => {
                alerta.textContent = '';
                alerta.style.display = 'none';
            });

            console.log('Formulario y alertas limpiadas correctamente');
        });
    });

    document.getElementById('searchInput').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const resultsContainer = document.getElementById('searchResults');
        resultsContainer.innerHTML = '';

        // Supongamos que tienes los clientes disponibles en JS o haces llamada AJAX
        const clientes = @json($clientes); // desde blade

        const filtered = clientes.filter(cliente => cliente.nombre.toLowerCase().includes(query));

        filtered.forEach(cliente => {
            const item = document.createElement('a');
            item.href = "#";
            item.classList.add('list-group-item', 'list-group-item-action');
            item.textContent = cliente.nombre;
            item.addEventListener('click', () => {
                document.getElementById('searchInput').value = cliente.nombre;
                document.getElementById('cliente_id').value = cliente.id;
                resultsContainer.innerHTML = '';
            });
            resultsContainer.appendChild(item);
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const botonesVerDetalles = document.querySelectorAll('.btnVerDetalles');

        botonesVerDetalles.forEach(boton => {
            boton.addEventListener('click', function () {
                document.getElementById('detalleNombre').textContent = this.dataset.nombre;
                document.getElementById('detalleCategoria').textContent = this.dataset.categoria;
                document.getElementById('detalleSerie').textContent = this.dataset.serie;
                document.getElementById('detalleCodigo').textContent = this.dataset.codigo;
                document.getElementById('detalleMarca').textContent = this.dataset.marca;
                document.getElementById('detalleModelo').textContent = this.dataset.modelo;
                document.getElementById('detalleCantidad').textContent = this.dataset.cantidad;
                document.getElementById('detalleIVA').textContent = this.dataset.iva;
                document.getElementById('detalleDescripcion').textContent = this.dataset.descripcion;
            });
        });
    });


        document.addEventListener('DOMContentLoaded', function () {
        const inputBuscar = document.getElementById('buscarProducto');
        const selectCategoria = document.getElementById('categoriaFiltro');
        const filas = document.querySelectorAll('#tablaProductosBody tr');

        function filtrarProductos() {
        const texto = inputBuscar.value.toLowerCase();
        const categoria = selectCategoria.value;

        filas.forEach(fila => {
        const nombre = fila.querySelector('td:nth-child(1)').textContent.toLowerCase();
        const categoriaFila = fila.querySelector('td:nth-child(2)').textContent;

        const coincideNombre = nombre.includes(texto);
        const coincideCategoria = !categoria || categoriaFila === categoria;

        fila.style.display = (coincideNombre && coincideCategoria) ? '' : 'none';
    });
    }

        inputBuscar.addEventListener('input', filtrarProductos);
        selectCategoria.addEventListener('change', filtrarProductos);
    });






</script>
<script src="{{ asset('js/tu-script.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
