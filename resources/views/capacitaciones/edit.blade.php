@extends('plantilla')
@section('content')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-light p-5 rounded shadow-lg position-relative">

                    <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                        <i class="bi bi-building" style="font-size: 4rem;"></i>
                    </div>

                    <h3 class="text-center mb-4" style="color: #09457f;">
                        <i class="bi bi-person-plus-fill me-2"></i> Editar una capacitación
                    </h3>

                    {{-- ALERTA DE ÉXITO --}}
                    @if(session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif

                    <form id="form-curso" action="{{ route('capacitaciones.update', $capacitacion->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row g-4">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre de la institución</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-book-fill"></i></span>
                                    <input type="text" name="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre', $capacitacion->nombre) }}"
                                           maxlength="50"
                                           onkeypress="return /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s.,]*$/.test(String.fromCharCode(event.charCode))"
                                           required>
                                    <div class="invalid-feedback">@error('nombre') {{ $message }} @enderror</div>
                                </div>
                            </div>

                            <!-- Correo -->
                            <div class="col-md-6">
                                <label for="correo" class="form-label">Correo de la institución</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" name="correo"
                                           class="form-control @error('correo') is-invalid @enderror"
                                           value="{{ old('correo', $capacitacion->correo) }}"
                                           maxlength="50"
                                           required>
                                    <div class="invalid-feedback">@error('correo') {{ $message }} @enderror</div>
                                </div>
                            </div>

                            <!-- Contacto -->
                            <div class="col-md-6">
                                <label for="contacto" class="form-label">Nombre de contacto</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                    <input type="text" name="contacto"
                                           class="form-control @error('contacto') is-invalid @enderror"
                                           value="{{ old('contacto', $capacitacion->contacto) }}"
                                           maxlength="50"
                                           required>
                                    <div class="invalid-feedback">@error('contacto') {{ $message }} @enderror</div>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" name="telefono"
                                           class="form-control @error('telefono') is-invalid @enderror"
                                           value="{{ old('telefono', $capacitacion->telefono) }}"
                                           maxlength="8"
                                           pattern="[2389][0-9]{7}"
                                           required>
                                    <div class="invalid-feedback">@error('telefono') {{ $message }} @enderror</div>
                                </div>
                            </div>

                            <!-- Modalidad -->
                            <div class="col-md-4">
                                <label for="modalidad" class="form-label">Modalidad</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-laptop"></i></span>
                                    <select name="modalidad" class="form-select @error('modalidad') is-invalid @enderror" required>
                                        <option value="">Seleccione una modalidad</option>
                                        <option value="Presencial" {{ old('modalidad', $capacitacion->modalidad)=='Presencial'?'selected':'' }}>Presencial</option>
                                        <option value="Virtual" {{ old('modalidad', $capacitacion->modalidad)=='Virtual'?'selected':'' }}>Virtual</option>
                                        <option value="Mixta" {{ old('modalidad', $capacitacion->modalidad)=='Mixta'?'selected':'' }}>Mixta</option>
                                    </select>
                                    <div class="invalid-feedback">@error('modalidad') {{ $message }} @enderror</div>
                                </div>
                            </div>

                            <!-- Nivel -->
                            <div class="col-md-4">
                                <label for="nivel" class="form-label">Nivel</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-bar-chart-fill"></i></span>
                                    <select name="nivel" class="form-select @error('nivel') is-invalid @enderror" required>
                                        <option value="">Seleccione un nivel</option>
                                        <option value="Básico" {{ old('nivel', $capacitacion->nivel)=='Básico'?'selected':'' }}>Básico</option>
                                        <option value="Intermedio" {{ old('nivel', $capacitacion->nivel)=='Intermedio'?'selected':'' }}>Intermedio</option>
                                        <option value="Avanzado" {{ old('nivel', $capacitacion->nivel)=='Avanzado'?'selected':'' }}>Avanzado</option>
                                    </select>
                                    <div class="invalid-feedback">@error('nivel') {{ $message }} @enderror</div>
                                </div>
                            </div>

                            <!-- Duración -->
                            <div class="col-md-4">
                                <label for="duracion" class="form-label">Duración (días)</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                                    <input type="number" name="duracion"
                                           class="form-control @error('duracion') is-invalid @enderror"
                                           value="{{ old('duracion', $capacitacion->duracion) }}"
                                           min="1" max="99"
                                           required>
                                    <div class="invalid-feedback">@error('duracion') {{ $message }} @enderror</div>
                                </div>
                            </div>

                            <!-- Fecha de inicio -->
                            <div class="col-md-6">
                                <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-calendar-event-fill"></i></span>
                                    <input type="date" name="fecha_inicio"
                                           class="form-control @error('fecha_inicio') is-invalid @enderror"
                                           value="{{ old('fecha_inicio', $capacitacion->fecha_inicio->format('Y-m-d')) }}"
                                           required>
                                    <div class="invalid-feedback">@error('fecha_inicio') {{ $message }} @enderror</div>
                                </div>
                            </div>

                            <!-- Fecha fin -->
                            <div class="col-md-6">
                                <label for="fecha_fin" class="form-label">Fecha de finalización</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-calendar-check-fill"></i></span>
                                    <input type="date" name="fecha_fin"
                                           class="form-control @error('fecha_fin') is-invalid @enderror"
                                           value="{{ old('fecha_fin', $capacitacion->fecha_fin->format('Y-m-d')) }}"
                                           required>
                                    <div class="invalid-feedback">@error('fecha_fin') {{ $message }} @enderror</div>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-md-6">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" maxlength="250" required>{{ old('descripcion', $capacitacion->descripcion) }}</textarea>
                                    <div class="invalid-feedback">@error('descripcion') {{ $message }} @enderror</div>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="col-md-6">
                                <label for="direccion" class="form-label">Dirección</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                                    <textarea name="direccion" class="form-control @error('direccion') is-invalid @enderror" maxlength="250">{{ old('direccion', $capacitacion->direccion) }}</textarea>
                                    <div class="invalid-feedback">@error('direccion') {{ $message }} @enderror</div>
                                </div>
                            </div>

                        </div>

                        <div class="text-center mt-5 d-flex justify-content-center gap-3">
                            <a href="{{ route('capacitaciones.index') }}" class="btn btn-danger"><i class="bi bi-x-circle me-2"></i> Cancelar</a>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-2"></i> Guardar cambios</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputDuracion = document.querySelector('input[name="duracion"]');
            const inputFechaInicio = document.querySelector('input[name="fecha_inicio"]');
            const inputFechaFin = document.querySelector('input[name="fecha_fin"]');

            // --- FUNCIONES DE CONCORDANCIA ---
            function actualizarFechaFin() {
                const inicio = inputFechaInicio.value;
                const dias = parseInt(inputDuracion.value);

                if (inicio && !isNaN(dias) && dias > 0) {
                    // Calcula fecha_fin visual según inicio + duración
                    const fecha = new Date(inicio + 'T00:00:00');
                    fecha.setDate(fecha.getDate() + (dias - 1));
                    inputFechaFin.value = fecha.toISOString().split('T')[0];

                    // Ajusta mínimo de fecha_fin visualmente
                    inputFechaFin.min = inicio;
                }
            }

            function actualizarDuracion() {
                const inicioStr = inputFechaInicio.value;
                const finStr = inputFechaFin.value;

                if (inicioStr && finStr) {
                    const inicio = new Date(inicioStr + 'T00:00:00');
                    const fin = new Date(finStr + 'T00:00:00');

                    // Calcula diferencia en días + 1
                    const dias = Math.floor((fin - inicio) / (1000 * 60 * 60 * 24)) + 1;
                    inputDuracion.value = dias > 0 ? dias : 1;
                }
            }

            // --- EVENTOS ---
            inputDuracion.addEventListener('input', actualizarFechaFin);
            inputFechaInicio.addEventListener('change', actualizarFechaFin);
            inputFechaFin.addEventListener('change', actualizarDuracion);
        });
    </script>
@endsection
