<?php $__env->startSection('titulo', 'Venta de servicio'); ?>
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

        #mainTurnosTable th {
            font-size: 0.875rem;
        }

        #mainTurnosTable tbody td {
            font-size: 0.875rem;
        }

        textarea.form-control {
            resize: none;
            overflow: hidden;
            min-height: 38px;
            border-radius: 0.375rem;
        }

        #modal-empleado-checkbox-container {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 0.5rem;
            background-color: #fff;
            max-height: 150px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        #modal-empleado-checkbox-container .form-check {
            padding-left: 2.25rem;
            min-height: 1.5rem;
            cursor: pointer;
        }

        #modal-empleado-checkbox-container .form-check-input {
            margin-top: 0.25rem;
            border-radius: 0.25rem;
        }

        #modal-empleado-checkbox-container.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .fila-vacia-estilo {
            border: 1px dashed #dee2e6;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
        }

        .form-control,
        .form-select,
        .input-group-text {
            border-radius: 0.375rem;
        }

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

        #modal-error-message {
            display: none;
            margin-bottom: 1rem;
            padding: 0.75rem 1.25rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
        }

        /* Estilos de validación para los input-group del formulario principal */
        .input-group.is-invalid .form-control,
        .input-group.is-invalid .form-select {
            border-color: #dc3545 !important;
        }

        .input-group.is-invalid .form-control:focus,
        .input-group.is-invalid .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .input-group .input-group-text {
            border-color: #ced4da;
        }

        /* Asegura que el ícono de validación solo aparezca en el select */
        .input-group .form-select.is-invalid {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right calc(0.375em + 0.1875rem) center !important;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
        }

        .input-group .form-select.is-invalid:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
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
            border: 1.5px solid #ced4da;
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

        .input-group.search-icon-right {
            position: relative;
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

        .search-icon-right .form-control:focus+.input-group-text {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        .btn-faded {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-faded:hover {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #198754;
            border-color: #198754;
        }

        .input-group .invalid-feedback {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 5;
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .modal-body .form-select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .modal-body .form-select-dropdown {
            position: absolute;
            z-index: 1060;
            top: 100%;
            left: 0;
            width: 100%;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: 1px solid #ced4da;
            border-top: none;
            background-color: white;
            border-radius: 0 0 .375rem .375rem;
        }

        .form-select.is-invalid {
            border-color: #dc3545;
        }
    </style>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-white p-5 rounded shadow-lg position-relative">
                    <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                        <i class="bi bi-calendar-check" style="font-size: 4rem;"></i>
                    </div>

                    <h3 class="text-center mb-4">
                        <i class="bi bi-calendar-plus me-2"></i>Venta de servicio
                    </h3>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('turnos.store')); ?>" novalidate id="mainForm">
                        <?php echo csrf_field(); ?>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="cliente_search" class="form-label">Cliente</label>
                                <div class="input-group search-icon-right" id="cliente_search-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" id="cliente_search" class="form-control"
                                           placeholder="Buscar cliente por nombre..." autocomplete="off"
                                           value="<?php echo e(old('cliente_id', isset($venta) ? $venta->cliente->nombre . ' ' . $venta->cliente->apellido : '')); ?>">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="hidden" name="cliente_id" id="cliente_id"
                                           value="<?php echo e(old('cliente_id', isset($venta) ? $venta->cliente_id : '')); ?>">
                                    <div id="cliente_results" class="autocomplete-results"></div>
                                </div>
                                <div class="invalid-feedback text-danger mt-1 small" id="cliente_search-error-message" style="display:none;">El cliente es obligatorio.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="servicio_id" class="form-label">Tipo de servicio</label>
                                <div class="input-group" id="servicio_id-group">
                                    <span class="input-group-text"><i class="bi-shield-check"></i></span>
                                    <select name="servicio_id" id="servicio_id"
                                            class="form-select <?php $__errorArgs = ['servicio_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione un servicio</option>
                                        <?php $__currentLoopData = $servicios->sortBy('nombre'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($servicio->id); ?>"
                                                <?php echo e(old('servicio_id') == $servicio->id ? 'selected' : ''); ?>>
                                                <?php echo e($servicio->nombre); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <?php $__errorArgs = ['servicio_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php else: ?>
                                    <div class="invalid-feedback" id="servicio_id-error-message" style="display:none;">
                                        El tipo de servicio es obligatorio.
                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-12">
                                <div class="row g-4 align-items-end">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-success btn-faded" id="add-empleado-btn" disabled>
                                            <i class="bi bi-plus-circle me-1"></i> Agregar Empleado(s)
                                        </button>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                                        <div class="input-group" id="fecha_inicio-group">
                                            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                            <input type="date" name="fecha_inicio" id="fecha_inicio"
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
                                        <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php else: ?>
                                            <div class="invalid-feedback" id="fecha_inicio-error-message"
                                                 style="display:none;">
                                                La fecha de inicio es obligatoria.
                                            </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="fecha_fin" class="form-label">Fecha fin</label>
                                        <div class="input-group has-validation" id="fecha_fin-group">
                                            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
                                            <input type="date" name="fecha_fin" id="fecha_fin"
                                                   class="form-control <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   value="<?php echo e(old('fecha_fin')); ?>" required>
                                            <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php else: ?>
                                                <div class="invalid-feedback" id="fecha_fin-error-message"
                                                     style="display:none;">
                                                    La fecha de fin es obligatoria.
                                                </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered table-hover table-striped text-center"
                                           id="mainTurnosTable">
                                        <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Empleados</th>
                                            <th>Tipo de Turno</th>
                                            <th>Hora Inicio</th>
                                            <th>Hora Fin</th>
                                            <th>Costo (Lps)</th>
                                            <th>Eliminar</th>
                                        </tr>
                                        </thead>
                                        <tbody id="turnosTableBody">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end align-items-center mt-2">
                                    <label class="form-label mb-0 me-2" style="font-size: 0.875rem;">Costo Total:</label>
                                    <div class="input-group" style="width: auto;">
                                        <input type="text" class="form-control text-end fw-bold"
                                               id="total-costo-display" value="0.00" readonly
                                               style="font-size: 0.875rem; min-width: 100px;">
                                    </div>
                                </div>
                                <input type="hidden" name="turnos_data" id="turnos_data">
                                <div id="turnos-data-error" class="invalid-feedback mt-1 small" style="display: none;">
                                    Debe agregar al menos un turno a la tabla.
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="observaciones" class="form-label">Observaciones o instrucciones
                                    especiales</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                                    <textarea name="observaciones" id="observaciones" rows="1"
                                              class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="300"
                                              oninput="autoResizeTextarea(this);" onkeypress="return validarTexto(event)"><?php echo e(old('observaciones')); ?></textarea>
                                </div>
                                <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php else: ?>
                                    <div class="invalid-feedback" id="observaciones-error-message" style="display:none;">
                                        Las observaciones son obligatorias.
                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <a href="<?php echo e(route('turnos.index')); ?>" class="btn btn-danger me-2">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>

                            <button type="reset" class="btn btn-warning me-2" id="resetBtn">
                                <i class="bi bi-eraser-fill me-2"></i> Limpiar
                            </button>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save-fill me-2"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="asignarTurnoModal" tabindex="-1" aria-labelledby="asignarTurnoModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A1F44; color: white;">
                    <h5 class="modal-title" id="asignarTurnoModalLabel">Asignar un empleado a su respectivo turno</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="modal-error-message" class="alert alert-danger" role="alert" style="display: none;"></div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-8">
                                    <label class="form-label">Empleado(s) asignado(s)</label>
                                    <div id="modal-empleado-checkbox-container" class="form-control">
                                        <p class="text-muted m-0">Seleccione un servicio en el formulario principal primero</p>
                                    </div>
                                    <div id="empleado-ids-error" class="invalid-feedback mt-1 small" style="display: none;">
                                        Debe seleccionar al menos un empleado.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="modal_tipo_turno" class="form-label">Tipo de turno</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                                        <select name="modal_tipo_turno" id="modal_tipo_turno" class="form-select"
                                                required>
                                            <option value="">Seleccione</option>
                                            <option value="diurno">Diurno</option>
                                            <option value="nocturno">Nocturno</option>
                                            <option value="24 horas">24 horas</option>
                                        </select>
                                    </div>
                                    <div id="tipo-turno-error" class="invalid-feedback mt-1 small" style="display:none;">
                                        El tipo de turno es obligatorio.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="modal_costo" class="form-label">Costo (Lps)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-cash-coin"></i></span>
                                        <input type="number" step="0.01" name="modal_costo" id="modal_costo"
                                               class="form-control" readonly>
                                    </div>
                                    <div id="costo-error" class="invalid-feedback mt-1 small" style="display:none;">El
                                        costo es obligatorio.
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="modal_hora_inicio" class="form-label">Hora inicio</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-clock-history"></i></span>
                                        <select name="modal_hora_inicio" id="modal_hora_inicio" class="form-select" required>
                                            <option value="">Seleccione la hora</option>
                                        </select>
                                    </div>
                                    <div id="hora-inicio-error" class="invalid-feedback mt-1 small" style="display:none;">
                                        Hora de inicio es obligatoria.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="modal_hora_fin" class="form-label">Hora fin</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
                                        <select name="modal_hora_fin" id="modal_hora_fin" class="form-select" required>
                                            <option value="">Seleccione la hora</option>
                                        </select>
                                    </div>
                                    <div id="hora-fin-error" class="invalid-feedback mt-1 small" style="display:none;">
                                        Hora de fin es obligatoria.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-warning" id="limpiarModalBtn">
                        <i class="bi bi-eraser"></i> Limpiar
                    </button>
                    <button type="button" class="btn btn-success" id="addTurnoBtn">
                        <i class="bi bi-plus-circle"></i> Agregar Empleado
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const clientes = <?php echo json_encode($clientes, 15, 512) ?>;
        const servicios = <?php echo json_encode($servicios->keyBy('id'), 15, 512) ?>;

        function validarTexto(e) {
            const key = e.keyCode || e.which;
            const char = String.fromCharCode(key);
            const input = e.target;
            const pos = input.selectionStart;
            if (pos === 0 && !/^[A-Za-zÁÉÍÓÚáéíóúÑñ]$/.test(char)) {
                e.preventDefault();
                return false;
            }
            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }
            if (key === 32) {
                const pos = input.selectionStart;
                if (input.value.charAt(pos - 1) === ' ') {
                    e.preventDefault();
                    return false;
                }
            }
            return true;
        }

        function autoResizeTextarea(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        function configurarAutocomplete(inputId, resultsId, hiddenInputId, data) {
            const searchInput = document.getElementById(inputId);
            const resultsContainer = document.getElementById(resultsId);
            const hiddenInput = document.getElementById(hiddenInputId);
            const feedback = document.getElementById(inputId + '-error-message');
            const inputGroup = document.getElementById(inputId + '-group');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                resultsContainer.innerHTML = '';
                if (searchTerm.length > 0) {
                    const filteredData = data.filter(item => {
                        const fullName = (item.nombre + ' ' + (item.apellido || '')).toLowerCase();
                        return fullName.includes(searchTerm);
                    });
                    filteredData.sort((a, b) => {
                        const nameA = (a.nombre + ' ' + (a.apellido || '')).toLowerCase();
                        const nameB = (b.nombre + ' ' + (b.apellido || '')).toLowerCase();
                        return nameA.localeCompare(nameB);
                    });
                    if (filteredData.length > 0) {
                        filteredData.forEach(item => {
                            const resultItem = document.createElement('a');
                            resultItem.href = '#';
                            const fullName = item.nombre + ' ' + (item.apellido || '');
                            resultItem.textContent = fullName;
                            resultItem.addEventListener('click', function(e) {
                                e.preventDefault();
                                searchInput.value = fullName;
                                hiddenInput.value = item.id;
                                resultsContainer.style.display = 'none';
                                searchInput.classList.remove('is-invalid');
                                inputGroup.classList.remove('is-invalid');
                                if (feedback) feedback.style.display = 'none';
                            });
                            resultsContainer.appendChild(resultItem);
                        });
                        resultsContainer.style.display = 'block';
                    } else {
                        resultsContainer.style.display = 'none';
                    }
                } else {
                    resultsContainer.style.display = 'none';
                    hiddenInput.value = '';
                }
            });
            document.addEventListener('click', function(e) {
                if (!resultsContainer.contains(e.target) && e.target !== searchInput) {
                    resultsContainer.style.display = 'none';
                }
            });
        }

        function isTimeKey(event) {
            const key = event.key;
            const allowedKeys = /[0-9: ap.m]/;
            if (event.ctrlKey || event.metaKey || event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 9) {
                return true;
            }
            if (!allowedKeys.test(key)) {
                event.preventDefault();
                return false;
            }
            const input = event.target;
            const inputValue = input.value;
            const selectionStart = input.selectionStart;
            if (inputValue.length >= 8 && selectionStart === inputValue.length) {
                if (!['a', 'p', '.', 'm', ' '].includes(key)) {
                    event.preventDefault();
                    return false;
                }
            }
            return true;
        }

        function validarHoraFormato12(input) {
            const feedback = document.getElementById(input.id + '-error');
            input.addEventListener('input', () => {
                input.classList.remove('is-invalid');
                if (feedback) feedback.style.display = 'none';
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            configurarAutocomplete('cliente_search', 'cliente_results', 'cliente_id', clientes);
            let turnosAsignados = [];
            const empleadosPorServicioUrl = "<?php echo e(route('turnos.empleadosPorServicio', ['servicio_id' => ':id'])); ?>";
            let asignarTurnoModal;
            const mainForm = document.getElementById('mainForm');
            const clienteSearchInput = document.getElementById('cliente_search');
            const clienteSearchGroup = document.getElementById('cliente_search-group');
            const clienteError = document.getElementById('cliente_search-error-message');
            const servicioSelect = document.getElementById('servicio_id');
            const servicioSelectGroup = document.getElementById('servicio_id-group');
            const fechaInicioInput = document.getElementById('fecha_inicio');
            const fechaInicioGroup = document.getElementById('fecha_inicio-group');
            const fechaFinInput = document.getElementById('fecha_fin');
            const fechaFinGroup = document.getElementById('fecha_fin-group');
            const observacionesTextarea = document.getElementById('observaciones');
            const addEmpleadoBtnPrincipal = document.getElementById('add-empleado-btn');
            const turnosTableBody = document.getElementById('turnosTableBody');
            const turnosDataInput = document.getElementById('turnos_data');
            const turnosDataError = document.getElementById('turnos-data-error');
            const resetBtn = document.getElementById('resetBtn');
            const modalElement = document.getElementById('asignarTurnoModal');
            const modalEmpleadoContainer = document.getElementById('modal-empleado-checkbox-container');
            const modalTipoTurnoSelect = document.getElementById('modal_tipo_turno');
            const modalHoraInicioSelect = document.getElementById('modal_hora_inicio');
            const modalHoraFinSelect = document.getElementById('modal_hora_fin');
            const modalCostoInput = document.getElementById('modal_costo');
            const addTurnoBtn = document.getElementById('addTurnoBtn');
            const limpiarModalBtn = document.getElementById('limpiarModalBtn');
            const modalErrorMessage = document.getElementById('modal-error-message');
            const empleadoIdsError = document.getElementById('empleado-ids-error');
            const tipoTurnoError = document.getElementById('tipo-turno-error');
            const horaInicioError = document.getElementById('hora-inicio-error');
            const horaFinError = document.getElementById('hora-fin-error');
            const costoError = document.getElementById('costo-error');

            function init() {
                if (modalElement) {
                    asignarTurnoModal = new bootstrap.Modal(modalElement, {
                        backdrop: 'static',
                        keyboard: false
                    });
                }
                const today = new Date().toISOString().split('T')[0];
                fechaInicioInput.setAttribute('min', today);
                loadOldTurnosData();
                renderTurnosTable();
                setupEventListeners();
                toggleAddEmpleadoBtn();
                if (observacionesTextarea) autoResizeTextarea(observacionesTextarea);
            }

            function loadOldTurnosData() {
                const oldTurnosData = <?php echo json_encode(old('turnos_data', '[]'), 512) ?>;
                try {
                    const parsedOldTurnos = JSON.parse(oldTurnosData);
                    if (Array.isArray(parsedOldTurnos) && parsedOldTurnos.length > 0) {
                        turnosAsignados = parsedOldTurnos;
                    }
                } catch (e) {
                    console.error("Error al parsear datos antiguos de turnos:", e);
                }
            }

            function setupEventListeners() {
                servicioSelect.addEventListener('change', handleServiceChange);
                addEmpleadoBtnPrincipal.addEventListener('click', handleAddEmpleadoClick);
                mainForm.addEventListener('submit', handleFormSubmit);
                resetBtn.addEventListener('click', handleFormReset);
                fechaInicioInput.addEventListener('change', handleDateChange);
                fechaFinInput.addEventListener('change', handleDateChange);
                modalTipoTurnoSelect.addEventListener('change', () => {
                    modalTipoTurnoSelect.classList.remove('is-invalid');
                    tipoTurnoError.style.display = 'none';
                    modalCostoInput.classList.remove('is-invalid');
                    costoError.style.display = 'none';
                    modalHoraInicioSelect.classList.remove('is-invalid');
                    horaInicioError.style.display = 'none';
                    modalHoraFinSelect.classList.remove('is-invalid');
                    horaFinError.style.display = 'none';
                    updateModalCost();
                    populateModalHourSelects();
                });
                modalHoraInicioSelect.addEventListener('change', () => {
                    modalHoraInicioSelect.classList.remove('is-invalid');
                    horaInicioError.style.display = 'none';
                });
                modalHoraFinSelect.addEventListener('change', () => {
                    modalHoraFinSelect.classList.remove('is-invalid');
                    horaFinError.style.display = 'none';
                });
                modalCostoInput.addEventListener('input', () => {
                    modalCostoInput.classList.remove('is-invalid');
                    costoError.style.display = 'none';
                });
                const fields = [{
                    input: clienteSearchInput,
                    group: clienteSearchGroup
                }, {
                    input: servicioSelect,
                    group: servicioSelectGroup
                }, {
                    input: fechaInicioInput,
                    group: fechaInicioGroup
                }, {
                    input: fechaFinInput,
                    group: fechaFinGroup
                }];
                fields.forEach(field => {
                    field.input.addEventListener('input', () => {
                        field.input.classList.remove('is-invalid');
                        if (field.group) {
                            field.group.classList.remove('is-invalid');
                        }
                        const feedback = document.getElementById(field.input.id + '-error-message');
                        if (feedback) feedback.style.display = 'none';
                    });
                });
                addTurnoBtn.addEventListener('click', handleAddTurnoModalClick);
                limpiarModalBtn.addEventListener('click', clearModalInputs);
                modalElement.addEventListener('hidden.bs.modal', clearModalInputs);
                turnosTableBody.addEventListener('click', function(e) {
                    if (e.target.closest('.btn-danger')) {
                        const row = e.target.closest('tr');
                        const index = Array.from(turnosTableBody.children).indexOf(row);
                        removeTurnoFromTable(index);
                    }
                });
            }

            function handleServiceChange() {
                toggleAddEmpleadoBtn();
            }

            function handleAddEmpleadoClick() {
                const currentServicioId = servicioSelect.value;
                if (currentServicioId) {
                    clearModalInputs();
                    cargarEmpleadosParaModal(currentServicioId);
                    asignarTurnoModal.show();
                }
            }

            function handleFormSubmit(e) {
                e.preventDefault();
                e.stopPropagation();
                let formIsValid = true;
                // Limpiar todos los estados de validación existentes
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.input-group.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

                const clienteIdInput = document.getElementById('cliente_id');
                if (!clienteIdInput.value) {
                    clienteSearchInput.classList.add('is-invalid');
                    clienteSearchGroup.classList.add('is-invalid');
                    if (clienteError) clienteError.style.display = 'block';
                    formIsValid = false;
                }
                const requiredFields = [servicioSelect, fechaInicioInput, fechaFinInput];
                requiredFields.forEach((field) => {
                    const feedback = document.getElementById(field.id + '-error-message');
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        const group = document.getElementById(field.id + '-group');
                        if (group) {
                            group.classList.add('is-invalid');
                        }
                        if (feedback) feedback.style.display = 'block';
                        formIsValid = false;
                    }
                });

                if (fechaInicioInput.value && fechaFinInput.value && new Date(fechaFinInput.value) < new Date(
                    fechaInicioInput.value)) {
                    fechaFinInput.classList.add('is-invalid');
                    fechaFinGroup.classList.add('is-invalid');
                    document.getElementById('fecha_fin-error-message').textContent =
                        'La fecha de fin no puede ser anterior a la de inicio.';
                    document.getElementById('fecha_fin-error-message').style.display = 'block';
                    formIsValid = false;
                }
                if (turnosAsignados.length === 0) {
                    turnosDataError.style.display = 'block';
                    formIsValid = false;
                } else {
                    turnosDataInput.value = JSON.stringify(turnosAsignados);
                }
                if (formIsValid) {
                    mainForm.submit();
                } else {
                    const firstInvalid = mainForm.querySelector('.is-invalid, .input-group.is-invalid, #turnos-data-error');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }
            }

            function handleFormReset() {
                turnosAsignados = [];
                renderTurnosTable();
                mainForm.classList.remove('was-validated');
                if (observacionesTextarea) {
                    observacionesTextarea.value = '';
                    autoResizeTextarea(observacionesTextarea);
                }
                servicioSelect.value = '';
                toggleAddEmpleadoBtn();
                document.getElementById('cliente_search').value = '';
                document.getElementById('cliente_id').value = '';
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');
                clienteSearchGroup.classList.remove('is-invalid');
                servicioSelectGroup.classList.remove('is-invalid');
                fechaInicioGroup.classList.remove('is-invalid');
                fechaFinGroup.classList.remove('is-invalid');
            }

            function handleDateChange(event) {
                const changedField = event.target;
                const value = changedField.value;
                const group = document.getElementById(changedField.id + '-group');
                if (value.trim() !== '') {
                    changedField.classList.remove('is-invalid');
                    if (group) {
                        group.classList.remove('is-invalid');
                    }
                    const feedback = document.getElementById(changedField.id + '-error-message');
                    if (feedback) feedback.style.display = 'none';
                }
                if (changedField.id === 'fecha_inicio') {
                    fechaFinInput.min = value;
                }
            }

            function toggleAddEmpleadoBtn() {
                const isServiceSelected = !!servicioSelect.value;
                addEmpleadoBtnPrincipal.disabled = !isServiceSelected;
                if (isServiceSelected) {
                    addEmpleadoBtnPrincipal.classList.remove('btn-faded');
                } else {
                    addEmpleadoBtnPrincipal.classList.add('btn-faded');
                }
            }

            function renderTurnosTable() {
                let tableHtml = '';
                if (turnosAsignados.length === 0) {
                    tableHtml = `
                <tr>
                    <td colspan="7" class="text-center text-muted py-4 fila-vacia-estilo">
                        <i class="bi bi-person-x" style="font-size: 2rem; opacity: 0.5;"></i>
                        <br>
                        <span style="font-size: 0.9rem;">No hay empleados agregados</span>
                        <br>
                        <small style="font-size: 0.8rem; opacity: 0.7;">Haga clic en "Agregar Empleado(s)" para asignar un empleado al servicio</small>
                    </td>
                </tr>
            `;
                } else {
                    turnosAsignados.forEach((turno, index) => {
                        const tipoTurnoCapitalizado = turno.tipo_turno.charAt(0).toUpperCase() + turno.tipo_turno.slice(1);
                        tableHtml += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${turno.empleado_nombres.join(', ')}</td>
                        <td>${tipoTurnoCapitalizado}</td>
                        <td>${convertirHora12(turno.hora_inicio)}</td>
                        <td>${convertirHora12(turno.hora_fin)}</td>
                        <td>${parseFloat(turno.costo).toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" data-index="${index}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                    });
                }
                turnosTableBody.innerHTML = tableHtml;
                turnosDataInput.value = JSON.stringify(turnosAsignados);
                if (turnosAsignados.length > 0) {
                    turnosDataError.style.display = 'none';
                }
                calculateTotalCost();
            }

            function convertirHora12(hora24) {
                const [horas, minutos] = hora24.split(':');
                const horasNum = parseInt(horas, 10);
                const ampm = horasNum >= 12 ? 'p.m.' : 'a.m.';
                const horas12 = horasNum % 12 || 12;
                return `${horas12.toString().padStart(2, '0')}:${minutos} ${ampm}`;
            }

            function calculateTotalCost() {
                let total = 0;
                turnosAsignados.forEach(turno => {
                    total += parseFloat(turno.costo) || 0;
                });
                const totalCostDisplay = document.getElementById('total-costo-display');
                if (totalCostDisplay) {
                    totalCostDisplay.value = total.toFixed(2);
                }
            }

            function removeTurnoFromTable(index) {
                turnosAsignados.splice(index, 1);
                renderTurnosTable();
            }

            async function cargarEmpleadosParaModal(servicioId) {
                modalEmpleadoContainer.innerHTML = '<p class="text-muted m-0">Cargando empleados...</p>';
                if (!servicioId) {
                    modalEmpleadoContainer.innerHTML =
                        '<p class="text-muted m-0">Seleccione un servicio en el formulario principal primero</p>';
                    return;
                }
                try {
                    const url = empleadosPorServicioUrl.replace(':id', servicioId);
                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Error al cargar empleados.');
                    const empleados = await response.json();
                    const empleadosAsignadosIds = turnosAsignados.map(t => t.empleado_id);
                    renderEmpleadosRadiobuttons(empleados, empleadosAsignadosIds);
                } catch (error) {
                    console.error('Error al cargar empleados:', error);
                    modalEmpleadoContainer.innerHTML = '<p class="text-muted m-0">Error al cargar empleados.</p>';
                }
            }

            function renderEmpleadosRadiobuttons(empleados, empleadosAsignadosIds) {
                modalEmpleadoContainer.innerHTML = '';
                empleados.sort((a, b) => {
                    const nombreCompletoA = (a.nombre + ' ' + a.apellido).toLowerCase();
                    const nombreCompletoB = (b.nombre + ' ' + b.apellido).toLowerCase();
                    return nombreCompletoA.localeCompare(nombreCompletoB);
                });
                if (empleados.length > 0) {
                    empleados.forEach(empleado => {
                        const isAssigned = empleadosAsignadosIds.includes(empleado.id);
                        const div = document.createElement('div');
                        div.classList.add('form-check');
                        div.innerHTML = `
                    <input class="form-check-input" type="radio" name="modal_empleado_id" value="${empleado.id}" id="modal_empleado_${empleado.id}" ${isAssigned ? 'disabled' : ''}>
                    <label class="form-check-label" for="modal_empleado_${empleado.id}">
                        ${empleado.nombre} ${empleado.apellido} ${isAssigned ? ' (ya asignado)' : ''}
                    </label>
                `;
                        modalEmpleadoContainer.appendChild(div);
                    });
                    const radioInputs = modalEmpleadoContainer.querySelectorAll('input[type="radio"]');
                    radioInputs.forEach(radio => {
                        radio.addEventListener('change', () => {
                            if (radio.checked) {
                                empleadoIdsError.style.display = 'none';
                                modalEmpleadoContainer.classList.remove('is-invalid');
                            }
                        });
                    });
                } else {
                    modalEmpleadoContainer.innerHTML =
                        '<p class="text-muted m-0">No hay empleados disponibles para este servicio.</p>';
                }
            }

            function populateModalHourSelects() {
                const tipoTurno = modalTipoTurnoSelect.value;
                const horaInicioSelect = document.getElementById('modal_hora_inicio');
                const horaFinSelect = document.getElementById('modal_hora_fin');
                horaInicioSelect.innerHTML = '<option value="">Seleccione la hora</option>';
                horaFinSelect.innerHTML = '<option value="">Seleccione la hora</option>';
                let hours = [];
                if (tipoTurno === 'diurno') {
                    for (let i = 6; i <= 21; i++) {
                        const time24 = `${i.toString().padStart(2, '0')}:00`;
                        hours.push(time24);
                    }
                } else if (tipoTurno === 'nocturno') {
                    for (let i = 21; i < 24; i++) {
                        const time24 = `${i.toString().padStart(2, '0')}:00`;
                        hours.push(time24);
                    }
                    for (let i = 0; i <= 6; i++) {
                        const time24 = `${i.toString().padStart(2, '0')}:00`;
                        hours.push(time24);
                    }
                } else if (tipoTurno === '24 horas') {
                    horaInicioSelect.innerHTML = '<option value="06:00">06:00 a.m.</option>';
                    horaFinSelect.innerHTML = '<option value="06:00">06:00 a.m.</option>';
                    horaInicioSelect.disabled = true;
                    horaFinSelect.disabled = true;
                    return;
                }
                horaInicioSelect.disabled = false;
                horaFinSelect.disabled = false;
                hours.forEach(hora => {
                    const option = document.createElement('option');
                    option.value = hora;
                    option.textContent = convertirHora12(hora);
                    horaInicioSelect.appendChild(option);
                    horaFinSelect.appendChild(option.cloneNode(true));
                });
            }

            function updateModalCost() {
                const tipoTurno = modalTipoTurnoSelect.value;
                const servicioId = servicioSelect.value;
                let costoUnitario = 0;
                const servicioData = servicios[servicioId];
                if (servicioData) {
                    if (tipoTurno === 'diurno') {
                        costoUnitario = servicioData.costo_diurno;
                    } else if (tipoTurno === 'nocturno') {
                        costoUnitario = servicioData.costo_nocturno;
                    } else if (tipoTurno === '24 horas') {
                        costoUnitario = servicioData.costo_24_horas;
                    }
                }
                modalCostoInput.value = parseFloat(costoUnitario || 0).toFixed(2);
            }

            function handleAddTurnoModalClick(e) {
                e.preventDefault();
                if (validateModalInputs()) {
                    agregarTurno();
                }
            }

            function agregarTurno() {
                const selectedEmployeeRadio = modalEmpleadoContainer.querySelector(
                    'input[name="modal_empleado_id"]:checked');
                if (!selectedEmployeeRadio) {
                    console.error('No se ha seleccionado un empleado.');
                    return;
                }
                const empleadoId = parseInt(selectedEmployeeRadio.value);
                const empleadoNombre = selectedEmployeeRadio.labels[0].textContent.replace(/\s*\(ya asignado\)/, '')
                    .trim();
                const tipoTurno = modalTipoTurnoSelect.value;
                const horaInicio = modalHoraInicioSelect.value;
                const horaFin = modalHoraFinSelect.value;
                let costo = 0;
                const servicioId = servicioSelect.value;
                const servicioData = servicios[servicioId];
                if (servicioData) {
                    let duracionHoras = 0;
                    if (tipoTurno === 'diurno' || tipoTurno === 'nocturno') {
                        const totalMinutosInicio = convertirAMinutos(horaInicio);
                        let totalMinutosFin = convertirAMinutos(horaFin);

                        if (tipoTurno === 'nocturno' && totalMinutosFin < totalMinutosInicio) {
                            totalMinutosFin += 24 * 60;
                        }

                        duracionHoras = (totalMinutosFin - totalMinutosInicio) / 60;
                    } else if (tipoTurno === '24 horas') {
                        duracionHoras = 24;
                    }
                    costo = (servicioData.costo_diurno / 15) * duracionHoras;
                    if (tipoTurno === 'nocturno') {
                        costo = (servicioData.costo_nocturno / 9) * duracionHoras;
                    } else if (tipoTurno === '24 horas') {
                        costo = servicioData.costo_24_horas;
                    }
                }
                const newTurno = {
                    empleado_id: empleadoId,
                    empleado_nombres: [empleadoNombre],
                    tipo_turno: tipoTurno,
                    hora_inicio: horaInicio,
                    hora_fin: horaFin,
                    costo: parseFloat(costo).toFixed(2)
                };
                turnosAsignados.push(newTurno);
                renderTurnosTable();
                asignarTurnoModal.hide();
            }

            function validateModalInputs() {
                let isValid = true;
                clearModalErrors();

                const selectedEmployeeRadio = modalEmpleadoContainer.querySelector('input[name="modal_empleado_id"]:checked');
                if (!selectedEmployeeRadio) {
                    empleadoIdsError.style.display = 'block';
                    modalEmpleadoContainer.classList.add('is-invalid');
                    isValid = false;
                }

                if (!modalTipoTurnoSelect.value) {
                    tipoTurnoError.style.display = 'block';
                    modalTipoTurnoSelect.classList.add('is-invalid');
                    isValid = false;
                }

                if (modalTipoTurnoSelect.value !== '24 horas') {
                    if (!modalHoraInicioSelect.value) {
                        horaInicioError.textContent = 'Hora de inicio es obligatoria.';
                        horaInicioError.style.display = 'block';
                        modalHoraInicioSelect.classList.add('is-invalid');
                        isValid = false;
                    }
                    if (!modalHoraFinSelect.value) {
                        horaFinError.textContent = 'Hora de fin es obligatoria.';
                        horaFinError.style.display = 'block';
                        modalHoraFinSelect.classList.add('is-invalid');
                        isValid = false;
                    }

                    if (modalHoraInicioSelect.value && modalHoraFinSelect.value) {
                        const totalMinutosInicio = convertirAMinutos(modalHoraInicioSelect.value);
                        let totalMinutosFin = convertirAMinutos(modalHoraFinSelect.value);

                        if (modalTipoTurnoSelect.value === 'nocturno') {
                            if (totalMinutosInicio < convertirAMinutos('21:00') && totalMinutosFin > convertirAMinutos('06:00')) {
                                horaInicioError.textContent = 'La hora de inicio debe ser 9:00 p.m. o posterior para un turno nocturno.';
                                horaInicioError.style.display = 'block';
                                modalHoraInicioSelect.classList.add('is-invalid');
                                isValid = false;
                            }
                            if (totalMinutosFin > convertirAMinutos('06:00') && totalMinutosFin < convertirAMinutos('21:00')) {
                                horaFinError.textContent = 'La hora de fin debe ser 6:00 a.m. o anterior para un turno nocturno.';
                                horaFinError.style.display = 'block';
                                modalHoraFinSelect.classList.add('is-invalid');
                                isValid = false;
                            }
                            if (totalMinutosFin <= totalMinutosInicio && totalMinutosFin > convertirAMinutos('06:00')) {
                                horaFinError.textContent = 'La hora de fin del turno nocturno debe estar entre 12:00 a.m. y 6:00 a.m.';
                                horaFinError.style.display = 'block';
                                modalHoraFinSelect.classList.add('is-invalid');
                                isValid = false;
                            }
                        }

                        if (modalTipoTurnoSelect.value !== 'nocturno' && totalMinutosFin <= totalMinutosInicio) {
                            horaFinError.textContent = 'La hora de fin debe ser posterior a la de inicio.';
                            horaFinError.style.display = 'block';
                            modalHoraFinSelect.classList.add('is-invalid');
                            isValid = false;
                        }
                    }
                }

                if (!modalCostoInput.value || parseFloat(modalCostoInput.value) <= 0) {
                    costoError.style.display = 'block';
                    modalCostoInput.classList.add('is-invalid');
                    isValid = false;
                }

                return isValid;
            }

            function convertirAMinutos(hora) {
                const [h, m] = hora.split(':').map(Number);
                return h * 60 + m;
            }

            function convertirHora24(hora12) {
                const [time, ampm] = hora12.split(' ');
                let [hours, minutes] = time.split(':');
                hours = parseInt(hours);
                if (ampm.startsWith('p') && hours !== 12) {
                    hours += 12;
                } else if (ampm.startsWith('a') && hours === 12) {
                    hours = 0;
                }
                return `${hours.toString().padStart(2, '0')}:${minutes}`;
            }

            function clearModalInputs() {
                const selectedRadio = modalEmpleadoContainer.querySelector(
                    'input[name="modal_empleado_id"]:checked');
                if (selectedRadio) selectedRadio.checked = false;
                modalTipoTurnoSelect.value = '';
                modalHoraInicioSelect.value = '';
                modalHoraFinSelect.value = '';
                modalCostoInput.value = '';
                clearModalErrors();
                populateModalHourSelects();
            }

            function clearModalErrors() {
                modalErrorMessage.style.display = 'none';
                modalEmpleadoContainer.classList.remove('is-invalid');
                empleadoIdsError.style.display = 'none';
                modalTipoTurnoSelect.classList.remove('is-invalid');
                tipoTurnoError.style.display = 'none';
                modalHoraInicioSelect.classList.remove('is-invalid');
                horaInicioError.style.display = 'none';
                modalHoraFinSelect.classList.remove('is-invalid');
                horaFinError.style.display = 'none';
                modalCostoInput.classList.remove('is-invalid');
                costoError.style.display = 'none';
            }
            init();
            calculateTotalCost();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ardon\OneDrive\Documentos\GitHub\Centinela\resources\views/turnos/formulario.blade.php ENDPATH**/ ?>