@extends('plantilla')
@section('content')

    <!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Capacitaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { background-color: #e6f0ff; height: 100vh; margin: 0; }
        .form-wrapper { min-height: 100vh; display: flex; justify-content: center; align-items: center; }
        .form-box { background-color: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); width: 100%; max-width: 500px; }
        .invalid-tooltip { background-color: transparent !important; border: 1px solid #dc3545 !important; color: #dc3545 !important; box-shadow: none !important; padding: 0.5rem 1rem !important; font-size: 0.9rem !important; top: 100% !important; margin-top: 0.25rem !important; z-index: 10 !important; white-space: normal !important; }
    </style>
</head>
<body>

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

                <form id="form-curso" action="{{ route('capacitaciones.update', $capacitacion->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre de la institución</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-book-fill"></i></span>
                                <input type="text" name="nombre"
                                       class="form-control"
                                       value="{{ old('nombre', $capacitacion->nombre) }}"
                                       maxlength="50"
                                       onkeypress="return /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s.,]*$/.test(String.fromCharCode(event.charCode))"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                            </div>
                            <div class="invalid-feedback"></div>
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
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                            </div>
                            <div class="invalid-feedback">@error('correo') {{ $message }} @enderror</div>
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
                                       onkeypress="return /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]*$/.test(String.fromCharCode(event.charCode))"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                            </div>
                            <div class="invalid-feedback">@error('contacto') {{ $message }} @enderror</div>
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
                                       inputmode="numeric"
                                       pattern="[0-9]*"
                                       onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       required>
                            </div>
                            <div class="invalid-feedback">@error('telefono') {{ $message }} @enderror</div>
                        </div>

                        <!-- Modalidad -->
                        <div class="col-md-4">
                            <label for="modalidad" class="form-label">Modalidad</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-laptop"></i></span>
                                <select name="modalidad" id="modalidad" class="form-select @error('modalidad') is-invalid @enderror" required>
                                    <option value="">Seleccione una modalidad</option>
                                    <option value="Presencial" {{ old('modalidad', $capacitacion->modalidad) == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                    <option value="Virtual" {{ old('modalidad', $capacitacion->modalidad) == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                                    <option value="Mixta" {{ old('modalidad', $capacitacion->modalidad) == 'Mixta' ? 'selected' : '' }}>Mixta</option>
                                </select>
                            </div>
                            <div class="invalid-feedback">@error('modalidad') {{ $message }} @enderror</div>
                        </div>

                        <!-- Nivel -->
                        <div class="col-md-4">
                            <label for="nivel" class="form-label">Nivel</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-bar-chart-fill"></i></span>
                                <select name="nivel" class="form-select @error('nivel') is-invalid @enderror" required>
                                    <option value="">Seleccione un nivel</option>
                                    <option value="Básico" {{ old('nivel', $capacitacion->nivel) == 'Básico' ? 'selected' : '' }}>Básico</option>
                                    <option value="Intermedio" {{ old('nivel', $capacitacion->nivel) == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                                    <option value="Avanzado" {{ old('nivel', $capacitacion->nivel) == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                                </select>
                            </div>
                            <div class="invalid-feedback">@error('nivel') {{ $message }} @enderror</div>
                        </div>

                        <!-- Duración -->
                        <!-- Duración -->
                        <div class="col-md-4">
                            <label for="duracion" class="form-label">Duración (días)</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                                <input type="number" name="duracion"
                                       class="form-control @error('duracion') is-invalid @enderror"
                                       value="{{ old('duracion', $capacitacion->duracion) }}"
                                       min="1" max="99"
                                       oninput="if(this.value.length>2)this.value=this.value.slice(0,2); if(this.value<1)this.value='';"
                                       required>
                            </div>
                            <div class="invalid-feedback">@error('duracion') {{ $message }} @enderror</div>
                        </div>


                        <!-- Fecha inicio -->
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-calendar-event-fill"></i></span>
                                <input type="date" name="fecha_inicio"
                                       class="form-control @error('fecha_inicio') is-invalid @enderror"
                                       value="{{ old('fecha_inicio', $capacitacion->fecha_inicio->format('Y-m-d')) }}"
                                       min="{{ now()->format('Y-m-d') }}"
                                       max="{{ now()->addMonths(2)->format('Y-m-d') }}"
                                       required>
                            </div>
                            <div class="invalid-feedback">@error('fecha_inicio') {{ $message }} @enderror</div>
                        </div>

                        <!-- Fecha fin -->
                        <div class="col-md-6">
                            <label for="fecha_fin" class="form-label">Fecha de finalización</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-calendar-check-fill"></i></span>
                                <input type="date" name="fecha_fin"
                                       class="form-control @error('fecha_fin') is-invalid @enderror"
                                       value="{{ old('fecha_fin', $capacitacion->fecha_fin->format('Y-m-d')) }}"
                                       min="{{ now()->format('Y-m-d') }}"
                                       max="{{ now()->addMonths(2)->format('Y-m-d') }}"
                                       required>
                            </div>
                            <div class="invalid-feedback">@error('fecha_fin') {{ $message }} @enderror</div>
                        </div>

                        <!-- Descripción -->
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <textarea name="descripcion"
                                          class="form-control auto-expand @error('descripcion') is-invalid @enderror"
                                          maxlength="250"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this)"
                                          required
                                          style="overflow:hidden; min-height:80px; resize:none;">{{ old('descripcion', $capacitacion->descripcion) }}</textarea>
                            </div>
                            <div class="invalid-feedback">@error('descripcion') {{ $message }} @enderror</div>
                        </div>

                        <!-- Dirección -->
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                                <textarea name="direccion"
                                          id="direccion"
                                          class="form-control auto-expand @error('direccion') is-invalid @enderror"
                                          maxlength="250"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this)"
                                          style="overflow:hidden; min-height:80px; resize:none;">{{ old('direccion', $capacitacion->direccion) }}</textarea>
                            </div>
                            <div class="invalid-feedback">@error('direccion') {{ $message }} @enderror</div>
                        </div>

                    </div>

                    <div class="text-center mt-5 d-flex justify-content-center gap-3">
                        <a href="{{ route('capacitaciones.index') }}" class="btn btn-danger"><i class="bi bi-x-circle me-2"></i> Cancelar</a>
                        <button type="button" class="btn btn-warning" id="btnRestablecer"><i class="bi bi-eraser-fill me-2"></i> Restablecer</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-2"></i> Guardar cambios</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("form-curso");
        const restablecerBtn = document.getElementById("btnRestablecer");

        const valoresOriginales = {
            nombre: @json($capacitacion->nombre),
            correo: @json($capacitacion->correo),
            contacto: @json($capacitacion->contacto),
            telefono: @json($capacitacion->telefono),
            modalidad: @json($capacitacion->modalidad),
            nivel: @json($capacitacion->nivel),
            duracion: @json($capacitacion->duracion),
            fecha_inicio: @json($capacitacion->fecha_inicio->format('Y-m-d')),
            fecha_fin: @json($capacitacion->fecha_fin->format('Y-m-d')),
            descripcion: @json($capacitacion->descripcion),
            direccion: @json($capacitacion->direccion),
        };

        const mensajes = {
            nombre: "Por favor ingresa el nombre de la institución (solo letras, números, comas y puntos).",
            correo: "Por favor ingresa un correo válido.",
            contacto: "Por favor ingresa el nombre de la persona de contacto (solo letras).",
            telefono: "Debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.",
            modalidad: "Seleccione una modalidad.",
            nivel: "Seleccione un nivel.",
            duracion: "Duración obligatoria (1-99 días).",
            fecha_inicio: "Seleccione la fecha de inicio (solo hoy hasta 2 meses).",
            fecha_fin: "Seleccione la fecha de fin (no antes de la fecha de inicio, máximo 2 meses).",
            descripcion: "Por favor ingresa una descripción.",
            direccion: "Por favor ingresa la dirección."
        };

        function mostrarError(campo, mensaje) {
            campo.classList.add("is-invalid");
            const feedback = campo.closest(".input-group")?.nextElementSibling;
            if (feedback && feedback.classList.contains("invalid-feedback")) {
                feedback.textContent = mensaje;
                feedback.style.display = "block";
            }
        }

        function limpiarError(campo) {
            campo.classList.remove("is-invalid");
            const feedback = campo.closest(".input-group")?.nextElementSibling;
            if (feedback && feedback.classList.contains("invalid-feedback")) {
                feedback.textContent = "";
                feedback.style.display = "none";
            }
        }

        function ajustarAltura(textarea) {
            textarea.style.height = "auto";
            textarea.style.height = textarea.scrollHeight + "px";
        }

        form.querySelectorAll("textarea").forEach(t => { ajustarAltura(t); t.addEventListener("input", ()=>ajustarAltura(t)); });
        form.querySelectorAll("input, textarea, select").forEach(el => {
            el.addEventListener("input", ()=>limpiarError(el));
            el.addEventListener("change", ()=>limpiarError(el));
        });

        // --- Dirección obligatoria según modalidad ---
        const modalidad = document.getElementById("modalidad");
        const direccion = document.getElementById("direccion");

        function actualizarRequeridoDireccion() {
            if (modalidad.value === "Virtual") {
                direccion.removeAttribute("required");
                limpiarError(direccion);
            } else {
                direccion.setAttribute("required", "required");
            }
        }

        modalidad.addEventListener("change", actualizarRequeridoDireccion);
        actualizarRequeridoDireccion();

        form.addEventListener("submit", function(e) {
            let valido = true;

            form.querySelectorAll("input[required], textarea[required], select[required]").forEach(el => {
                if(el.name === "direccion" && modalidad.value === "Virtual") return;
                if(!el.value.trim()){ mostrarError(el, mensajes[el.name]); valido=false; }
            });

            // Validación teléfono
            const telefono = form.querySelector('input[name="telefono"]');
            if (!/^[2389]\d{7}$/.test(telefono.value)) { mostrarError(telefono, mensajes.telefono); valido=false; }

            const duracion = form.querySelector('input[name="duracion"]');
            if (duracion.value < 1 || duracion.value > 99) {
                mostrarError(duracion, mensajes.duracion);
                valido = false;
            }

            // Validación fechas
            const fiDate = new Date(fi.value);
            const ffDate = new Date(ff.value);

// Crear fechas sin hora para comparación
            const hoyDate = new Date();
            hoyDate.setHours(0,0,0,0);

            const maxFecha = new Date();
            maxFecha.setMonth(hoyDate.getMonth()+2);
            maxFecha.setHours(0,0,0,0);

            if(fiDate < hoyDate){ mostrarError(fi,mensajes.fecha_inicio); valido=false; }
            if(fiDate > maxFecha){ mostrarError(fi,mensajes.fecha_inicio); valido=false; }
            if(ffDate < fiDate){ mostrarError(ff,"La fecha final no puede ser anterior a la fecha de inicio."); valido=false; }
            if(ffDate > maxFecha){ mostrarError(ff,mensajes.fecha_fin); valido=false; }

            // Validación extra del correo
            const correo = form.querySelector('input[name="correo"]');
            if(correo.value && !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(correo.value)) {
                mostrarError(correo, "Debe ingresar un correo válido");
                valido = false;
            }

            if(!valido) e.preventDefault();
        });

        restablecerBtn.addEventListener("click", function(e){
            e.preventDefault();
            form.querySelectorAll("input, textarea, select").forEach(el=>{
                if(valoresOriginales.hasOwnProperty(el.name)) el.value = valoresOriginales[el.name];
                limpiarError(el);
                if(el.tagName==="TEXTAREA") ajustarAltura(el);
            });
            actualizarRequeridoDireccion();
        });

    });
</script>

</body>
</html>

@endsection
