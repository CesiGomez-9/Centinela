@extends('plantilla')
@section('content')

    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Instalación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
            max-width: 800px;
        }
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
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-light p-5 rounded shadow-lg position-relative">

                <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                    <i class="bi bi-tools" style="font-size: 4rem;"></i>
                </div>

                <h3 class="text-center mb-4" style="color: #09457f;">
                    <i class="bi bi-gear-fill me-2"></i> Programar instalación
                </h3>

                <form action="{{ route('instalaciones.store') }}" method="POST" id="form-instalacion" novalidate>
                    @csrf

                    <div class="row g-4">
                        <!-- Cliente -->
                        <div class="col-md-6">
                            <label for="cliente_id" class="form-label">Cliente</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <select id="cliente_id" name="cliente_id"
                                        class="form-select @error('cliente_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('cliente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_instalacion" class="form-label">Fecha de instalación</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                <input type="date" id="fecha_instalacion" name="fecha_instalacion"
                                       class="form-control @error('fecha_instalacion') is-invalid @enderror"
                                       value="{{ now()->format('Y-m-d') }}"
                                       min="2025-07-01" max="2025-08-31" required>
                                @error('fecha_instalacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>


                        <!-- Técnicos (select múltiple en una línea) -->
                        <div class="col-md-6">
                            <label for="empleado_id" class="form-label">Técnicos</label>
                            <div class="border rounded p-2" id="tecnicos-container" style="max-height: 200px; overflow-y: auto;">
                                <div class="row">
                                    @foreach ($tecnicos as $tecnico)
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="tecnico_id[]"
                                                value="{{ $tecnico->id }}"
                                                id="tecnico_{{ $tecnico->id }}"
                                                {{-- Si estamos editando, o hay old input, marcar el checkbox --}}
                                                {{ (collect(old('tecnico_id'))->contains($tecnico->id) || (isset($instalacion) && $instalacion->tecnicos->contains($tecnico->id))) ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="tecnico_{{ $tecnico->id }}">
                                                {{ $tecnico->nombre }}
                                            </label>
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                            <small class="text-muted">Seleccione uno o más técnicos.</small>
                        </div>

                        <!-- Servicio -->
                        <div class="col-md-6">
                            <label for="servicio_id" class="form-label">Servicio</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-list-task"></i></span>
                                <select id="servicio_id" name="servicio_id"
                                        class="form-select @error('servicio_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un servicio</option>
                                    @foreach($servicios as $servicio)
                                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('servicio_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- Fecha instalación -->
                        <!-- Costo instalación -->
                        <div class="col-md-6">
                            <label for="costo_instalacion" class="form-label">Costo de Instalación (L.)</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                <input type="number" id="costo_instalacion" name="costo_instalacion"
                                       class="form-control @error('costo_instalacion') is-invalid @enderror"
                                       min="1" max="9999" step="0.01" placeholder="Ej: 500.00" required>

                                @error('costo_instalacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- Factura -->
                        <div class="col-md-6">
                            <label for="factura_id" class="form-label">Factura de Venta (Opcional)</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-receipt"></i></span>
                                <select id="factura_id" name="factura_id" class="form-select">
                                    <option value="">Seleccione una factura</option>
                                    @foreach($facturas as $factura)
                                        <option value="{{ $factura->id }}" data-total="{{ $factura->total }}">
                                            Factura #{{ $factura->id }} - L. {{ number_format($factura->total, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <textarea id="descripcion" name="descripcion"
                                          class="form-control auto-expand @error('descripcion') is-invalid @enderror"
                                          rows="2" required></textarea>
                                @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <textarea id="direccion" name="direccion"
                                          class="form-control auto-expand @error('direccion') is-invalid @enderror"
                                          rows="2" required></textarea>
                                @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de costos -->
                    <div class="d-flex justify-content-end mt-4">
                        <div class="bg-light p-3 rounded shadow-sm" style="width: 300px; font-size: 0.9rem;">
                            <h6 class="text-center mb-3">Costos totales</h6>
                            <p class="mb-1"><strong>Costo Factura:</strong> L. <span id="total-factura">0.00</span></p>
                            <p class="mb-1"><strong>Costo Instalación:</strong> L. <span id="total-instalacion">0.00</span></p>
                            <hr>
                            <p class="mb-1 fw-bold text-primary text-center">Total General: L. <span id="total-general">0.00</span></p>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="text-center mt-4 d-flex justify-content-center gap-3">
                        <a href="{{ route('instalaciones.index') }}" class="btn btn-danger" type="button">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>

                        <button type="button" class="btn btn-warning" id="btn-limpiar">
                            <i class="bi bi-eraser-fill me-2"></i> Limpiar
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i> Guardar
                        </button>


                    </div>
                </form>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const form = document.getElementById("form-instalacion");

                        const fields = {
                            cliente: document.getElementById("cliente_id"),
                            servicio: document.getElementById("servicio_id"),
                            fecha: document.getElementById("fecha_instalacion"),
                            costo: document.getElementById("costo_instalacion"),
                            descripcion: document.getElementById("descripcion"),
                            direccion: document.getElementById("direccion"),
                            factura: document.getElementById("factura_id")
                        };

                        const tecnicosContainer = document.getElementById("tecnicos-container");

                        const totalFacturaSpan = document.getElementById("total-factura");
                        const totalInstalacionSpan = document.getElementById("total-instalacion");
                        const totalGeneralSpan = document.getElementById("total-general");

                        function actualizarTotales() {
                            const costo = parseFloat(fields.costo.value) || 0;
                            const facturaTotal = parseFloat(fields.factura.selectedOptions[0]?.dataset.total || 0);
                            totalFacturaSpan.textContent = facturaTotal.toFixed(2);
                            totalInstalacionSpan.textContent = costo.toFixed(2);
                            totalGeneralSpan.textContent = (facturaTotal + costo).toFixed(2);
                        }

                        fields.costo.addEventListener("input", actualizarTotales);
                        fields.factura.addEventListener("change", actualizarTotales);

                        document.getElementById("btn-limpiar").addEventListener("click", function () {
                            form.reset();
                            totalFacturaSpan.textContent = "0.00";
                            totalInstalacionSpan.textContent = "0.00";
                            totalGeneralSpan.textContent = "0.00";
                            limpiarErrores();
                        });

                        // ✅ Evitar espacios al inicio en tiempo real
                        [fields.descripcion, fields.direccion].forEach(field => {
                            field.addEventListener("input", function () {
                                if (this.value.startsWith(" ")) {
                                    this.value = this.value.trimStart();
                                }
                            });
                        });
                        // ✅ Autoajuste dinámico de altura para textareas
                        document.querySelectorAll(".auto-expand").forEach(textarea => {
                            textarea.style.overflow = "hidden"; // Sin scroll interno
                            textarea.addEventListener("input", function () {
                                this.style.height = "auto"; // Reinicia altura
                                this.style.height = this.scrollHeight + "px"; // Ajusta a contenido
                            });
                        });


                        // Función para mostrar error
                        function setError(element, message) {
                            element.classList.add("is-invalid");
                            let feedback = element.parentNode.querySelector(".invalid-feedback");
                            if (!feedback) {
                                feedback = document.createElement("div");
                                feedback.className = "invalid-feedback";
                                element.parentNode.appendChild(feedback);
                            }
                            feedback.textContent = message;
                        }
                        // Limitar costo a 4 cifras enteras (antes del punto)
                        fields.costo.addEventListener("input", function () {
                            let value = this.value;

                            // Si hay decimales, separa la parte entera
                            let [entero, decimal] = value.split(".");

                            // Limitar la parte entera a 4 dígitos
                            if (entero.length > 4) {
                                entero = entero.slice(0, 4);
                            }

                            // Reconstruir valor
                            this.value = decimal !== undefined ? `${entero}.${decimal}` : entero;
                        });


                        // Para el contenedor de técnicos
                        function setGroupError(container, message) {
                            container.classList.add("is-invalid");
                            let feedback = container.parentNode.querySelector(".invalid-feedback");
                            if (!feedback) {
                                feedback = document.createElement("div");
                                feedback.className = "invalid-feedback";
                                feedback.style.display = "block";
                                container.parentNode.appendChild(feedback);
                            }
                            feedback.textContent = message;
                        }

                        function limpiarErrores() {
                            form.querySelectorAll(".is-invalid").forEach(el => el.classList.remove("is-invalid"));
                            form.querySelectorAll(".invalid-feedback").forEach(fb => fb.remove());
                        }

                        form.addEventListener("submit", function (e) {
                            limpiarErrores();
                            let isValid = true;

                            // ✅ Limpiar espacios al inicio antes de validar
                            fields.descripcion.value = fields.descripcion.value.trimStart();
                            fields.direccion.value = fields.direccion.value.trimStart();

                            // Cliente
                            if (!fields.cliente.value) {
                                setError(fields.cliente, "Debe seleccionar un cliente.");
                                isValid = false;
                            }

                            // Técnicos
                            const tecnicosMarcados = document.querySelectorAll('input[name="tecnico_id[]"]:checked');
                            if (tecnicosMarcados.length === 0) {
                                setGroupError(tecnicosContainer, "Debe seleccionar al menos un técnico.");
                                isValid = false;
                            }


                            // Servicio
                            if (!fields.servicio.value) {
                                setError(fields.servicio, "Debe seleccionar un servicio.");
                                isValid = false;
                            }

                            // Fecha instalación
                            if (!fields.fecha.value) {
                                setError(fields.fecha, "Debe ingresar una fecha de instalación.");
                                isValid = false;
                            }

                            // Costo instalación
                            const costo = parseFloat(fields.costo.value);
                            if (isNaN(costo) || costo <= 0) {
                                setError(fields.costo, "El costo debe ser mayor a 0.");
                                isValid = false;
                            } else if (!/^\d{1,4}$/.test(fields.costo.value)) {
                                setError(fields.costo, "El costo solo permite hasta 4 cifras (ej. 9999).");
                                isValid = false;
                            }

                            // Descripción
                            if (!fields.descripcion.value.trim()) {
                                setError(fields.descripcion, "Debe ingresar una descripción.");
                                isValid = false;
                            } else if (fields.descripcion.value.length > 255) {
                                setError(fields.descripcion, "La descripción no puede superar los 255 caracteres.");
                                isValid = false;
                            }

                            // Dirección
                            if (!fields.direccion.value.trim()) {
                                setError(fields.direccion, "Debe ingresar una dirección.");
                                isValid = false;
                            } else if (fields.direccion.value.length > 255) {
                                setError(fields.direccion, "La dirección no puede superar los 255 caracteres.");
                                isValid = false;
                            }

                            if (!isValid) e.preventDefault();
                        });
                    });

                </script>

@endsection
