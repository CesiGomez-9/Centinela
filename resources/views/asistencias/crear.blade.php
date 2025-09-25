@extends('plantilla')

@section('content')
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 50px;
        }

        .container {
            max-width: 550px;
            margin: 0 auto;
            padding: 15px 30px;
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
            color: #cda34f;
            font-size: 13px;
            text-align: left;
            margin-bottom: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-size: 17px;
            background-color: #cda34f;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #cda34f;
        }

        .mensaje {
            margin-top: 12px;
            font-size: 15px;
            font-weight: bold;
            color: #00ff99;
        }
    </style>

    <div class="container">
        <h1>Control de Asistencia</h1>

        <div class="clock-icon">🕒</div>
        <div id="hora">00:00</div>

        <form id="formAsistencia" method="POST" action="{{ route('asistencias.store') }}">
            @csrf
            <input type="text" id="nombre" name="nombre" placeholder="Nombre">
            <div id="error-nombre" class="error"></div>

            <input type="text" id="apellido" name="apellido" placeholder="Apellido">
            <div id="error-apellido" class="error"></div>

            <input type="text" id="identidad" name="identidad" placeholder="DNI / Identidad" maxlength="13">
            <div id="error-identidad" class="error"></div>

            <button type="submit">Registrar</button>
        </form>
        <div class="mensaje" id="mensaje"></div>
    </div>
    <script>
        // Obtener elementos del DOM
        const form = document.getElementById("formAsistencia");
        const mensaje = document.getElementById("mensaje");

        const nombre = document.getElementById("nombre");
        const apellido = document.getElementById("apellido");
        const identidad = document.getElementById("identidad");

        const errorNombre = document.getElementById("error-nombre");
        const errorApellido = document.getElementById("error-apellido");
        const errorIdentidad = document.getElementById("error-identidad");

        // Validaciones de caracteres mientras el usuario escribe
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

        // Función para enviar el formulario con fetch
        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            let valido = true;

            // Reset de errores
            errorNombre.textContent = "";
            errorApellido.textContent = "";
            errorIdentidad.textContent = "";
            mensaje.textContent = "";

            // Validar campos
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

            if (!valido) return;

            // Crear FormData antes de usarlo
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    // Redirigir al listado en lugar de mostrar mensaje
                    window.location.href = "{{ route('asistencias.index') }}";
                } else {
                    mensaje.style.color = "red";
                    mensaje.textContent = data.error || "❌ Ocurrió un error";
                }
            } catch (err) {
                mensaje.style.color = "red";
                mensaje.textContent = "❌ Error de conexión: " + err.message;
            }
        });

        // Reloj dinámico
        function actualizarHora() {
            const ahora = new Date();
            let horas = ahora.getHours();
            let minutos = ahora.getMinutes();
            let segundos = ahora.getSeconds();

            horas = horas < 10 ? "0" + horas : horas;
            minutos = minutos < 10 ? "0" + minutos : minutos;
            segundos = segundos < 10 ? "0" + segundos : segundos;

            document.getElementById("hora").textContent = `${horas}:${minutos}:${segundos}`;
        }

        actualizarHora();
        setInterval(actualizarHora, 1000);
    </script>

@endsection
