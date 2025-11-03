<?php $__env->startSection('titulo','Registrar una factura'); ?>
<?php $__env->startSection('content'); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #e6f0ff;
            margin: 0;
        }

        .form-label,
        .form-control,
        .form-select,
        .input-group-text,
        .text-danger,
        .small,
        .form-check-label,
        .btn {
            font-size: 0.875rem;
        }

        h3 {
            font-size: 1.5rem;
            color: #09457f;
        }

        #tablaFacturaProductos th,
        #tablaFacturaProductos td {
            font-size: 0.875rem;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
            width: 100%;
        }

        .field-error {
            border-color: #dc3545 !important;
        }

        .form-control.invalid {
            border-color: #dc3545;
        }

        #tablaFacturaBody td {
            color: black !important;
            font-size: 0.875rem !important;
            visibility: visible !important;
            opacity: 1 !important;
            background-color: #ffffff !important;
            min-width: 50px;
            padding: 8px;
        }

        #tablaFacturaBody td input[type="hidden"] + * {
            margin-left: 5px;
        }

        .modal:not(.show) {
            display: none !important;
        }

        .modal-backdrop:not(.show) {
            display: none !important;
            opacity: 0 !important;
        }

        .summary-value-box {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            text-align: end;
            font-weight: bold !important;
            box-sizing: border-box;
            width: 100%;
            font-size: 0.875rem;
        }

        #productosModal .modal-body {
            font-size: 0.875rem;
        }

        #productosModal .table th,
        #productosModal .table td {
            font-size: 0.875rem;
        }

        #productosModal .form-label {
            font-size: 0.875rem;
        }

        #productosModal .form-control {
            font-size: 0.875rem;
        }

        .form-control,
        .form-select,
        .input-group-text,
        .btn {
            border-radius: 0.375rem;
        }

        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }

        .modal-content {
            border-radius: 0.5rem;
        }

        .modal-header {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .fila-vacia {
            border: 1px dashed #dee2e6;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
        }
        .autocomplete-container {
            position: relative;
        }

        .autocomplete-results {
            position: absolute;
            z-index: 1050;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ced4da;
            border-top: none;
            background-color: white;
            border-radius: 0 0 .25rem .25rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .autocomplete-results a {
            display: block;
            padding: .5rem 1rem;
            text-decoration: none;
            color: #212529;
        }

        .autocomplete-results a:hover {
            background-color: #f8f9fa;
        }

        .search-icon-right .input-group-text:first-child {
            border-right: 0;
        }

        .search-icon-right .form-control {
            border-radius: 0;
        }

        .search-icon-right .input-group-text:last-child {
            border-left: 0;
            border-radius: 0 .25rem .25rem 0;
        }

        .search-icon-right .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        .search-icon-right .form-control:focus + .input-group-text {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
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

                    <form method="POST" id="facturaForm"
                          action="<?php echo e(isset($factura) ? route('facturas_compras.update', $factura->id) : route('facturas_compras.store')); ?>"
                          novalidate>
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
                                           maxlength="20"
                                           value="<?php echo e(old('numero_factura', isset($factura) ? $factura->numero_factura : '')); ?>"
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
                                <label for="proveedorId" class="form-label">Proveedor</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <select name="proveedor_id" id="proveedorId"
                                            class="form-select <?php $__errorArgs = ['proveedor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione un proveedor</option>
                                        <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($proveedor->id); ?>"
                                                <?php echo e((old('proveedor_id', isset($factura) ? $factura->proveedor_id : '') == $proveedor->id) ? 'selected' : ''); ?>>
                                                <?php echo e($proveedor->nombreEmpresa); ?>

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
                                            <option value="<?php echo e($forma); ?>"
                                                <?php echo e((old('forma_pago', isset($factura) ? $factura->forma_pago : '') === $forma) ? 'selected' : ''); ?>>
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
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#productosModal">
                                        <i class="bi bi-search"></i> Buscar Productos
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle text-center"
                                           id="tablaFacturaProductos">
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
                                            <td colspan="8" class="text-center text-muted py-4"
                                                style="border: 1px dashed #dee2e6; background-color: #f8f9fa;">
                                                <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                                                <br>
                                                <span style="font-size: 0.9rem;">No hay productos agregados</span>
                                                <br>
                                                <small style="font-size: 0.8rem; opacity: 0.7;">Haga clic en "Buscar
                                                    Productos" para agregar productos a la factura</small>
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
                                    <div class="row g-1">

                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0"
                                                   style="white-space: nowrap; font-weight: normal;">Importe Gravado
                                                (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box"
                                                   id="importeGravadoLabel">0.00</label>
                                        </div>

                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0"
                                                   style="white-space: nowrap; font-weight: normal;">Importe Exento
                                                (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box"
                                                   id="importeExentoLabel">0.00</label>
                                        </div>

                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0"
                                                   style="white-space: nowrap; font-weight: normal;">Importe Exonerado
                                                (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box"
                                                   id="importeExoneradoLabel">0.00</label>
                                        </div>

                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0"
                                                   style="white-space: nowrap; font-weight: normal;">Subtotal
                                                (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box"
                                                   id="subtotalGeneralLabel">0.00</label>
                                        </div>

                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0" style="white-space: nowrap; font-weight: normal;">ISV
                                                15% (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box" id="isv15Label">0.00</label>
                                        </div>

                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0" style="white-space: nowrap; font-weight: normal;">ISV
                                                18% (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box" id="isv18Label">0.00</label>
                                        </div>

                                        <div class="col-8 text-start">
                                            <label class="form-label mb-0"
                                                   style="white-space: nowrap; font-weight: bold;">Total Final
                                                (Lps)</label>
                                        </div>
                                        <div class="col-4 text-end">
                                            <label class="form-control summary-value-box" id="totalGeneralLabel">0.00</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="responsable_search" class="form-label">Responsable</label>
                                <div class="input-group search-icon-right">
                                    <span class="input-group-text"><i class="bi bi-person-check-fill"></i></span>
                                    <input type="text" id="responsable_search" class="form-control"
                                           placeholder="Buscar por nombre del empleado..." autocomplete="off"
                                           value="<?php echo e(old('responsable_id', isset($factura) ? ($factura->responsable->nombre . ' ' . $factura->responsable->apellido) : '')); ?>">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="hidden" name="responsable_id" id="responsable_id"
                                           value="<?php echo e(old('responsable_id', isset($factura) ? $factura->responsable_id : '')); ?>">
                                </div>
                                <div id="responsable_results" class="autocomplete-results"></div>
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
                                <a href="<?php echo e(route('facturas_compras.index')); ?>" class="btn btn-danger me-2">
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

    <div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel"
         aria-hidden="true">
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
                                <input type="text" id="searchInput" class="form-control"
                                       placeholder="Buscar producto por nombre...">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="cerrarModalProductos">
                        <i class="bi bi-x-circle"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let productoSeleccionadoActual = null;
        let productoIndexCounter = 0;

        function validarTexto(e) {
            const key = e.keyCode || e.which;
            const tecla = String.fromCharCode(key);
            const input = e.target;

            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }

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

            document.getElementById('importeGravadoLabel').textContent = '0.00';
            document.getElementById('importeExentoLabel').textContent = '0.00';
            document.getElementById('importeExoneradoLabel').textContent = '0.00';
            document.getElementById('isv15Label').textContent = '0.00';
            document.getElementById('isv18Label').textContent = '0.00';

            document.getElementById('subtotalGeneralLabel').textContent = '0.00';
            document.getElementById('totalGeneralLabel').textContent = '0.00';

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
                    modalInstance.hide();
                }
            }

            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            document.documentElement.style.overflow = '';

            document.getElementById('responsable_search').value = '';
            document.getElementById('responsable_id').value = '';
            const proveedorSelect = document.getElementById('proveedorId');
            if (proveedorSelect) {
                proveedorSelect.selectedIndex = 0;
            }

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

            form.querySelectorAll('.error-message').forEach(error => {
                error.style.display = 'none';
            });
            form.querySelectorAll('.field-error').forEach(field => {
                field.classList.remove('field-error');
            });

            const precioCompra = parseInt(precioCompraInput.value);
            const precioVenta = parseInt(precioVentaInput.value);
            const cantidad = parseInt(cantidadInput.value);

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

        function validarFormularioPrincipal() {
            let esValido = true;
            const form = document.getElementById('facturaForm');

            form.querySelectorAll('.form-control.is-invalid, .form-select.is-invalid').forEach(input => input.classList.remove('is-invalid'));
            form.querySelectorAll('.text-danger.mt-1.small.error-mensaje-js').forEach(error => error.style.display = 'none');

            const campos = ['numeroFactura', 'fecha', 'proveedorId', 'formaPago', 'responsable_id'];
            campos.forEach(campoId => {
                const campo = document.getElementById(campoId);
                if (campo && !campo.value) {
                    mostrarError(campoId, 'Este campo es obligatorio.');
                    esValido = false;
                } else {
                    ocultarError(campoId);
                }
            });

            const tablaProductos = document.getElementById('tablaFacturaBody');
            const productosAgregados = tablaProductos.querySelectorAll('tr:not(#filaVacia)');
            if (productosAgregados.length === 0) {
                const errorProductos = document.getElementById('errorProductos');
                errorProductos.style.display = 'block';
                esValido = false;
            } else {
                document.getElementById('errorProductos').style.display = 'none';
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

                tbody.innerHTML = '';

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
                    fila.setAttribute('data-cantidad-disponible', Math.floor(producto.cantidad));
                    fila.setAttribute('data-iva-porcentaje', producto.impuesto ? producto.impuesto.porcentaje : 0);

                    let ivaDisplay;
                    const ivaPorcentaje = producto.impuesto ? parseFloat(producto.impuesto.porcentaje) : 0;
                    if (ivaPorcentaje === 0) {
                        ivaDisplay = '0% (Exento)';
                    } else if (ivaPorcentaje === 15 || ivaPorcentaje === 18) {
                        ivaDisplay = `${ivaPorcentaje}% (No exento)`;
                    } else {
                        ivaDisplay = `${ivaPorcentaje}%`;
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
                                <div class="row modal-product-inputs-row align-items-end">
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
                    if (key === '.') {
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
                    return;
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
                    const precioCompra = parseInt(this.querySelector('.precioCompra').value);
                    const precioVenta = parseInt(this.querySelector('.precioVenta').value);
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
                    actualizarNumeracionFilas();
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

        function configurarAutocomplete(inputId, resultsId, hiddenInputId, data) {
            const searchInput = document.getElementById(inputId);
            const resultsContainer = document.getElementById(resultsId);
            const hiddenInput = document.getElementById(hiddenInputId);

            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = this.value.toLowerCase().trim();

                if (searchTerm.length === 0) {
                    resultsContainer.style.display = 'none';
                    hiddenInput.value = '';
                    return;
                }

                searchTimeout = setTimeout(() => {
                    const filteredData = data.filter(item =>
                        (item.nombreEmpresa || (item.nombre + ' ' + item.apellido)).toLowerCase().includes(searchTerm)
                    );

                    filteredData.sort((a, b) => {
                        const nombreA = (a.nombreEmpresa || (a.nombre + ' ' + a.apellido)).toLowerCase();
                        const nombreB = (b.nombreEmpresa || (b.nombre + ' ' + b.apellido)).toLowerCase();
                        return nombreA.localeCompare(nombreB);
                    });

                    mostrarResultadosAutocomplete(filteredData, resultsContainer, searchInput, hiddenInputId);
                }, 250);
            });

            document.addEventListener('click', function(e) {
                if (!resultsContainer.contains(e.target) && e.target !== searchInput) {
                    resultsContainer.style.display = 'none';
                }
            });

            if(searchInput.value) {
                const initialSearchTerm = searchInput.value.toLowerCase().trim();
                const initialData = data.find(item => (item.nombreEmpresa || (item.nombre + ' ' + item.apellido)).toLowerCase() === initialSearchTerm);
                if (initialData) {
                    hiddenInput.value = initialData.id;
                }
            }
        }

        function mostrarResultadosAutocomplete(resultados, container, input, hiddenInputId) {
            container.innerHTML = '';
            container.className = 'autocomplete-results';

            if (resultados.length === 0) {
                container.style.display = 'none';
                return;
            }

            resultados.forEach(item => {
                const li = document.createElement('a');
                li.className = 'list-group-item list-group-item-action';
                li.href = '#';

                const nombreCompleto = item.nombreEmpresa || (item.nombre + ' ' + item.apellido);
                li.textContent = nombreCompleto;

                li.addEventListener('click', function(e) {
                    e.preventDefault();
                    input.value = nombreCompleto;
                    document.getElementById(hiddenInputId).value = item.id;
                    container.style.display = 'none';
                });
                container.appendChild(li);
            });

            container.style.display = 'block';
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

        function configurarEventosGenerales() {
            document.getElementById('btnLimpiar').addEventListener('click', limpiarFormularioCompleto);

            document.getElementById('tablaFacturaBody').addEventListener('click', function(e) {
                if (e.target.closest('.btn-eliminar-producto')) {
                    const fila = e.target.closest('tr');
                    fila.remove();
                    actualizarFilaVacia();
                    calcularTotalesGenerales();
                    actualizarNumeracionFilas();
                }
            });

            document.getElementById('fecha').addEventListener('input', function() {
                ocultarError('fecha');
            });
            document.getElementById('numeroFactura').addEventListener('input', function() {
                ocultarError('numeroFactura');
            });
            document.getElementById('proveedorId').addEventListener('change', function() {
                ocultarError('proveedorId');
            });
            document.getElementById('formaPago').addEventListener('change', function() {
                ocultarError('formaPago');
            });

            const productosModalElement = document.getElementById('productosModal');
            productosModalElement.addEventListener('shown.bs.modal', function() {
                const searchInput = document.getElementById('searchInput');
                searchInput.value = '';
                cargarProductosEnModal('');
                searchInput.focus();
            });

            productosModalElement.addEventListener('hidden.bs.modal', function() {
                limpiarFormulariosModal();
            });
        }


        function calcularTotalesGenerales() {
            let importeGravado = 0;
            let importeExento = 0;
            let importeExonerado = 0;
            let isv15 = 0;
            let isv18 = 0;
            let subtotalGeneral = 0;

            const tablaFacturaBody = document.getElementById('tablaFacturaBody');
            const filas = tablaFacturaBody.querySelectorAll('tr:not(#filaVacia)');

            filas.forEach(fila => {
                const precioCompra = parseFloat(fila.querySelector('.hidden-precio-compra').value);
                const cantidad = parseFloat(fila.querySelector('.hidden-cantidad').value);
                const ivaPorcentaje = parseFloat(fila.querySelector('.hidden-iva').value);
                const baseCalculo = precioCompra * cantidad;

                let impuesto = 0;

                if (ivaPorcentaje > 0) {
                    importeGravado += baseCalculo;
                    impuesto = baseCalculo * (ivaPorcentaje / 100);

                    if (ivaPorcentaje === 15) {
                        isv15 += impuesto;
                    } else if (ivaPorcentaje === 18) {
                        isv18 += impuesto;
                    }
                } else if (ivaPorcentaje === 0) {
                    importeExento += baseCalculo;
                }
            });

            subtotalGeneral = importeGravado + importeExento + importeExonerado;
            const totalFinal = subtotalGeneral + isv15 + isv18;

            document.getElementById('importeGravadoLabel').textContent = importeGravado.toFixed(2);
            document.getElementById('importeExentoLabel').textContent = importeExento.toFixed(2);
            document.getElementById('importeExoneradoLabel').textContent = importeExonerado.toFixed(2);
            document.getElementById('subtotalGeneralLabel').textContent = subtotalGeneral.toFixed(2);
            document.getElementById('isv15Label').textContent = isv15.toFixed(2);
            document.getElementById('isv18Label').textContent = isv18.toFixed(2);
            document.getElementById('totalGeneralLabel').textContent = totalFinal.toFixed(2);
        }

        function actualizarFilaVacia() {
            const tbody = document.getElementById('tablaFacturaBody');
            const filasProductos = tbody.querySelectorAll('tr:not(#filaVacia)');
            const filaVacia = document.getElementById('filaVacia');

            if (filasProductos.length > 0) {
                if (filaVacia) {
                    filaVacia.style.display = 'none';
                }
            } else {
                if (filaVacia) {
                    filaVacia.style.display = 'table-row';
                }
            }
        }

        function actualizarNumeracionFilas() {
            const tablaFacturaBody = document.getElementById('tablaFacturaBody');
            const filas = tablaFacturaBody.querySelectorAll('tr:not(#filaVacia)');
            filas.forEach((fila, index) => {
                fila.querySelector('td:first-child').textContent = index + 1;

                const hiddenInputs = fila.querySelectorAll('input[type="hidden"]');
                hiddenInputs.forEach(input => {
                    const originalName = input.name;
                    const nameSuffix = originalName.match(/\[[^\]]+\]$/)[0];
                    input.name = `productos[${index}]${nameSuffix}`;
                });
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
            const empleados = <?php echo json_encode($empleados ?? [], 15, 512) ?>;
            configurarAutocomplete('responsable_search', 'responsable_results', 'responsable_id', empleados);

            const hoy = new Date().toISOString().split('T')[0];
            document.getElementById('fecha').max = hoy;

            if (document.getElementById('numeroFactura').value === '') {
                document.getElementById('numeroFactura').focus();
            }

            // Al cargar la página, se inicializa la tabla y los eventos
            actualizarFilaVacia();
            calcularTotalesGenerales();
            configurarValidacionFormulario();
            configurarEventosGenerales();
            configurarBuscador();

            const productosModal = new bootstrap.Modal(document.getElementById('productosModal'));

            // Pre-llenar la tabla de productos si hay datos antiguos
            const productosAntiguos = <?php echo json_encode(old('productos', isset($factura) ? $factura->productos : []), 512) ?>;
            if (productosAntiguos && productosAntiguos.length > 0) {
                const tablaFacturaBody = document.getElementById('tablaFacturaBody');
                productosAntiguos.forEach((producto, index) => {
                    const nuevaFila = document.createElement('tr');
                    const base = producto.precioCompra * producto.cantidad;
                    const impuestoCalculado = (producto.iva / 100) * base;
                    const subtotalLinea = base + impuestoCalculado;

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
                            ${parseFloat(producto.precioCompra).toFixed(2)}
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
                        <td class="subtotal-producto">${subtotalLinea.toFixed(2)}</td>
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
            }

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/facturas_compras/formulario.blade.php ENDPATH**/ ?>