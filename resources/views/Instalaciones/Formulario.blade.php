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
                    <i class="bi bi-gear-fill me-2"></i> Registrar Instalación
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
                                @error('cliente_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Técnico -->
                        <div class="col-md-6">
                            <label for="empleado_id" class="form-label">Técnico</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-gear"></i></span>
                                <select id="empleado_id" name="empleado_id"
                                        class="form-select @error('empleado_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un técnico</option>
                                    @foreach($tecnicos as $tecnico)
                                        <option value="{{ $tecnico->id }}">{{ $tecnico->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('empleado_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                                @error('servicio_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fecha de instalación -->
                        <div class="col-md-6">
                            <label for="fecha_instalacion" class="form-label">Fecha de instalación</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                <input type="date" id="fecha_instalacion" name="fecha_instalacion"
                                       class="form-control @error('fecha_instalacion') is-invalid @enderror"
                                       value="{{ now()->format('Y-m-d') }}"
                                       min="2025-07-01" max="2025-08-31" required>
                                @error('fecha_instalacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                <select id="estado" name="estado"
                                        class="form-select @error('estado') is-invalid @enderror" required>
                                    <option value="">Seleccione estado</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="terminado">Terminado</option>
                                </select>
                                @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <textarea id="descripcion" name="descripcion"
                                          class="form-control @error('descripcion') is-invalid @enderror"
                                          rows="2" required></textarea>
                                @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <textarea id="direccion" name="direccion"
                                          class="form-control @error('direccion') is-invalid @enderror"
                                          rows="2" required></textarea>
                                @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5 d-flex justify-content-center gap-3">
                        <!-- Botón Cancelar -->
                        <a href="{{ route('instalaciones.index') }}" class="btn btn-danger">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>

                        <!-- Botón Limpiar -->
                        <button type="button" class="btn btn-warning" id="btn-limpiar">
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("form-instalacion");
        const descripcion = document.getElementById("descripcion");
        const direccion = document.getElementById("direccion");
        const fechaInput = document.getElementById("fecha_instalacion");
        const limpiarBtn = document.getElementById("btn-limpiar");

        const today = new Date();
        const minDate = new Date("2025-07-01");
        const maxDate = new Date("2025-08-31");

        if (today >= minDate && today <= maxDate) {
            fechaInput.value = today.toISOString().split("T")[0];
        }

        form.addEventListener("submit", function (e) {
            let valid = true;

            ["cliente_id", "empleado_id", "servicio_id", "estado"].forEach(id => {
                const select = document.getElementById(id);
                if (!select.value.trim()) {
                    select.classList.add("is-invalid");
                    valid = false;
                } else {
                    select.classList.remove("is-invalid");
                }
            });

            if (!descripcion.value.trim() || /^\s+/.test(descripcion.value)) {
                descripcion.classList.add("is-invalid");
                valid = false;
            } else {
                descripcion.classList.remove("is-invalid");
            }

            if (!direccion.value.trim() || /^\s+/.test(direccion.value)) {
                direccion.classList.add("is-invalid");
                valid = false;
            } else {
                direccion.classList.remove("is-invalid");
            }

            const selectedDate = new Date(fechaInput.value);
            if (selectedDate < minDate || selectedDate > maxDate) {
                fechaInput.classList.add("is-invalid");
                valid = false;
            } else {
                fechaInput.classList.remove("is-invalid");
            }

            if (!valid) {
                e.preventDefault();
                alert("Por favor, corrige los errores antes de enviar.");
            }
        });

        limpiarBtn.addEventListener("click", function () {
            form.reset();
            form.querySelectorAll(".is-invalid").forEach(el => el.classList.remove("is-invalid"));
            if (today >= minDate && today <= maxDate) {
                fechaInput.value = today.toISOString().split("T")[0];
            }
        });
    });
</script>

@endsection
