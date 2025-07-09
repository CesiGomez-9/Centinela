@extends('plantilla')
@section('titulo','Registrar una factura')
@section('content')

    <style>
        body {
            background-color: #e6f0ff;
            margin: 0;
        }
        /* Mantener .error-message para los errores de JS en productos del modal */
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

        /* CSS de depuración: Asegura la visibilidad del texto en la tabla */
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
            margin-left: 5px;
        }

        /* CSS para asegurar que el modal y su backdrop se oculten completamente */
        .modal:not(.show) {
            display: none !important;
        }
        .modal-backdrop:not(.show) {
            display: none !important;
            opacity: 0 !important;
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
                                {{-- Este div se mantiene si lo usas para otros JS o si Laravel lo llena --}}
                                <div class="text-danger mt-1 small error-mensaje-js"></div>
                                @error('numero_factura')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Fecha --}}
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" name="fecha" id="fecha"
                                           class="form-control @error('fecha') is-invalid @enderror"
                                           value="{{ old('fecha', isset($factura) ? $factura->fecha : \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                           required>
                                </div>
                                <div class="text-danger mt-1 small error-mensaje-js"></div>
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
                                        @foreach ($proveedores as $prov)
                                            <option value="{{ $prov->id }}" {{ (old('proveedor_id', isset($factura) ? $factura->proveedor_id : '') == $prov->id) ? 'selected' : '' }}>
                                                {{ $prov->nombreEmpresa }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-danger mt-1 small error-mensaje-js"></div>
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
                                            <th>N°</th>
                                            <th style="width: 30%;">Descripción</th>
                                            <th style="width: 20%;">Categoría</th>
                                            <th style="width: 15%;">Precio Compra (Lps)</th>
                                            <th style="width: 10%;">Cantidad</th>
                                            <th style="width: 10%;">IVA%</th>
                                            <th style="width: 15%;">Subtotal (Lps)</th>
                                            <th style="width: 10%;">Eliminar</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tablaFacturaBody">
                                        <tr id="filaVacia" class="fila-vacia">
                                            <td colspan="8" class="text-center text-muted py-4" style="border: 1px dashed #dee2e6; background-color: #f8f9fa;">
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

                            <div class="row mt-4">
                                <div class="col-md-4 offset-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Subtotal (Lps)</label>
                                        <label class="form-control text-end" id="subtotalGeneralLabel" style="background-color: #e9ecef; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">0.00</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Impuestos (Lps)</label>
                                        <label class="form-control text-end" id="impuestosGeneralLabel" style="background-color: #e9ecef; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">0.00</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Total final (Lps)</label>
                                        <label class="form-control text-end" id="totalGeneralLabel" style="background-color: #e9ecef; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">0.00</label>
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

                            <div class="text-center mt-5">
                                <a href="{{ route('facturas.index') }}" class="btn btn-danger me-2">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </a>

                                <button type="button" id="btnLimpiar" class="btn btn-warning me-2">
                                    <i class="bi bi-eraser-fill"></i> Limpiar
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save-fill"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel" aria-hidden="true">
        <div class="modal-dialog-scrollablea modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A1F44; color: white;">
                    <h5 class="modal-title">Listado de Productos</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control" placeholder="Buscar producto por nombre...">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                            </div>
                            <div id="searchResults" class="mt-2"></div>
                        </div>
                    </div>

                    <div class="table-responsive" style="max-height: 300px;">
                        <table class="table table-bordered table-hover text-center" id="tablaProductos">
                            <thead class="table-light sticky-top">
                            <tr>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Cantidad Disponible</th>
                                <th>IVA %</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody id="tablaProductosBody">
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
        document.addEventListener("DOMContentLoaded", function () {
            // Este listener del botón cerrar es redundante si ya tienes el hidden.bs.modal
            // Lo mantengo comentado si quieres un comportamiento extra solo al presionar este botón
            /*
            const btnCerrarModal = document.getElementById('cerrarModalProductos');
            if (btnCerrarModal) {
                btnCerrarModal.addEventListener('click', function() {
                    console.log('DEBUG: Botón "Cerrar" del modal presionado. Limpiando formularios del modal.');
                    limpiarFormulariosModal();
                });
            }
            */
        });
        // Variables globales
        let productoSeleccionadoActual = null;
        let productoIndexCounter = 0; // Nuevo contador para los índices de productos

        // --- Funciones de Validación y Utilidad ---

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

            document.getElementById('subtotalGeneralLabel').textContent = '0.00';
            document.getElementById('impuestosGeneralLabel').textContent = '0.00';
            document.getElementById('totalGeneralLabel').textContent = '0.00';

            // Limpiar los mensajes de error de Laravel y JS
            form.querySelectorAll('.text-danger.mt-1.small, .invalid-feedback').forEach(error => {
                error.style.display = 'none';
                error.textContent = '';
            });
            form.querySelectorAll('.form-control.is-invalid').forEach(input => {
                input.classList.remove('is-invalid');
            });


            const errorProductos = document.getElementById('errorProductos');
            if (errorProductos) {
                errorProductos.style.display = 'none';
            }

            const modal = document.getElementById('productosModal');
            if (modal) {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide(); // Esto debería disparar hidden.bs.modal y limpiar el modal
                }
            }

            // Ya no es necesario llamar limpiarFormulariosModal() aquí directamente
            // porque el evento 'hidden.bs.modal' del modal se encarga de ello.

            document.body.classList.remove('modal-open'); // Asegurar remoción de la clase
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            document.documentElement.style.overflow = '';


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
                // Recargar productos en el modal para mostrar todos de nuevo
                cargarProductosEnModal();
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

            let errorDiv = campo.nextElementSibling;
            if (!errorDiv || !errorDiv.classList.contains('error-mensaje-js')) {
                errorDiv = campo.parentNode.querySelector('.error-mensaje-js');
                if (!errorDiv) {
                    const parentCol = campo.closest('.col-md-6, .col-md-4, .col-12');
                    if (parentCol) {
                        errorDiv = parentCol.querySelector('.error-mensaje-js');
                    }
                }
            }

            if (errorDiv) {
                errorDiv.textContent = mensaje;
                errorDiv.style.display = 'block';
            } else {
                console.warn(`No se encontró un div.error-mensaje-js para el campo ${campoId}.`);
            }
        }

        function ocultarError(campoId) {
            const campo = document.getElementById(campoId);
            if (!campo) return;

            campo.classList.remove('is-invalid');

            let errorDiv = campo.nextElementSibling;
            if (!errorDiv || !errorDiv.classList.contains('error-mensaje-js')) {
                errorDiv = campo.parentNode.querySelector('.error-mensaje-js');
                if (!errorDiv) {
                    const parentCol = campo.closest('.col-md-6, .col-md-4, .col-12');
                    if (parentCol) {
                        errorDiv = parentCol.querySelector('.error-mensaje-js');
                    }
                }
            }

            if (errorDiv) {
                errorDiv.textContent = '';
                errorDiv.style.display = 'none';
            }
        }

        function validarFormularioProducto(form) {
            const precioCompraInput = form.querySelector('.precioCompra');
            const precioVentaInput = form.querySelector('.precioVenta');
            const cantidadInput = form.querySelector('.cantidad');

            let esValido = true;

            // Limpiar mensajes de error previos
            form.querySelectorAll('.error-message').forEach(error => {
                error.style.display = 'none';
            });
            form.querySelectorAll('.field-error').forEach(field => {
                field.classList.remove('field-error');
            });

            const precioCompra = parseFloat(precioCompraInput.value);
            const precioVenta = parseFloat(precioVentaInput.value);
            const cantidad = parseInt(cantidadInput.value);

            // Validar Precio Compra
            if (isNaN(precioCompra) || precioCompra <= 0) {
                precioCompraInput.classList.add('field-error');
                let errorDiv = precioCompraInput.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    precioCompraInput.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Precio de compra debe ser mayor que cero.';
                errorDiv.style.display = 'block';
                esValido = false;
            }

            // Validar Precio Venta
            if (isNaN(precioVenta) || precioVenta <= 0) {
                precioVentaInput.classList.add('field-error');
                let errorDiv = precioVentaInput.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    precioVentaInput.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Precio de venta debe ser mayor que cero.';
                errorDiv.style.display = 'block';
                esValido = false;
            } else if (precioVenta < precioCompra) {
                precioVentaInput.classList.add('field-error');
                let errorDiv = precioVentaInput.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    precioVentaInput.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Precio de venta no puede ser menor que el precio de compra.';
                errorDiv.style.display = 'block';
                esValido = false;
            }

            // Validar Cantidad (solo mayor que cero)
            if (isNaN(cantidad) || cantidad <= 0) {
                cantidadInput.classList.add('field-error');
                let errorDiv = cantidadInput.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    precioVentaInput.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Cantidad debe ser un número entero mayor que cero.';
                errorDiv.style.display = 'block';
                esValido = false;
            }

            return esValido;
        }

        function validarFormularioPrincipal() {
            let esValido = true;
            let primerCampoConError = null;

            // Ocultar errores previos manejados por JS
            // Asegúrate de incluir 'fecha' aquí para que su error-mensaje-js se limpie
            ['numeroFactura', 'fecha', 'proveedor_id', 'formaPago', 'responsable_id'].forEach(campo => {
                ocultarError(campo);
            });

            const errorProductos = document.getElementById('errorProductos');
            if (errorProductos) {
                errorProductos.style.display = 'none';
            }

            // Validar Número de Factura
            const numeroFacturaInput = document.getElementById('numeroFactura');
            const numeroFactura = numeroFacturaInput.value.trim();
            if (!numeroFactura) {
                mostrarError('numeroFactura', 'Número de factura es obligatorio');
                if (!primerCampoConError) primerCampoConError = numeroFacturaInput;
                esValido = false;
            }

            // Validar Fecha
            const fechaInput = document.getElementById('fecha');
            const fecha = fechaInput.value.trim();
            if (!fecha) { // Si el campo de fecha está vacío
                mostrarError('fecha', 'La fecha es obligatoria'); // Llama a mostrarError para la fecha
                if (!primerCampoConError) primerCampoConError = fechaInput;
                esValido = false;
            }
            // Puedes añadir aquí más validaciones de JS para la fecha si las necesitas (ej. rango)
            // Pero recuerda que Laravel también valida el rango, así que no dupliques innecesariamente.


            // Validar Proveedor
            const proveedorSelect = document.getElementById('proveedor_id');
            const proveedorId = proveedorSelect.value;
            if (!proveedorId) {
                mostrarError('proveedor_id', 'Proveedor es obligatorio');
                if (!primerCampoConError) primerCampoConError = proveedorSelect;
                esValido = false;
            }

            // Validar Forma de Pago
            const formaPagoSelect = document.getElementById('formaPago');
            const formaPago = formaPagoSelect.value;
            if (!formaPago) {
                mostrarError('formaPago', 'Forma de pago es obligatorio');
                if (!primerCampoConError) primerCampoConError = formaPagoSelect;
                esValido = false;
            }

            // Validar Responsable
            const responsableSelect = document.getElementById('responsable_id');
            const responsableId = responsableSelect.value;
            if (!responsableId) {
                mostrarError('responsable_id', 'Responsable es obligatorio');
                if (!primerCampoConError) primerCampoConError = responsableSelect;
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
                    // El formulario se enviará si esta función devuelve true
                    return true;
                });
            }
        }

        // --- Función para cargar productos en el modal desde la API ---
        async function cargarProductosEnModal(searchTerm = '') {
            const tbody = document.getElementById('tablaProductosBody');
            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-3">Cargando productos...</td></tr>';

            try {
                const apiUrl = `/api/productos?search=${encodeURIComponent(searchTerm)}`;
                const response = await fetch(apiUrl);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const productos = await response.json();

                tbody.innerHTML = ''; // Limpiar antes de añadir nuevos resultados

                if (productos.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-3 text-muted">No se encontraron productos.</td></tr>';
                    mostrarResultados(searchTerm, 0);
                    return;
                }

                productos.forEach(producto => {
                    const fila = document.createElement('tr');
                    fila.className = 'producto-fila';
                    fila.setAttribute('data-id', producto.id);
                    fila.setAttribute('data-nombre', producto.nombre);
                    fila.setAttribute('data-categoria', producto.categoria);
                    fila.setAttribute('data-cantidad-disponible', producto.cantidad);
                    fila.setAttribute('data-es-exento', producto.es_exento ? 'true' : 'false');

                    const ivaDisplay = producto.es_exento ? '0% (Exento)' : '15% (No Exento)';

                    fila.innerHTML = `
                        <td>${producto.nombre}</td>
                        <td>${producto.categoria}</td>
                        <td><span class="badge bg-secondary">${producto.cantidad}</span></td>
                        <td>${ivaDisplay}</td>
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
                        <td colspan="4">
                            <form class="d-flex align-items-end gap-2 form-edicion-producto p-2" novalidate >
                                <div style="width: 25%;">
                                    <label class="form-label">Precio Compra (Lps)</label>
                                    <input type="number" step="0.01" min="0.01" max="9999" class="form-control precioCompra" required>
                                    <div class="error-message"></div>
                                </div>
                                <div style="width: 25%;">
                                    <label class="form-label">Precio Venta (Lps)</label>
                                    <input type="number" step="0.01" min="0.01" max="9999" class="form-control precioVenta" required>
                                    <div class="error-message"></div>
                                </div>
                                <div style="width: 20%;">
                                    <label class="form-label">Cantidad</label>
                                    <input type="number" min="1" max="999" class="form-control cantidad" required>
                                    <div class="error-message"></div>
                                </div>
                                <div class="d-flex gap-1">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> Agregar
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm limpiar-campos">
                                         <i class="bi bi-eraser-fill"></i> Limpiar
                                    </button>
                                </div>
                            </form>
                        </td>
                    `;
                    tbody.appendChild(fila);
                    tbody.appendChild(filaEdicion);
                });
                configurarEventosProductos();
                mostrarResultados(searchTerm, productos.length);
            } catch (error) {
                console.error('Error al cargar productos:', error);
                tbody.innerHTML = '<tr><td colspan="5" class="text-center py-3 text-danger">Error al cargar productos. Intente de nuevo.</td></tr>';
                mostrarResultados(searchTerm, 0);
            }
        }

        /**
         * Maneja la entrada de caracteres para campos numéricos (type="number").
         * Permite solo dígitos y un punto decimal opcional para campos decimales.
         * Formatea a 2 decimales en el evento 'blur' para campos decimales.
         * Los límites numéricos (min/max) se manejan con los atributos HTML del input.
         *
         * @param {HTMLInputElement} input El elemento input.
         * @param {number} maxIntegerDigits El número máximo de dígitos permitidos en la parte entera.
         * @param {boolean} isDecimal Indica si el campo acepta decimales.
         */
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
                if (value === '') {
                    return;
                }

                let numValue = parseFloat(value);
                let min = parseFloat(e.target.getAttribute('min'));
                let max = parseFloat(e.target.getAttribute('max'));

                if (isNaN(numValue)) {
                    e.target.value = '';
                    return;
                }

                // Ajusta el valor si está fuera de los límites min/max del atributo HTML
                if (!isNaN(min) && numValue < min) {
                    e.target.value = min.toFixed(isDecimal ? 2 : 0);
                } else if (!isNaN(max) && numValue > max) {
                    e.target.value = max.toFixed(isDecimal ? 2 : 0);
                }

                // Formatear a 2 decimales solo si es un campo decimal y tiene un valor
                if (isDecimal && e.target.value !== '') {
                    e.target.value = parseFloat(e.target.value).toFixed(2);
                }
            });
        }

        // --- Función para configurar eventos de productos (la que añade productos desde el modal) ---
        function configurarEventosProductos() {
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
                        form.querySelector('.cantidad').value = '';

                        form.querySelector('.precioCompra').focus();
                    } else {
                        filaEdicion.style.display = 'none';
                        this.className = 'btn btn-sm btn-info seleccionar-producto';
                        this.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
                        productoSeleccionadoActual = null;
                    }
                });
            });

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
                        if (mensaje.parentNode) {
                            mensaje.remove();
                        }
                    });
                });
            });

            document.querySelectorAll('.form-edicion-producto').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    console.log('DEBUG: Intentando agregar producto. Validando formulario de producto...');

                    if (!validarFormularioProducto(this)) {
                        console.log('DEBUG: Validación del formulario de producto falló.');
                        return;
                    }
                    console.log('DEBUG: Validación del formulario de producto exitosa.');

                    const filaEdicion = this.closest('.producto-edicion-fila');
                    const filaProducto = filaEdicion.previousElementSibling;

                    const product_id = filaProducto.dataset.id;
                    const nombre = filaProducto.dataset.nombre;
                    const categoria = filaProducto.dataset.categoria;
                    const precioCompra = parseFloat(this.querySelector('.precioCompra').value);
                    const precioVenta = parseFloat(this.querySelector('.precioVenta').value);
                    const cantidad = parseInt(this.querySelector('.cantidad').value);
                    const iva = filaProducto.dataset.esExento === 'true' ? 0 : 15;


                    const tablaFactura = document.getElementById('tablaFacturaBody');
                    const productosExistentes = Array.from(tablaFactura.querySelectorAll('tr')).map(tr => {
                        const idInput = tr.querySelector('input[name^="productos["][name$="][product_id]"]');
                        return idInput ? idInput.value : null;
                    });

                    if (productosExistentes.includes(product_id)) {
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
                        console.log('DEBUG: Producto ya existente en la factura.');
                        return;
                    }

                    const base = precioCompra * cantidad;
                    const impuesto = (iva / 100) * base;
                    const subtotal = base + impuesto;

                    const nuevaFila = document.createElement('tr');

                    const currentIndex = productoIndexCounter++;

                    nuevaFila.dataset.index = currentIndex;
                    nuevaFila.innerHTML = `
                        <td>${currentIndex + 1}</td>
                        <td>
                            <input type="hidden" name="productos[${currentIndex}][product_id]" value="${product_id}" class="hidden-product-id">
                            <input type="hidden" name="productos[${currentIndex}][nombre]" value="${nombre}" class="hidden-nombre">
                            ${nombre}
                        </td>
                        <td>
                            <input type="hidden" name="productos[${currentIndex}][categoria]" value="${categoria}" class="hidden-categoria">
                            ${categoria}
                        </td>
                        <td>
                            <input type="hidden" name="productos[${currentIndex}][precioCompra]" value="${precioCompra.toFixed(2)}" class="hidden-precio-compra">
                            ${precioCompra.toFixed(2)}
                        </td>
                        <td>
                            <input type="hidden" name="productos[${currentIndex}][cantidad]" value="${cantidad}" class="hidden-cantidad">
                            <input type="hidden" name="productos[${currentIndex}][precioVenta]" value="${precioVenta.toFixed(2)}" class="hidden-precio-venta">
                            ${cantidad}
                        </td>
                        <td>
                            <input type="hidden" name="productos[${currentIndex}][iva]" value="${iva}" class="hidden-iva">
                            ${iva}%
                        </td>
                        <td class="subtotal-producto">${subtotal.toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto" title="Eliminar producto">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    `;
                    tablaFactura.appendChild(nuevaFila);
                    actualizarFilaVacia();

                    const modalElement = document.getElementById('productosModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);

                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    // La llamada a limpiarFormulariosModal() está en el evento hidden.bs.modal, no aquí.
                    console.log('DEBUG: Producto agregado y totales recalculados.');

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

            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const termino = this.value.replace(/^\s*\d*\s*/, '').toLowerCase().trim();

                searchTimeout = setTimeout(() => {
                    cargarProductosEnModal(termino);
                }, 300);
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
                    <td colspan="8" class="text-center text-muted py-4" style="border: 1px dashed #dee2e6; background-color: #f8f9fa;">
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
            const tablaFacturaBody = document.getElementById('tablaFacturaBody');
            const filasProductos = tablaFacturaBody.querySelectorAll('tr:not(#filaVacia)');
            let subtotalGeneral = 0;
            let impuestosGeneral = 0;

            filasProductos.forEach(fila => {
                const precioCompra = parseFloat(fila.querySelector('.hidden-precio-compra').value);
                const cantidad = parseInt(fila.querySelector('.hidden-cantidad').value);
                const iva = parseInt(fila.querySelector('.hidden-iva').value);

                const base = precioCompra * cantidad;
                const impuesto = (iva / 100) * base;

                subtotalGeneral += base;
                impuestosGeneral += impuesto;
            });

            const totalGeneral = subtotalGeneral + impuestosGeneral;

            document.getElementById('subtotalGeneralLabel').textContent = subtotalGeneral.toFixed(2); // Subtotal (base imponible)
            document.getElementById('impuestosGeneralLabel').textContent = impuestosGeneral.toFixed(2); // Impuestos
            document.getElementById('totalGeneralLabel').textContent = totalGeneral.toFixed(2); // Total final
        }

        // --- DOMContentLoaded Listener ---
        document.addEventListener("DOMContentLoaded", function () {
            const btnLimpiar = document.getElementById('btnLimpiar');
            if (btnLimpiar) {
                btnLimpiar.addEventListener('click', function (e) {
                    e.preventDefault();
                    limpiarFormularioCompleto();
                });
            }

            setTimeout(() => {
                document.querySelectorAll('.form-edicion-producto .precioCompra').forEach(input => {
                    handleNumericInput(input, 4, true);
                });
                document.querySelectorAll('.form-edicion-producto .precioVenta').forEach(input => {
                    handleNumericInput(input, 4, true);
                });
                document.querySelectorAll('.form-edicion-producto .cantidad').forEach(input => {
                    handleNumericInput(input, 3, false);
                });
            }, 500);

            configurarValidacionFormulario();
            cargarProductosEnModal();
            configurarBuscador();

            const tablaFacturaBody = document.getElementById('tablaFacturaBody');

            // --- INICIO DE LA LÓGICA DE REPOBLACIÓN CORREGIDA ---

            let productsToLoad = [];

            // 1. Intentar cargar desde `old()` data primero (si hay errores de validación)
            const oldProductsFromSession = @json(session()->getOldInput('productos'));

            if (oldProductsFromSession && Object.keys(oldProductsFromSession).length > 0) {
                // `oldProductsFromSession` es un objeto como {0: {product_id: 'x', nombre: 'y'}, 1: {...}}
                // Convertirlo a un array de objetos más fácil de manejar
                for (const key in oldProductsFromSession) {
                    if (Object.hasOwnProperty.call(oldProductsFromSession, key)) {
                        const prodData = oldProductsFromSession[key];
                        productsToLoad.push({
                            product_id: String(prodData.product_id || ''),
                            nombre: String(prodData.nombre || ''),
                            categoria: String(prodData.categoria || ''),
                            precioCompra: parseFloat(prodData.precioCompra || 0),
                            precioVenta: parseFloat(prodData.precioVenta || 0),
                            cantidad: parseInt(prodData.cantidad || 0),
                            iva: parseFloat(prodData.iva || 0),
                            total: parseFloat(prodData.total || 0) // Si el total ya viene en old, úsalo
                        });
                    }
                }
                console.log('DEBUG: Productos cargados desde old() data:', productsToLoad);

            } else {
                // 2. Si no hay `old()` data, intentar cargar desde la factura existente (modo edición)
                const existingFacturaDetalles = @json(isset($factura) ? $factura->detalles : null);
                if (existingFacturaDetalles && existingFacturaDetalles.length > 0) {
                    productsToLoad = existingFacturaDetalles.map(detail => ({
                        product_id: String(detail.product_id || ''),
                        nombre: String(detail.producto || ''),
                        categoria: String(detail.categoria || ''),
                        precioCompra: parseFloat(detail.precio_compra || 0),
                        precioVenta: parseFloat(detail.precio_venta || 0),
                        cantidad: parseInt(detail.cantidad || 0),
                        iva: parseFloat(detail.iva || 0),
                        total: parseFloat(detail.total || 0)
                    }));
                    console.log('DEBUG: Cargando productos desde detalles de factura existentes:', productsToLoad);
                }
            }

            // Asegurarse de que el contador de índice de productos sea el correcto
            productoIndexCounter = productsToLoad.length;

            if (productsToLoad.length > 0) {
                tablaFacturaBody.innerHTML = ''; // Limpiar la fila vacía si hay productos
                productsToLoad.forEach((producto, index) => {
                    // Recalcular subtotal aquí para asegurar consistencia
                    // Esto es útil si `old()` no siempre guarda el 'total' calculado
                    const baseProductoRepoblado = producto.precioCompra * producto.cantidad;
                    const impuestoProductoRepoblado = (producto.iva / 100) * baseProductoRepoblado;
                    const subtotalDisplay = (baseProductoRepoblado + impuestoProductoRepoblado).toFixed(2);

                    const nuevaFila = document.createElement('tr');
                    nuevaFila.dataset.index = index; // Usar el índice del array
                    nuevaFila.innerHTML = `
                        <td>${index + 1}</td>
                        <td>
                            <input type="hidden" name="productos[${index}][product_id]" value="${producto.product_id}" class="hidden-product-id">
                            <input type="hidden" name="productos[${index}][nombre]" value="${producto.nombre}" class="hidden-nombre">
                            ${producto.nombre}
                        </td>
                        <td>
                            <input type="hidden" name="productos[${index}][categoria]" value="${producto.categoria}" class="hidden-categoria">
                            ${producto.categoria}
                        </td>
                        <td>
                            <input type="hidden" name="productos[${index}][precioCompra]" value="${producto.precioCompra.toFixed(2)}" class="hidden-precio-compra">
                            ${producto.precioCompra.toFixed(2)}
                        </td>
                        <td>
                            <input type="hidden" name="productos[${index}][cantidad]" value="${producto.cantidad}" class="hidden-cantidad">
                            <input type="hidden" name="productos[${index}][precioVenta]" value="${producto.precioVenta.toFixed(2)}" class="hidden-precio-venta">
                            ${producto.cantidad}
                        </td>
                        <td>
                            <input type="hidden" name="productos[${index}][iva]" value="${producto.iva}" class="hidden-iva">
                            ${producto.iva}%
                        </td>
                        <td class="subtotal-producto">${subtotalDisplay}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto" title="Eliminar producto">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    `;
                    tablaFacturaBody.appendChild(nuevaFila);
                });
                actualizarFilaVacia(); // Ocultará la fila vacía si hay productos
                calcularTotalesGenerales();
            } else {
                actualizarFilaVacia(); // Asegurará que la fila vacía se muestre si no hay productos
                calcularTotalesGenerales();
            }
            // --- FIN DE LA LÓGICA DE REPOBLACIÓN CORREGIDA ---
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-eliminar-producto')) {
                const fila = e.target.closest('tr');
                fila.remove();
                calcularTotalesGenerales();
                actualizarFilaVacia();
            }
        });

        const productosModalElement = document.getElementById('productosModal');
        if (productosModalElement) {
            productosModalElement.addEventListener('hidden.bs.modal', function () {
                console.log('DEBUG: El modal de productos ha terminado de ocultarse (evento hidden.bs.modal disparado).');

                document.body.classList.remove('modal-open');
                console.log('DEBUG: Clase modal-open eliminada del body.');

                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.documentElement.style.overflow = '';
                console.log('DEBUG: Body overflow/padding-right restored.');

                limpiarFormulariosModal(); // Llama a la función para limpiar
                console.log('DEBUG: Formularios del modal limpiados al cerrar.');
            });
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
