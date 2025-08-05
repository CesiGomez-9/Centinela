<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de Instalaciones</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
    <style>
        body {
            padding: 2rem;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4">Registrar Instalación</h2>

    <form method="POST" action="{{ route('instalaciones.index') }}">
        @csrf
        <div class="row g-4">
            <!-- Cliente -->
            <div class="col-md-6">
                <label for="cliente_id" class="form-label">Cliente</label>
                <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('cliente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif


            <!-- Técnico -->
            <div class="col-md-6">
                <label for="empleado_id" class="form-label">Técnico</label>
                <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-person-gear"></i></span>
                    <select name="empleado_id" id="empleado_id" class="form-select @error('empleado_id') is-invalid @enderror" required>
                        <option value="">Seleccione un técnico</option>
                        @foreach($tecnicos as $tecnico)
                            <option value="{{ $tecnico->id }}" {{ old('empleado_id') == $tecnico->id ? 'selected' : '' }}>
                                {{ $tecnico->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('empleado_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Servicio -->
            <div class="col-md-6">
                <label for="servicio_id" class="form-label">Servicio</label>
                <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-list-task"></i></span>
                    <select name="servicio_id" id="servicio_id" class="form-select @error('servicio_id') is-invalid @enderror" required>
                        <option value="">Seleccione un servicio</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                {{ $servicio->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('servicio_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Fecha -->
            <div class="col-md-6">
                <label for="fecha_instalacion" class="form-label">Fecha de instalación</label>
                <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                    <input type="date" name="fecha_instalacion" class="form-control @error('fecha_instalacion') is-invalid @enderror"
                           value="{{ old('fecha_instalacion', now()->format('Y-m-d')) }}" min="2025-07-01" max="2025-08-31" required>
                    @error('fecha_instalacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Estado -->
            <div class="col-md-6">
                <label for="estado" class="form-label">Estado</label>
                <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                    <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                        <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="terminado" {{ old('estado') == 'terminado' ? 'selected' : '' }}>Terminado</option>
                    </select>
                    @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Descripción -->
            <div class="col-md-6">
                <label for="descripcion" class="form-label">Descripción</label>
                <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                    <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="2" required>{{ old('descripcion') }}</textarea>
                    @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Dirección -->
            <div class="col-md-6">
                <label for="direccion" class="form-label">Dirección</label>
                <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                    <textarea name="direccion" class="form-control @error('direccion') is-invalid @enderror" rows="2" required>{{ old('direccion') }}</textarea>
                    @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar Instalación</button>
            </div>
        </div>
    </form>

    <hr class="my-5">

    <h2 class="mb-3">Calendario de Instalaciones</h2>
    <div id="calendar"></div>
</div>

<!-- Modal Detalles -->
<div class="modal fade" id="detalleEventoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de Instalación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Cliente:</strong> <span id="modalCliente"></span></p>
                <p><strong>Técnico:</strong> <span id="modalTecnico"></span></p>
                <p><strong>Servicio:</strong> <span id="modalServicio"></span></p>
                <p><strong>Fecha:</strong> <span id="modalFecha"></span></p>
                <p><strong>Estado:</strong> <span id="modalEstado"></span></p>
                <p><strong>Descripción:</strong> <span id="modalDescripcion"></span></p>
                <p><strong>Dirección:</strong> <span id="modalDireccion"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales/es.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            locale: 'es',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '/eventos', // Ruta que devuelve JSON desde el backend
            eventClick: function(info) {
                const event = info.event;

                document.getElementById('modalCliente').innerText = event.extendedProps.cliente;
                document.getElementById('modalTecnico').innerText = event.extendedProps.tecnico;
                document.getElementById('modalServicio').innerText = event.extendedProps.servicio;
                document.getElementById('modalFecha').innerText = event.start.toLocaleDateString();
                document.getElementById('modalEstado').innerText = event.extendedProps.estado;
                document.getElementById('modalDescripcion').innerText = event.extendedProps.descripcion;
                document.getElementById('modalDireccion').innerText = event.extendedProps.direccion;

                new bootstrap.Modal(document.getElementById('detalleEventoModal')).show();
            }
        });

        calendar.render();
    });
</script>
</body>
</html>
