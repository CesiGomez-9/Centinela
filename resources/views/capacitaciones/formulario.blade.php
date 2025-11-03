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
        body {
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }
        .form-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-box {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
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
                    <i class="bi bi-person-plus-fill me-2"></i> Registrar una capacitación
                </h3>

                <style>
                    .invalid-tooltip {
                        background-color: transparent !important;
                        border: 1px solid #dc3545 !important;
                        color: #dc3545 !important;
                        box-shadow: none !important;
                        padding: 0.5rem 1rem !important;
                        font-size: 0.9rem !important;
                        top: 100% !important;
                        margin-top: 0.25rem !important;
                        z-index: 10 !important;
                        white-space: normal !important;
                    }
                </style>

                <form action="{{ route('capacitaciones.store') }}"  method="POST" id="form-curso" novalidate>
                    @csrf

                    <div class="row g-4">

                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre de la institución</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-book-fill"></i></span>
                                <input type="text" name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre') }}"
                                       maxlength="100"
                                       onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                                @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo de la institución</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" name="correo"
                                       class="form-control @error('correo') is-invalid @enderror"
                                       value="{{ old('correo') }}"
                                       maxlength="50"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                                @error('correo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- contacto -->
                        <div class="col-md-6">
                            <label for="contacto" class="form-label">Contacto</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                <input type="text" name="contacto"
                                       class="form-control @error('contacto') is-invalid @enderror"
                                       value="{{ old('contacto') }}"
                                       maxlength="100"
                                       onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                                @error('contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <!-- telefono de la institucion -->
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                <input type="text" name="telefono"
                                       class="form-control @error('telefono') is-invalid @enderror"
                                       value="{{ old('telefono') }}"
                                       maxlength="20"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                                @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Modalidad -->
                        <div class="col-md-6">
                            <label for="modalidad" class="form-label">Modalidad</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-laptop"></i></span>
                                <select name="modalidad" class="form-select @error('modalidad') is-invalid @enderror" required>
                                    <option value="">Seleccione una modalidad</option>
                                    <option value="Presencial" {{ old('modalidad') == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                    <option value="Virtual" {{ old('modalidad') == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                                    <option value="Mixta" {{ old('modalidad') == 'Mixta' ? 'selected' : '' }}>Mixta</option>
                                </select>
                                @error('modalidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nivel -->
                        <div class="col-md-6">
                            <label for="nivel" class="form-label">Nivel</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-bar-chart-fill"></i></span>
                                <select name="nivel" class="form-select @error('nivel') is-invalid @enderror" required>
                                    <option value="">Seleccione un nivel</option>
                                    <option value="Básico" {{ old('nivel') == 'Básico' ? 'selected' : '' }}>Básico</option>
                                    <option value="Intermedio" {{ old('nivel') == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                                    <option value="Avanzado" {{ old('nivel') == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                                </select>
                                @error('nivel')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Duración -->
                        <div class="col-md-6">
                            <label for="duracion" class="form-label">Duración (días)</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                                <input type="number" name="duracion"
                                       class="form-control @error('duracion') is-invalid @enderror"
                                       value="{{ old('duracion') }}"
                                       min="1" max="1000"
                                       onkeypress="soloNumeros(event)"
                                       required>
                                @error('duracion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                        </div>


                        <!-- Fecha de inicio -->
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-calendar-event-fill"></i></span>
                                <input type="date" name="fecha_inicio"
                                       class="form-control @error('fecha_inicio') is-invalid @enderror"
                                       value="{{ old('fecha_inicio') }}"
                                       required>
                                @error('fecha_inicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fecha de fin -->
                        <div class="col-md-6">
                            <label for="fecha_fin" class="form-label">Fecha de finalización</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-calendar-check-fill"></i></span>
                                <input type="date" name="fecha_fin"
                                       class="form-control @error('fecha_fin') is-invalid @enderror"
                                       value="{{ old('fecha_fin') }}"
                                       required>
                                @error('fecha_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>




                        <!-- Descripción -->
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <textarea name="descripcion"
                                          class="form-control @error('descripcion') is-invalid @enderror"
                                          maxlength="300"
                                          style="height: 100px; resize: none;"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this)"
                                          required>{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Temario -->
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                                <textarea name="direccion"
                                          class="form-control @error('direccion') is-invalid @enderror"
                                          maxlength="500"
                                          style="height: 100px; resize: none;"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this)"
                                          required>{{ old('direccion') }}</textarea>
                                @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


        </div>














        <div class="text-center mt-5 d-flex justify-content-center gap-3">


                        <button type="button" class="btn btn-warning" onclick="limpiarFormulario()">
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

<!-- Boton Limpiar -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const resetBtn = document.querySelector('button[type="reset"]');

        if (resetBtn) {
            resetBtn.addEventListener('click', function (e) {
                e.preventDefault();

                const form = this.closest('form');
                if (!form) return;

                // Limpiar manualmente cada campo
                form.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(el => {
                    el.value = '';
                });

                form.querySelectorAll('select').forEach(el => {
                    el.selectedIndex = 0;
                });

                // Remover clases de validación
                form.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                    el.classList.remove('is-valid', 'is-invalid');
                });

                // Limpiar mensajes de error si hay
                form.querySelectorAll('.text-danger').forEach(el => {
                    el.innerText = '';
                });
            });
        }
    });
</script>

<script>
    function validarSoloLetras(input) {
        input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
        if (input.value.length > 50) {
            input.value = input.value.substring(0, 50);
        }



    }






    document.addEventListener("DOMContentLoaded", function(){
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('.is-invalid'));
        tooltipTriggerList.forEach(function (element) {
            new bootstrap.Tooltip(element, { placement: 'right' });
        });
    });

    function soloLetras(e) {
        const key = e.key;
        const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]$/;
        if (!regex.test(key) && !['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'].includes(key)) {
            e.preventDefault();
        }



    }

    function soloNumeros(e) {
        const key = e.key;
        if (!/^[0-9]$/.test(key) && !['Backspace','Tab','ArrowLeft','ArrowRight','Delete'].includes(key)) {
            e.preventDefault();
        }
    }

    function bloquearEspacioAlInicio(e, input) {
        if (e.key === ' ' && input.selectionStart === 0) {
            e.preventDefault();
        }
    }

    function eliminarEspaciosIniciales(input) {
        input.value = input.value.replace(/^\s+/, '');
    }

    function limpiarFormulario() {
        const formulario = document.getElementById("form-proveedor");

        // Limpiar campos manualmente
        const elementos = formulario.querySelectorAll("input, textarea, select");
        elementos.forEach(elemento => {
            if (elemento.type === "checkbox" || elemento.type === "radio") {
                elemento.checked = false;
            } else {
                elemento.value = "";
            }
        });

        // Quitar clases de error
        const inputsInvalidos = formulario.querySelectorAll('.form-control.is-invalid');
        inputsInvalidos.forEach(input => {
            input.classList.remove('is-invalid');
        });

        // Borrar los mensajes de error
        const mensajesError = formulario.querySelectorAll('.invalid-feedback');
        mensajesError.forEach(msg => {
            msg.textContent = '';
        });




    }



</script>











<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

@endsection
