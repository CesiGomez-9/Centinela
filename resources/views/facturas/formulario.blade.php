@extends('layouts.plantilla')
@section('titulo','Registrar una factura')
@section('content')

    <style>
        body {
            background-color: #e6f0ff;
            margin: 0;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
            display: none;
        }
        .field-error {
            border-color: #dc3545;
        }
        .form-control.invalid {
            border-color: #dc3545;
        }

        /* CSS de depuración: Añade esto temporalmente en tu formulario.blade.php */
        #tablaFacturaBody td {
            color: black !important; /* Fuerza el color del texto a negro */
            font-size: 1rem !important; /* Asegura un tamaño de fuente legible */
            visibility: visible !important; /* Asegura que el elemento sea visible */
            opacity: 1 !important; /* Asegura que no sea transparente */
            background-color: #ffffff !important; /* Fondo blanco para contraste */
            min-width: 50px; /* Asegura un ancho mínimo para las celdas */
            padding: 8px; /* Añade un poco de padding para que el texto no esté pegado */
        }

        /* Opcional: Si el texto está muy pegado al input hidden */
        #tablaFacturaBody td input[type="hidden"] + * {
            margin-left: 5px; /* Pequeño margen si el texto visible es un hermano del input */
        }
    </style>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-white p-5 rounded shadow-lg position-relative">
                    <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                        <i class="bi bi-receipt" style="font-size: 4rem;"></i>
                    </div>

                    <h3 class="text-center mb-4" style="color: #09457f;">
                        <i class="bi bi-file-text"></i>
                        @isset($factura)
                            Editar una factura de compra
                        @else
                            Registrar una nueva factura de compra
                        @endisset
                    </h3>

                    <form method="POST" id="facturaForm" action="{{ isset($factura) ? route('facturas.update', $factura->id) : route('facturas.store') }}" novalidate>
                        @csrf
                        @isset($factura)
                            @method('PUT')
                        @endisset
                        <div class="row g-4">
                            {{-- Número de Factura --}}
                            <div class="col-md-6">
                                <label for="numeroFactura" class="form-label">Número de Factura</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                    <input type="text" name="numero_factura" id="numeroFactura"
                                           class="form-control @error('numero_factura') is-invalid @enderror"
                                           maxlength="20" value="{{ old('numero_factura', isset($factura) ? $factura->numero_factura : '') }}"
                                           onkeypress="validarTexto(event)" required>
                                </div>
                                @error('numero_factura')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Fecha --}}
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" name="fecha" id="fecha" min="2025-01-01" max="2099-12-31"
                                           class="form-control @error('fecha') is-invalid @enderror"
                                           value="{{ old('fecha', isset($factura) ? $factura->fecha : '') }}" required>
                                </div>
                                @error('fecha')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Proveedor (Select) --}}
                            <div class="col-md-6">
                                <label for="proveedor_id" class="form-label">Proveedor</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <select id="proveedor_id" name="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un proveedor</option>
                                        {{-- Iterar sobre los proveedores pasados desde el controlador --}}
                                        @foreach ($proveedores as $prov)
                                            <option value="{{ $prov->id }}" {{ (old('proveedor_id', isset($factura) ? $factura->proveedor_id : '') == $prov->id) ? 'selected' : '' }}>
                                                {{ $prov->nombreEmpresa }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('proveedor_id')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Forma de Pago (Select) --}}
                            <div class="col-md-6">
                                <label for="formaPago" class="form-label">Forma de Pago</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-wallet-fill"></i></span>
                                    <select name="forma_pago" id="formaPago"
                                            class="form-select @error('forma_pago') is-invalid @enderror" required>
                                        <option value="">Seleccione una opción</option>
                                        {{-- Iterar sobre las formas de pago pasadas desde el controlador --}}
                                        @foreach ($formasPago as $forma)
                                            <option value="{{ $forma }}" {{ (old('forma_pago', isset($factura) ? $factura->forma_pago : '') === $forma) ? 'selected' : '' }}>
                                                {{ $forma }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('forma_pago')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Botón para abrir modal -->
                            <div class="col-12">
                                <div class="d-flex justify-content-start mb-4">
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#productosModal">
                                        <i class="bi bi-search"></i> Buscar Productos
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle text-center" id="tablaFacturaProductos">
                                        <thead class="table-light small">
                                        <tr>
                                            <th style="width: 30%;">Descripción</th>
                                            <th style="width: 20%;">Categoría</th>
                                            <th style="width: 15%;">Precio Compra (Lps)</th>
                                            <th style="width: 10%;">Cantidad</th>
                                            <th style="width: 10%;">IVA %</th>
                                            <th style="width: 15%;">Subtotal (Lps)</th>
                                            <th style="width: 10%;">Eliminar</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tablaFacturaBody">
                                        <!-- Fila vacía para mostrar que hay una tabla -->
                                        <tr id="filaVacia" class="fila-vacia">
                                            <td colspan="7" class="text-center text-muted py-4" style="border: 1px dashed #dee2e6; background-color: #f8f9fa;">
                                                <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                                                <br>
                                                <span style="font-size: 0.9rem;">No hay productos agregados</span>
                                                <br>
                                                <small style="font-size: 0.8rem; opacity: 0.7;">Haga clic en "Buscar Productos" para agregar productos a la factura</small>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="error-message" id="errorProductos" style="display: none; margin-top: 10px;">
                                    Debe agregar al menos un producto a la factura
                                </div>
                            </div>

                            <!-- Totales -->
                            <div class="row mt-4">
                                <div class="col-md-4 offset-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Subtotal (Lps)</label>
                                        <input type="text" class="form-control text-end" id="subtotalGeneral" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Impuestos (Lps)</label>
                                        <input type="text" class="form-control text-end" id="impuestosGeneral" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Total final (Lps)</label>
                                        <input type="text" class="form-control text-end" id="totalGeneral" readonly>
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
                                        {{-- Iterar sobre los empleados pasados desde el controlador --}}
                                        @foreach ($empleados as $empleado)
                                            <option value="{{ $empleado->id }}" {{ (old('responsable_id', isset($factura) ? $factura->responsable_id : '') == $empleado->id) ? 'selected' : '' }}>
                                                {{ $empleado->nombre }} {{ $empleado->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('responsable_id')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Botones -->
                            <div class="text-center mt-5">
                                <a href="{{ route('facturas.index') }}" class="btn btn-danger me-2">
                                    <i class="bi bi-x-circle me-2"></i> Cancelar
                                </a>

                                <button type="button" id="btnLimpiar" class="btn btn-warning me-2">
                                    <i class="bi bi-eraser-fill me-2"></i> Limpiar
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save-fill me-2"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal productos -->
    <div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel" aria-hidden="true">
        <div class="modal-dialog-scrollablea modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A1F44; color: white;">
                    <h5 class="modal-title">Listado de Productos</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Buscador -->
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control" placeholder="Buscar producto por nombre...">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de productos -->
                    <div class="table-responsive" style="max-height: 300px;">
                        <table class="table table-bordered table-hover text-center" id="tablaProductos">
                            <thead class="table-light sticky-top">
                            <tr>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody id="tablaProductosBody">
                            <!-- Productos por categoría -->
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Variables globales (si las tienes, asegúrate de que estén declaradas aquí o arriba)
        let productoSeleccionadoActual = null;
        let productoIndexCounter = 0; // Nuevo contador para los índices de productos

        // Datos de productos (asegúrate de que esta variable esté definida si la usas en cargarProductosEnModal)
        const nombresPorCategoria = {
            'Cámaras de seguridad': [
                'Cámara IP Full HD', 'Cámara Bullet 4K', 'Cámara domo PTZ',
                'Cámara térmica portátil', 'Cámara con visión nocturna'
            ],
            'Alarmas antirrobo': [
                'Alarma inalámbrica', 'Alarma con sirena', 'Alarma de puerta y ventana',
                'Sistema de alarma GSM', 'Alarma con detector de humo'
            ],
            'Cerraduras inteligentes': [
                'Cerradura biométrica', 'Cerradura con teclado', 'Cerradura Bluetooth',
                'Cerradura con control remoto', 'Cerradura electrónica para puertas'
            ],
            'Sensores de movimiento': [
                'Sensor PIR inalámbrico', 'Sensor de movimiento con cámara',
                'Sensor de movimiento para interiores', 'Sensor de movimiento con alarma',
                'Sensor doble tecnología'
            ],
            'Luces con sensor de movimiento': [
                'Luz LED con sensor', 'Luz solar con sensor', 'Foco exterior con sensor',
                'Luz para jardín con sensor', 'Lámpara de seguridad con sensor'
            ],
            'Rejas o puertas de seguridad': [
                'Reja metálica reforzada', 'Puerta de seguridad con cerradura',
                'Reja plegable de acero', 'Puerta blindada residencial', 'Reja corrediza automática'
            ],
            'Sistema de monitoreo 24/7': [
                'Sistema CCTV avanzado', 'Monitoreo remoto por app',
                'Servicio de vigilancia en tiempo real', 'Sistema con alertas SMS',
                'Monitoreo con sensores integrados'
            ],
            'Implementos de seguridad': [
                'Chaleco antibalas', 'Casco de seguridad', 'Guantes tácticos',
                'Botas reforzadas', 'Radio comunicador portátil'
            ]
        };


        // --- Funciones de Validación y Utilidad ---

        function validarFecha() {
            const fechaInput = document.getElementById('fecha');
            if (!fechaInput) {
                console.warn('Campo fecha no encontrado.');
                return false;
            }

            const val = fechaInput.value;

            if (!val) {
                mostrarError('fecha', 'La fecha es obligatoria');
                return false;
            }

            const fechaRegex = /^\d{4}-\d{2}-\d{2}$/;
            if (!fechaRegex.test(val)) {
                mostrarError('fecha', 'Formato de fecha inválido');
                return false;
            }

            const fecha = new Date(val);
            if (isNaN(fecha.getTime())) {
                mostrarError('fecha', 'Fecha inválida');
                return false;
            }

            const year = parseInt(val.substring(0, 4));
            if (year < 2025 || year > 2099) { // Ajuste para que coincida con la validación del controlador
                mostrarError('fecha', 'El año debe estar entre 2025 y 2099');
                return false;
            }

            ocultarError('fecha');
            return true;
        }

        function validarTexto(e) {
            const key = e.keyCode || e.which;
            const tecla = String.fromCharCode(key);
            const input = e.target;

            // Evitar espacio al inicio
            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }

            // Evitar múltiples espacios seguidos
            const pos = input.selectionStart;
            if (key === 32 && input.value.charAt(pos - 1) === ' ') {
                e.preventDefault();
                return false;
            }

            return true;
        }

        function limpiarFormularioCompleto() {
            const form = document.getElementById('facturaForm');
            if (!form) return;

            form.querySelectorAll('input[type="text"], input[type="date"], input[type="number"]').forEach(input => {
                input.value = '';
                input.classList.remove('is-valid', 'is-invalid');
            });

            form.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0;
                select.classList.remove('is-valid', 'is-invalid');
            });

            const tablaFacturaBody = document.getElementById('tablaFacturaBody');
            if (tablaFacturaBody) {
                const filas = tablaFacturaBody.querySelectorAll('tr:not(#filaVacia)');
                filas.forEach(fila => fila.remove());
                actualizarFilaVacia();
            }

            document.getElementById('subtotalGeneral').value = '';
            document.getElementById('impuestosGeneral').value = '';
            document.getElementById('totalGeneral').value = '';

            form.querySelectorAll('.text-danger, .invalid-feedback, .error-message').forEach(error => {
                error.style.display = 'none';
                error.textContent = '';
            });

            const errorProductos = document.getElementById('errorProductos');
            if (errorProductos) {
                errorProductos.style.display = 'none';
            }

            const modal = document.getElementById('productosModal');
            if (modal) {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }

            limpiarFormulariosModal();

            const primerCampo = form.querySelector('input[name="numero_factura"]');
            if (primerCampo) {
                primerCampo.focus();
            }
        }

        function limpiarFormulariosModal() {
            const formulariosModal = document.querySelectorAll('.form-edicion-producto');
            formulariosModal.forEach(form => {
                form.reset();
                form.querySelectorAll('.form-control, .form-select').forEach(input => {
                    input.classList.remove('is-valid', 'is-invalid', 'field-error');
                });
                form.querySelectorAll('.error-message').forEach(error => {
                    error.style.display = 'none';
                });
            });

            document.querySelectorAll('.producto-edicion-fila').forEach(fila => {
                fila.style.display = 'none';
            });

            document.querySelectorAll('.seleccionar-producto').forEach(btn => {
                btn.className = 'btn btn-sm btn-info seleccionar-producto';
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
            });

            productoSeleccionadoActual = null;

            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.value = '';
                document.querySelectorAll('#tablaProductosBody .producto-fila').forEach(fila => {
                    fila.style.display = 'table-row';
                    const celdaNombre = fila.querySelector('td:first-child');
                    if (celdaNombre) {
                        quitarResaltado(celdaNombre);
                    }
                });
                const searchResults = document.getElementById('searchResults');
                if (searchResults) {
                    searchResults.innerHTML = '';
                }
            }
        }

        function mostrarError(campoId, mensaje) {
            const campo = document.getElementById(campoId);
            if (!campo) {
                console.warn(`Campo no encontrado: ${campoId}`);
                return;
            }

            campo.classList.add('is-invalid');

            let errorDiv = campo.parentNode.querySelector('.text-danger');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'text-danger mt-1 small';
                errorDiv.style.opacity = '0';
                errorDiv.style.transition = 'opacity 0.3s ease';
                campo.parentNode.appendChild(errorDiv);
            }

            errorDiv.textContent = mensaje;
            errorDiv.style.display = 'block';

            setTimeout(() => {
                errorDiv.style.opacity = '1';
            }, 10);
        }

        function ocultarError(campoId) {
            const campo = document.getElementById(campoId);
            if (!campo) return;

            campo.classList.remove('is-invalid');

            const errorDiv = campo.parentNode.querySelector('.text-danger');
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
        }

        function validarFormularioProducto(form) {
            const precioCompra = form.querySelector('.precioCompra');
            const precioVenta = form.querySelector('.precioVenta');
            const cantidad = form.querySelector('.cantidad');
            const iva = form.querySelector('.iva');

            let esValido = true;

            form.querySelectorAll('.error-message').forEach(error => {
                error.style.display = 'none';
            });
            form.querySelectorAll('.field-error').forEach(field => {
                field.classList.remove('field-error');
            });

            if (!precioCompra.value || parseFloat(precioCompra.value) < 0) { // Cambiado a < 0 para permitir 0
                precioCompra.classList.add('field-error');
                let errorDiv = precioCompra.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    precioCompra.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Precio de compra es obligatorio y no puede ser negativo.';
                errorDiv.style.display = 'block';
                esValido = false;
            }

            if (!precioVenta.value || parseFloat(precioVenta.value) < 0) { // Cambiado a < 0 para permitir 0
                precioVenta.classList.add('field-error');
                let errorDiv = precioVenta.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    precioVenta.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Precio de venta es obligatorio y no puede ser negativo.';
                errorDiv.style.display = 'block';
                esValido = false;
            }

            if (!cantidad.value || parseInt(cantidad.value) <= 0) {
                cantidad.classList.add('field-error');
                let errorDiv = cantidad.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    cantidad.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Cantidad es obligatoria.';
                errorDiv.style.display = 'block';
                esValido = false;
            }

            if (!iva.value || iva.value.trim() === "") {
                iva.classList.add('field-error');
                let errorDiv = iva.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    iva.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'IVA es obligatorio.';
                errorDiv.style.display = 'block';
                esValido = false;
            }

            return esValido;
        }

        function validarFormularioPrincipal() {
            let esValido = true;
            let primerCampoConError = null;

            // Ocultar errores previos
            ['numeroFactura', 'fecha', 'proveedor_id', 'formaPago', 'responsable_id'].forEach(campo => {
                ocultarError(campo);
            });

            const errorProductos = document.getElementById('errorProductos');
            if (errorProductos) {
                errorProductos.style.display = 'none';
            }

            // Validar Número de Factura
            const numeroFactura = document.getElementById('numeroFactura').value.trim();
            if (!numeroFactura) {
                mostrarError('numeroFactura', 'Número de factura es obligatorio');
                if (!primerCampoConError) primerCampoConError = document.getElementById('numeroFactura');
                esValido = false;
            }

            // Validar Fecha
            if (!validarFecha()) {
                if (!primerCampoConError) primerCampoConError = document.getElementById('fecha');
                esValido = false;
            }

            // Validar Proveedor (ahora usa proveedor_id)
            const proveedorId = document.getElementById('proveedor_id').value;
            if (!proveedorId) {
                mostrarError('proveedor_id', 'Proveedor es obligatorio');
                if (!primerCampoConError) primerCampoConError = document.getElementById('proveedor_id');
                esValido = false;
            }

            // Validar Forma de Pago
            const formaPago = document.getElementById('formaPago').value;
            if (!formaPago) {
                mostrarError('formaPago', 'Forma de pago es obligatorio');
                if (!primerCampoConError) primerCampoConError = document.getElementById('formaPago');
                esValido = false;
            }

            // Validar Responsable (ahora usa responsable_id)
            const responsableId = document.getElementById('responsable_id').value;
            if (!responsableId) {
                mostrarError('responsable_id', 'Responsable es obligatorio');
                if (!primerCampoConError) primerCampoConError = document.getElementById('responsable_id');
                esValido = false;
            }


            // Validar Productos en la tabla
            const productos = document.querySelectorAll('#tablaFacturaBody tr:not(#filaVacia)');
            if (productos.length === 0) {
                const errorProductos = document.getElementById('errorProductos');
                if (errorProductos) {
                    errorProductos.style.display = 'block';
                    errorProductos.textContent = 'Debe agregar al menos un producto a la factura';
                }
                esValido = false;
            }

            // Enfocar el primer campo con error si existe
            if (!esValido && primerCampoConError) {
                primerCampoConError.focus();
                primerCampoConError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            return esValido;
        }

        function configurarValidacionFormulario() {
            const form = document.getElementById('facturaForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Formulario enviado, validando...');

                    if (!validarFormularioPrincipal()) {
                        console.log('Validación falló, previniendo envío');
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }

                    console.log('Validación exitosa, enviando formulario...');
                    return true;
                });
            }
        }

        function cargarProductosEnModal() {
            const tbody = document.getElementById('tablaProductosBody');
            tbody.innerHTML = '';

            Object.entries(nombresPorCategoria).forEach(([categoria, productos]) => {
                productos.forEach(nombre => {
                    const fila = document.createElement('tr');
                    fila.className = 'producto-fila';
                    fila.setAttribute('data-nombre', nombre);
                    fila.setAttribute('data-categoria', categoria);

                    fila.innerHTML = `
                    <td>${nombre}</td>
                    <td>${categoria}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info seleccionar-producto">
                            <i class="bi bi-check-circle"></i> Seleccionar
                        </button>
                    </td>
                `;

                    const filaEdicion = document.createElement('tr');
                    filaEdicion.className = 'producto-edicion-fila';
                    filaEdicion.style.display = 'none';
                    filaEdicion.innerHTML = `
                    <td colspan="3">
                        <form class="d-flex align-items-end gap-2 form-edicion-producto p-2" novalidate >
                            <div style="width: 18%;">
                                <label class="form-label">Precio Compra (Lps)</label>
                                <input type="number" min="0" max="9999" maxlength="4"  class="form-control precioCompra" required>
                            </div>
                            <div style="width: 18%;">
                                <label class="form-label">Precio Venta (Lps)</label>
                                <input type="number" min="0" max="9999" maxlength="4" class="form-control precioVenta" required>
                            </div>
                            <div style="width: 10%;">
                                <label class="form-label">Cantidad</label>
                                <input type="number" min="1" max="999" maxlength="3" class="form-control cantidad" required>
                            </div>
                            <div style="width: 20%;">
                                <label class="form-label">IVA</label>
                                <select class="form-select iva">
                                    <option value="">Seleccione</option>
                                    <option value="0">0%</option>
                                    <option value="15">15%</option>
                                </select>
                            </div>
                            <div class="d-flex gap-1">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle">Agregar</i>
                                </button>
                                <button type="button" class="btn btn-warning btn-sm limpiar-campos">
                                     <i class="bi bi-eraser-fill">Limpiar</i>
                                </button>
                            </div>
                        </form>
                    </td>
                `;
                    tbody.appendChild(fila);
                    tbody.appendChild(filaEdicion);
                });
            });
            configurarEventosProductos();
        }

        function limitarDigitos(input, maxDigitos) {
            if (!input) return;

            input.addEventListener('input', function(e) {
                let valor = e.target.value.replace(/[^0-9]/g, '');
                if (valor.length > maxDigitos) {
                    valor = valor.slice(0, maxDigitos);
                }
                e.target.value = valor;
            });

            input.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e.key)) {
                    e.preventDefault();
                }
            });

            input.addEventListener('blur', function(e) {
                let valor = parseInt(e.target.value) || 0;
                let max = parseInt(e.target.getAttribute('max'));

                if (valor > max) {
                    e.target.value = max;
                }
            });
        }

        // --- Función para configurar eventos de productos (la que añade productos desde el modal) ---
        function configurarEventosProductos() {
            // Botones seleccionar producto
            document.querySelectorAll('.seleccionar-producto').forEach(btn => {
                btn.addEventListener('click', function() {
                    const fila = this.closest('tr');
                    const filaEdicion = fila.nextElementSibling;

                    document.querySelectorAll('.producto-edicion-fila').forEach(f => {
                        if (f !== filaEdicion) {
                            f.style.display = 'none';
                        }
                    });

                    document.querySelectorAll('.seleccionar-producto').forEach(b => {
                        b.className = 'btn btn-sm btn-info seleccionar-producto';
                        b.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
                    });

                    if (filaEdicion.style.display === 'none') {
                        filaEdicion.style.display = 'table-row';
                        this.className = 'btn btn-sm btn-success seleccionar-producto btn-seleccionar-activo';
                        this.innerHTML = '<i class="bi bi-check-circle-fill"></i> Seleccionado';
                        productoSeleccionadoActual = fila;

                        const form = filaEdicion.querySelector('.form-edicion-producto');
                        form.reset();
                        form.querySelector('.precioCompra').focus();
                    } else {
                        filaEdicion.style.display = 'none';
                        this.className = 'btn btn-sm btn-info seleccionar-producto';
                        this.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
                        productoSeleccionadoActual = null;
                    }
                });
            });

            // Botones limpiar campos
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
                        mensaje.remove();
                    });
                    form.querySelectorAll('.mensaje-error, .mensaje-validacion').forEach(elemento => {
                        elemento.textContent = '';
                        elemento.style.display = 'none';
                    });
                });
            });

            // Formularios de edición de productos
            document.querySelectorAll('.form-edicion-producto').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!validarFormularioProducto(this)) {
                        return;
                    }

                    const filaEdicion = this.closest('.producto-edicion-fila');
                    const filaProducto = filaEdicion.previousElementSibling;

                    const nombre = filaProducto.dataset.nombre;
                    const categoria = filaProducto.dataset.categoria;
                    const precioCompra = parseFloat(this.querySelector('.precioCompra').value);
                    const precioVenta = parseFloat(this.querySelector('.precioVenta').value);
                    const cantidad = parseInt(this.querySelector('.cantidad').value);
                    const iva = parseInt(this.querySelector('.iva').value);

                    const tablaFactura = document.getElementById('tablaFacturaBody');
                    const productosExistentes = Array.from(tablaFactura.querySelectorAll('tr')).map(tr => {
                        const nombreInput = tr.querySelector('input[name^="productos["][name$="][nombre]"]'); // Usar selector más robusto
                        return nombreInput ? nombreInput.value : null;
                    });

                    if (productosExistentes.includes(nombre)) {
                        let errorDiv = this.querySelector('.error-producto-existente');
                        if (!errorDiv) {
                            errorDiv = document.createElement('div');
                            errorDiv.className = 'error-message error-producto-existente';
                            errorDiv.style.display = 'block';
                            errorDiv.textContent = 'Este producto ya está agregado a la factura. Si desea modificarlo, elimínelo primero.';
                            this.appendChild(errorDiv);
                        } else {
                            errorDiv.style.display = 'block';
                        }
                        return;
                    }

                    // Calcular subtotal
                    const base = precioCompra * cantidad;
                    const impuesto = (iva / 100) * base;
                    const subtotal = base + impuesto;

                    // Crear fila en la tabla de factura
                    const nuevaFila = document.createElement('tr');

                    // Asignar un índice único al producto
                    const currentIndex = productoIndexCounter++;

                    // *** CONSTRUCCIÓN DE CELDAS PARA LA ADICIÓN DESDE EL MODAL (AHORA CON ÍNDICES) ***

                    // Celda de Descripción (Nombre)
                    const tdNombre = document.createElement('td');
                    tdNombre.innerHTML = `
                    <input type="hidden" name="productos[${currentIndex}][nombre]" value="${nombre}" class="hidden-nombre">
                    ${nombre}
                `;
                    nuevaFila.appendChild(tdNombre);

                    // Celda de Categoría
                    const tdCategoria = document.createElement('td');
                    tdCategoria.innerHTML = `
                    <input type="hidden" name="productos[${currentIndex}][categoria]" value="${categoria}" class="hidden-categoria">
                    ${categoria}
                `;
                    nuevaFila.appendChild(tdCategoria);

                    // Celda de Precio Compra
                    const tdPrecioCompra = document.createElement('td'); // Corregido: document.createElement('td')
                    tdPrecioCompra.innerHTML = `
                    <input type="hidden" name="productos[${currentIndex}][precioCompra]" value="${precioCompra.toFixed(2)}" class="hidden-precio-compra">
                    ${precioCompra.toFixed(2)}
                `;
                    nuevaFila.appendChild(tdPrecioCompra);

                    // Celda de Cantidad
                    const tdCantidad = document.createElement('td');
                    tdCantidad.innerHTML = `
                    <input type="hidden" name="productos[${currentIndex}][cantidad]" value="${cantidad}" class="hidden-cantidad">
                    <input type="hidden" name="productos[${currentIndex}][precioVenta]" value="${precioVenta.toFixed(2)}" class="hidden-precio-venta">
                    ${cantidad}
                `;
                    nuevaFila.appendChild(tdCantidad);

                    // Celda de IVA
                    const tdIva = document.createElement('td');
                    tdIva.innerHTML = `
                    <input type="hidden" name="productos[${currentIndex}][iva]" value="${iva}" class="hidden-iva">
                    ${iva}%
                `;
                    nuevaFila.appendChild(tdIva);

                    // Celda de Subtotal
                    const tdSubtotal = document.createElement('td');
                    tdSubtotal.className = 'subtotal-producto';
                    tdSubtotal.textContent = subtotal.toFixed(2);
                    nuevaFila.appendChild(tdSubtotal);

                    // Celda de Eliminar
                    const tdAccion = document.createElement('td');
                    tdAccion.innerHTML = `
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto" title="Eliminar producto">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
                    nuevaFila.appendChild(tdAccion);
                    // *** FIN CONSTRUCCIÓN DE CELDAS ***

                    tablaFactura.appendChild(nuevaFila);
                    actualizarFilaVacia();

                    filaEdicion.style.display = 'none';
                    const btnSeleccionar = filaProducto.querySelector('.seleccionar-producto');
                    btnSeleccionar.className = 'btn btn-sm btn-info seleccionar-producto';
                    btnSeleccionar.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
                    productoSeleccionadoActual = null;

                    calcularTotalesGenerales();
                    document.getElementById('errorProductos').style.display = 'none';
                });
            });
        }

        function configurarBuscador() {
            const searchInput = document.getElementById('searchInput');

            if (!searchInput) {
                console.error('No se encontró el elemento con ID "searchInput"');
                return;
            }

            searchInput.addEventListener('input', function() {
                let termino = this.value.replace(/^\s*\d*\s*/, '', '').toLowerCase().trim();
                this.value = termino;

                const filas = document.querySelectorAll('#tablaProductosBody .producto-fila');
                let resultadosVisibles = 0;

                filas.forEach(fila => {
                    const nombre = fila.dataset.nombre ? fila.dataset.nombre.toLowerCase() : '';
                    const filaEdicion = fila.nextElementSibling;

                    const celdaNombre = fila.querySelector('td:first-child');

                    if (termino === '' || nombre.includes(termino)) {
                        fila.style.display = 'table-row';
                        resultadosVisibles++;

                        if (filaEdicion && filaEdicion.style.display !== 'none') {
                            filaEdicion.style.display = 'none';
                            const btnSeleccionar = fila.querySelector('.seleccionar-producto');
                            if (btnSeleccionar) {
                                btnSeleccionar.className = 'btn btn-sm btn-info seleccionar-producto';
                                btnSeleccionar.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
                            }
                        }

                        if (celdaNombre) {
                            if (termino !== '') {
                                resaltarTexto(celdaNombre, termino);
                            } else {
                                quitarResaltado(celdaNombre);
                            }
                        }
                    } else {
                        fila.style.display = 'none';
                        if (filaEdicion) {
                            filaEdicion.style.display = 'none';
                        }
                    }
                });

                mostrarResultados(termino, resultadosVisibles);
            });
        }

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

        function actualizarFilaVacia() {
            const tablaFactura = document.getElementById('tablaFacturaBody');
            const filaVacia = document.getElementById('filaVacia');
            const productosReales = tablaFactura.querySelectorAll('tr:not(#filaVacia)');

            if (productosReales.length === 0) {
                if (!filaVacia) {
                    const nuevaFilaVacia = document.createElement('tr');
                    nuevaFilaVacia.id = 'filaVacia';
                    nuevaFilaVacia.className = 'fila-vacia';
                    nuevaFilaVacia.innerHTML = `
                    <td colspan="7" class="text-center text-muted py-4" style="border: 1px dashed #dee2e6; background-color: #f8f9fa;">
                        <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                        <br>
                        <span style="font-size: 0.9rem;">No hay productos agregados</span>
                        <br>
                        <small style="font-size: 0.8rem; opacity: 0.7;">Haga clic en "Buscar Productos" para agregar productos a la factura</small>
                    </td>
                `;
                    tablaFactura.appendChild(nuevaFilaVacia);
                } else {
                    filaVacia.style.display = 'table-row';
                }
            } else {
                if (filaVacia) {
                    filaVacia.style.display = 'none';
                }
            }
        }

        function calcularTotalesGenerales() {
            const subtotales = document.querySelectorAll('.subtotal-producto');
            let subtotalGeneral = 0;
            let impuestosGeneral = 0;

            subtotales.forEach(td => {
                const fila = td.closest('tr');
                // Usar las clases para seleccionar los inputs hidden
                const inputPrecioCompra = fila.querySelector('.hidden-precio-compra');
                const inputCantidad = fila.querySelector('.hidden-cantidad');
                const inputIva = fila.querySelector('.hidden-iva');

                if (!inputPrecioCompra || !inputCantidad || !inputIva) {
                    console.error('ERROR: No se encontró uno o más inputs hidden de producto en la fila para calcular totales:', fila);
                    return; // Saltar está fila si falta algun input
                }

                const precioCompra = parseFloat(inputPrecioCompra.value);
                const cantidad = parseInt(inputCantidad.value);
                const iva = parseInt(inputIva.value);

                const base = precioCompra * cantidad;
                const impuesto = (iva / 100) * base;

                subtotalGeneral += base;
                impuestosGeneral += impuesto;
            });

            const totalGeneral = subtotalGeneral + impuestosGeneral;

            document.getElementById('subtotalGeneral').value = subtotalGeneral.toFixed(2); // Suma base + impuesto
            document.getElementById('impuestosGeneral').value = impuestosGeneral.toFixed(2); // Solo impuestos
            document.getElementById('totalGeneral').value = totalGeneral.toFixed(2); // Total final
        }

        // --- DOMContentLoaded Listener ---
        document.addEventListener("DOMContentLoaded", function () {
            // Configurar el botón Limpiar
            const btnLimpiar = document.getElementById('btnLimpiar');
            if (btnLimpiar) {
                btnLimpiar.addEventListener('click', function (e) {
                    e.preventDefault();
                    limpiarFormularioCompleto();
                });
            }

            // Limitar dígitos para campos numéricos (inicializar para inputs existentes en el modal)
            setTimeout(() => {
                const precioCompraInputs = document.querySelectorAll('.precioCompra');
                const precioVentaInputs = document.querySelectorAll('.precioVenta');
                const cantidadInputs = document.querySelectorAll('.cantidad');

                precioCompraInputs.forEach(input => limitarDigitos(input, 4));
                precioVentaInputs.forEach(input => limitarDigitos(input, 4));
                cantidadInputs.forEach(input => limitarDigitos(input, 3));
            }, 1000); // Pequeño retraso para asegurar que los inputs del modal estén en el DOM

            // Configurar validación del formulario principal
            configurarValidacionFormulario();

            // Cargar productos en el modal (inicializar la tabla de búsqueda de productos)
            cargarProductosEnModal();

            // Configurar buscador
            configurarBuscador();

            // --- Lógica para repoblar la tabla de productos al cargar la página ---
            const tablaFacturaBody = document.getElementById('tablaFacturaBody');

            const oldProductosRaw = @json(old('productos'));
            console.log('DEBUG: RAW oldProductos (para análisis):', oldProductosRaw);

            const existingFacturaDetalles = @json(isset($factura) ? $factura->detalles : null);

            let productsToLoad = [];

            if (oldProductosRaw && oldProductosRaw.length > 0) {
                let tempProducts = [];
                // La lógica de reconstrucción de oldProductosRaw, si viene aplanado
                let reconstructedProducts = [];
                let currentReconstructedProduct = {};
                const expectedProperties = ['nombre', 'categoria', 'precioCompra', 'cantidad', 'precioVenta', 'iva']; // Orden de las propiedades
                let propertiesCount = 0;

                oldProductosRaw.forEach(item => {
                    const key = Object.keys(item)[0];
                    const value = item[key];
                    currentReconstructedProduct[key] = value;
                    propertiesCount++;

                    if (propertiesCount === expectedProperties.length) {
                        reconstructedProducts.push({
                            nombre: String(currentReconstructedProduct.nombre || 'N/A'),
                            categoria: String(currentReconstructedProduct.categoria || 'N/A'),
                            precioCompra: parseFloat(currentReconstructedProduct.precioCompra || 0),
                            precioVenta: parseFloat(currentReconstructedProduct.precioVenta || 0),
                            cantidad: parseInt(currentReconstructedProduct.cantidad || 0),
                            iva: parseFloat(currentReconstructedProduct.iva || 0),
                            total: 0 // Se calculará
                        });
                        currentReconstructedProduct = {};
                        propertiesCount = 0;
                    }
                });
                productsToLoad = reconstructedProducts;

                // Calcular el total para los productos repoblados
                productsToLoad.forEach(p => {
                    const pBase = p.precioCompra * p.cantidad;
                    const pImpuesto = (p.iva / 100) * pBase;
                    p.total = pBase + pImpuesto;
                });

                console.log('DEBUG: oldProductos RECONSTRUIDOS (estructura correcta con total calculado):', productsToLoad);

            } else if (existingFacturaDetalles && existingFacturaDetalles.length > 0) {
                productsToLoad = existingFacturaDetalles.map(detail => ({
                    product_id: detail.product_id, // 👈 AÑADIR ESTO
                    nombre: String(detail.producto || 'N/A'),
                    categoria: String(detail.categoria || 'N/A'),
                    precioCompra: parseFloat(detail.precio_compra || 0),
                    precioVenta: parseFloat(detail.precio_venta || 0),
                    cantidad: parseInt(detail.cantidad || 0),
                    iva: parseFloat(detail.iva || 0),
                    total: parseFloat(detail.total || 0)
                }));
                console.log('DEBUG: Cargando productos desde detalles de factura existentes (mapeados a camelCase):', productsToLoad);
            }

            // Resetear el contador de índice de productos al cargar la página
            // Esto es importante para que los nuevos productos agregados desde el modal
            // tengan índices que no colisionen con los repoblados.
            productoIndexCounter = productsToLoad.length;


            if (productsToLoad.length > 0) {
                tablaFacturaBody.innerHTML = '';
                productsToLoad.forEach((producto, index) => { // Añadir 'index' aquí
                    console.log('DEBUG: Procesando producto para la tabla (estructura final):', producto);

                    const nombre = producto.nombre;
                    const categoria = producto.categoria;
                    const precioCompra = producto.precioCompra;
                    const precioVenta = producto.precioVenta;
                    const cantidad = producto.cantidad;
                    const iva = producto.iva;

                    const subtotalDisplay = parseFloat(producto.total).toFixed(2);

                    console.log(`DEBUG: Valores para HTML - Nombre: ${nombre}, Precio Compra: ${precioCompra}, Cantidad: ${cantidad}, IVA: ${iva}, Subtotal Display: ${subtotalDisplay}`);

                    const nuevaFila = document.createElement('tr');

                    // *** CONSTRUCCIÓN DE CELDAS REPOPULACIÓN (AHORA CON ÍNDICES) ***

                    // Celda de Descripción (Nombre)
                    const tdNombre = document.createElement('td');
                    tdNombre.innerHTML = `
    <input type="hidden" name="productos[${index}][product_id]" value="${producto.product_id}">
    <input type="hidden" name="productos[${index}][nombre]" value="${nombre}" class="hidden-nombre">
    ${nombre}
