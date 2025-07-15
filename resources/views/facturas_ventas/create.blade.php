<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturas de Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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

                        {{-- Cliente --}}
                        <div class="col-md-6">
                            <label for="cliente_id" class="form-label">Cliente</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                <select id="cliente_id" name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
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

                    {{-- Responsable (Ahora un select que usa ID) --}}
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
                        <button type="reset" class="btn btn-warning me-2"><i class="bi bi-eraser-fill me-2"></i>Limpiar</button>
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
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar producto por nombre...">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                        <div id="searchResults" class="mt-2"></div>
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
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->categoria->nombre }}</td>
                                <td>{{ number_format($producto->precioVenta, 2) }}</td> <!-- ✅ Mostrar precio -->
                                <td>{{ $producto->cantidad ?? 'N/A' }}</td>
                                <td>{{ $producto->iva }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary btnSeleccionarProducto"
                                            data-id="{{ $producto->id }}"
                                            data-nombre="{{ $producto->nombre }}"
                                            data-categoria="{{ $producto->categoria->nombre }}"
                                            data-precioventa="{{ $producto->precioVenta }}"
                                            data-iva="{{ $producto->iva }}">
                                        Seleccionar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cerrarModalProductos">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>

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

        subtotalCell.textContent = totalLinea.toFixed(2); // Actualiza el subtotal de la fila
    });

        document.getElementById('importeGravadoLabel').textContent = importeGravado.toFixed(2);
        document.getElementById('importeExentoLabel').textContent = importeExento.toFixed(2);
        document.getElementById('isv15Label').textContent = isv15.toFixed(2);
        document.getElementById('isv18Label').textContent = isv18.toFixed(2);
        document.getElementById('subtotalGeneralLabel').textContent = subtotal.toFixed(2);
        document.getElementById('totalGeneralLabel').textContent = total.toFixed(2);
    }


