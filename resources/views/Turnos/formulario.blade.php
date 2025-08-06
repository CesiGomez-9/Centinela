@extends('plantilla')
@section('titulo','Asignación de servicio')
@section('content')

    <style>
        body {
            background-color: #e6f0ff;
            margin: 0;
        }
        .form-label, .form-control, .form-select, .input-group-text, .text-danger, .small, .form-check-label {
            font-size: 0.875rem; /* Tamaño de fuente consistente para todos los elementos */
        }
        h3 {
            font-size: 1.5rem;
        }

        textarea.form-control {
            resize: none;
            overflow: hidden;
            min-height: 38px;
        }
        #empleado-checkbox-container {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.5rem;
            background-color: #fff;
            max-height: 150px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        #empleado-checkbox-container .form-check {
            padding-left: 2.25rem;
            min-height: 1.5rem;
            cursor: pointer;
        }
        #empleado-checkbox-container.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-white p-5 rounded shadow-lg position-relative">

                    <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                        <i class="bi bi-calendar-check" style="font-size: 4rem;"></i>
                    </div>

                    <h3 class="text-center mb-4" style="color: #09457f;">
                        <i class="bi bi-calendar-plus me-2"></i>
                        Asignación de servicio
                    </h3>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('turnos.store') }}" novalidate>
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="cliente_id" class="form-label">Cliente</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-person-check-fill"></i></span>
                                    <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nombre }} {{ $cliente->apellido }}
                                            </option>

                                        @endforeach
                                    </select>
                                    @error('cliente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="servicio_id" class="form-label">Tipo de servicio</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-tools"></i></span>
                                    <select name="servicio_id" id="servicio_id" class="form-select @error('servicio_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un servicio</option>
                                        @foreach($servicios as $servicio)
                                            <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                                {{ $servicio->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('servicio_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Empleado(s) asignado(s) - Ahora con checkboxes --}}
                            <div class="col-md-6">
                                <label for="empleado-checkbox-container" class="form-label">Empleado(s) asignado(s)</label>
                                <div id="empleado-checkbox-container" class="@error('empleado_ids') is-invalid @enderror">
                                    <p class="text-muted m-0">Seleccione un servicio primero</p>
                                </div>
                                <input type="hidden" name="empleado_ids[]" value=""> {{-- Campo oculto para manejar la validación si no se selecciona nada --}}
                                @error('empleado_ids')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                                @error('empleado_ids.*')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Fila 2: Tipo de Turno, Hora inicio, Hora fin --}}
                            <div class="col-md-4">
                                <label for="tipo_turno" class="form-label">Tipo de turno</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                                    <select name="tipo_turno" id="tipo_turno" class="form-select @error('tipo_turno') is-invalid @enderror" required>
                                        <option value="">Seleccione el tipo</option>
                                        <option value="Diurno" {{ old('tipo_turno') == 'Diurno' ? 'selected' : '' }}>Diurno</option>
                                        <option value="Nocturno" {{ old('tipo_turno') == 'Nocturno' ? 'selected' : '' }}>Nocturno</option>
                                        <option value="24 horas" {{ old('tipo_turno') == '24 horas' ? 'selected' : '' }}>24 horas</option>
                                    </select>
                                </div>
                                @error('tipo_turno')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="hora_inicio" class="form-label">Hora inicio</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                    <input type="time" name="hora_inicio" id="hora_inicio" class="form-control @error('hora_inicio') is-invalid @enderror" value="{{ old('hora_inicio') }}" required>
                                </div>
                                @error('hora_inicio')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="hora_fin" class="form-label">Hora fin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
                                    <input type="time" name="hora_fin" id="hora_fin" class="form-control @error('hora_fin') is-invalid @enderror" value="{{ old('hora_fin') }}" required>
                                </div>
                                @error('hora_fin')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Fila 3: Fecha inicio, Fecha fin, Observaciones --}}
                            <div class="col-md-3">
                                <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror" value="{{ old('fecha_inicio') }}" required>
                                </div>
                                @error('fecha_inicio')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="fecha_fin" class="form-label">Fecha fin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
                                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control @error('fecha_fin') is-invalid @enderror" value="{{ old('fecha_fin') }}" required>
                                </div>
                                @error('fecha_fin')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="observaciones" class="form-label">Observaciones o instrucciones especiales</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                                    <textarea name="observaciones" id="observaciones" rows="1" class="form-control @error('observaciones') is-invalid @enderror" maxlength="255">{{ old('observaciones') }}</textarea>
                                </div>
                                @error('observaciones')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <a href="{{ route('turnos.index') }}" class="btn btn-danger me-2">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>

                            <button type="reset" class="btn btn-warning me-2">
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const servicioSelect = document.getElementById('servicio_id');
            const empleadosContainer = document.getElementById('empleado-checkbox-container');
            const observacionesTextarea = document.getElementById('observaciones');
            const resetBtn = document.querySelector('button[type="reset"]');

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

            // Función principal para cargar los empleados como checkboxes
            async function cargarEmpleados(servicioId, oldEmpleados = []) {
                empleadosContainer.innerHTML = '';
                empleadosContainer.classList.remove('is-invalid');

                if (!servicioId) {
                    empleadosContainer.innerHTML = '<p class="text-muted m-0">Seleccione un servicio primero</p>';
                    return;
                }

                try {
                    const response = await fetch(`/turnos/empleados-por-servicio/${servicioId}`);
                    if (!response.ok) {
                        throw new Error('Error en la red o en el servidor');
                    }
                    const empleados = await response.json();

                    if (empleados.length > 0) {
                        empleados.forEach(empleado => {
                            const isChecked = oldEmpleados.includes(empleado.id);
                            const div = document.createElement('div');
                            div.classList.add('form-check');
                            div.innerHTML = `
                                <input class="form-check-input" type="checkbox" name="empleado_ids[]" value="${empleado.id}" id="empleado_${empleado.id}" ${isChecked ? 'checked' : ''}>
                                <label class="form-check-label" for="empleado_${empleado.id}">
                                    ${empleado.nombre} ${empleado.apellido}
                                </label>
                            `;
                            empleadosContainer.appendChild(div);
                        });
                    } else {
                        empleadosContainer.innerHTML = '<p class="text-muted m-0">No hay empleados para este servicio</p>';
                    }
                } catch (error) {
                    console.error('Error al cargar empleados:', error);
                    empleadosContainer.innerHTML = '<p class="text-muted m-0">Error al cargar empleados</p>';
                }
            }

            // Listener para cuando se cambia el servicio
            servicioSelect.addEventListener('change', function () {
                cargarEmpleados(this.value);
            });

            // Lógica de reseteo del formulario
            if (resetBtn) {
                resetBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    if (!form) return;

                    form.querySelectorAll('input:not([type="hidden"]), select, textarea').forEach(el => {
                        if (el.tagName.toLowerCase() === 'input' && el.type !== 'checkbox') {
                            el.value = '';
                        } else if (el.tagName.toLowerCase() === 'select') {
                            el.selectedIndex = 0;
                        } else if (el.tagName.toLowerCase() === 'textarea') {
                            el.value = '';
                            autoResizeTextarea(el);
                        }
                    });

                    // Resetear el contenedor de checkboxes
                    empleadosContainer.innerHTML = '<p class="text-muted m-0">Seleccione un servicio primero</p>';

                    form.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                        el.classList.remove('is-valid', 'is-invalid');
                    });
                });
            }

            // Cargar empleados al cargar la página si ya hay un servicio seleccionado
            const oldServicioId = servicioSelect.value;
            if (oldServicioId) {
                const oldEmpleados = @json(old('empleado_ids', []));
                cargarEmpleados(oldServicioId, oldEmpleados);
            }
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
