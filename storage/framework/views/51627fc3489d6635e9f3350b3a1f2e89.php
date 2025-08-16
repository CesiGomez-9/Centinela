<?php $__env->startSection('titulo','Registrar una factura'); ?>
<?php $__env->startSection('content'); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
            display: none; /* Controlado por JS para mostrar/ocultar */
            width: 100%; /* Asegura que ocupe todo el ancho disponible de su contenedor */
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

        /* Estilos específicos para la sección de resumen */
        .summary-value-box {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
            text-align: end;
            font-weight: normal !important; /* Asegura que no haya negrita */
            box-sizing: border-box; /* Incluye padding y border en el ancho */
            width: 100%; /* Asegura que tome el 100% del ancho de su columna col-4 */
        }

        /* Estilos para el modal */
        #productosModal .modal-body {
            font-size: 0.95rem; /* Tamaño de fuente para el cuerpo del modal */
        }
        #productosModal .table th,
        #productosModal .table td {
            font-size: 0.9rem; /* Tamaño de fuente para las celdas de la tabla del modal */
        }
        #productosModal .form-label {
            font-size: 0.95rem; /* Tamaño de fuente para las etiquetas de los formularios en el modal */
        }
        #productosModal .form-control {
            font-size: 0.95rem; /* Tamaño de fuente para los inputs en el modal */
        }

        /* Estilos para el formulario principal (ajustados para coincidir con el modal) */
        .form-label {
            font-size: 0.95rem; /* Tamaño de fuente para las etiquetas del formulario principal */
        }
        .form-control, .form-select {
            font-size: 0.95rem; /* Tamaño de fuente para los inputs y selects del formulario principal */
        }
        #tablaFacturaProductos th,
        #tablaFacturaProductos td {
            font-size: 0.9rem; /* Tamaño de fuente para la tabla principal */
        }
        .summary-value-box {
            font-size: 0.95rem; /* Ajustar el tamaño de la letra en las cajas de resumen */
        }

        /* Hacer más pequeños los textfields de precio compra, precio venta y cantidad en el modal */
        #productosModal .form-edicion-producto input[type="number"] {
            max-width: 100px; /* Ajusta este valor según sea necesario */
            display: inline-block; /* Asegura que no rompa el diseño de la línea */
        }

        /* Reducir el espacio entre los campos de precio y cantidad en el modal */
        #productosModal .modal-product-inputs-row > [class*="col-"] {
            padding-left: 0 !important; /* Elimina el padding izquierdo de las columnas */
            padding-right: 0 !important; /* Elimina el padding derecho de las columnas */
        }
        /* Añadir un pequeño margen entre los inputs para que no estén completamente pegados si se desea */
        #productosModal .modal-product-inputs-row .cantidad {
            margin-right: 0.5rem; /* Margen a la derecha del campo cantidad */
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
                        <?php if(isset($factura)): ?>
                            Editar una factura de compra
                        <?php else: ?>
                            Registrar una nueva factura de compra
                        <?php endif; ?>
                    </h3>

                    <form method="POST" id="facturaForm" action="<?php echo e(isset($factura) ? route('facturas.update', $factura->id) : route('facturas.store')); ?>" novalidate>
                        <?php echo csrf_field(); ?>
                        <?php if(isset($factura)): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php endif; ?>
                        <div class="row g-4">
                            
                            <div class="col-md-6">
                                <label for="numeroFactura" class="form-label">Número de Factura</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                    <input type="text" name="numero_factura" id="numeroFactura"
                                           class="form-control <?php $__errorArgs = ['numero_factura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           maxlength="20" value="<?php echo e(old('numero_factura', isset($factura) ? $factura->numero_factura : '')); ?>"
                                           onkeypress="validarTexto(event)" required>
                                </div>
                                
                                <div class="text-danger mt-1 small error-mensaje-js"></div>
                                <?php $__errorArgs = ['numero_factura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" name="fecha" id="fecha"
                                           class="form-control <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('fecha', isset($factura) ? $factura->fecha : \Carbon\Carbon::now()->format('Y-m-d'))); ?>"
                                           required>
                                </div>
                                <div class="text-danger mt-1 small error-mensaje-js"></div>
                                <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="col-md-6">
                                <label for="proveedor_id" class="form-label">Proveedor</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <select id="proveedor_id" name="proveedor_id" class="form-select <?php $__errorArgs = ['proveedor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione un proveedor</option>
                                        <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($prov->id); ?>" <?php echo e((old('proveedor_id', isset($factura) ? $factura->proveedor_id : '') == $prov->id) ? 'selected' : ''); ?>>
                                                <?php echo e($prov->nombreEmpresa); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="text-danger mt-1 small error-mensaje-js"></div>
                                <?php $__errorArgs = ['proveedor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="col-md-6">
                                <label for="formaPago" class="form-label">Forma de Pago</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-wallet-fill"></i></span>
                                    <select name="forma_pago" id="formaPago"
                                            class="form-select <?php $__errorArgs = ['forma_pago'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php $__currentLoopData = $formasPago; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($forma); ?>" <?php echo e((old('forma_pago', isset($factura) ? $factura->forma_pago : '') === $forma) ? 'selected' : ''); ?>>
                                                <?php echo e($forma); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="text-danger mt-1 small error-mensaje-js"></div>
                                <?php $__errorArgs = ['forma_pago'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

                            
                            <div class="row mt-4 justify-content-end">
                                <div class="col-md-6 col-lg-4"> 
                                    <div class="row g-1"> <!-- Usar un row con un pequeño gap para los items del resumen -->

                                        
                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0" style="white-space: nowrap; font-weight: normal;">Importe Gravado (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box" id="importeGravadoLabel">0.00</label>
                                        </div>

                                        
                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0" style="white-space: nowrap; font-weight: normal;">Importe Exento (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box" id="importeExentoLabel">0.00</label>
                                        </div>

                                        
                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0" style="white-space: nowrap; font-weight: normal;">Importe Exonerado (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box" id="importeExoneradoLabel">0.00</label>
                                        </div>

                                        
                                        <div class="col-8 text-start"> <!-- Columna para la etiqueta -->
                                            <label class="form-label mb-0" style="white-space: nowrap; font-weight: normal;">Subtotal (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end"> <!-- Columna para el valor -->
                                            <label class="form-control summary-value-box" id="subtotalGeneralLabel">0.00</label>
                                        </div>

                                        
                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0" style="white-space: nowrap; font-weight: normal;">ISV 15% (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box" id="isv15Label">0.00</label>
                                        </div>

                                        
                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0" style="white-space: nowrap; font-weight: normal;">ISV 18% (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box" id="isv18Label">0.00</label>
                                        </div>

                                        
                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0" style="white-space: nowrap; font-weight: normal;">Total Final (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box" id="totalGeneralLabel">0.00</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="col-md-6">
                                <label for="responsable_id" class="form-label">Responsable</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-check-fill"></i></span>
                                    <select name="responsable_id" id="responsable_id"
                                            class="form-select <?php $__errorArgs = ['responsable_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione un empleado</option>
                                        <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($empleado->id); ?>" <?php echo e((old('responsable_id', isset($factura) ? $factura->responsable_id : '') == $empleado->id) ? 'selected' : ''); ?>>
                                                <?php echo e($empleado->nombre); ?> <?php echo e($empleado->apellido); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="text-danger mt-1 small error-mensaje-js"></div>
                                <?php $__errorArgs = ['responsable_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="text-center mt-5">
                                <a href="<?php echo e(route('facturas.index')); ?>" class="btn btn-danger me-2">
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

            // Limpiar los nuevos campos de resumen
            document.getElementById('importeGravadoLabel').textContent = '0.00';
            document.getElementById('importeExentoLabel').textContent = '0.00';
            document.getElementById('importeExoneradoLabel').textContent = '0.00';
            document.getElementById('isv15Label').textContent = '0.00';
            document.getElementById('isv18Label').textContent = '0.00';

            // Subtotal y Total Final
            document.getElementById('subtotalGeneralLabel').textContent = '0.00';
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

            const precioCompra = parseInt(precioCompraInput.value); // Parsear como entero
            const precioVenta = parseInt(precioVentaInput.value);   // Parsear como entero
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
                errorDiv.textContent = 'Precio de compra debe ser un número entero mayor que cero.';
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
                errorDiv.textContent = 'Precio de venta debe ser un número entero mayor que cero.';
                errorDiv.style.display = 'block';
                esValido = false;
            } else if (precioVenta <= precioCompra) {
                precioVentaInput.classList.add('field-error');
                let errorDiv = precioVentaInput.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    precioVentaInput.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Precio de venta debe ser mayor que el precio de compra.';
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
                    cantidadInput.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Cantidad debe ser un número entero mayor que cero.';
                errorDiv.style.display = 'block';
                esValido = false;
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
                // Asegúrate de que tu ruta API devuelva el impuesto asociado al producto
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
                    // Asegúrate de que 'cantidad' sea un entero al guardarlo en el data-attribute
                    fila.setAttribute('data-cantidad-disponible', Math.floor(producto.cantidad));
                    // Asegúrate de que 'impuesto' esté cargado y el porcentaje sea accesible
                    fila.setAttribute('data-iva-porcentaje', producto.impuesto ? producto.impuesto.porcentaje : 0);

                    // Determinar el texto a mostrar para el IVA
                    let ivaDisplay;
                    const ivaPorcentaje = producto.impuesto ? parseFloat(producto.impuesto.porcentaje) : 0; // Asegurarse de que sea número
                    if (ivaPorcentaje === 0) {
                        ivaDisplay = '0% (Exento)';
                    } else if (ivaPorcentaje === 15 || ivaPorcentaje === 18) {
                        ivaDisplay = `${ivaPorcentaje}% (No exento)`;
                    } else {
                        ivaDisplay = `${ivaPorcentaje}%`; // Para otros porcentajes no especificados
                    }

                    fila.innerHTML = `
                        <td>${producto.nombre}</td>
                        <td>${producto.categoria}</td>
                        <td><span class="badge bg-secondary">${Math.floor(producto.cantidad)}</span></td> 
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
                            <form class="p-2 form-edicion-producto" novalidate >
                                <div class="row modal-product-inputs-row align-items-end"> <!-- Añadida la clase modal-product-inputs-row y eliminada g-1 -->
                                    <div class="col-md-3">
                                        <label class="form-label">Precio Compra (Lps)</label>
                                        <input type="number" step="1" max="9999" class="form-control precioCompra" required>
                                        <div class="error-message"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Precio Venta (Lps)</label>
                                        <input type="number" step="1" max="9999" class="form-control precioVenta" required>
                                        <div class="error-message"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Cantidad</label>
                                        <input type="number" step="1" max="999" class="form-control cantidad" required>
                                        <div class="error-message"></div>
                                    </div>
                                    <div class="col-md-2 d-flex flex-column justify-content-end gap-1">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-circle"></i> Agregar
                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm limpiar-campos">
                                             <i class="bi bi-eraser-fill"></i> Limpiar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </td>
                    `;
                    tbody.appendChild(fila);
                    tbody.appendChild(filaEdicion);

                    // APLICAR handleNumericInput A LOS NUEVOS CAMPOS CREADOS
                    const form = filaEdicion.querySelector('.form-edicion-producto');
                    handleNumericInput(form.querySelector('.precioCompra'), 4, false);
                    handleNumericInput(form.querySelector('.precioVenta'), 4, false);
                    handleNumericInput(form.querySelector('.cantidad'), 3, false);
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
                let numValue = parseFloat(value);
                // No usar min/max de atributos HTML para la lógica de blur, solo para validación al final
                // let min = parseFloat(e.target.getAttribute('min'));
                // let max = parseFloat(e.target.getAttribute('max'));

                if (value === '') {
                    return; // Permite dejar el campo vacío, la validación de formulario lo manejará
                }

                if (isNaN(numValue)) {
                    e.target.value = ''; // Si no es un número válido, limpiar el campo
                    return;
                }

                // Si es un número válido, formatear según si es decimal o entero
                if (isDecimal) {
                    e.target.value = numValue.toFixed(2);
                } else {
                    e.target.value = Math.floor(numValue); // Para enteros, asegurar que no haya decimales
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
                        // No pre-llenar cantidad con 1, dejarla vacía o con el valor por defecto del HTML
                        // form.querySelector('.cantidad').value = '';

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
                        // Solo remover si el mensaje es un div de error dinámico
                        if (mensaje.classList.contains('error-message')) {
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
                    const precioCompra = parseInt(this.querySelector('.precioCompra').value); // Parsear como entero
                    const precioVenta = parseInt(this.querySelector('.precioVenta').value);   // Parsear como entero
                    const cantidad = parseInt(this.querySelector('.cantidad').value);
                    const ivaPorcentaje = parseFloat(filaProducto.dataset.ivaPorcentaje); // Obtener el porcentaje de IVA real

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
                    const impuestoCalculado = (ivaPorcentaje / 100) * base;
                    const subtotalLinea = base + impuestoCalculado;

                    const nuevaFila = document.createElement('tr');

                    const newRowIndex = tablaFactura.children.length; // Usar la longitud actual para el nuevo índice

                    nuevaFila.dataset.index = newRowIndex; // Asignar un índice al data-attribute de la fila
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
                            <input type="hidden" name="productos[${newRowIndex}][precioCompra]" value="${precioCompra}" class="hidden-precio-compra">
                            ${precioCompra}
                        </td>
                        <td>
                            <input type="hidden" name="productos[${newRowIndex}][cantidad]" value="${cantidad}" class="hidden-cantidad">
                            <input type="hidden" name="productos[${newRowIndex}][precioVenta]" value="${precioVenta}" class="hidden-precio-venta">
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
                    actualizarFilaVacia();

                    const modalElement = document.getElementById('productosModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);

                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    console.log('DEBUG: Producto agregado y totales recalculados.');

                    calcularTotalesGenerales();
                    document.getElementById('errorProductos').style.display = 'none';
                    actualizarNumeracionFilas(); // Llama a la función para re-numerar
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

        function actualizarNumeracionFilas() {
            const tablaFacturaBody = document.getElementById('tablaFacturaBody');
            const filasProductos = tablaFacturaBody.querySelectorAll('tr:not(#filaVacia)');
            filasProductos.forEach((fila, index) => {
                fila.querySelector('td:first-child').textContent = index + 1;
                // También actualiza los índices en los atributos `name` de los inputs ocultos
                fila.querySelectorAll('input[type="hidden"]').forEach(input => {
                    const originalName = input.name;
                    // Extrae la parte final del nombre (ej. '[product_id]', '[nombre]')
                    const nameSuffix = originalName.match(/\[[^\]]+\]$/)[0];
                    input.name = `productos[${index}]${nameSuffix}`;
                });
            });
        }


        function calcularTotalesGenerales() {
            const tablaFacturaBody = document.getElementById('tablaFacturaBody');
            const filasProductos = tablaFacturaBody.querySelectorAll('tr:not(#filaVacia)');
            let importeGravado = 0;
            let importeExento = 0;
            let importeExonerado = 0; // Por ahora, se mantiene en 0 a menos que haya una lógica específica
            let isv15 = 0;
            let isv18 = 0;
            let subtotalCalculado = 0; // Suma de bases imponibles (gravado + exento + exonerado)
            let totalFinal = 0;

            filasProductos.forEach(fila => {
                const precioCompra = parseInt(fila.querySelector('.hidden-precio-compra').value); // Parsear como entero
                const cantidad = parseInt(fila.querySelector('.hidden-cantidad').value);
                const ivaPorcentaje = parseInt(fila.querySelector('.hidden-iva').value);

                const baseProducto = precioCompra * cantidad;
                const impuestoCalculadoLinea = (ivaPorcentaje / 100) * baseProducto;

                // Acumular Importe Gravado / Exento
                if (ivaPorcentaje > 0) {
                    importeGravado += baseProducto;
                } else {
                    importeExento += baseProducto;
                }

                // Acumular ISV por porcentaje
                if (ivaPorcentaje === 15) {
                    isv15 += impuestoCalculadoLinea;
                } else if (ivaPorcentaje === 18) {
                    isv18 += impuestoCalculadoLinea;
                }
                // Si hay otros porcentajes de IVA, se añadirían aquí

                // Sumar al subtotal general (suma de bases imponibles)
                subtotalCalculado += baseProducto;
            });

            // Calcular el total final (subtotal + ISV15 + ISV18)
            totalFinal = subtotalCalculado + isv15 + isv18;

            // Mostrar con dos decimales para precisión en los totales
            document.getElementById('importeGravadoLabel').textContent = importeGravado.toFixed(2);
            document.getElementById('importeExentoLabel').textContent = importeExento.toFixed(2);
            document.getElementById('importeExoneradoLabel').textContent = importeExonerado.toFixed(2);
            document.getElementById('isv15Label').textContent = isv15.toFixed(2);
            document.getElementById('isv18Label').textContent = isv18.toFixed(2);

            // Actualizar el Subtotal y Total Final
            document.getElementById('subtotalGeneralLabel').textContent = subtotalCalculado.toFixed(2);
            document.getElementById('totalGeneralLabel').textContent = totalFinal.toFixed(2);
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

            configurarValidacionFormulario();
            cargarProductosEnModal(); // Carga inicial de productos en el modal
            configurarBuscador();

            const tablaFacturaBody = document.getElementById('tablaFacturaBody');

            // --- INICIO DE LA LÓGICA DE REPOBLACIÓN CORREGIDA ---

            let productsToLoad = [];

            // 1. Intentar cargar desde `old()` data primero (si hay errores de validación)
            const oldProductsFromSession = <?php echo json_encode(session()->getOldInput('productos'), 15, 512) ?>;

            if (oldProductsFromSession && Object.keys(oldProductsFromSession).length > 0) {
                for (const key in oldProductsFromSession) {
                    if (Object.hasOwnProperty.call(oldProductsFromSession, key)) {
                        const prodData = oldProductsFromSession[key];
                        productsToLoad.push({
                            product_id: String(prodData.product_id || ''),
                            nombre: String(prodData.nombre || ''),
                            categoria: String(prodData.categoria || ''),
                            precioCompra: parseInt(prodData.precioCompra || 0), // Parsear como entero
                            precioVenta: parseInt(prodData.precioVenta || 0),   // Parsear como entero
                            cantidad: parseInt(prodData.cantidad || 0),
                            iva: parseFloat(prodData.iva || 0),
                        });
                    }
                }
                console.log('DEBUG: Productos cargados desde old() data:', productsToLoad);

            } else {
                // 2. Si no hay `old()` data, intentar cargar desde la factura existente (modo edición)
                const existingFacturaDetalles = <?php echo json_encode(isset($factura) ? $factura->detalles : null, 15, 512) ?>;
                if (existingFacturaDetalles && existingFacturaDetalles.length > 0) {
                    productsToLoad = existingFacturaDetalles.map(detail => ({
                        product_id: String(detail.product_id || ''),
                        nombre: String(detail.producto_inventario.nombre || ''), // Acceder a producto_inventario.nombre
                        categoria: String(detail.producto_inventario.categoria || ''), // Acceder a producto_inventario.categoria
                        precioCompra: parseInt(detail.precio_compra || 0), // Parsear como entero
                        precioVenta: parseInt(detail.precio_venta || 0),   // Parsear como entero
                        cantidad: parseInt(detail.cantidad || 0),
                        iva: parseFloat(detail.iva || 0),
                        total: parseFloat(detail.total || 0)
                    }));
                    console.log('DEBUG: Cargando productos desde detalles de factura existentes:', productsToLoad);
                }
            }

            productoIndexCounter = productsToLoad.length;

            if (productsToLoad.length > 0) {
                tablaFacturaBody.innerHTML = ''; // Limpiar la fila vacía si hay productos
                productsToLoad.forEach((producto, index) => {
                    const baseProductoRepoblado = producto.precioCompra * producto.cantidad;
                    const impuestoProductoRepoblado = (producto.iva / 100) * baseProductoRepoblado;
                    const subtotalDisplay = (baseProductoRepoblado + impuestoProductoRepoblado).toFixed(2); // Mostrar con dos decimales

                    const nuevaFila = document.createElement('tr');
                    nuevaFila.dataset.index = index;
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
                            <input type="hidden" name="productos[${index}][precioCompra]" value="${producto.precioCompra}" class="hidden-precio-compra">
                            ${producto.precioCompra}
                        </td>
                        <td>
                            <input type="hidden" name="productos[${index}][cantidad]" value="${producto.cantidad}" class="hidden-cantidad">
                            <input type="hidden" name="productos[${index}][precioVenta]" value="${producto.precioVenta}" class="hidden-precio-venta">
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
                actualizarFilaVacia();
                calcularTotalesGenerales();
                actualizarNumeracionFilas();
            } else {
                actualizarFilaVacia();
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
                actualizarNumeracionFilas();
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

                limpiarFormulariosModal();
                console.log('DEBUG: Formularios del modal limpiados al cerrar.');
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/facturas/formulario.blade.php ENDPATH**/ ?>