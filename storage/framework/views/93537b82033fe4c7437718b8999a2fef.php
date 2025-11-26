<?php $__env->startSection('content'); ?>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    </head>

    <style>
        body {
            background-color: #ffffff;
            color: #000000;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            max-width: 550px;
            margin: 0 auto;
            padding: 20px 30px;
            border-radius: 15px;
            background-color: #1a2340;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            color: #ffffff;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 12px;
            color: #ffffff;
        }

        .clock-icon {
            font-size: 80px;
            margin-bottom: 5px;
            color: #ffffff;
        }

        #hora {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 18px;
            color: #ffffff;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 7px 0 3px 0;
            border-radius: 8px;
            border: none;
            background-color: #2a3357;
            color: #fff;
            font-size: 15px;
        }

        input::placeholder {
            color: #aaa;
        }

        .error {
            color: #ffc107;
            font-size: 13px;
            text-align: left;
            margin-bottom: 5px;
        }

        .botones {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 15px;
        }

        .mensaje {
            margin-top: 12px;
            font-size: 15px;
            font-weight: bold;
            color: #00ff99;
        }

        .btn i {
            vertical-align: middle;
        }
        #listaEmpleadosNombre .list-group-item,
        #listaEmpleadosApellido .list-group-item {
            background-color: #f4f4f4; /* fondo azul oscuro */
            color: #070606;  /* texto siempre blanco */
            border: 1px solid #606063;
            padding: 8px 10px;
            cursor: pointer;
        }

        #listaEmpleadosNombre .list-group-item:hover,
        #listaEmpleadosApellido .list-group-item:hover {
            background-color: #f5f5f8; /* solo cambia el fondo al pasar el mouse */
            color: #090505; /* texto sigue siendo blanco */
        }

        .clock-icon i {
            font-size: 80px; /* tamaño grande */
            margin-bottom: 5px;
            color: #ffffff;
        }


    </style>

    <div class="container">
        <h1>Control de Asistencia</h1>

        <div class="clock-icon">
            <i class="bi bi-clock"></i>
        </div>
        <div id="hora">00:00</div>
        <div id="fecha" style="font-size:18px; margin-bottom:18px; color:#ffffff;"></div>


        <form id="formAsistencia" method="POST" action="<?php echo e(route('asistencias.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="text" name="nombre" id="nombre" value="<?php echo e(old('nombre')); ?>" placeholder="Buscar empleado por nombre">
            <div class="error" id="error-nombre">
                <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ⚠️ <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Contenedor para lista de resultados por nombre -->
            <div id="listaEmpleadosNombre"></div>

            <input type="text" name="apellido" id="apellido" value="<?php echo e(old('apellido')); ?>" placeholder="Buscar empleado por apellido">
            <div class="error" id="error-apellido">
                <?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ⚠️ <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Contenedor para lista de resultados por apellido -->
            <div id="listaEmpleadosApellido"></div>


            <input type="text" name="identidad" id="identidad" maxlength="13" value="<?php echo e(old('identidad')); ?>" placeholder="DNI / Identidad">
            <div class="error" id="error-identidad">
                <?php $__errorArgs = ['identidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                ⚠️ <?php echo e($message); ?>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="botones">
                <a href="<?php echo e(route('asistencias.index')); ?>" class="btn btn-danger w-100">
                    <i class="bi bi-x-circle me-2"></i> Cancelar
                </a>
                <button type="button" class="btn btn-secondary w-100" id="btnLimpiar">
                    <i class="bi bi-eraser-fill me-2"></i> Limpiar
                </button>
                <button type="submit" class="btn btn-warning w-100 text-white fw-normal">
                    <i class="bi bi-save-fill me-2"></i> Registrar
                </button>
            </div>

        </form>



        <?php if(session('error')): ?>
            <div id="alertaError" class="mensaje" style="color: #ff4d4d; margin-top:10px;">
                ⚠️ <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

    </div>

    <script>
        const form = document.getElementById("formAsistencia");
        const mensaje = document.getElementById("mensaje");

        const nombre = document.getElementById("nombre");
        const apellido = document.getElementById("apellido");
        const identidad = document.getElementById("identidad");

        const errorNombre = document.getElementById("error-nombre");
        const errorApellido = document.getElementById("error-apellido");
        const errorIdentidad = document.getElementById("error-identidad");

        const btnLimpiar = document.getElementById("btnLimpiar");

        // Validaciones en tiempo real
        nombre.addEventListener("input", function() {
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, "");
        });

        apellido.addEventListener("input", function() {
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, "");
        });

        identidad.addEventListener("input", function() {
            this.value = this.value.replace(/[^0-9]/g, "");
            if (this.value.length > 13) {
                this.value = this.value.slice(0, 13);
            }
        });

        // Botón Limpiar
        btnLimpiar.addEventListener("click", () => {
            // Limpiar inputs
            nombre.value = "";
            apellido.value = "";
            identidad.value = "";

            // Limpiar errores
            document.getElementById("error-nombre").textContent = "";
            document.getElementById("error-apellido").textContent = "";
            document.getElementById("error-identidad").textContent = "";

            // Limpiar mensaje de sesión
            const alerta = document.getElementById("alertaError");
            if (alerta) {
                alerta.textContent = "";
                alerta.style.display = "none"; // opcional: ocultar div
            }

            nombre.focus();
        });


        // Envío del formulario
        form.addEventListener("submit", function(e) {
            // e.preventDefault(); // <--- comentado para permitir envío normal

            let valido = true;

            // Limpiar errores anteriores
            errorNombre.textContent = "";
            errorApellido.textContent = "";
            errorIdentidad.textContent = "";

            if (nombre.value.trim() === "") {
                errorNombre.textContent = "⚠️ Introduzca el nombre";
                valido = false;
            }
            if (apellido.value.trim() === "") {
                errorApellido.textContent = "⚠️ Introduzca el apellido";
                valido = false;
            }
            if (identidad.value.trim() === "") {
                errorIdentidad.textContent = "⚠️ Introduzca el DNI";
                valido = false;
            } else if (identidad.value.length !== 13) {
                errorIdentidad.textContent = "⚠️ El DNI debe tener 13 dígitos";
                valido = false;
            }

            if (!valido) {
                // Solo se muestran los errores, no se envía
                e.preventDefault(); // bloquear envío si hay errores
                return;
            }

            // Si todo es válido, se envía el formulario normalmente
        });

        function actualizarHora() {
            const ahora = new Date();

            // Hora en formato 12 horas
            let horas = ahora.getHours();
            const minutos = String(ahora.getMinutes()).padStart(2, '0');
            const segundos = String(ahora.getSeconds()).padStart(2, '0');
            const ampm = horas >= 12 ? 'PM' : 'AM';
            horas = horas % 12;
            horas = horas ? horas : 12; // 0 → 12

            document.getElementById("hora").textContent = `${horas}:${minutos}:${segundos} ${ampm}`;

            // Fecha actual
            const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            let fechaTexto = ahora.toLocaleDateString('es-ES', opciones);

// Capitalizar solo la primera letra
            fechaTexto = fechaTexto[0].toUpperCase() + fechaTexto.slice(1);

            document.getElementById("fecha").textContent = fechaTexto;

        }

        actualizarHora();
        setInterval(actualizarHora, 1000);



        const listaNombre = document.getElementById("listaEmpleadosNombre");
        const listaApellido = document.getElementById("listaEmpleadosApellido");

        // BUSCADOR POR NOMBRE
        nombre.addEventListener("input", async function() {
            const query = this.value.trim();
            listaNombre.innerHTML = "";
            if (!query) return;

            try {
                const response = await fetch(`<?php echo e(route('empleados.buscar')); ?>?nombre=${encodeURIComponent(query)}`);
                const empleados = await response.json();

                if (!empleados.length) {
                    listaNombre.innerHTML = `<div class="list-group-item text-Black">Sin resultados</div>`;
                    return;
                }

                empleados.forEach(emp => {
                    const item = document.createElement("div");
                    item.className = "list-group-item list-group-item-action";
                    // Mostrar nombre y apellido
                    item.textContent = `${emp.nombre} ${emp.apellido}`;
                    item.style.cursor = "pointer";
                    item.addEventListener("click", () => {
                        nombre.value = emp.nombre;
                        apellido.value = emp.apellido;
                        identidad.value = emp.identidad;
                        listaNombre.innerHTML = "";
                    });
                    listaNombre.appendChild(item);
                });
            } catch (err) {
                console.error(err);
            }
        });

        // BUSCADOR POR APELLIDO
        apellido.addEventListener("input", async function() {
            const query = this.value.trim();
            listaApellido.innerHTML = "";
            if (!query) return;

            try {
                const response = await fetch(`<?php echo e(route('empleados.buscar')); ?>?apellido=${encodeURIComponent(query)}`);
                const empleados = await response.json();

                if (!empleados.length) {
                    listaApellido.innerHTML = `<div class="list-group-item text-Black">Sin resultados</div>`;
                    return;
                }

                empleados.forEach(emp => {
                    const item = document.createElement("div");
                    item.className = "list-group-item list-group-item-action";
                    // Mostrar nombre y apellido
                    item.textContent = `${emp.nombre} ${emp.apellido}`;
                    item.style.cursor = "pointer";
                    item.addEventListener("click", () => {
                        nombre.value = emp.nombre;
                        apellido.value = emp.apellido;
                        identidad.value = emp.identidad;
                        listaApellido.innerHTML = "";
                    });
                    listaApellido.appendChild(item);
                });
            } catch (err) {
                console.error(err);
            }
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/asistencias/crear.blade.php ENDPATH**/ ?>