document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const tablaBody = document.getElementById('tablaProductosBody');

        // Filtrar tabla productos al escribir en el input búsqueda
        searchInput.addEventListener('input', () => {
            const filter = searchInput.value.toLowerCase();
            const filas = tablaBody.querySelectorAll('tr');
            filas.forEach(fila => {
                const nombre = fila.cells[0].textContent.toLowerCase();
                if(nombre.includes(filter)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });

        });

        // Evento para botones "Seleccionar"
        tablaBody.querySelectorAll('.btnSeleccionarProducto').forEach(boton => {
            boton.addEventListener('click', () => {
                const id = boton.getAttribute('data-id');
                const nombre = boton.getAttribute('data-nombre');
                const categoria = boton.getAttribute('data-categoria');
                const precioVenta = boton.getAttribute('data-precioventa');
                const iva = boton.getAttribute('data-iva');

                // Aquí llamas a la función para agregar el producto a la tabla de productos en la factura
                agregarProductoAFactura({id, nombre, categoria, precioVenta, iva});

                // Cerrar modal al seleccionar producto
                const modal = bootstrap.Modal.getInstance(document.getElementById('productosModal'));
                modal.hide();
            });
        });
    });

    // Función para agregar producto a la tabla de la factura
    function agregarProductoAFactura(producto) {
        // Revisa si ya existe producto
        const tablaFactura = document.getElementById('tablaFacturaBody');
        const productosExistentes = Array.from(tablaFactura.querySelectorAll('tr')).map(tr => {
            const idInput = tr.querySelector('input[name^="productos["][name$="][product_id]"]');
            return idInput ? idInput.value : null;
        });

        if (productosExistentes.includes(producto.id)) {
            alert('El producto ya está agregado a la factura.');
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
    }

    // Función para manejar inputs numéricos (enteros o decimales)
    function handleNumericInput(input, maxIntegerDigits, isDecimal) {
        input.addEventListener('keypress', function(e) {
            const key = e.key;
            if (['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(key)) {
                return true;
            }

            if (isDecimal) {
                if (key === '.') {
                    if (e.target.value.includes('.')) {
                        e.preventDefault();
                    }
                    return true;
                }
                if (!/[0-9]/.test(key)) {
                    e.preventDefault();
                }
            } else {
                if (!/[0-9]/.test(key)) {
                    e.preventDefault();
                }
                if (key === '.') { // No permitir punto decimal para enteros
                    e.preventDefault();
                }
            }
        });

        input.addEventListener('input', function(e) {
            let value = e.target.value;
            let sanitizedValue = '';

            if (isDecimal) {
                sanitizedValue = value.replace(/[^0-9.]/g, '');
                const parts = sanitizedValue.split('.');
                if (parts.length > 2) {
                    sanitizedValue = parts[0] + '.' + parts.slice(1).join('');
                }
                if (parts[0].length > maxIntegerDigits) {
                    sanitizedValue = parts[0].slice(0, maxIntegerDigits) + (parts[1] ? '.' + parts[1] : '');
                }
                if (parts[1] && parts[1].length > 2) {
                    sanitizedValue = parts[0] + '.' + parts[1].slice(0, 2);
                }
            } else {
                sanitizedValue = value.replace(/[^0-9]/g, '');
                if (sanitizedValue.length > maxIntegerDigits) {
                    sanitizedValue = sanitizedValue.slice(0, maxIntegerDigits);
                }
            }
            e.target.value = sanitizedValue;
        });

        input.addEventListener('blur', function(e) {
            let value = e.target.value;
            let numValue = parseFloat(value);

            if (value === '') {
                return; // Permite dejar vacío
            }

            if (isNaN(numValue)) {
                e.target.value = '';
                return;
            }

            if (isDecimal) {
                e.target.value = numValue.toFixed(2);
            } else {
                e.target.value = Math.floor(numValue);
            }
        });
    }

    // Variable global para producto seleccionado actual en el modal
    let productoSeleccionadoActual = null;

    // Configura eventos para botones de seleccionar productos, limpiar campos y enviar formulario de producto
    function configurarEventosProductos() {
        document.querySelectorAll('.seleccionar-producto').forEach(btn => {
            btn.addEventListener('click', function() {
                const fila = this.closest('tr');
                const filaEdicion = fila.nextElementSibling;

                // Ocultar todas las filas de edición excepto la actual
                document.querySelectorAll('.producto-edicion-fila').forEach(f => {
                    if (f !== filaEdicion) {
                        f.style.display = 'none';
                    }
                });

                // Resetear todos los botones a estado no seleccionado
                document.querySelectorAll('.seleccionar-producto').forEach(b => {
                    b.className = 'btn btn-sm btn-info seleccionar-producto';
                    b.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
                });

                // Toggle fila de edición actual
                if (filaEdicion.style.display === 'none') {
                    filaEdicion.style.display = 'table-row';
                    this.className = 'btn btn-sm btn-success seleccionar-producto btn-seleccionar-activo';
                    this.innerHTML = '<i class="bi bi-check-circle-fill"></i> Seleccionado';
                    productoSeleccionadoActual = fila;

                    const form = filaEdicion.querySelector('.form-edicion-producto');
                    form.reset();
                    form.querySelector('.precioVenta').focus();
                } else {
                    filaEdicion.style.display = 'none';
                    this.className = 'btn btn-sm btn-info seleccionar-producto';
                    this.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
                    productoSeleccionadoActual = null;
                }
            });
        });

        // Botones para limpiar campos del formulario producto
        document.querySelectorAll('.limpiar-campos').forEach(btn => {
            btn.addEventListener('click', function() {
                const form = this.closest('.form-edicion-producto');
                form.reset();
                form.querySelectorAll('.form-control, .form-select').forEach(input => {
                    input.classList.remove('is-valid', 'is-invalid', 'field-error');
                    input.setCustomValidity('');
                });
                form.classList.remove('was-validated');
                form.querySelectorAll('.invalid-feedback, .valid-feedback, .error-message, .text-danger, .text-success').forEach(mensaje => {
                    if (mensaje.classList.contains('error-message')) {
                        mensaje.remove();
                    }
                });
            });
        });

        // Envío del formulario para agregar producto a la factura
        document.querySelectorAll('.form-edicion-producto').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (!validarFormularioProducto(this)) {
                    return;
                }

                const filaEdicion = this.closest('.producto-edicion-fila');
                const filaProducto = filaEdicion.previousElementSibling;

                const product_id = filaProducto.dataset.id;
                const nombre = filaProducto.dataset.nombre;
                const categoria = filaProducto.dataset.categoria;

                const precioVenta = parseFloat(this.querySelector('.precioVenta').value);
                const cantidad = parseInt(this.querySelector('.cantidad').value);
                const ivaPorcentaje = parseFloat(filaProducto.dataset.ivaPorcentaje);

                const tablaFactura = document.getElementById('tablaFacturaBody');
                const productosExistentes = Array.from(tablaFactura.querySelectorAll('tr')).map(tr => {
                    const idInput = tr.querySelector('input[name^="productos["][name$="][product_id]"]');
                    return idInput ? idInput.value : null;
                });

                if (productosExistentes.includes(product_id)) {
                    let errorDiv = this.querySelector('.error-producto-existente');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'error-message error-producto-existente text-danger mt-2';
                        errorDiv.style.display = 'block';
                        errorDiv.textContent = 'Este producto ya está agregado a la factura. Si desea modificarlo, elimínelo primero.';
                        this.appendChild(errorDiv);
                    } else {
                        errorDiv.style.display = 'block';
                    }
                    return;
                }

                const base = precioVenta * cantidad;
                const impuestoCalculado = (ivaPorcentaje / 100) * base;
                const subtotalLinea = base + impuestoCalculado;

                const nuevaFila = document.createElement('tr');
                const newRowIndex = tablaFactura.children.length;

                nuevaFila.dataset.index = newRowIndex;
                nuevaFila.innerHTML = `
            <td>${newRowIndex + 1}</td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][product_id]" value="${product_id}" class="hidden-product-id">
                <input type="hidden" name="productos[${newRowIndex}][nombre]" value="${nombre}" class="hidden-nombre">
                ${nombre}
            </td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][categoria]" value="${categoria}" class="hidden-categoria">
                ${categoria}
            </td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][precioVenta]" value="${precioVenta.toFixed(2)}" class="hidden-precio-venta">
                ${precioVenta.toFixed(2)}
            </td>
            <td>
                <input type="hidden" name="productos[${newRowIndex}][cantidad]" value="${cantidad}" class="hidden-cantidad">
                ${cantidad}
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

                const modalElement = document.getElementById('productosModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }

                calcularTotalesGenerales();
                document.getElementById('errorProductos').style.display = 'none';
                actualizarNumeracionFilas();
            });
        });
    }

    // Configura buscador de productos en el modal
    function configurarBuscador() {
        const searchInput = document.getElementById('searchInput');
        if (!searchInput) {
            console.error('No se encontró el elemento con ID "searchInput"');
            return;
        }

        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const termino = this.value.replace(/^\s*\d*\s*/, '').toLowerCase().trim();

            searchTimeout = setTimeout(() => {
                cargarProductosEnModal(termino);
            }, 300);
        });
    }

    // Resaltar texto buscado
    function resaltarTexto(elemento, termino) {
        if (!elemento) return;

        const textoOriginal = elemento.getAttribute('data-original') || elemento.textContent;

        if (!elemento.getAttribute('data-original')) {
            elemento.setAttribute('data-original', textoOriginal);
        }

        const regex = new RegExp(`(${escapeRegex(termino)})`, 'gi');
        const textoResaltado = textoOriginal.replace(regex, '<mark class="bg-warning">$1</mark>');
        elemento.innerHTML = textoResaltado;
    }

    function quitarResaltado(elemento) {
        if (!elemento) return;

        const textoOriginal = elemento.getAttribute('data-original');
        if (textoOriginal) {
            elemento.textContent = textoOriginal;
            elemento.removeAttribute('data-original');
        }
    }

    function escapeRegex(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    // Mostrar resultados búsqueda
    function mostrarResultados(termino, cantidad) {
        let searchResults = document.getElementById('searchResults');

        if (!searchResults) {
            searchResults = document.createElement('div');
            searchResults.id = 'searchResults';
            searchResults.className = 'mt-2';

            const searchContainer = document.getElementById('searchInput').parentNode.parentNode;
            searchContainer.appendChild(searchResults);
        }

        if (termino === '') {
            searchResults.innerHTML = '';
            return;
        }

        if (cantidad === 0) {
            searchResults.innerHTML = `
        <div class="alert alert-warning alert-sm" role="alert" style="padding: 8px 12px; font-size: 0.875rem;">
            <i class="bi bi-exclamation-triangle me-2"></i>
            No se encontraron productos con el nombre "<strong>${termino}</strong>"
        </div>
    `;
        } else {
            searchResults.innerHTML = `
        <div class="alert alert-success alert-sm" role="alert" style="padding: 8px 12px; font-size: 0.875rem;">
            <i class="bi bi-check-circle me-2"></i>
            Se encontraron <strong>${cantidad}</strong> producto(s) con el nombre "<strong>${termino}</strong>"
        </div>
    `;
        }
    }

    // Mostrar fila vacía cuando no hay productos en la factura
    function actualizarFilaVacia() {
        const tablaFactura = document.getElementById('tablaFacturaBody');
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
            if (filaVacia) {
                filaVacia.style.display = 'none';
            }
        }
    }

    // Actualiza numeración y nombres de inputs para mantener consistencia
    function actualizarNumeracionFilas() {
        const tablaFactura = document.getElementById('tablaFacturaBody');
        const filas = tablaFactura.querySelectorAll('tr:not(#filaVacia)');

        filas.forEach((fila, index) => {
            fila.dataset.index = index;
            fila.cells[0].textContent = index + 1;

            // Actualizar atributos name de inputs
            fila.querySelectorAll('input').forEach(input => {
                if (input.name) {
                    const nuevoName = input.name.replace(/productos\[\d+\]/, `productos[${index}]`);
                    input.name = nuevoName;
                }
            });
        });
    }

    // Validación simple para formulario de producto (puedes extender)
    function validarFormularioProducto(form) {
        let valido = true;
        const precioVentaInput = form.querySelector('.precioVenta');
        const cantidadInput = form.querySelector('.cantidad');

        if (!precioVentaInput.value || isNaN(parseFloat(precioVentaInput.value)) || parseFloat(precioVentaInput.value) <= 0) {
            precioVentaInput.classList.add('is-invalid');
            valido = false;
        } else {
            precioVentaInput.classList.remove('is-invalid');
            precioVentaInput.classList.add('is-valid');
        }

        if (!cantidadInput.value || isNaN(parseInt(cantidadInput.value)) || parseInt(cantidadInput.value) <= 0) {
            cantidadInput.classList.add('is-invalid');
            valido = false;
        } else {
            cantidadInput.classList.remove('is-invalid');
            cantidadInput.classList.add('is-valid');
        }

        return valido;
    }
        function limpiarError(input) {
            const errorId = 'error-' + input.id;
            const errorEl = document.getElementById(errorId);
            if (errorEl) {
                errorEl.remove();
            }
            input.classList.remove('is-invalid');
        }


</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
