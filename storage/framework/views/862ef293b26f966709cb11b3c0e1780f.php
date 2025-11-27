<?php $__env->startSection('content'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    </head>
    <style>
        body {
            background-color: #e6f0ff;
            color: #000000;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            max-width: 750px;
            margin: 0 auto;
            padding: 25px 30px;
            border-radius: 15px;
            background-color: #1a2340;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            color: #ffffff;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #ffffff;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-bottom: 4px;
            background-color: #2a3357;
            color: #fff;
            font-size: 15px;
        }

        select option {
            color: #000;
        }

        input::placeholder {
            color: #aaa;
        }

        .error {
            color: #ffc107;
            font-size: 13px;
            text-align: left;
            margin-bottom: 10px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            text-align: left;
        }

        .full {
            grid-column: span 2;
        }

        .botones {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 15px;
        }

        .btn i {
            vertical-align: middle;
        }

        .input-icon {
            position: relative;
            margin-bottom: 5px;
        }

        .input-icon i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #ccc;
            font-size: 1rem;
            pointer-events: none;
        }

        .input-icon input,
        .input-icon select {
            width: 100%;
            padding-left: 35px;
            border-radius: 8px;
            border: none;
            background-color: #2a3357;
            color: #fff;
            font-size: 15px;
        }

        .input-icon select {
            color: #fff;
        }

        .input-icon input::placeholder,
        .input-icon select option {
            color: #aaa;
        }

        .input-icon input:focus,
        .input-icon select:focus {
            background-color: #2a3357 !important;
            color: #fff !important;
            outline: none;
        }

        input:-webkit-autofill,
        select:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #2a3357 inset !important;
            -webkit-text-fill-color: #fff !important;
        }

        .results {
            background-color: #2a3357;
            max-height: 150px;
            overflow-y: auto;
            border-radius: 8px;
            margin-top: 2px;
            position: absolute;
            width: calc(100% - 20px);
            z-index: 1000;
        }

        .results div {
            padding: 8px;
            cursor: pointer;
        }

        .results div:hover {
            background-color: #3a4467;
        }

        .grid-2 {
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .grid-2::before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 2px;
            background: linear-gradient(to bottom, #d4af37, #b8962e, #d4af37);
            opacity: 0.7;
            border-radius: 10px;
        }

        .columna {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            align-items: start;
        }

        .columna {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
    </style>

    <div class="container">
        <h1 style="display: flex; align-items: center; justify-content: center; gap: 10px; color: #ffffff;">
            Registrar usuario
            <i class="bi bi-person-fill" style="font-size: 2rem;"></i>
        </h1>

        <form id="formUsuarios" method="POST" action="<?php echo e(route('users.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="grid-2">
                <div class="columna">
                    <h5 class="mt-2 mb-3" style="font-weight: bold; text-align: center;">Datos del empleado</h5>

                    <div class="full" style="position: relative;">
                        <label>Empleado:</label>
                        <div class="input-icon">
                            <i class="bi bi-search"></i>
                            <input type="text" id="buscarEmpleado" name="empleado_nombre" placeholder="Buscar empleado..." value="<?php echo e(old('empleado_nombre')); ?>">
                        </div>
                        <div class="results" id="results"></div>
                        <div class="error" id="error-empleado">
                            <?php $__errorArgs = ['empleado_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ⚠️ <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <input type="hidden" name="empleado_id" id="empleado_id" value="<?php echo e(old('empleado_id')); ?>">
                    </div>

                    <div class="full">
                        <label>Identidad:</label>
                        <div class="input-icon">
                            <i class="bi bi-card-list"></i>
                            <input type="text" id="identidad" placeholder="Identidad" readonly>
                        </div>
                    </div>

                    <div class="full">
                        <label>Correo electrónico:</label>
                        <div class="input-icon">
                            <i class="bi bi-envelope-fill"></i>
                            <input type="email" name="email" id="email" placeholder="Correo" readonly>
                        </div>
                        <div class="error" id="error-email">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ⚠️ <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="columna">
                    <h5 class="mt-2 mb-3" style="font-weight: bold; text-align: center;">Datos para iniciar sesión</h5>

                    <div class="full">
                        <label>Usuario:</label>
                        <div class="input-icon">
                            <i class="bi bi-person-badge-fill"></i>
                            <input type="text" name="usuario" id="usuario" placeholder="Usuario" readonly>
                        </div>
                        <div class="error" id="error-usuario">
                            <?php $__errorArgs = ['usuario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ⚠️ <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="full">
                        <label>Contraseña temporal:</label>
                        <div class="input-icon">
                            <i class="bi bi-lock-fill"></i>
                            <input type="text" name="password" id="password" placeholder="Contraseña" readonly>
                        </div>
                        <div class="error" id="error-password"></div>
                    </div>

                    <div class="full">
                        <label>Rol:</label>
                        <div class="input-icon">
                            <i class="bi bi-shield-lock-fill"></i>
                            <select name="rol" id="rol">
                                <option value="">Seleccione un rol</option>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($rol); ?>" <?php echo e(old('rol') == $rol ? 'selected' : ''); ?>><?php echo e($rol); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="error" id="error-rol">
                            <?php $__errorArgs = ['rol'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ⚠️ <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="botones">
                <a href="<?php echo e(route('users.index')); ?>" class="btn btn-danger w-100">
                    <i class="bi bi-x-circle me-2"></i> Cancelar
                </a>
                <button type="button" class="btn btn-secondary w-100" id="btnLimpiar">
                    <i class="bi bi-eraser-fill me-2"></i> Limpiar
                </button>
                <button type="submit" class="btn btn-warning w-100 text-white fw-normal">
                    <i class="bi bi-save-fill me-2"></i> Guardar
                </button>
            </div>
        </form>
    </div>

    <script>
        const btnLimpiar = document.getElementById("btnLimpiar");
        const buscarEmpleado = document.getElementById("buscarEmpleado");
        const results = document.getElementById("results");
        const email = document.getElementById("email");
        const identidad = document.getElementById("identidad");
        const usuario = document.getElementById("usuario");
        const password = document.getElementById("password");
        const empleado_id = document.getElementById("empleado_id");
        const errorEmpleado = document.getElementById("error-empleado");
        const errorRol = document.getElementById("error-rol");
        const formUsuarios = document.getElementById("formUsuarios");

        let empleadoTieneUsuario = false;

        btnLimpiar.addEventListener("click", () => {
            document.querySelectorAll("input, select").forEach(e => {
                if (e.id !== "empleado_id") e.value = "";
            });

            document.querySelectorAll(".error").forEach(e => e.textContent = "");
            empleado_id.value = "";
            empleadoTieneUsuario = false;
            results.innerHTML = "";
            buscarEmpleado.focus();
        });

        buscarEmpleado.addEventListener("input", function () {
            const q = this.value.trim();

            if (q.length === 0) {
                results.innerHTML = "";
                empleado_id.value = "";
                empleadoTieneUsuario = false;
                errorEmpleado.textContent = "";
                return;
            }

            fetch(`/ajax/empleados?q=${encodeURIComponent(q)}`, {
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(res => res.json())
                .then(data => {
                    results.innerHTML = "";

                    data.forEach(emp => {
                        const div = document.createElement("div");
                        div.textContent = `${emp.nombre} ${emp.apellido} - ${emp.identidad}`;

                        div.addEventListener("click", () => {

                            buscarEmpleado.value = emp.nombre + " " + emp.apellido;

                            fetch(`/ajax/check-user/${emp.id}`, {
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                                }
                            })
                                .then(r => r.json())
                                .then(resp => {

                                    if (resp.tiene_usuario) {
                                        errorEmpleado.textContent = "Este empleado ya tiene un usuario.";
                                        empleadoTieneUsuario = true;

                                        identidad.value = "";
                                        email.value = "";
                                        usuario.value = "";
                                        password.value = "";
                                        empleado_id.value = "";
                                    } else {
                                        errorEmpleado.textContent = "";
                                        empleadoTieneUsuario = false;

                                        identidad.value = emp.identidad;
                                        email.value = emp.email;
                                        usuario.value = (emp.nombre.charAt(0) + "." + emp.apellido)
                                            .toLowerCase().replace(/\s+/g, '');
                                        password.value = Math.random().toString(36).slice(-10);
                                        empleado_id.value = emp.id;
                                    }

                                    results.innerHTML = "";
                                });
                        });

                        results.appendChild(div);
                    });
                });
        });

        formUsuarios.addEventListener("submit", e => {
            let hayError = false;

            if (empleadoTieneUsuario) {
                errorEmpleado.textContent = "Este empleado ya tiene un usuario.";
                hayError = true;
            } else if (empleado_id.value.trim() === "") {
                errorEmpleado.textContent = "Debe seleccionar un empleado.";
                hayError = true;
            } else {
                errorEmpleado.textContent = "";
            }
            if (!empleadoTieneUsuario) {
                if (document.getElementById("rol").value === "") {
                    errorRol.textContent = "Debe seleccionar un rol.";
                    hayError = true;
                } else {
                    errorRol.textContent = "";
                }
            } else {
                errorRol.textContent = "";
            }


            if (hayError) {
                e.preventDefault();
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/users/create.blade.php ENDPATH**/ ?>