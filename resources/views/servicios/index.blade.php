<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Servicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f0ff;
            font-size: 1.1rem;
        }
        .form-contenedor {
            max-width: 1000px;
            margin: auto;
            background-color: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('seguridad/GrupoCentinela.jpg') }}" style="height:80px; margin-right: 10px;">
            Grupo Centinela
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="#">Registrate</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Servicios</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Nosotros</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="form-contenedor">
        <h2 class="text-center mb-4 text-primary fs-3">
            <i class="bi bi-journal-plus me-2"></i> Registrar un nuevo servicio
        </h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <form id="servicioForm" action="{{ route('servicios.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="nombreServicio" class="form-label fs-5">Nombre del servicio</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                        <input type="text" id="nombreServicio" name="nombreServicio" class="form-control form-control-lg" maxlength="30"
                               pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo letras y espacios, máximo 30 caracteres"
                               onkeydown="bloquearEspacioAlInicio(event, this)"
                               oninput="eliminarEspaciosIniciales(this)"
                               oninput="this.value = this.value.replace(/[^A-Za-z\s]/g,'')" required>
                        <div class="invalid-feedback">Por favor, ingrese información aquí.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="tipoServicio" class="form-label fs-5">Tipo de servicio</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                        <input type="text" id="tipoServicio" name="tipoServicio" class="form-control form-control-lg" maxlength="30"
                               pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo letras y espacios, máximo 30 caracteres"
                               onkeydown="bloquearEspacioAlInicio(event, this)"
                               oninput="eliminarEspaciosIniciales(this)"
                               oninput="this.value = this.value.replace(/[^A-Za-z\s]/g,'')" required>
                        <div class="invalid-feedback">Por favor, ingresa información aquí.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="descripcionServicio" class="form-label fs-5">Descripción del servicio</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-text-paragraph"></i></span>
                        <textarea id="descripcionServicio" name="descripcionServicio" class="form-control form-control-lg" maxlength="100"
                                  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" rows="3" title="Solo letras y espacios, máximo 100 caracteres"
                                  onkeydown="bloquearEspacioAlInicio(event, this)"
                                  oninput="eliminarEspaciosIniciales(this)"
                                  oninput="this.value = this.value.replace(/[^A-Za-z\s]/g,'')" required></textarea>
                        <div class="invalid-feedback">Por favor, ingresa información aquí.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="duracionEstimada" class="form-label fs-5">Duración estimada</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
                        <input type="text" id="duracionEstimada" name="duracionEstimada" class="form-control form-control-lg" maxlength="30"
                               pattern="^[A-Za-z0-9\s]+$" title="Solo letras, números y espacios, máximo 30 caracteres"
                               onkeydown="bloquearEspacioAlInicio(event, this)"
                               oninput="eliminarEspaciosIniciales(this)"
                               oninput="this.value = this.value.replace(/[^A-Za-z\s]/g,'')" required>
                        <div class="invalid-feedback">Por favor, ingresa información aquí.</div>
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="form-label fs-5">¿Requiere productos específicos?</label>
                    <div class="form-check form-check-inline fs-5">
                        <input class="form-check-input" type="radio" name="requiereProductos" id="requiereSi" value="sí" required>
                        <label class="form-check-label" for="requiereSi">Sí</label>
                    </div>
                    <div class="form-check form-check-inline fs-5">
                        <input class="form-check-input" type="radio" name="requiereProductos" id="requiereNo" value="no" required>
                        <label class="form-check-label" for="requiereNo">No</label>
                    </div>
                    <div id="radioFeedback" class="invalid-feedback" style="display: none; margin-top: 0.3rem;">
                        Por favor, selecciona una opción.
                    </div>
                </div>

                <div class="col-md-12 d-none" id="especificarProductosDiv">
                    <label for="especificarProductos" class="form-label fs-5">Especificar productos</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                        <textarea id="especificarProductos" name="especificarProductos" class="form-control form-control-lg"
                                  maxlength="100"
                                  pattern="^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ,\\s]+$"
                                  onkeydown="bloquearEspacioAlInicio(event, this)"
                                  oninput="eliminarEspaciosIniciales(this)"
                                  oninput="this.value = this.value.replace(/[^A-Za-z\s]/g,'')"
                                  rows="2"
                                  title="Solo letras, números, espacios y comas, máximo 100 caracteres"></textarea>
                        <div class="invalid-feedback">Por favor, ingresa información válida aquí.</div>
                    </div>
                </div>


                <div class="text-center mt-5">
                    <a href="{{ route('servicios.catalogo') }}" class="btn btn-danger me-2"
                       onclick="return confirm('¿Estás seguro que deseas cancelar? Se perderán los cambios no guardados.');">
                        <i class="bi bi-x-circle me-2"></i> Cancelar
                    </a>

                    <button type="reset" class="btn btn-warning me-2">
                        <i class="bi bi-eraser-fill me-2"></i> Limpiar
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save-fill me-2"></i> Guardar

                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Mostrar/ocultar campo de productos
    document.querySelectorAll('input[name="requiereProductos"]').forEach(radio => {
        radio.addEventListener('change', () => {
            const especificarDiv = document.getElementById('especificarProductosDiv');
            const especificarInput = document.getElementById('especificarProductos');

            if (document.getElementById('requiereSi').checked) {
                especificarDiv.classList.remove('d-none');
                especificarInput.setAttribute('required', 'required');
            } else {
                especificarDiv.classList.add('d-none');
                especificarInput.value = '';
                especificarInput.removeAttribute('required');
            }
        });
    });

    // Validaciones personalizadas en input (para evitar caracteres no deseados)
    function validarInput(e, pattern, maxLength) {
        const input = e.target;
        let valor = input.value;
        let regex = new RegExp(pattern, 'g');
        let soloPermitidos = valor.match(regex);
        valor = soloPermitidos ? soloPermitidos.join('') : '';
        if (valor.length > maxLength) valor = valor.substring(0, maxLength);
        input.value = valor;
    }

    document.getElementById('nombreServicio').addEventListener('input', e => {
        // Aquí limite a 50 caracteres permitiendo letras y espacios
        validarInput(e, '[A-Za-zÁÉÍÓÚáéíóúÑñ\\s]', 50);
    });

    document.getElementById('descripcionServicio').addEventListener('input', e => {
        validarInput(e, '[A-Za-zÁÉÍÓÚáéíóúÑñ\\s]', 100);
    });

    document.getElementById('tipoServicio').addEventListener('input', e => {
        validarInput(e, '[A-Za-zÁÉÍÓÚáéíóúÑñ\\s]', 30);
    });

    document.getElementById('duracionEstimada').addEventListener('input', e => {
        validarInput(e, '[A-Za-z0-9\\s]', 30);
    });

    // Aquí el cambio: se permite la coma además de letras, números y espacios
    document.getElementById('especificarProductos').addEventListener('input', e => {
        validarInput(e, '[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ,\\s]', 100);
    });
    function bloquearEspacioAlInicio(e, input) {
        if (e.key === ' ' && input.selectionStart === 0) {
            e.preventDefault();
        }
    }

    function eliminarEspaciosIniciales(input) {
        input.value = input.value.replace(/^\s+/,'');
    }

    // Validación Bootstrap + radios personalizados
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                // Validar radios (requiere productos)
                const radios = form.querySelectorAll('input[name="requiereProductos"]');
                const radioChecked = Array.from(radios).some(radio => radio.checked);
                const radioFeedback = document.getElementById('radioFeedback');
                if (!radioChecked) {
                    radioFeedback.style.display = 'block';
                } else {
                    radioFeedback.style.display = 'none';
                }

                if (!form.checkValidity() || !radioChecked) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
