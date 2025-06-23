@extends('plantilla')
@section('content')


<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Proveedor</title>
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
                    <i class="bi bi-person-plus-fill me-2"></i> Registrar un proveedor
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

                <form action="{{ route('Proveedores.store') }}" method="POST" id="form-proveedor" novalidate>
                    @csrf

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label for="nombreEmpresa" class="form-label">Nombre de la empresa </label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="nombreEmpresa"
                                       class="form-control @error('nombreEmpresa') is-invalid @enderror"
                                       value="{{ old('nombreEmpresa') }}"
                                       maxlength="50"
                                       onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                       required>
                                @error('nombreEmpresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <textarea name="direccion"
                                          class="form-control @error('direccion') is-invalid @enderror"
                                          maxlength="150"
                                          style="resize: none; height: 38px;"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this)">{{ old('direccion') }}</textarea>
                                @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="telefonodeempresa" class="form-label">Teléfono de la empresa</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="text" name="telefonodeempresa"
                                       class="form-control @error('telefonodeempresa') is-invalid @enderror"
                                       value="{{ old('telefonodeempresa') }}"
                                       maxlength="8"
                                       onkeypress="soloNumeros(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       required>
                                @error('telefonodeempresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="correoempresa" class="form-label">Correo Electrónico</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" name="correoempresa"
                                       class="form-control @error('correoempresa') is-invalid @enderror"
                                       value="{{ old('correoempresa') }}"
                                       maxlength="100"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                                @error('correoempresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="nombrerepresentante" class="form-label">Nombre del representante</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="nombrerepresentante"
                                       class="form-control @error('nombrerepresentante') is-invalid @enderror"
                                       value="{{ old('nombrerepresentante') }}"
                                       maxlength="50"
                                       onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                       required>
                                @error('nombrerepresentante')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="identificacion" class="form-label">Identificación</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input type="text" name="identificacion"
                                       class="form-control @error('identificacion') is-invalid @enderror"
                                       value="{{ old('identificacion') }}"
                                       maxlength="13"
                                       onkeypress="soloNumeros(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       required>
                                @error('identificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="categoriarubro" class="form-label">Categoría o rubro</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                <select name="categoriarubro" class="form-select @error('categoriarubro') is-invalid @enderror" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="Cámaras de seguridad" {{ old('categoriarubro') == 'Cámaras de seguridad' ? 'selected' : '' }}>Cámaras de seguridad</option>
                                    <option value="Alarmas antirrobo" {{ old('categoriarubro') == 'Alarmas antirrobo' ? 'selected' : '' }}>Alarmas antirrobo</option>
                                    <option value="Cerraduras inteligentes" {{ old('categoriarubro') == 'Cerraduras inteligentes' ? 'selected' : '' }}>Cerraduras inteligentes</option>
                                    <option value="Sensores de movimiento" {{ old('categoriarubro') == 'Sensores de movimiento' ? 'selected' : '' }}>Sensores de movimiento</option>
                                    <option value="Luces con sensor de movimiento" {{ old('categoriarubro') == 'Luces con sensor de movimiento' ? 'selected' : '' }}>Luces con sensor de movimiento</option>
                                    <option value="Rejas o puertas de seguridad" {{ old('categoriarubro') == 'Rejas o puertas de seguridad' ? 'selected' : '' }}>Rejas o puertas de seguridad</option>
                                    <option value="Sistema de monitoreo 24/7" {{ old('categoriarubro') == 'Sistema de monitoreo 24/7' ? 'selected' : '' }}>Sistema de monitoreo 24/7</option>
                                    <option value="Otros" {{ old('categoriarubro') == 'Otros' ? 'selected' : '' }}>Otros</option>
                                </select>
                                @error('categoriarubro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-5 d-flex justify-content-center gap-3">
                        <!-- Botón Cancelar -->
                        <a href="{{ route('Proveedores.indexProveedor') }}" class="btn btn-danger">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>

                        <!-- Botón Limpiar -->
                        <button type="button" class="btn btn-warning" onclick="limpiarFormulario()">
                            <i class="bi bi-eraser-fill me-2"></i> Limpiar
                        </button>

                        <!-- Botón Guardar -->
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
        input.value = input.value.replace(/[^A-Za-z\s]/g, '');
        if (input.value.length > 50) {
            input.value = input.value.substring(0, 50);
        }


    }

    function validarTelefono(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length > 8) {
            input.value = input.value.substring(0, 8);
        }
        if (input.value.length > 0 && !['2','3', '8', '9'].includes(input.value[0])) {
            input.setCustomValidity("El teléfono debe iniciar con 2, 3, 8 o 9");
        } else {
            input.setCustomValidity("");
        }
    }

    function validarIdentificacion(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length > 13) {
            input.value = input.value.substring(0, 13);
        }
        if (input.value.length >= 2) {
            const inicio = input.value.substring(0, 2);
            if (!/^(0[1-9]|1[0-3])$/.test(inicio)) {
                input.setCustomValidity("La identidad debe iniciar entre 01 y 13");
                return;
            }
        }
        input.setCustomValidity("");
    }

    function validarCorreo(input) {
        if (input.value.length > 100) {
            input.value = input.value.substring(0, 100);
        }
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test(input.value)) {
            input.setCustomValidity("Correo no válido");
        } else {
            input.setCustomValidity("");
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
        const regex = /^[A-Za-z\s]$/;
        if (!regex.test(key) && !['Backspace','Tab','ArrowLeft','ArrowRight','Delete'].includes(key)) {
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

