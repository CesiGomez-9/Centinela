@extends('layouts.plantilla')
@section('titulo','Registrar una factura')
@section('content')

    <style>
        body {
            background-color: #e6f0ff;
            margin: 0;
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
                                           maxlength="20" value="{{ old('numero_factura') }}"
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
                                    <input type="date" name="fecha" id="fecha" min="2000-01-01" max="2099-12-31"
                                           class="form-control @error('fecha') is-invalid @enderror"
                                           value="{{ old('fecha') }}" required>
                                </div>
                                @error('fecha')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Proveedor (Select) --}}
                            <div class="col-md-6">
                                <label for="proveedor" class="form-label">Proveedor</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <select id="proveedor" name="proveedor" class="form-select" required>
                                        <option value="">Seleccione un proveedor</option>
                                        <option value="TE seguridad">TE seguridad</option>
                                        <option value="TecnoSeguridad SA">TecnoSeguridad SA</option>
                                        <option value="Alarmas Prosegur">Alarmas Prosegur</option>
                                        <option value="Seguridad Total">Seguridad Total</option>
                                        <option value="LockPro Cerraduras">LockPro Cerraduras</option>
                                        <option value="VigiTech Honduras">VigiTech Honduras</option>
                                        <option value="Securitas HN">Securitas HN</option>
                                        <option value="AlertaHN">AlertaHN</option>
                                        <option value="MoniSegur">MoniSegur</option>
                                        <option value="RejaMax">RejaMax</option>
                                    </select>
                                </div>
                                @error('proveedor')
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
                                        @php
                                            $formasPago = ['Efectivo', 'Cheque', 'Transferencia'];
                                        @endphp
                                        @foreach ($formasPago as $forma)
                                            <option value="{{ $forma }}" {{ old('forma_pago') === $forma ? 'selected' : '' }}>
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

                            {{-- Responsable --}}
                            <div class="col-md-6">
                                <label for="responsable" class="form-label">Responsable</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-check-fill"></i></span>
                                    <input type="text" name="responsable" id="responsable"
                                           class="form-control @error('responsable') is-invalid @enderror"
                                           maxlength="50" value="{{ old('responsable') }}"
                                           required>
                                </div>
                                @error('responsable')
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
        const fechaInput = document.getElementById('fecha');
        const errorFecha = document.createElement('div');
        errorFecha.style.color = 'red';
        errorFecha.style.fontSize = '0.9rem';
        errorFecha.style.marginTop = '4px';
        fechaInput.parentNode.appendChild(errorFecha);

        // Función para validar fecha - CORREGIDA
        function validarFecha() {
            const fechaInput = document.getElementById('fecha');
            const val = fechaInput.value;

            if (!val) {
                mostrarError('fecha', 'La fecha es obligatoria');
                return false;
            }

            if (val.length === 10) {
                const year = val.substring(0, 4);
                if (!year.startsWith('2')) {
                    mostrarError('fecha', 'El año debe comenzar con "2" (entre 2000 y 2099)');
                    return false;
                }
            }

            ocultarError('fecha');
            return true;
        }

        fechaInput.addEventListener('input', function() {
            const val = this.value;
            if (val.length === 10) {
                const year = val.substring(0,4);
                if (!year.startsWith('2')) {
                    errorFecha.textContent = 'El año debe comenzar con "2" (entre 2000 y 2099).';
                } else {
                    errorFecha.textContent = '';
                }
            } else {
                errorFecha.textContent = '';
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const numeroInput = document.querySelector('input[name="numero_factura"]');

            if (numeroInput) {
                numeroInput.addEventListener('keypress', function (e) {
                    const key = e.key;
                    const pos = this.selectionStart;

                    // Solo permite letras, números y guiones
                    const permitido = /^[A-Za-z0-9\-]$/;

                    // Si el primer carácter no es letra o número, se bloquea
                    if (pos === 0 && !/^[A-Za-z0-9]$/.test(key)) {
                        e.preventDefault();
                        return false;
                    }

                    // Si en cualquier posición se escribe algo no permitido, se bloquea
                    if (!permitido.test(key)) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
        });

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

        document.addEventListener("DOMContentLoaded", function () {
            // Configurar el botón Limpiar
            const btnLimpiar = document.getElementById('btnLimpiar');

            if (btnLimpiar) {
                btnLimpiar.addEventListener('click', function (e) {
                    e.preventDefault();
                    limpiarFormularioCompleto();
                });
            }
        });

        function limpiarFormularioCompleto() {
            const form = document.getElementById('facturaForm');

            if (!form) return;

            // 1. Limpiar campos básicos del formulario
            form.querySelectorAll('input[type="text"], input[type="date"], input[type="number"]').forEach(input => {
                input.value = '';
                input.classList.remove('is-valid', 'is-invalid');
            });

            // 2. Resetear selects
            form.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0;
                select.classList.remove('is-valid', 'is-invalid');
            });

            // 3. Limpiar tabla de productos
            const tablaFacturaBody = document.getElementById('tablaFacturaBody');
            if (tablaFacturaBody) {
                // Eliminar todas las filas excepto la fila vacía
                const filas = tablaFacturaBody.querySelectorAll('tr:not(#filaVacia)');
                filas.forEach(fila => fila.remove());

                // Mostrar la fila vacía
                actualizarFilaVacia();
            }

            // 4. Resetear totales
            document.getElementById('subtotalGeneral').value = '';
            document.getElementById('impuestosGeneral').value = '';
            document.getElementById('totalGeneral').value = '';

            // 5. Limpiar mensajes de error
            form.querySelectorAll('.text-danger, .invalid-feedback, .error-message').forEach(error => {
                error.style.display = 'none';
                error.textContent = '';
            });

            // 6. Ocultar error de productos si está visible
            const errorProductos = document.getElementById('errorProductos');
            if (errorProductos) {
                errorProductos.style.display = 'none';
            }

            // 7. Cerrar modal si está abierto
            const modal = document.getElementById('productosModal');
            if (modal) {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }

            // 8. Resetear formularios del modal
            limpiarFormulariosModal();

            // 9. Enfocar el primer campo
            const primerCampo = form.querySelector('input[name="numero_factura"]');
            if (primerCampo) {
                primerCampo.focus();
            }
        }

        function limpiarFormulariosModal() {
            // Limpiar formularios de edición de productos en el modal
            const formulariosModal = document.querySelectorAll('.form-edicion-producto');
            formulariosModal.forEach(form => {
                form.reset();

                // Remover clases de validación
                form.querySelectorAll('.form-control, .form-select').forEach(input => {
                    input.classList.remove('is-valid', 'is-invalid', 'field-error');
                });

                // Limpiar mensajes de error
                form.querySelectorAll('.error-message').forEach(error => {
                    error.style.display = 'none';
                });
            });

            // Ocultar filas de edición y resetear botones
            document.querySelectorAll('.producto-edicion-fila').forEach(fila => {
                fila.style.display = 'none';
            });

            document.querySelectorAll('.seleccionar-producto').forEach(btn => {
                btn.className = 'btn btn-sm btn-info seleccionar-producto';
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
            });

            // Resetear variable global
            productoSeleccionadoActual = null;

            // Limpiar buscador
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.value = '';

                // Mostrar todas las filas de productos
                document.querySelectorAll('#tablaProductosBody .producto-fila').forEach(fila => {
                    fila.style.display = 'table-row';

                    // Quitar resaltado
                    const celdaNombre = fila.querySelector('td:first-child');
                    if (celdaNombre) {
                        quitarResaltado(celdaNombre);
                    }
                });

                // Limpiar resultados de búsqueda
                const searchResults = document.getElementById('searchResults');
                if (searchResults) {
                    searchResults.innerHTML = '';
                }
            }
        }

        // Función auxiliar para mostrar errores
        function mostrarError(campoId, mensaje) {
            const campo = document.getElementById(campoId);
            if (!campo) return;

            campo.classList.add('is-invalid');

            let errorDiv = campo.parentNode.querySelector('.text-danger');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'text-danger mt-1 small';
                campo.parentNode.appendChild(errorDiv);
            }
            errorDiv.textContent = mensaje;
            errorDiv.style.display = 'block';
        }

        // Función auxiliar para ocultar errores
        function ocultarError(campoId) {
            const campo = document.getElementById(campoId);
            if (!campo) return;

            campo.classList.remove('is-invalid');

            const errorDiv = campo.parentNode.querySelector('.text-danger');
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
        }

        // Datos de productos
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

        let productoSeleccionadoActual = null;

        function validarFormularioProducto(form) {
            const precioCompra = form.querySelector('.precioCompra');
            const precioVenta = form.querySelector('.precioVenta');
            const cantidad = form.querySelector('.cantidad');
            const iva = form.querySelector('.iva');

            let esValido = true;

            // Limpiar errores previos
            form.querySelectorAll('.error-message').forEach(error => {
                error.style.display = 'none';
            });
            form.querySelectorAll('.field-error').forEach(field => {
                field.classList.remove('field-error');
            });

            // Validar precio de compra
            if (!precioCompra.value || parseFloat(precioCompra.value) <= 0) {
                precioCompra.classList.add('field-error');
                let errorDiv = precioCompra.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    precioCompra.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Precio de compra es obligatorio.';
                errorDiv.style.display = 'block';
                esValido = false;
            }

            // Validar precio de venta
            if (!precioVenta.value || parseFloat(precioVenta.value) <= 0) {
                precioVenta.classList.add('field-error');
                let errorDiv = precioVenta.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    precioVenta.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Precio de venta es obligatorio.';
                errorDiv.style.display = 'block';
                esValido = false;
            }

            // Validar cantidad
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

            // Validar iva
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

        // Inicializar cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarProductosEnModal();
            configurarBuscador();
            configurarValidacionFormulario();
        });

        // NUEVA FUNCIÓN - Configurar validación del formulario principal
        function configurarValidacionFormulario() {
            const form = document.getElementById('facturaForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Formulario enviado, validando...');

                    // Validar formulario
                    if (!validarFormularioPrincipal()) {
                        console.log('Validación falló, previniendo envío');
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }

                    console.log('Validación exitosa, enviando formulario...');
                    // Si llegamos aquí, el formulario es válido y se puede enviar
                    return true;
                });
            }
        }

        // Cargar productos en el modal
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

                    // Fila de edición (oculta inicialmente)
                    const filaEdicion = document.createElement('tr');
                    filaEdicion.className = 'producto-edicion-fila';
                    filaEdicion.style.display = 'none';
                    filaEdicion.innerHTML = `
                <td colspan="3">
                    <form class="d-flex align-items-end gap-2 form-edicion-producto p-2" novalidate >
                        <div class="width: 18%;">
                            <label class="form-label">Precio Compra (Lps)</label>
                            <input type="number" min="0" max="9999" maxlength="4"  class="form-control precioCompra" required>
                        </div>
                        <div class="width: 18%;">
                            <label class="form-label">Precio Venta (Lps)</label>
                            <input type="number" min="0" max="9999" maxlength="4" class="form-control precioVenta" required>
                        </div>
                        <div class="width: 10%;">
                            <label class="form-label">Cantidad</label>
                            <input type="number" min="1" max="999" maxlength="3" class="form-control cantidad" required>
                        </div>
                        <div class="width: 20%;">
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

        document.addEventListener('DOMContentLoaded', function() {
            // Función para limitar dígitos
            function limitarDigitos(input, maxDigitos) {
                if (!input) return;

                input.addEventListener('input', function(e) {
                    // Remover cualquier carácter que no sea número
                    let valor = e.target.value.replace(/[^0-9]/g, '');

                    // Limitar a máximo de dígitos
                    if (valor.length > maxDigitos) {
                        valor = valor.slice(0, maxDigitos);
                    }

                    e.target.value = valor;
                });

                // Prevenir entrada de caracteres no numéricos
                input.addEventListener('keypress', function(e) {
                    // Permitir solo números, backspace, delete, etc.
                    if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e.key)) {
                        e.preventDefault();
                    }
                });

                // Validar al salir del campo
                input.addEventListener('blur', function(e) {
                    let valor = parseInt(e.target.value) || 0;
                    let max = parseInt(e.target.getAttribute('max'));

                    if (valor > max) {
                        e.target.value = max;
                    }
                });
            }

            // Aplicar limitaciones cuando se cargan los productos
            setTimeout(() => {
                const precioCompra = document.querySelector('.precioCompra');
                const precioVenta = document.querySelector('.precioVenta');
                const cantidad = document.querySelector('.cantidad');

                if (precioCompra) limitarDigitos(precioCompra, 4);
                if (precioVenta) limitarDigitos(precioVenta, 4);
                if (cantidad) limitarDigitos(cantidad, 3);
            }, 1000);
        });

        // Configurar eventos de productos
        function configurarEventosProductos() {
            // Botones seleccionar producto
            document.querySelectorAll('.seleccionar-producto').forEach(btn => {
                btn.addEventListener('click', function() {
                    const fila = this.closest('tr');
                    const filaEdicion = fila.nextElementSibling;

                    // Ocultar cualquier otra fila de edición activa
                    document.querySelectorAll('.producto-edicion-fila').forEach(f => {
                        if (f !== filaEdicion) {
                            f.style.display = 'none';
                        }
                    });

                    // Resetear botones
                    document.querySelectorAll('.seleccionar-producto').forEach(b => {
                        b.className = 'btn btn-sm btn-info seleccionar-producto';
                        b.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
                    });

                    // Mostrar/ocultar fila de edición
                    if (filaEdicion.style.display === 'none') {
                        filaEdicion.style.display = 'table-row';
                        this.className = 'btn btn-sm btn-success seleccionar-producto btn-seleccionar-activo';
                        this.innerHTML = '<i class="bi bi-check-circle-fill"></i> Seleccionado';
                        productoSeleccionadoActual = fila;

                        // Limpiar campos del formulario
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

                    // Limpiar todos los campos del formulario
                    form.reset();

                    // Remover clases de validación y error
                    form.querySelectorAll('.form-control, .form-select').forEach(input => {
                        input.classList.remove('is-valid', 'is-invalid', 'field-error');
                        input.setCustomValidity('');
                    });

                    // Remover clase was-validated del formulario (Bootstrap)
                    form.classList.remove('was-validated');

                    // Limpiar mensajes de error/validación
                    form.querySelectorAll('.invalid-feedback, .valid-feedback, .error-message, .text-danger, .text-success').forEach(mensaje => {
                        mensaje.remove();
                    });

                    // Ocultar elementos de mensaje de error específicos
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

                    // Verificar si el producto ya está en la factura
                    const tablaFactura = document.getElementById('tablaFacturaBody');
                    const productosExistentes = Array.from(tablaFactura.querySelectorAll('tr')).map(tr => {
                        const nombreInput = tr.querySelector('input[name="productos[][nombre]"]');
                        return nombreInput ? nombreInput.value : null;
                    });

                    if (productosExistentes.includes(nombre)) {
                        // Mostrar mensaje de error en lugar de alert
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
                    nuevaFila.innerHTML = `
                <td>
                    <input type="hidden" name="productos[][nombre]" value="${nombre}">
                    ${nombre}
                </td>
                <td>
                    <input type="hidden" name="productos[][categoria]" value="${categoria}">
                    ${categoria}
                </td>
                <td>
                    <input type="hidden" name="productos[][precioCompra]" value="${precioCompra}">
                    ${precioCompra.toFixed(2)}
                </td>
                <td>
                    <input type="hidden" name="productos[][cantidad]" value="${cantidad}">
                    <input type="hidden" name="productos[][precioVenta]" value="${precioVenta}">
                    ${cantidad}
                </td>
                <td>
                    <input type="hidden" name="productos[][iva]" value="${iva}">
                    ${iva}%
                </td>
                <td class="subtotal-producto">
                    ${subtotal.toFixed(2)}
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto" title="Eliminar producto">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;

                    tablaFactura.appendChild(nuevaFila);
                    actualizarFilaVacia();

                    // Ocultar formulario de edición
                    filaEdicion.style.display = 'none';
                    const btnSeleccionar = filaProducto.querySelector('.seleccionar-producto');
                    btnSeleccionar.className = 'btn btn-sm btn-info seleccionar-producto';
                    btnSeleccionar.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
                    productoSeleccionadoActual = null;

                    // Calcular totales
                    calcularTotalesGenerales();

                    // Ocultar mensaje de error de productos si existe
                    document.getElementById('errorProductos').style.display = 'none';
                });
            });
        }

        // Configurar buscador corregido
        function configurarBuscador() {
            const searchInput = document.getElementById('searchInput');

            if (!searchInput) {
                console.error('No se encontró el elemento con ID "searchInput"');
                return;
            }

            searchInput.addEventListener('input', function() {
                // Remover espacios y números al inicio
                let termino = this.value.replace(/^\s*\d*\s*/, '').toLowerCase().trim();

                // Actualizar el input con el valor limpio
                this.value = termino;

                const filas = document.querySelectorAll('#tablaProductosBody .producto-fila');
                let resultadosVisibles = 0;

                filas.forEach(fila => {
                    const nombre = fila.dataset.nombre ? fila.dataset.nombre.toLowerCase() : '';
                    const filaEdicion = fila.nextElementSibling;

                    // Obtener la celda del nombre (primera celda td)
                    const celdaNombre = fila.querySelector('td:first-child');

                    if (termino === '' || nombre.includes(termino)) {
                        fila.style.display = 'table-row';
                        resultadosVisibles++;

                        // Ocultar fila de edición si no coincide con la búsqueda
                        if (filaEdicion && filaEdicion.style.display !== 'none') {
                            filaEdicion.style.display = 'none';
                            const btnSeleccionar = fila.querySelector('.seleccionar-producto');
                            if (btnSeleccionar) {
                                btnSeleccionar.className = 'btn btn-sm btn-info seleccionar-producto';
                                btnSeleccionar.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
                            }
                        }

                        // Resaltar texto encontrado si hay búsqueda
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

                // Mostrar resultados
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
            // Crear o actualizar el elemento de resultados si no existe
            let searchResults = document.getElementById('searchResults');

            if (!searchResults) {
                searchResults = document.createElement('div');
                searchResults.id = 'searchResults';
                searchResults.className = 'mt-2';

                // Insertar después del input de búsqueda
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


        // Función para mostrar/ocultar fila vacía
        function actualizarFilaVacia() {
            const tablaFactura = document.getElementById('tablaFacturaBody');
            const filaVacia = document.getElementById('filaVacia');
            const productosReales = tablaFactura.querySelectorAll('tr:not(#filaVacia)');

            if (productosReales.length === 0) {
                // Mostrar fila vacía si no hay productos
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
                // Ocultar fila vacía si hay productos
                if (filaVacia) {
                    filaVacia.style.display = 'none';
                }
            }
        }

        // Eliminar productos de la factura
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-eliminar-producto')) {
                const fila = e.target.closest('tr');
                fila.remove();
                calcularTotalesGenerales();
                actualizarFilaVacia();
            }
        });
        // Calcular totales generales
        function calcularTotalesGenerales() {
            const subtotales = document.querySelectorAll('.subtotal-producto');
            let subtotalGeneral = 0;
            let impuestosGeneral = 0;

            subtotales.forEach(td => {
                const fila = td.closest('tr');
                const precioCompra = parseFloat(fila.querySelector('input[name="productos[][precioCompra]"]').value);
                const cantidad = parseInt(fila.querySelector('input[name="productos[][cantidad]"]').value);
                const iva = parseInt(fila.querySelector('input[name="productos[][iva]"]').value);

                const base = precioCompra * cantidad;
                const impuesto = (iva / 100) * base;

                subtotalGeneral += base;
                impuestosGeneral += impuesto;
            });

            const totalGeneral = subtotalGeneral + impuestosGeneral;

            document.getElementById('subtotalGeneral').value = subtotalGeneral.toFixed(2);
            document.getElementById('impuestosGeneral').value = impuestosGeneral.toFixed(2);
            document.getElementById('totalGeneral').value = totalGeneral.toFixed(2);
        }


    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

