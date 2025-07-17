<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar Servicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
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
        /* Quitar icono check de validación en inputs, selects y textareas */
        .was-validated .form-control:valid,
        .was-validated .form-select:valid,
        .was-validated textarea:valid {
            background-image: none !important;
            box-shadow: none !important;
        }



    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('seguridad/GrupoCentinela.jpg') }}" style="height:80px; margin-right: 10px;" />
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
                        <input type="text" id="nombreServicio" name="nombreServicio" class="form-control form-control-lg"
                               maxlength="50" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                               title="Solo letras, máximo 50 caracteres"
                               onkeydown="bloquearEspacioAlInicio(event, this)"
                               oninput="eliminarEspaciosIniciales(this)" required />
                        <div class="invalid-feedback">Ingrese un nombre válido (solo letras).</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="descripcionServicio" class="form-label fs-5">Descripción</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-textarea-t"></i></span>
                        <textarea id="descripcionServicio" name="descripcionServicio" class="form-control form-control-lg"
                                  maxlength="125" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                                  onkeydown="bloquearEspacioAlInicio(event, this)"
                                  oninput="eliminarEspaciosIniciales(this); autoExpand(this);"
                                  title="Solo letras, máximo 125 caracteres"
                                  rows="1" required
                                  style="overflow:hidden; resize:none;"></textarea>
                        <div class="invalid-feedback">Ingrese una descripción válida.</div>
                    </div>
                </div>
                s



                <div class="col-md-6">
                    <label for="costo" class="form-label fs-5">Costo estimado (L)</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                        <input type="text" class="form-control form-control-lg" id="costo" name="costo"
                               pattern="^[1-9][0-9]{0,3}$"
                               maxlength="4"
                               title="Solo números, hasta 4 cifras, no iniciar con cero" required />
                        <div class="invalid-feedback">Ingrese un costo válido.</div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <label class="form-label fs-5">Duración estimada</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                        <input type="number" class="form-control form-control-lg" id="duracionCantidad" name="duracion_cantidad"
                               min="1" max="99" placeholder="Cantidad" required />
                        <select class="form-select form-select-lg" id="duracionTipo" name="duracion_tipo" required>
                            <option value="">Unidad</option>
                            <option value="horas">Horas</option>
                            <option value="dias">Días</option>
                            <option value="meses">Meses</option>
                            <option value="años">Años</option>
                        </select>
                        <div class="invalid-feedback">Ingrese una duración válida.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="categoria" class="form-label fs-5">Categoría</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-ui-checks"></i></span>
                        <select class="form-select form-select-lg" id="categoria" name="categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="vigilancia">Vigilancia</option>
                            <option value="tecnico">Técnico</option>
                        </select>
                        <div class="invalid-feedback">Seleccione una categoría.</div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label class="form-label fs-5">Productos requeridos</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                        <select class="form-select form-select-lg" id="productosCategoria" name="productos_categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="vigilancia">Vigilancia</option>
                            <option value="tecnico">Técnico</option>
                        </select>
                        <div class="invalid-feedback">Seleccione una categoría de productos.</div>
                    </div>
                </div>

                <!-- Productos de vigilancia -->
                <div class="col-md-12 d-none" id="productos_vigilancia">
                    <label class="form-label fs-5">Productos de vigilancia</label>
                    <div class="row">
                        @foreach(['Cinturón táctico', 'Radio de comunicación (walkie-talkie)', 'Linterna', 'Cuaderno o libreta de bitácora', 'Bolígrafo o lápiz', 'Silbato', 'Toner o bastón', 'Esposas', 'Chaleco antibalas', 'Botas reforzadas'] as $producto)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="productos_vigilancia[]" value="{{ $producto }}" id="vig_{{ Str::slug($producto, '_') }}">
                                    <label class="form-check-label" for="vig_{{ Str::slug($producto, '_') }}">
                                        {{ $producto }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <!-- Técnico productos -->
                <!-- Productos técnicos -->
                <div class="col-md-12 d-none" id="productos_tecnico">
                    <label class="form-label fs-5">Productos técnicos</label>
                    <div class="row">
                        @foreach([
                            'Cámara IP Full HD', 'Cámara Bullet 4K', 'Cámara domo PTZ', 'Cámara térmica portátil', 'Cámara con visión nocturna',
                            'Alarma inalámbrica', 'Alarma con sirena', 'Alarma de puerta y ventana', 'Sistema de alarma GSM', 'Alarma con detector de humo',
                            'Cerradura biométrica', 'Cerradura con teclado', 'Cerradura Bluetooth', 'Cerradura con control remoto', 'Cerradura electrónica para puertas',
                            'Sensor PIR inalámbrico', 'Sensor de movimiento con cámara', 'Sensor de movimiento para interiores', 'Sensor de movimiento con alarma', 'Sensor doble tecnología',
                            'Luz LED con sensor', 'Luz solar con sensor', 'Foco exterior con sensor', 'Luz para jardín con sensor', 'Lámpara de seguridad con sensor',
                            'Reja metálica reforzada', 'Puerta de seguridad con cerradura', 'Reja plegable de acero', 'Puerta blindada residencial', 'Reja corrediza automática',
                            'Casco de seguridad', 'Guantes tácticos', 'Botas reforzadas', 'Escalera', 'Caja de herramientas'
                        ] as $producto)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="productos_tecnico[]" value="{{ $producto }}" id="tec_{{ Str::slug($producto, '_') }}">
                                    <label class="form-check-label" for="tec_{{ Str::slug($producto, '_') }}">
                                        {{ $producto }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>



                <div class="text-center mt-5">
                    <a href="{{ route('servicios.catalogo') }}" class="btn btn-danger me-2">
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
    function autoExpand(textarea) {
        textarea.style.height = 'auto'; // Reinicia
        textarea.style.height = (textarea.scrollHeight) + 'px'; // Ajusta al contenido
    }

    // Expande al cargar si ya tiene texto
    window.addEventListener('DOMContentLoaded', () => {
        const textarea = document.getElementById('descripcionServicio');
        autoExpand(textarea);
    });
</script>
<script>
    // Mostrar productos según la categoría
    document.getElementById('productosCategoria').addEventListener('change', function () {
        const categoria = this.value;
        const tecnico = document.getElementById('productos_tecnico');
        const vigilancia = document.getElementById('productos_vigilancia');

        if (categoria === 'tecnico') {
            tecnico.classList.remove('d-none');
            vigilancia.classList.add('d-none');
        } else if (categoria === 'vigilancia') {
            vigilancia.classList.remove('d-none');
            tecnico.classList.add('d-none');
        } else {
            tecnico.classList.add('d-none');
            vigilancia.classList.add('d-none');
        }
    });

    // Validaciones input personalizados
    function validarInput(e, pattern, maxLength) {
        const input = e.target;
        let valor = input.value;
        let regex = new RegExp(pattern, 'g');
        let soloPermitidos = valor.match(regex);
        valor = soloPermitidos ? soloPermitidos.join('') : '';
        if (valor.length > maxLength) valor = valor.substring(0, maxLength);
        input.value = valor;
    }

    // Nombre y descripción: solo letras y espacios
    document.getElementById('nombreServicio').addEventListener('input', e => {
        validarInput(e, '[A-Za-zÁÉÍÓÚáéíóúÑñ\\s]', 50);
    });

    document.getElementById('descripcionServicio').addEventListener('input', e => {
        validarInput(e, '[A-Za-zÁÉÍÓÚáéíóúÑñ\\s]', 125);
    });

    // Costo: solo números, máximo 3 cifras, sin iniciar con 0
    document.getElementById('costo').addEventListener('input', function () {
        let valor = this.value.replace(/\D/g, ''); // solo dígitos
        if (valor.startsWith('0')) valor = valor.replace(/^0+/, ''); // no dejar que empiece con cero
        this.value = valor.slice(0, 4); // máximo 4 dígitos
    });


    // Duración cantidad: solo 2 cifras, sin ceros al inicio
    document.getElementById('duracionCantidad').addEventListener('input', function () {
        let valor = this.value.replace(/\D/g, '');
        valor = valor.replace(/^0+/, '');
        this.value = valor.slice(0, 2);
    });

    // Evitar espacios al inicio
    function eliminarEspaciosIniciales(input) {
        input.value = input.value.replace(/^\s+/, '');
    }

    // Validación final del formulario
    (() => {
        'use strict';
        const form = document.getElementById('servicioForm');
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    })();
    function bloquearEspacioAlInicio(e, input) {
        if (e.key === ' ' && input.selectionStart === 0) {
            e.preventDefault();
        }
    }



    // Limpiar y ocultar campos dinámicos al hacer reset
    document.getElementById('servicioForm').addEventListener('reset', function () {
        document.getElementById('productos_tecnico').classList.add('d-none');
        document.getElementById('productos_vigilancia').classList.add('d-none');
        this.classList.remove('was-validated');
    });
    // Cuando cambie categoría, ajustar tipo_personal y productos_categoria
    document.getElementById('categoria').addEventListener('change', function() {
        const categoria = this.value;
        const tipoPersonalSelect = document.getElementById('tipo_personal');
        const productosCategoriaSelect = document.getElementById('productosCategoria');

        // Ajustar tipo_personal: dejar solo opción que coincide con categoría
        tipoPersonalSelect.value = categoria;
        for (let i = 0; i < tipoPersonalSelect.options.length; i++) {
            const option = tipoPersonalSelect.options[i];
            option.disabled = option.value !== categoria;
        }

        // Ajustar productos_categoria: dejar solo opción que coincide con categoría
        productosCategoriaSelect.value = categoria;
        for (let i = 0; i < productosCategoriaSelect.options.length; i++) {
            const option = productosCategoriaSelect.options[i];
            option.disabled = option.value !== categoria;
        }

        // Trigger cambio para mostrar productos correctos
        productosCategoriaSelect.dispatchEvent(new Event('change'));
    });

    // Al cargar la página, dispara cambio para forzar sincronía si hay valor
    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('categoria').dispatchEvent(new Event('change'));
    });

</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