`;
                    nuevaFila.appendChild(tdNombre);


                    // Celda de Categoría
                    const tdCategoria = document.createElement('td');
                    tdCategoria.innerHTML = `
                    <input type="hidden" name="productos[${index}][categoria]" value="${categoria}" class="hidden-categoria">
                    ${categoria}
                `;
                    nuevaFila.appendChild(tdCategoria);

                    // Celda de Precio Compra
                    const tdPrecioCompra = document.createElement('td');
                    tdPrecioCompra.innerHTML = `
                    <input type="hidden" name="productos[${index}][precioCompra]" value="${precioCompra.toFixed(2)}" class="hidden-precio-compra">
                    ${precioCompra.toFixed(2)}
                `;
                    nuevaFila.appendChild(tdPrecioCompra);

                    // Celda de Cantidad
                    const tdCantidad = document.createElement('td');
                    tdCantidad.innerHTML = `
                    <input type="hidden" name="productos[${index}][cantidad]" value="${cantidad}" class="hidden-cantidad">
                    <input type="hidden" name="productos[${index}][precioVenta]" value="${precioVenta.toFixed(2)}" class="hidden-precio-venta">
                    ${cantidad}
                `;
                    nuevaFila.appendChild(tdCantidad);

                    // Celda de IVA
                    const tdIva = document.createElement('td');
                    tdIva.innerHTML = `
                    <input type="hidden" name="productos[${index}][iva]" value="${iva}" class="hidden-iva">
                    ${iva}%
                `;
                    nuevaFila.appendChild(tdIva);

                    // Celda de Subtotal
                    const tdSubtotal = document.createElement('td');
                    tdSubtotal.className = 'subtotal-producto';
                    tdSubtotal.textContent = subtotalDisplay;
                    nuevaFila.appendChild(tdSubtotal);

                    // Celda de Eliminar
                    const tdAccion = document.createElement('td');
                    tdAccion.innerHTML = `
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto" title="Eliminar producto">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
                    nuevaFila.appendChild(tdAccion);
                    // *** FIN CONSTRUCCIÓN DE CELDAS ***

                    tablaFacturaBody.appendChild(nuevaFila);
                });
                actualizarFilaVacia();
                calcularTotalesGenerales();
            }
        });

        // Eliminar productos de la factura
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-eliminar-producto')) {
                const fila = e.target.closest('tr');
                fila.remove();
                calcularTotalesGenerales();
                actualizarFilaVacia();
            }
        });

    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection


