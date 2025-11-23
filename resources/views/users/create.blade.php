@extends('plantilla')

@section('content')
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
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active,
        select:-webkit-autofill,
        select:-webkit-autofill:hover,
        select:-webkit-autofill:focus,
        select:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #2a3357 inset !important;
            -webkit-text-fill-color: #fff !important;
        }

        /* Lista de resultados de búsqueda */
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
    </style>

    <div class="container">
        <h1 style="display: flex; align-items: center; justify-content: center; gap: 10px; color: #ffffff;">
            Registrar usuario
            <i class="bi bi-person-fill" style="font-size: 2rem;"></i>
        </h1>

        <form id="formUsuarios" method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="grid-2">

                {{-- Buscar Empleado --}}
                <div class="full" style="position: relative;">
                    <div class="input-icon">
                        <i class="bi bi-search"></i>
                        <input type="text" id="buscarEmpleado" placeholder="Buscar empleado...">
                    </div>
                    <div class="results" id="results"></div>
                    <div class="error" id="error-empleado"></div>
                </div>

                {{-- Correo (autocompletado) --}}
                <div class="full">
                    <div class="input-icon">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" id="email" placeholder="Correo electrónico" readonly>
                    </div>
                    <div class="error" id="error-email">@error('email') ⚠️ {{ $message }} @enderror</div>
                </div>

                {{-- Usuario (autogenerado) --}}
                <div class="full">
                    <div class="input-icon">
                        <i class="bi bi-person-badge-fill"></i>
                        <input type="text" name="usuario" id="usuario" placeholder="Usuario" readonly>
                    </div>
                    <div class="error" id="error-usuario">@error('usuario') ⚠️ {{ $message }} @enderror</div>
                </div>

                {{-- Contraseña (autogenerada) --}}
                <div class="full">
                    <div class="input-icon">
                        <i class="bi bi-lock-fill"></i>
                        <input type="text" name="password" id="password" placeholder="Contraseña temporal" readonly>
                    </div>
                    <div class="error" id="error-password"></div>
                </div>

                {{-- Rol --}}
                <div class="full">
                    <div class="input-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                        <select name="rol" id="rol">
                            <option value="">Seleccione un rol</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol }}" {{ old('rol') == $rol ? 'selected' : '' }}>
                                    {{ $rol }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="error" id="error-rol">@error('rol') ⚠️ {{ $message }} @enderror</div>
                </div>

            </div>

            <div class="botones">
                <a href="{{ route('users.index') }}" class="btn btn-danger w-100">
                    <i class="bi bi-x-circle me-2"></i> Cancelar
                </a>

                <button type="button" class="btn btn-secondary w-100" id="btnLimpiar">
                    <i class="bi bi-eraser-fill me-2"></i> Limpiar
                </button>

                <button type="submit" class="btn btn-warning w-100 text-white fw-normal">
                    <i class="bi bi-save-fill me-2"></i> Guardar
                </button>
            </div>

            <input type="hidden" name="empleado_id" id="empleado_id">
        </form>
    </div>

    <script>
        const btnLimpiar = document.getElementById("btnLimpiar");

        btnLimpiar.addEventListener("click", () => {
            document.querySelectorAll("input, select").forEach(e => e.value = "");
            document.querySelectorAll(".error").forEach(e => e.textContent = "");
            document.getElementById("buscarEmpleado").focus();
        });

        // Búsqueda AJAX de empleados
        const buscarEmpleado = document.getElementById("buscarEmpleado");
        const results = document.getElementById("results");
        const email = document.getElementById("email");
        const usuario = document.getElementById("usuario");
        const password = document.getElementById("password");
        const empleado_id = document.getElementById("empleado_id");

        buscarEmpleado.addEventListener("input", function() {
            const q = this.value;

            if(q.length === 0){
                results.innerHTML = "";
                return;
            }

            fetch("{{ route('ajax.empleados') }}?q=" + q)
                .then(response => response.json())
                .then(data => {
                    results.innerHTML = "";
                    data.forEach(emp => {
                        const div = document.createElement("div");
                        div.textContent = emp.nombre + " " + emp.apellido + " - " + emp.identidad;
                        div.dataset.email = emp.email;
                        div.dataset.nombre = emp.nombre;
                        div.dataset.apellido = emp.apellido;
                        div.dataset.id = emp.id;
                        div.addEventListener("click", () => {
                            buscarEmpleado.value = emp.nombre + " " + emp.apellido;
                            email.value = emp.email;
                            usuario.value = (emp.nombre.charAt(0) + "." + emp.apellido).toLowerCase().replace(/\s+/g, '');
                            password.value = Math.random().toString(36).slice(-10);
                            empleado_id.value = emp.id;
                            results.innerHTML = "";
                        });
                        results.appendChild(div);
                    });
                });
        });
    </script>
@endsection
