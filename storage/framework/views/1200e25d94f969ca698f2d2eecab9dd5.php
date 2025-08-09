<?php $__env->startSection('titulo', 'Asignación de servicio'); ?>
<?php $__env->startSection('content'); ?>

    <style>
        body {
            font-family: 'Inter', sans-serif;
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
    </style>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-white p-5 rounded shadow-lg position-relative">

                    <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                        <i class="bi bi-calendar-check" style="font-size: 4rem;"></i>
                    </div>

                    <h3 class="text-center mb-4">
                        <i class="bi bi-calendar-plus me-2"></i>
                        Asignación de servicio
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
                                <label for="cliente_id" class="form-label">Cliente</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-person-check-fill"></i></span>
                                    <select name="cliente_id" id="cliente_id"
                                            class="form-select <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione un cliente</option>
                                        <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cliente->id); ?>"
                                                <?php echo e(old('cliente_id') == $cliente->id ? 'selected' : ''); ?>>
                                                <?php echo e($cliente->nombre); ?> <?php echo e($cliente->apellido); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="servicio_id" class="form-label">Tipo de servicio</label>
                                <div class="input-group has-validation">
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
                                        <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($servicio->id); ?>"
                                                    data-costo-diurno="<?php echo e($servicio->costo_diurno ?? 0); ?>"
                                                    data-costo-nocturno="<?php echo e($servicio->costo_nocturno ?? 0); ?>"
                                                    data-costo-24-horas="<?php echo e($servicio->costo_24_horas ?? 0); ?>"
                                                <?php echo e(old('servicio_id') == $servicio->id ? 'selected' : ''); ?>>
                                                <?php echo e($servicio->nombre); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['servicio_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row g-4 align-items-end">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                                data-bs-target="#asignarTurnoModal">
                                            <i class="bi bi-plus-circle me-1"></i> Agregar Empleado(s)
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                                                   class="form-control <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   value="<?php echo e(old('fecha_inicio')); ?>" required>
                                            <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="fecha_fin" class="form-label">Fecha fin</label>
                                        <div class="input-group has-validation">
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
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive mt-2">
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
                                        <tfoot id="turnosTableFooter">
                                        <tr>
                                            <td colspan="5" class="text-end fw-bold">Subtotal (Lps):</td>
                                            <td id="subtotalTurnosCosto" class="fw-bold">0.00</td>
                                            <td></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <input type="hidden" name="turnos_data" id="turnos_data">
                                <div id="turnos-data-error" class="invalid-feedback mt-1 small" style="display: none;">
                                    Debe agregar al menos un turno a la tabla.</div>
                            </div>

                            <div class="col-md-12">
                                <label for="observaciones" class="form-label">Observaciones o instrucciones
                                    especiales</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                                    <textarea name="observaciones" id="observaciones" rows="1"
                                              class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="255"
                                              onkeypress="return validarDescripcion(event)"
                                              oninput="validarTexto(event); autoResizeTextarea(this);"><?php echo e(old('observaciones')); ?></textarea>
                                    <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
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
                    <div id="modal-error-message" class="alert alert-danger" role="alert"></div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Empleado(s) asignado(s)</label>
                            <div id="modal-empleado-checkbox-container">
                                <p class="text-muted m-0">Seleccione un servicio en el formulario principal primero</p>
                            </div>
                            <div id="empleado-ids-error" class="invalid-feedback mt-1 small" style="display: none;">Debe
                                seleccionar al menos un empleado.</div>
                        </div>

                        <div class="col-md-12">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="modal_tipo_turno" class="form-label">Tipo de turno</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                                        <select name="modal_tipo_turno" id="modal_tipo_turno" class="form-select" required>
                                            <option value="">Seleccione</option>
                                            <option value="diurno">Diurno</option>
                                            <option value="nocturno">Nocturno</option>
                                            <option value="24 horas">24 horas</option>
                                        </select>
                                    </div>
                                    <div id="tipo-turno-error" class="invalid-feedback mt-1 small" style="display: none;">
                                        Tipo de turno es obligatorio.</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="modal_costo" class="form-label">Costo (Lps)</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                        <input type="number" step="0.01" name="modal_costo" id="modal_costo"
                                               class="form-control" readonly>
                                    </div>
                                    <div id="costo-error" class="invalid-feedback mt-1 small" style="display: none;">El
                                        costo es obligatorio.</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="modal_hora_inicio" class="form-label">Hora inicio</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                        <input type="time" name="modal_hora_inicio" id="modal_hora_inicio"
                                               class="form-control" required>
                                    </div>
                                    <div id="hora-inicio-error" class="invalid-feedback mt-1 small"
                                         style="display: none;">Hora inicio es obligatorio.</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="modal_hora_fin" class="form-label">Hora fin</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
                                        <input type="time" name="modal_hora_fin" id="modal_hora_fin"
                                               class="form-control" required>
                                    </div>
                                    <div id="hora-fin-error" class="invalid-feedback mt-1 small" style="display: none;">
                                        Hora fin es obligatorio.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="addTurnoBtn">
                        <i class="bi bi-plus-circle"></i> Agregar Empleado
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Variables globales
        let turnosAsignados = [];
        let currentServiceCosts = {
            diurno: 0,
            nocturno: 0,
            '24 horas': 0
        };

        // Elementos del DOM
        const mainForm = document.getElementById('mainForm');
        const clienteSelect = document.getElementById('cliente_id');
        const servicioSelect = document.getElementById('servicio_id');
        const fechaInicioInput = document.getElementById('fecha_inicio');
        const fechaFinInput = document.getElementById('fecha_fin');
        const observacionesTextarea = document.getElementById('observaciones');
        const resetBtn = document.getElementById('resetBtn');
        const turnosTableBody = document.getElementById('turnosTableBody');
        const turnosDataInput = document.getElementById('turnos_data');
        const subtotalTurnosCostoElement = document.getElementById('subtotalTurnosCosto');
        const turnosDataError = document.getElementById('turnos-data-error');

        // Elementos del modal
        let asignarTurnoModal;
        const modalEmpleadoContainer = document.getElementById('modal-empleado-checkbox-container');
        const modalTipoTurnoSelect = document.getElementById('modal_tipo_turno');
        const modalHoraInicioInput = document.getElementById('modal_hora_inicio');
        const modalHoraFinInput = document.getElementById('modal_hora_fin');
        const modalCostoInput = document.getElementById('modal_costo');
        const addTurnoBtn = document.getElementById('addTurnoBtn');
        const empleadoIdsError = document.getElementById('empleado-ids-error');
        const tipoTurnoError = document.getElementById('tipo-turno-error');
        const horaInicioError = document.getElementById('hora-inicio-error');
        const horaFinError = document.getElementById('hora-fin-error');
        const costoError = document.getElementById('costo-error');
        const modalErrorMessage = document.getElementById('modal-error-message');

        const empleadosPorServicioUrl = "<?php echo e(route('turnos.empleadosPorServicio', ['servicio_id' => ':id'])); ?>";

        // Inicializar modal después de cargar Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('asignarTurnoModal');
            if (modalElement) {
                asignarTurnoModal = new bootstrap.Modal(modalElement, {
                    backdrop: 'static',
                    keyboard: false
                });
            }

            // Cargar datos antiguos si existen
            const oldTurnosData = <?php echo json_encode(old('turnos_data', '[]'), 512) ?>;
            try {
                const parsedOldTurnos = JSON.parse(oldTurnosData);
                if (Array.isArray(parsedOldTurnos) && parsedOldTurnos.length > 0) {
                    turnosAsignados = parsedOldTurnos;
                }
            } catch (e) {
                console.error("Error al parsear datos antiguos de turnos:", e);
            }

            renderTurnosTable();
        });

        // --- Funciones de Utilidad ---
        function autoResizeTextarea(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        if (observacionesTextarea) {
            autoResizeTextarea(observacionesTextarea);
            observacionesTextarea.addEventListener('input', function() {
                autoResizeTextarea(this);
            });
        }

        function showModalError(message) {
            modalErrorMessage.textContent = message;
            modalErrorMessage.style.display = 'block';
            setTimeout(() => {
                modalErrorMessage.style.display = 'none';
            }, 5000);
        }

        function clearModalErrors() {
            modalErrorMessage.style.display = 'none';
            empleadoIdsError.style.display = 'none';
            modalTipoTurnoSelect.classList.remove('is-invalid');
            tipoTurnoError.style.display = 'none';
            modalHoraInicioInput.classList.remove('is-invalid');
            horaInicioError.style.display = 'none';
            modalHoraFinInput.classList.remove('is-invalid');
            horaFinError.style.display = 'none';
            modalCostoInput.classList.remove('is-invalid');
            costoError.style.display = 'none';
            modalEmpleadoContainer.classList.remove('is-invalid');
        }

        // --- Lógica de la Tabla de Turnos ---
        function renderTurnosTable() {
            let tableHtml = '';
            let totalCosto = 0;

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
                    tableHtml += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${turno.empleado_nombres.join(', ')}</td>
                        <td>${turno.tipo_turno}</td>
                        <td>${turno.hora_inicio}</td>
                        <td>${turno.hora_fin}</td>
                        <td>${parseFloat(turno.costo).toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeTurnoFromTable(${index})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                    totalCosto += parseFloat(turno.costo);
                });
            }

            turnosTableBody.innerHTML = tableHtml;
            subtotalTurnosCostoElement.textContent = totalCosto.toFixed(2);
            turnosDataInput.value = JSON.stringify(turnosAsignados);
        }

        window.removeTurnoFromTable = function(index) {
            turnosAsignados.splice(index, 1);
            renderTurnosTable();
        };

        // --- Lógica del Modal ---
        function updateModalBaseCostDisplay() {
            const tipoTurno = modalTipoTurnoSelect.value;
            let costoUnitario = 0;

            if (tipoTurno in currentServiceCosts) {
                costoUnitario = currentServiceCosts[tipoTurno];
            }

            modalCostoInput.value = parseFloat(costoUnitario).toFixed(2);
        }

        modalTipoTurnoSelect.addEventListener('change', updateModalBaseCostDisplay);
        modalEmpleadoContainer.addEventListener('change', updateModalBaseCostDisplay);

        // --- Carga Dinámica de Empleados ---
        async function cargarEmpleadosParaModal(servicioId) {
            modalEmpleadoContainer.innerHTML = '<p class="text-muted m-0">Cargando empleados...</p>';

            if (!servicioId) {
                modalEmpleadoContainer.innerHTML =
                    '<p class="text-muted m-0">Seleccione un servicio en el formulario principal primero</p>';
                currentServiceCosts = {
                    diurno: 0,
                    nocturno: 0,
                    '24 horas': 0
                };
                modalCostoInput.value = '0.00';
                return;
            }

            try {
                const url = empleadosPorServicioUrl.replace(':id', servicioId);
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error('Error en la red o en el servidor al cargar empleados.');
                }

                const empleados = await response.json();
                const empleadosAsignadosIds = turnosAsignados.map(t => t.empleado_id);

                modalEmpleadoContainer.innerHTML = '';

                if (empleados.length > 0) {
                    empleados.forEach(empleado => {
                        const isAssigned = empleadosAsignadosIds.includes(empleado.id);
                        const div = document.createElement('div');
                        div.classList.add('form-check');
                        div.innerHTML = `
                        <input class="form-check-input" type="radio" name="modal_empleado_ids" value="${empleado.id}" id="modal_empleado_${empleado.id}" ${isAssigned ? 'disabled' : ''}>
                        <label class="form-check-label" for="modal_empleado_${empleado.id}">
                            ${empleado.nombre} ${empleado.apellido} ${isAssigned ? ' (ya asignado)' : ''}
                        </label>
                    `;
                        modalEmpleadoContainer.appendChild(div);
                    });

                    modalEmpleadoContainer.querySelectorAll('input[name="modal_empleado_ids"]').forEach(radio => {
                        radio.addEventListener('change', updateModalBaseCostDisplay);
                    });
                } else {
                    modalEmpleadoContainer.innerHTML =
                        '<p class="text-muted m-0">No hay empleados disponibles para este servicio.</p>';
                }

                const selectedOption = servicioSelect.options[servicioSelect.selectedIndex];
                if (selectedOption) {
                    currentServiceCosts = {
                        diurno: parseFloat(selectedOption.dataset.costoDiurno || 0),
                        nocturno: parseFloat(selectedOption.dataset.costoNocturno || 0),
                        '24 horas': parseFloat(selectedOption.dataset.costo24Horas || 0)
                    };
                } else {
                    currentServiceCosts = {
                        diurno: 0,
                        nocturno: 0,
                        '24 horas': 0
                    };
                }

                updateModalBaseCostDisplay();

            } catch (error) {
                console.error('Error al cargar empleados o costo del servicio:', error);
                modalEmpleadoContainer.innerHTML = '<p class="text-muted m-0">Error al cargar empleados.</p>';
                currentServiceCosts = {
                    diurno: 0,
                    nocturno: 0,
                    '24 horas': 0
                };
                modalCostoInput.value = '0.00';
            }
        }

        // --- Eventos del Modal (CORREGIDO) ---
        document.getElementById('asignarTurnoModal').addEventListener('show.bs.modal', function(e) {
            const currentServicioId = servicioSelect.value;
            if (!currentServicioId) {
                e.preventDefault(); // Evita que el modal se muestre
                alert('Debe seleccionar un tipo de servicio primero.');
                return;
            }

            // Si el servicio está seleccionado, limpia y carga los datos
            clearModalInputs();
            cargarEmpleadosParaModal(currentServicioId);
        });

        document.getElementById('asignarTurnoModal').addEventListener('hidden.bs.modal', function() {
            clearModalInputs();
        });

        // --- Event Listener del Select de Servicio ---
        servicioSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.value) {
                currentServiceCosts = {
                    diurno: parseFloat(selectedOption.dataset.costoDiurno || 0),
                    nocturno: parseFloat(selectedOption.dataset.costoNocturno || 0),
                    '24 horas': parseFloat(selectedOption.dataset.costo24Horas || 0)
                };
            } else {
                currentServiceCosts = {
                    diurno: 0,
                    nocturno: 0,
                    '24 horas': 0
                };
            }
            updateModalBaseCostDisplay();
        });

        // --- Validación del Modal ---
        function validateModalInputs() {
            let isValid = true;
            clearModalErrors();

            const selectedEmployeeRadio = modalEmpleadoContainer.querySelector(
                'input[name="modal_empleado_ids"]:checked');
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

            if (!modalHoraInicioInput.value) {
                horaInicioError.style.display = 'block';
                modalHoraInicioInput.classList.add('is-invalid');
                isValid = false;
            }

            if (!modalHoraFinInput.value) {
                horaFinError.style.display = 'block';
                modalHoraFinInput.classList.add('is-invalid');
                isValid = false;
            } else if (modalHoraInicioInput.value && modalHoraFinInput.value) {
                const [hInicio, mInicio] = modalHoraInicioInput.value.split(':').map(Number);
                const [hFin, mFin] = modalHoraFinInput.value.split(':').map(Number);

                if (modalTipoTurnoSelect.value !== '24 horas' && (hFin * 60 + mFin) <= (hInicio * 60 + mInicio)) {
                    horaFinError.textContent = 'La hora de fin debe ser posterior a la hora de inicio.';
                    horaFinError.style.display = 'block';
                    modalHoraFinInput.classList.add('is-invalid');
                    isValid = false;
                } else if (modalTipoTurnoSelect.value === '24 horas' && (hFin * 60 + mFin) !== (hInicio * 60 + mInicio)) {
                    horaFinError.textContent = 'Para un turno de 24 horas, la hora de fin debe ser igual a la de inicio.';
                    horaFinError.style.display = 'block';
                    modalHoraFinInput.classList.add('is-invalid');
                    isValid = false;
                }
            }

            const costoValue = parseFloat(modalCostoInput.value);
            if (isNaN(costoValue) || costoValue <= 0) {
                costoError.textContent = 'El costo es obligatorio y debe ser un número positivo.';
                costoError.style.display = 'block';
                modalCostoInput.classList.add('is-invalid');
                isValid = false;
            }

            return isValid;
        }

        function clearModalInputs() {
            const selectedRadio = modalEmpleadoContainer.querySelector('input[name="modal_empleado_ids"]:checked');
            if (selectedRadio) {
                selectedRadio.checked = false;
            }
            modalTipoTurnoSelect.value = '';
            modalHoraInicioInput.value = '';
            modalHoraFinInput.value = '';
            modalCostoInput.value = '';
            clearModalErrors();
        }

        addTurnoBtn.addEventListener('click', function(e) {
            e.preventDefault();
            agregarTurno();
        });

        async function agregarTurno() {
            if (!validateModalInputs()) {
                showModalError("Por favor, complete todos los campos requeridos y corrija los errores.");
                return;
            }

            const selectedEmployeeRadio = modalEmpleadoContainer.querySelector(
                'input[name="modal_empleado_ids"]:checked');
            const empleadoId = parseInt(selectedEmployeeRadio.value);
            const empleadoNombre = selectedEmployeeRadio.nextElementSibling.textContent.trim();

            const isAlreadyAssigned = turnosAsignados.some(existingTurno =>
                existingTurno.empleado_id === empleadoId
            );

            if (isAlreadyAssigned) {
                showModalError(`El empleado ${empleadoNombre} ya está asignado a un turno.`);
                return;
            }

            const tipoTurno = modalTipoTurnoSelect.value;
            const horaInicio = modalHoraInicioInput.value;
            const horaFin = modalHoraFinInput.value;

            // Lógica de cálculo del costo por turno
            let costo = 0;
            const costoBaseTurno = currentServiceCosts[tipoTurno];

            if (costoBaseTurno > 0) {
                const [hInicio, mInicio] = horaInicio.split(':').map(Number);
                const [hFin, mFin] = horaFin.split(':').map(Number);
                const totalMinutosInicio = hInicio * 60 + mInicio;
                let totalMinutosFin = hFin * 60 + mFin;

                if (totalMinutosFin < totalMinutosInicio) {
                    totalMinutosFin += 24 * 60; // Ajusta si el turno cruza la medianoche
                }

                const duracionMinutos = totalMinutosFin - totalMinutosInicio;
                const duracionHoras = duracionMinutos / 60;

                let duracionEstandar = 0;
                if (tipoTurno === 'diurno' || tipoTurno === 'nocturno') {
                    duracionEstandar = 12;
                } else if (tipoTurno === '24 horas') {
                    duracionEstandar = 24;
                }

                if (duracionEstandar > 0) {
                    const costoPorHora = costoBaseTurno / duracionEstandar;
                    costo = costoPorHora * duracionHoras;
                }
            }

            const newTurno = {
                empleado_id: empleadoId,
                empleado_nombres: [empleadoNombre],
                tipo_turno: tipoTurno,
                hora_inicio: horaInicio,
                hora_fin: horaFin,
                costo: costo
            };

            turnosAsignados.push(newTurno);
            renderTurnosTable();
            clearModalInputs();
            asignarTurnoModal.hide();
        }

        // --- Validación del Formulario Principal ---
        mainForm.addEventListener('submit', function(e) {
            let formIsValid = true;
            mainForm.querySelectorAll('.is-invalid, .is-valid').forEach(el => {
                el.classList.remove('is-invalid', 'is-valid');
            });
            mainForm.querySelectorAll('.invalid-feedback').forEach(el => {
                el.style.display = 'none';
            });

            if (!clienteSelect.value) {
                clienteSelect.classList.add('is-invalid');
                formIsValid = false;
            }

            if (!servicioSelect.value) {
                servicioSelect.classList.add('is-invalid');
                formIsValid = false;
            }

            if (!fechaInicioInput.value) {
                fechaInicioInput.classList.add('is-invalid');
                formIsValid = false;
            }

            if (!fechaFinInput.value) {
                fechaFinInput.classList.add('is-invalid');
                formIsValid = false;
            } else if (fechaInicioInput.value && fechaFinInput.value) {
                const fechaInicio = new Date(fechaInicioInput.value);
                const fechaFin = new Date(fechaFinInput.value);
                if (fechaFin < fechaInicio) {
                    fechaFinInput.classList.add('is-invalid');
                    fechaFinInput.closest('.has-validation').querySelector('.invalid-feedback').textContent =
                        'La fecha de fin debe ser igual o posterior a la fecha de inicio.';
                    formIsValid = false;
                }
            }

            if (turnosAsignados.length === 0) {
                turnosDataError.style.display = 'block';
                formIsValid = false;
            }

            // Aplicar 'is-invalid' y mostrar feedback para los campos inválidos
            mainForm.querySelectorAll('input:required, select:required').forEach(input => {
                if (!input.value) {
                    input.classList.add('is-invalid');
                    const feedback = input.closest('.has-validation').querySelector('.invalid-feedback');
                    if (feedback) feedback.style.display = 'block';
                    formIsValid = false;
                }
            });

            if (!formIsValid) {
                e.preventDefault();
                mainForm.classList.add('was-validated');
                const firstInvalid = mainForm.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            } else {
                turnosDataInput.value = JSON.stringify(turnosAsignados);
                mainForm.classList.remove('was-validated');
            }
        });

        // --- Lógica de Reset del Formulario ---
        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                // e.preventDefault(); ya no es necesario con type="reset"

                turnosAsignados = [];
                renderTurnosTable();

                mainForm.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                    el.classList.remove('is-valid', 'is-invalid');
                });

                mainForm.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.style.display = 'none';
                });

                mainForm.classList.remove('was-validated');

                // Asegurar que el textarea se resetee y cambie de tamaño
                if (observacionesTextarea) {
                    observacionesTextarea.value = '';
                    autoResizeTextarea(observacionesTextarea);
                }

                clearModalInputs();

                currentServiceCosts = {
                    diurno: 0,
                    nocturno: 0,
                    '24 horas': 0
                };
            });
        }

        // --- Funciones de Validación de Texto ---
        function validarDescripcion(event) {
            const charCode = event.which ? event.which : event.keyCode;
            const pattern = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.\-#()]+$/;
            const char = String.fromCharCode(charCode);

            if (!pattern.test(char) && charCode !== 8 && charCode !== 0) {
                event.preventDefault();
                return false;
            }
            return true;
        }

        function validarTexto(event) {
            const input = event.target;
            const originalValue = input.value;
            const cleanedValue = originalValue.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.\-#()]/g, '');
            if (cleanedValue !== originalValue) {
                input.value = cleanedValue;
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/turnos/formulario.blade.php ENDPATH**/ ?>