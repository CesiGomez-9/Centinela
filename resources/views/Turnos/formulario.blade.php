@extends('plantilla')
@section('titulo', 'Asignación de servicio')
@section('content')

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

        .input-group:not(.has-validation) .form-control:valid,
        .input-group:not(.has-validation) .form-select:valid {
            border-color: #dee2e6 !important;
            padding-right: 0.75rem;
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

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('turnos.store') }}" novalidate id="mainForm">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="cliente_id" class="form-label">Cliente</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-check-fill"></i></span>
                                    <select name="cliente_id" id="cliente_id"
                                            class="form-select @error('cliente_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}"
                                                {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nombre }} {{ $cliente->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('cliente_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback" id="cliente_id-error-message" style="display:none;">
                                        El cliente es obligatorio.
                                    </div>
                                    @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="servicio_id" class="form-label">Tipo de servicio</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi-shield-check"></i></span>
                                    <select name="servicio_id" id="servicio_id"
                                            class="form-select @error('servicio_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un servicio</option>
                                        @foreach ($servicios as $servicio)
                                            <option value="{{ $servicio->id }}"
                                                    data-costo-diurno="{{ $servicio->costo_diurno ?? 0 }}"
                                                    data-costo-nocturno="{{ $servicio->costo_nocturno ?? 0 }}"
                                                    data-costo-24-horas="{{ $servicio->costo_24_horas ?? 0 }}"
                                                {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                                {{ $servicio->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('servicio_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback" id="servicio_id-error-message" style="display:none;">
                                        El tipo de servicio es obligatorio.
                                    </div>
                                    @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="row g-4 align-items-end">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-success" id="add-empleado-btn" disabled>
                                            <i class="bi bi-plus-circle me-1"></i> Agregar Empleado(s)
                                        </button>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                                                   class="form-control @error('fecha') is-invalid @enderror"
                                                   value="{{ old('fecha', isset($factura) ? $factura->fecha : \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                                   required>
                                        </div>
                                        @error('fecha_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="invalid-feedback" id="fecha_inicio-error-message" style="display:none;">
                                                La fecha de inicio es obligatoria.
                                            </div>
                                            @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="fecha_fin" class="form-label">Fecha fin</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
                                            <input type="date" name="fecha_fin" id="fecha_fin"
                                                   class="form-control @error('fecha_fin') is-invalid @enderror"
                                                   value="{{ old('fecha_fin') }}" required>
                                        </div>
                                        @error('fecha_fin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="invalid-feedback" id="fecha_fin-error-message" style="display:none;">
                                                La fecha de fin es obligatoria.
                                            </div>
                                            @enderror
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
                                        <tfoot>
                                        <tr class="table-light fw-bold">
                                            <td colspan="5" class="text-end">Costo Total:</td>
                                            <td id="total-costo-display">0.00</td>
                                            <td></td>
                                        </tr>
                                        </tfoot>
                                    </table>
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
                                              class="form-control @error('observaciones') is-invalid @enderror" maxlength="255"
                                              oninput="autoResizeTextarea(this);" required>{{ old('observaciones') }}</textarea>
                                </div>
                                @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback" id="observaciones-error-message" style="display:none;">
                                        Las observaciones son obligatorias.
                                    </div>
                                    @enderror
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <a href="{{ route('turnos.index') }}" class="btn btn-danger me-2">
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
                                    <div id="tipo-turno-error" class="invalid-feedback mt-1 small" style="display: none;">
                                        Tipo de turno es obligatorio.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="modal_costo" class="form-label">Costo (Lps)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                        <input type="number" step="0.01" name="modal_costo" id="modal_costo"
                                               class="form-control" readonly>
                                    </div>
                                    <div id="costo-error" class="invalid-feedback mt-1 small" style="display: none;">El
                                        costo es obligatorio.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="modal_hora_inicio" class="form-label">Hora inicio</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                        <input type="time" name="modal_hora_inicio" id="modal_hora_inicio"
                                               class="form-control" required>
                                        <select class="form-select" id="modal_hora_inicio_ampm">
                                            <option value="am">a.m.</option>
                                            <option value="pm">p.m.</option>
                                        </select>
                                    </div>
                                    <div id="hora-inicio-error" class="invalid-feedback mt-1 small" style="display: none;">
                                        Hora inicio es obligatoria.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="modal_hora_fin" class="form-label">Hora fin</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
                                        <input type="time" name="modal_hora_fin" id="modal_hora_fin"
                                               class="form-control" required>
                                        <select class="form-select" id="modal_hora_fin_ampm">
                                            <option value="am">a.m.</option>
                                            <option value="pm">p.m.</option>
                                        </select>
                                    </div>
                                    <div id="hora-fin-error" class="invalid-feedback mt-1 small" style="display: none;">
                                        Hora fin es obligatoria.
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function autoResizeTextarea(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Variables y estado
            let turnosAsignados = [];
            let currentServiceCosts = { diurno: 0, nocturno: 0, '24 horas': 0 };
            const empleadosPorServicioUrl = "{{ route('turnos.empleadosPorServicio', ['servicio_id' => ':id']) }}";
            let asignarTurnoModal;

            // Elementos del DOM
            const mainForm = document.getElementById('mainForm');
            const clienteSelect = document.getElementById('cliente_id');
            const servicioSelect = document.getElementById('servicio_id');
            const fechaInicioInput = document.getElementById('fecha_inicio');
            const fechaFinInput = document.getElementById('fecha_fin');
            const observacionesTextarea = document.getElementById('observaciones');
            const addEmpleadoBtnPrincipal = document.getElementById('add-empleado-btn');
            const turnosTableBody = document.getElementById('turnosTableBody');
            const turnosDataInput = document.getElementById('turnos_data');
            const turnosDataError = document.getElementById('turnos-data-error');
            const resetBtn = document.getElementById('resetBtn');

            // Elementos del modal
            const modalElement = document.getElementById('asignarTurnoModal');
            const modalEmpleadoContainer = document.getElementById('modal-empleado-checkbox-container');
            const modalTipoTurnoSelect = document.getElementById('modal_tipo_turno');
            const modalHoraInicioInput = document.getElementById('modal_hora_inicio');
            const modalHoraFinInput = document.getElementById('modal_hora_fin');
            const modalCostoInput = document.getElementById('modal_costo');
            const addTurnoBtn = document.getElementById('addTurnoBtn');
            const limpiarModalBtn = document.getElementById('limpiarModalBtn');
            const modalErrorMessage = document.getElementById('modal-error-message');

            const modalHoraInicioAmPmSelect = document.getElementById('modal_hora_inicio_ampm');
            const modalHoraFinAmPmSelect = document.getElementById('modal_hora_fin_ampm');

            const empleadoIdsError = document.getElementById('empleado-ids-error');
            const tipoTurnoError = document.getElementById('tipo-turno-error');
            const horaInicioError = document.getElementById('hora-inicio-error');
            const horaFinError = document.getElementById('hora-fin-error');
            const costoError = document.getElementById('costo-error');


            // Inicialización de la lógica
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
                const oldTurnosData = @json(old('turnos_data', '[]'));
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

                const fields = [clienteSelect, servicioSelect, fechaInicioInput, fechaFinInput, observacionesTextarea];
                fields.forEach(field => {
                    field.addEventListener('input', () => {
                        if (field.value.trim() !== '') {
                            field.classList.remove('is-invalid');
                            const feedback = document.getElementById(field.id + '-error-message');
                            if (feedback) feedback.style.display = 'none';
                        }
                    });
                });

                addTurnoBtn.addEventListener('click', handleAddTurnoModalClick);
                limpiarModalBtn.addEventListener('click', clearModalInputs);
                modalTipoTurnoSelect.addEventListener('change', updateModalBaseCostDisplay);
                modalElement.addEventListener('hidden.bs.modal', clearModalInputs);

                turnosTableBody.addEventListener('click', function(e) {
                    if (e.target.closest('.btn-danger')) {
                        const row = e.target.closest('tr');
                        const index = Array.from(turnosTableBody.children).indexOf(row);
                        removeTurnoFromTable(index);
                    }
                });
            }

            function handleDateChange(event) {
                const changedField = event.target;
                const value = changedField.value;

                if (value.trim() !== '') {
                    changedField.classList.remove('is-invalid');
                    const feedback = document.getElementById(changedField.id + '-error-message');
                    if (feedback) feedback.style.display = 'none';
                }

                if (changedField.id === 'fecha_inicio') {
                    fechaFinInput.min = value;
                }
            }

            function toggleAddEmpleadoBtn() {
                addEmpleadoBtnPrincipal.disabled = !servicioSelect.value;
            }

            function handleServiceChange() {
                toggleAddEmpleadoBtn();
                const selectedOption = servicioSelect.options[servicioSelect.selectedIndex];
                currentServiceCosts = selectedOption ? {
                    diurno: parseFloat(selectedOption.dataset.costoDiurno || 0),
                    nocturno: parseFloat(selectedOption.dataset.costoNocturno || 0),
                    '24 horas': parseFloat(selectedOption.dataset.costo24Horas || 0)
                } : { diurno: 0, nocturno: 0, '24 horas': 0 };
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

                const allFormControls = mainForm.querySelectorAll('.form-control, .form-select');
                allFormControls.forEach(el => el.classList.remove('is-invalid'));
                const allInvalidFeedback = mainForm.querySelectorAll('.invalid-feedback');
                allInvalidFeedback.forEach(el => el.style.display = 'none');

                const requiredFields = [clienteSelect, servicioSelect, fechaInicioInput, fechaFinInput, observacionesTextarea];
                requiredFields.forEach(field => {
                    const feedback = document.getElementById(field.id + '-error-message');
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        if (feedback) feedback.style.display = 'block';
                        formIsValid = false;
                    }
                });

                if (fechaInicioInput.value && fechaFinInput.value && new Date(fechaFinInput.value) < new Date(fechaInicioInput.value)) {
                    fechaFinInput.classList.add('is-invalid');
                    document.getElementById('fecha_fin-error-message').textContent = 'La fecha de fin no puede ser anterior a la de inicio.';
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
                    const firstInvalid = mainForm.querySelector('.is-invalid, #turnos-data-error');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
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
                clearModalInputs();
                currentServiceCosts = { diurno: 0, nocturno: 0, '24 horas': 0 };
                toggleAddEmpleadoBtn();

                const allFormControls = mainForm.querySelectorAll('.form-control, .form-select');
                allFormControls.forEach(el => el.classList.remove('is-invalid'));
                const allInvalidFeedback = mainForm.querySelectorAll('.invalid-feedback');
                allInvalidFeedback.forEach(el => el.style.display = 'none');
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
                                <td>${turno.hora_inicio}</td>
                                <td>${turno.hora_fin}</td>
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

            function calculateTotalCost() {
                let total = 0;
                turnosAsignados.forEach(turno => {
                    total += parseFloat(turno.costo) || 0;
                });
                const totalCostDisplay = document.getElementById('total-costo-display');
                if (totalCostDisplay) {
                    totalCostDisplay.textContent = total.toFixed(2);
                }
            }

            function removeTurnoFromTable(index) {
                turnosAsignados.splice(index, 1);
                renderTurnosTable();
            }

            async function cargarEmpleadosParaModal(servicioId) {
                modalEmpleadoContainer.innerHTML = '<p class="text-muted m-0">Cargando empleados...</p>';
                if (!servicioId) {
                    modalEmpleadoContainer.innerHTML = '<p class="text-muted m-0">Seleccione un servicio en el formulario principal primero</p>';
                    return;
                }
                try {
                    const url = empleadosPorServicioUrl.replace(':id', servicioId);
                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Error al cargar empleados.');
                    const empleados = await response.json();
                    const empleadosAsignadosIds = turnosAsignados.map(t => t.empleado_id);
                    renderEmpleadosCheckboxes(empleados, empleadosAsignadosIds);
                } catch (error) {
                    console.error('Error al cargar empleados:', error);
                    modalEmpleadoContainer.innerHTML = '<p class="text-muted m-0">Error al cargar empleados.</p>';
                }
            }

            function renderEmpleadosCheckboxes(empleados, empleadosAsignadosIds) {
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
                    modalEmpleadoContainer.innerHTML = '<p class="text-muted m-0">No hay empleados disponibles para este servicio.</p>';
                }
            }

            function updateModalBaseCostDisplay() {
                const tipoTurno = modalTipoTurnoSelect.value;
                const costoUnitario = currentServiceCosts[tipoTurno] || 0;
                modalCostoInput.value = parseFloat(costoUnitario).toFixed(2);
            }

            function handleAddTurnoModalClick(e) {
                e.preventDefault();
                if (validateModalInputs()) {
                    agregarTurno();
                }
            }

            function agregarTurno() {
                const selectedEmployeeRadio = modalEmpleadoContainer.querySelector('input[name="modal_empleado_ids"]:checked');
                const empleadoId = parseInt(selectedEmployeeRadio.value);
                const empleadoNombre = selectedEmployeeRadio.labels[0].textContent.replace(/\s*\(ya asignado\)/, '').trim();
                const tipoTurno = modalTipoTurnoSelect.value;
                const horaInicio = modalHoraInicioInput.value;
                const horaFin = modalHoraFinInput.value;
                const inicioAmPm = modalHoraInicioAmPmSelect.value;
                const finAmPm = modalHoraFinAmPmSelect.value;

                let costo = 0;
                const costoBaseTurno = currentServiceCosts[tipoTurno];

                if (costoBaseTurno > 0) {
                    if (tipoTurno === '24 horas') {
                        costo = costoBaseTurno;
                    } else {
                        let [hInicio, mInicio] = horaInicio.split(':').map(Number);
                        let [hFin, mFin] = horaFin.split(':').map(Number);

                        if (inicioAmPm === 'pm' && hInicio < 12) hInicio += 12;
                        if (inicioAmPm === 'am' && hInicio === 12) hInicio = 0;

                        if (finAmPm === 'pm' && hFin < 12) hFin += 12;
                        if (finAmPm === 'am' && hFin === 12) hFin = 0;

                        const totalMinutosInicio = hInicio * 60 + mInicio;
                        let totalMinutosFin = hFin * 60 + mFin;
                        if (totalMinutosFin < totalMinutosInicio) totalMinutosFin += 24 * 60;

                        const duracionHoras = (totalMinutosFin - totalMinutosInicio) / 60;
                        const duracionEstandar = 12;

                        costo = (costoBaseTurno / duracionEstandar) * duracionHoras;
                    }
                }

                const newTurno = {
                    empleado_id: empleadoId,
                    empleado_nombres: [empleadoNombre],
                    tipo_turno: tipoTurno,
                    hora_inicio: `${horaInicio} ${inicioAmPm.toUpperCase()}`,
                    hora_fin: `${horaFin} ${finAmPm.toUpperCase()}`,
                    costo: parseFloat(costo).toFixed(2)
                };

                turnosAsignados.push(newTurno);
                renderTurnosTable();
                asignarTurnoModal.hide();
            }

            function validateModalInputs() {
                let isValid = true;
                clearModalErrors();
                const selectedEmployeeRadio = modalEmpleadoContainer.querySelector('input[name="modal_empleado_ids"]:checked');

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
                }

                if (!modalCostoInput.value || parseFloat(modalCostoInput.value) <= 0) {
                    costoError.style.display = 'block';
                    modalCostoInput.classList.add('is-invalid');
                    isValid = false;
                }

                if (isValid) {
                    const tipoTurno = modalTipoTurnoSelect.value;
                    const inicioValue = modalHoraInicioInput.value;
                    const finValue = modalHoraFinInput.value;
                    const inicioAmPm = modalHoraInicioAmPmSelect.value;
                    const finAmPm = modalHoraFinAmPmSelect.value;

                    let [hInicio, mInicio] = inicioValue.split(':').map(Number);
                    let [hFin, mFin] = finValue.split(':').map(Number);

                    if (inicioAmPm === 'pm' && hInicio < 12) hInicio += 12;
                    if (inicioAmPm === 'am' && hInicio === 12) hInicio = 0;

                    if (finAmPm === 'pm' && hFin < 12) hFin += 12;
                    if (finAmPm === 'am' && hFin === 12) hFin = 0;

                    const totalMinutosInicio = hInicio * 60 + mInicio;
                    const totalMinutosFin = hFin * 60 + mFin;

                    if (totalMinutosFin < totalMinutosInicio && tipoTurno !== 'nocturno') {
                        horaFinError.textContent = 'La hora de fin debe ser posterior a la de inicio.';
                        horaFinError.style.display = 'block';
                        modalHoraFinInput.classList.add('is-invalid');
                        isValid = false;
                    } else if (totalMinutosFin === totalMinutosInicio && tipoTurno !== '24 horas') {
                        horaFinError.textContent = 'La hora de fin no puede ser igual a la de inicio.';
                        horaFinError.style.display = 'block';
                        modalHoraFinInput.classList.add('is-invalid');
                        isValid = false;
                    } else if (tipoTurno === '24 horas' && totalMinutosFin !== totalMinutosInicio) {
                        horaFinError.textContent = 'Para un turno de 24 horas, la hora de fin debe ser igual a la de inicio.';
                        horaFinError.style.display = 'block';
                        modalHoraFinInput.classList.add('is-invalid');
                        isValid = false;
                    }
                }

                return isValid;
            }

            function clearModalInputs() {
                const selectedRadio = modalEmpleadoContainer.querySelector('input[name="modal_empleado_ids"]:checked');
                if (selectedRadio) selectedRadio.checked = false;
                modalTipoTurnoSelect.value = '';
                modalHoraInicioInput.value = '';
                modalHoraFinInput.value = '';
                modalCostoInput.value = '';
                modalHoraInicioAmPmSelect.value = 'am';
                modalHoraFinAmPmSelect.value = 'am';
                clearModalErrors();
            }

            function clearModalErrors() {
                modalErrorMessage.style.display = 'none';
                modalEmpleadoContainer.classList.remove('is-invalid');
                empleadoIdsError.style.display = 'none';
                modalTipoTurnoSelect.classList.remove('is-invalid');
                tipoTurnoError.style.display = 'none';
                modalHoraInicioInput.classList.remove('is-invalid');
                horaInicioError.style.display = 'none';
                modalHoraFinInput.classList.remove('is-invalid');
                horaFinError.style.display = 'none';
                modalCostoInput.classList.remove('is-invalid');
                costoError.style.display = 'none';
            }

            init();
            calculateTotalCost();
        });
    </script>
@endsection
