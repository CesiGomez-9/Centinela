@extends('layouts.plantilla')
@section('titulo','Registrar nueva factura')
@section('content')

    <style>
        body {
            background-color: #f2f7ff;
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
                        @isset($producto)
                            Editar una factura de compra
                        @else
                            Registrar una nueva factura de compra
                        @endisset
                    </h3>


                    <form method="POST" id="facturaForm" novalidate>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Número de factura</label>
                                <input type="text" name="numero_factura" id="numeroFactura" class="form-control" required maxlength="15">
                                <div class="error-message" id="error-numeroFactura">Número de factura es obligatorio</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" min="2000-01-01" max="2099-12-31"  required>
                                <div class="error-message" id="errorFecha">Fecha es obligatoria.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Proveedor</label>
                                <select name="proveedor" class="form-select" required>
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
                                <div class="error-message" id="errorProveedor">Proveedor es obligatorio.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Forma de pago</label>
                                <select name="forma_pago" class="form-select" required>
                                    <option value="">Seleccione una forma de pago</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Transferencia">Transferencia</option>
                                </select>
                                <div class="error-message" id="errorFormaPago">Forma de pago es obligatorio.</div>
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

                            <div class="col-md-6">
                                <label class="form-label">Responsable</label>
                                <input type="text" name="responsable" id="responsable" class="form-control" required maxlength="30">
                                <div class="error-message" id="error-responsable"></div>
                            </div>

                            <!-- Botones -->
                            <div class="text-center mt-5">
                                <a href="{{ route('facturas.index') }}" class="btn btn-danger me-2">
                                    <i class="bi bi-x-circle me-2"></i> Cancelar
                                </a>
                                <button type="reset" class="btn btn-warning me-2" id="btnLimpiar">
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
        <div class="modal-dialog modal-lg">
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
                    <div class="table-responsive" style="max-height: 500px;">
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

        // validar fecha
        // Función mejorada para forzar que el año siempre comience con "20"
        function configurarValidacionFecha() {
            const fechaInput = document.getElementById('fecha');

            if (!fechaInput) return;

            // Función para formatear el año
            function formatearAnio(valor) {
                if (!valor) return valor;

                const partes = valor.split('-');
                let anio = partes[0] || '';

                // Si el año tiene menos de 4 dígitos, completar con "20"
                if (anio.length === 1 || anio.length === 2) {
                    anio = '20' + anio.padStart(2, '0');
                } else if (anio.length === 3) {
                    anio = '20' + anio.slice(-2);
                } else if (anio.length === 4) {
                    // Si ya tiene 4 dígitos, verificar que comience con "20"
                    if (!anio.startsWith('20')) {
                        // Tomar los últimos 2 dígitos
                        anio = '20' + anio.slice(-2);
                    }
                } else if (anio.length > 4) {
                    // Si tiene más de 4 dígitos, tomar solo los primeros 4 y verificar
                    anio = anio.slice(0, 4);
                    if (!anio.startsWith('20')) {
                        anio = '20' + anio.slice(-2);
                    }
                }

                // Validar rango 2000-2099
                const anioNum = parseInt(anio);
                if (anioNum < 2000) anio = '2000';
                if (anioNum > 2099) anio = '2099';

                return anio;
            }

            // Función para validar fecha completa
            function validarFechaCompleta(fechaStr) {
                if (!fechaStr) return false;

                const fecha = new Date(fechaStr);
                const partes = fechaStr.split('-');

                if (partes.length !== 3) return false;

                const anio = parseInt(partes[0]);
                const mes = parseInt(partes[1]);
                const dia = parseInt(partes[2]);

                // Verificar que la fecha sea válida
                return fecha.getFullYear() === anio &&
                    fecha.getMonth() + 1 === mes &&
                    fecha.getDate() === dia &&
                    anio >= 2000 && anio <= 2099;
            }

            // Evento para formatear mientras se escribe
            fechaInput.addEventListener('input', function(e) {
                let valor = e.target.value;

                if (valor) {
                    const partes = valor.split('-');
                    if (partes[0]) {
                        const anioFormateado = formatearAnio(partes[0]);

                        // Reconstruir la fecha
                        const nuevaFecha = [anioFormateado, partes[1] || '', partes[2] || ''].join('-');

                        // Solo actualizar si es diferente para evitar loops
                        if (nuevaFecha !== valor) {
                            // Guardar la posición del cursor
                            const cursorPos = e.target.selectionStart;
                            e.target.value = nuevaFecha;

                            // Restaurar la posición del cursor
                            const nuevaPos = Math.min(cursorPos, nuevaFecha.length);
                            e.target.setSelectionRange(nuevaPos, nuevaPos);
                        }
                    }
                }

                // Validar fecha y mostrar/ocultar error
                const errorFecha = document.getElementById('errorFecha');
                if (valor && !validarFechaCompleta(valor)) {
                    if (errorFecha) {
                        errorFecha.textContent = 'Por favor ingrese una fecha válida (año entre 2000-2099)';
                        errorFecha.style.display = 'block';
                    }
                    e.target.classList.add('field-error');
                } else if (valor) {
                    if (errorFecha) {
                        errorFecha.style.display = 'none';
                    }
                    e.target.classList.remove('field-error');
                }
            });

            // Evento para validar al perder el foco
            fechaInput.addEventListener('blur', function(e) {
                let valor = e.target.value;

                if (valor) {
                    const partes = valor.split('-');
                    if (partes[0]) {
                        const anioFormateado = formatearAnio(partes[0]);

                        // Reconstruir la fecha
                        const nuevaFecha = [anioFormateado, partes[1] || '', partes[2] || ''].join('-');
                        e.target.value = nuevaFecha;

                        // Validar fecha final
                        if (!validarFechaCompleta(nuevaFecha)) {
                            const errorFecha = document.getElementById('errorFecha');
                            if (errorFecha) {
                                errorFecha.textContent = 'Fecha inválida. Por favor corrija la fecha.';
                                errorFecha.style.display = 'block';
                            }
                            e.target.classList.add('field-error');
                        } else {
                            const errorFecha = document.getElementById('errorFecha');
                            if (errorFecha) {
                                errorFecha.style.display = 'none';
                            }
                            e.target.classList.remove('field-error');
                        }
                    }
                }
            });

            // Evento para manejar pegado de texto
            fechaInput.addEventListener('paste', function(e) {
                setTimeout(() => {
                    let valor = e.target.value;

                    if (valor) {
                        const partes = valor.split('-');
                        if (partes[0]) {
                            const anioFormateado = formatearAnio(partes[0]);

                            // Reconstruir la fecha
                            const nuevaFecha = [anioFormateado, partes[1] || '', partes[2] || ''].join('-');
                            e.target.value = nuevaFecha;

                            // Disparar evento input para validación
                            e.target.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    }
                }, 0);
            });

            // Evento para teclas específicas
            fechaInput.addEventListener('keydown', function(e) {
                // Si presiona Enter, aplicar formato
                if (e.key === 'Enter') {
                    let valor = e.target.value;

                    if (valor) {
                        const partes = valor.split('-');
                        if (partes[0]) {
                            const anioFormateado = formatearAnio(partes[0]);

                            // Reconstruir la fecha
                            const nuevaFecha = [anioFormateado, partes[1] || '', partes[2] || ''].join('-');
                            e.target.value = nuevaFecha;

                            // Disparar evento input para validación
                            e.target.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    }
                }
            });

            // Evento para detectar cambios manuales en el año
            fechaInput.addEventListener('keyup', function(e) {
                // Solo procesar si se está escribiendo en la parte del año
                const cursorPos = e.target.selectionStart;
                const valor = e.target.value;

                if (cursorPos <= 4 && valor.length >= 4) {
                    const partes = valor.split('-');
                    if (partes[0] && partes[0].length >= 2) {
                        const anioFormateado = formatearAnio(partes[0]);

                        if (anioFormateado !== partes[0]) {
                            const nuevaFecha = [anioFormateado, partes[1] || '', partes[2] || ''].join('-');
                            e.target.value = nuevaFecha;

                            // Mantener cursor en posición apropiada
                            const nuevaPos = Math.min(cursorPos, 4);
                            e.target.setSelectionRange(nuevaPos, nuevaPos);
                        }
                    }
                }
            });
        }

        // Función de validación mejorada para el formulario
        function validarFecha() {
            const fechaInput = document.getElementById('fecha');
            const errorFecha = document.getElementById('errorFecha');

            if (!fechaInput || !errorFecha) return true;

            const valor = fechaInput.value;

            if (!valor) {
                errorFecha.textContent = 'Fecha es obligatoria';
                errorFecha.style.display = 'block';
                fechaInput.classList.add('field-error');
                return false;
            }

            // Validar formato y rango
            const fecha = new Date(valor);
            const partes = valor.split('-');

            if (partes.length !== 3) {
                errorFecha.textContent = 'Formato de fecha inválido';
                errorFecha.style.display = 'block';
                fechaInput.classList.add('field-error');
                return false;
            }

            const anio = parseInt(partes[0]);
            const mes = parseInt(partes[1]);
            const dia = parseInt(partes[2]);

            // Verificar que la fecha sea válida
            if (fecha.getFullYear() !== anio ||
                fecha.getMonth() + 1 !== mes ||
                fecha.getDate() !== dia) {
                errorFecha.textContent = 'Fecha inválida';
                errorFecha.style.display = 'block';
                fechaInput.classList.add('field-error');
                return false;
            }

            // Verificar rango de años
            if (anio < 2000 || anio > 2099) {
                errorFecha.textContent = 'El año debe estar entre 2000 y 2099';
                errorFecha.style.display = 'block';
                fechaInput.classList.add('field-error');
                return false;
            }

            // Si llegamos aquí, la fecha es válida
            errorFecha.style.display = 'none';
            fechaInput.classList.remove('field-error');
            return true;
        }

        // Función actualizada para validar formulario principal
        function validarFormularioPrincipal() {
            let esValido = true;

            // Limpiar errores previos
            ['numeroFactura', 'fecha', 'proveedor', 'formaPago', 'responsable'].forEach(campo => {
                ocultarError(campo);
            });
            document.getElementById('errorProductos').style.display = 'none';

            // Validar número de factura
            const numeroFactura = document.getElementById('numeroFactura').value.trim();
            if (!numeroFactura) {
                mostrarError('numeroFactura', 'Número de factura es obligatorio');
                esValido = false;
            }

            // Validar fecha usando la nueva función
            if (!validarFecha()) {
                esValido = false;
            }

            // Validar proveedor
            const proveedor = document.querySelector('select[name="proveedor"]').value;
            if (!proveedor) {
                mostrarError('proveedor', 'Proveedor es obligatorio');
                esValido = false;
            }

            // Validar forma de pago
            const formaPago = document.querySelector('select[name="forma_pago"]').value;
            if (!formaPago) {
                mostrarError('formaPago', 'Forma de pago es obligatorio');
                esValido = false;
            }

            // Validar responsable
            const responsable = document.getElementById('responsable').value.trim();
            if (!responsable) {
                mostrarError('responsable', 'Responsable es obligatorio');
                esValido = false;
            }

            // Validar productos
            const productos = document.querySelectorAll('#tablaFacturaBody tr:not(#filaVacia)');
            if (productos.length === 0) {
                document.getElementById('errorProductos').style.display = 'block';
                document.getElementById('errorProductos').textContent = 'Debe agregar al menos un producto a la factura';
                esValido = false;
            }

            return esValido;
        }

        // Llamar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            configurarValidacionFecha();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const numeroFactura = document.getElementById('numeroFactura');
            const responsable = document.getElementById('responsable');
            const errorNumeroFactura = document.getElementById('errorNumeroFactura');
            const errorResponsable = document.getElementById('errorResponsable');


            // Función para validar números (solo dígitos)
            function validarNumeros(input) {
                return /^\d*$/.test(input);
            }

            // Función para validar letras (solo letras y espacios, pero no espacios al inicio)
            function validarLetras(input) {
                return /^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]*$/.test(input) && !input.startsWith(' ');
            }

            // Función para prevenir espacios al inicio
            function prevenirEspacioInicial(e) {
                if (e.target.value === '' && e.key === ' ') {
                    e.preventDefault();
                }
            }

            // Validación para número de factura
            numeroFactura.addEventListener('input', function(e) {
                let valor = e.target.value;

                // Remover caracteres no numéricos
                valor = valor.replace(/\D/g, '');

                // Limitar a 15 caracteres
                if (valor.length > 15) {
                    valor = valor.substring(0, 15);
                }

                e.target.value = valor;

                // Validar y mostrar/ocultar error
                if (valor.length === 0) {
                    errorNumeroFactura.style.display = 'block';
                    numeroFactura.classList.add('invalid');
                } else {
                    errorNumeroFactura.style.display = 'none';
                    numeroFactura.classList.remove('invalid');
                }
            });

            // Prevenir espacios en número de factura
            numeroFactura.addEventListener('keypress', function(e) {
                if (e.key === ' ') {
                    e.preventDefault();
                }
            });

            // Validación para responsable
            responsable.addEventListener('input', function(e) {
                let valor = e.target.value;

                // Remover espacios al inicio
                valor = valor.replace(/^\s+/, '');

                // Permitir solo letras y espacios
                valor = valor.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1\s]/g, '');

                // Limitar a 30 caracteres
                if (valor.length > 30) {
                    valor = valor.substring(0, 30);
                }

                e.target.value = valor;

                // Validar y mostrar/ocultar error
                if (valor.length === 0) {
                    errorResponsable.style.display = 'block';
                    responsable.classList.add('invalid');
                } else {
                    errorResponsable.style.display = 'none';
                    responsable.classList.remove('invalid');
                }
            });

            // Prevenir espacios al inicio en responsable
            responsable.addEventListener('keypress', function(e) {
                prevenirEspacioInicial(e);
            });

            // Prevenir espacios al inicio con keydown también
            responsable.addEventListener('keydown', function(e) {
                if (e.target.value === '' && e.key === ' ') {
                    e.preventDefault();
                }
            });

            // Prevenir espacios al inicio en input
            responsable.addEventListener('beforeinput', function(e) {
                if (e.target.value === '' && e.data === ' ') {
                    e.preventDefault();
                }
            });

            // Prevenir pegar contenido que inicie con espacios
            responsable.addEventListener('paste', function(e) {
                e.preventDefault();
                let pastedText = (e.clipboardData || window.clipboardData).getData('text');

                // Remover espacios al inicio
                pastedText = pastedText.replace(/^\s+/, '');

                // Permitir solo letras y espacios
                pastedText = pastedText.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1\s]/g, '');

                // Limitar a 30 caracteres
                if (pastedText.length > 30) {
                    pastedText = pastedText.substring(0, 30);
                }

                // Solo pegar si hay contenido válido
                if (pastedText.length > 0) {
                    e.target.value = pastedText;
                    // Disparar evento input para validación
                    e.target.dispatchEvent(new Event('input'));
                }
            });

            numeroFactura.addEventListener('paste', function(e) {
                e.preventDefault();
                let pastedText = (e.clipboardData || window.clipboardData).getData('text');

                // Remover caracteres no numéricos
                pastedText = pastedText.replace(/\D/g, '');

                // Limitar a 15 caracteres
                if (pastedText.length > 15) {
                    pastedText = pastedText.substring(0, 15);
                }

                // Solo pegar si hay contenido válido
                if (pastedText.length > 0) {
                    e.target.value = pastedText;
                    // Disparar evento input para validación
                    e.target.dispatchEvent(new Event('input'));
                }
            });
        });

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

        // Funciones de validación
        function mostrarError(campo, mensaje) {
            let input;
            let errorDiv;

            if (campo === 'proveedor') {
                input = document.querySelector('select[name="proveedor"]');
                errorDiv = document.getElementById('errorProveedor');
            } else if (campo === 'formaPago') {
                input = document.querySelector('select[name="forma_pago"]');
                errorDiv = document.getElementById('errorFormaPago');
            } else {
                input = document.getElementById(campo);
                errorDiv = document.getElementById('error-' + campo) || document.getElementById('error' + campo.charAt(0).toUpperCase() + campo.slice(1));
            }

            if (input && errorDiv) {
                input.classList.add('field-error');
                errorDiv.style.display = 'block';
                errorDiv.textContent = mensaje;
            }
        }

        function ocultarError(campo) {
            let input;
            let errorDiv;

            if (campo === 'proveedor') {
                input = document.querySelector('select[name="proveedor"]');
                errorDiv = document.getElementById('errorProveedor');
            } else if (campo === 'formaPago') {
                input = document.querySelector('select[name="forma_pago"]');
                errorDiv = document.getElementById('errorFormaPago');
            } else {
                input = document.getElementById(campo);
                errorDiv = document.getElementById('error-' + campo) || document.getElementById('error' + campo.charAt(0).toUpperCase() + campo.slice(1));
            }

            if (input && errorDiv) {
                input.classList.remove('field-error');
                errorDiv.style.display = 'none';
            }
        }


        function validarFormularioPrincipal() {
            let esValido = true;

            // Limpiar errores previos
            ['numeroFactura', 'fecha', 'proveedor', 'formaPago', 'responsable'].forEach(campo => {
                ocultarError(campo);
            });
            document.getElementById('errorProductos').style.display = 'none';

            // Validar número de factura
            const numeroFactura = document.getElementById('numeroFactura').value.trim();
            if (!numeroFactura) {
                mostrarError('numeroFactura', 'Por favor ingrese un número de factura válido.');
                esValido = false;
            }



            // Validar proveedor
            const proveedor = document.getElementById('proveedor').value;
            if (!proveedor) {
                mostrarError('proveedor', 'Por favor seleccione un proveedor.');
                esValido = false;
            }

            // Validar forma de pago
            const formaPago = document.getElementById('formaPago').value;
            if (!formaPago) {
                mostrarError('formaPago', 'Por favor seleccione una forma de pago.');
                esValido = false;
            }

            // Validar responsable
            const responsable = document.getElementById('responsable').value.trim();
            if (!responsable) {
                mostrarError('responsable', 'Por favor ingrese el nombre del responsable.');
                esValido = false;
            }

            // Validar productos
            const productos = document.querySelectorAll('#tablaFacturaBody tr');
            if (productos.length === 0) {
                document.getElementById('errorProductos').style.display = 'block';
                esValido = false;
            }

            return esValido;
        }

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
        });

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

            // Aplicar limitaciones
            const precioCompra = document.querySelector('.precioCompra');
            const precioVenta = document.querySelector('.precioVenta');
            const cantidad = document.querySelector('.cantidad');

            limitarDigitos(precioCompra, 4);  // Máximo 4 dígitos (9999)
            limitarDigitos(precioVenta, 4);   // Máximo 4 dígitos (9999)
            limitarDigitos(cantidad, 3);      // Máximo 3 dígitos (999)
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
            const textoResaltado = textoOriginal.replace(regex, '<mark style="background-color: #ffeb3b; padding: 2px; border-radius: 3px; font-weight: bold;">$1</mark>');
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

        // Limpiar formulario
        document.getElementById('btnLimpiar').addEventListener('click', function() {
            // Resetear el formulario
            document.getElementById('facturaForm').reset();

            // Limpiar tabla de productos
            document.getElementById('tablaFacturaBody').innerHTML = '';
            calcularTotalesGenerales();
            actualizarFilaVacia();

            // Limpiar todas las advertencias y errores de validación
            limpiarTodasLasAdvertencias();

            // Limpiar estado del modal
            document.querySelectorAll('.producto-edicion-fila').forEach(fila => {
                fila.style.display = 'none';
            });
            document.querySelectorAll('.seleccionar-producto').forEach(btn => {
                btn.className = 'btn btn-sm btn-info seleccionar-producto';
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
            });
            productoSeleccionadoActual = null;
        });

        // Función para limpiar todas las advertencias y errores de validación
        function limpiarTodasLasAdvertencias() {
            // Lista de todos los campos que pueden tener errores
            const campos = ['numeroFactura', 'fecha', 'proveedor', 'formaPago', 'responsable'];

            // Ocultar errores de cada campo
            campos.forEach(campo => {
                ocultarError(campo);
            });

            // Ocultar error de productos
            const errorProductos = document.getElementById('errorProductos');
            if (errorProductos) {
                errorProductos.style.display = 'none';
            }

            // Remover clases de error de todos los inputs y selects
            document.querySelectorAll('#facturaForm .form-control, #facturaForm .form-select').forEach(input => {
                input.classList.remove('field-error', 'invalid');
            });

            // Ocultar todos los mensajes de error visibles
            document.querySelectorAll('#facturaForm .error-message').forEach(error => {
                error.style.display = 'none';
            });

            // Limpiar validaciones de Bootstrap si las hay
            document.getElementById('facturaForm').classList.remove('was-validated');

            // Remover cualquier estado de validación personalizado
            document.querySelectorAll('#facturaForm .is-invalid, #facturaForm .is-valid').forEach(element => {
                element.classList.remove('is-invalid', 'is-valid');
            });
        }

        // Validación del formulario al enviar

        document.getElementById('facturaForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validar formulario antes de enviar
            if (!validarFormularioPrincipal()) {
                return;
            }

            // Si llegamos aquí, el formulario es válido
            console.log('Formulario válido - Enviando datos...');

            // Aquí puedes agregar la lógica para enviar los datos
            // Por ejemplo: this.submit(); o hacer una petición AJAX
        });

        // Actualizar la función validarFormularioPrincipal para que funcione correctamente:
        function validarFormularioPrincipal() {
            let esValido = true;

            // Limpiar errores previos
            ['numeroFactura', 'fecha', 'proveedor', 'formaPago', 'responsable'].forEach(campo => {
                ocultarError(campo);
            });
            document.getElementById('errorProductos').style.display = 'none';

            // Validar número de factura
            const numeroFactura = document.getElementById('numeroFactura').value.trim();
            if (!numeroFactura) {
                mostrarError('numeroFactura', 'Número de factura es obligatorio');
                esValido = false;
            }

            // Validar fecha
            const fecha = document.getElementById('fecha').value;
            if (!fecha) {
                mostrarError('fecha', 'Fecha es obligatoria');
                esValido = false;
            }

            // Validar proveedor
            const proveedor = document.querySelector('select[name="proveedor"]').value;
            if (!proveedor) {
                mostrarError('proveedor', 'Proveedor es obligatorio');
                esValido = false;
            }

            // Validar forma de pago
            const formaPago = document.querySelector('select[name="forma_pago"]').value;
            if (!formaPago) {
                mostrarError('formaPago', 'Forma de pago es obligatorio');
                esValido = false;
            }

            // Validar responsable
            const responsable = document.getElementById('responsable').value.trim();
            if (!responsable) {
                mostrarError('responsable', 'Responsable es obligatorio');
                esValido = false;
            }

            // Validar productos
            const productos = document.querySelectorAll('#tablaFacturaBody tr');
            if (productos.length === 0) {
                document.getElementById('errorProductos').style.display = 'block';
                document.getElementById('errorProductos').textContent = 'Debe agregar al menos un producto a la factura';
                esValido = false;
            }

            return esValido;
        }


        // Limpiar modal al cerrarlo
        document.getElementById('productosModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('searchInput').value = '';

            // Limpiar resaltados
            document.querySelectorAll('#tablaProductosBody .producto-fila td:first-child').forEach(celda => {
                quitarResaltado(celda);
            });

            // Limpiar resultados de búsqueda
            const searchResults = document.getElementById('searchResults');
            if (searchResults) {
                searchResults.innerHTML = '';
            }

            document.querySelectorAll('.producto-edicion-fila').forEach(fila => {
                fila.style.display = 'none';
            });
            document.querySelectorAll('.seleccionar-producto').forEach(btn => {
                btn.className = 'btn btn-sm btn-info seleccionar-producto';
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Seleccionar';
            });
            document.querySelectorAll('.producto-fila').forEach(fila => {
                fila.style.display = 'table-row';
            });
            productoSeleccionadoActual = null;
        });
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
