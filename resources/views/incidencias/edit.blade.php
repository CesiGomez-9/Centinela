@extends('plantilla')
@section('content')


    <!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Incidencia</title>
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
        textarea.auto-expand {
            overflow-y: hidden;
            resize: none;
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
                    <i class="bi bi-person-plus-fill me-2"></i> Editar datos de la incidencia
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


                <form action="{{ route('incidencias.update', $incidencia->id) }}" method="POST" id="form-incidencia" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        {{-- Cliente afectado --}}
                        <div class="col-md-6">
                            <label for="clienteInput" class="form-label">Cliente afectado</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <input type="text"
                                       id="clienteInput"
                                       name="cliente_nombre"
                                       class="form-control"
                                       value="{{ $incidencia->cliente->nombre ?? '' }}"
                                       readonly>
                                <input type="hidden" name="cliente_id" id="cliente_id" value="{{ $incidencia->cliente_id }}">
                            </div>
                        </div>

                        {{-- Tipo de incidencia --}}
                        <div class="col-md-6">
                            <label for="tipoInput" class="form-label">Tipo de incidencia</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>

                                {{-- Campo visible (solo lectura, parece editable) --}}
                                <input type="text"
                                       id="tipoInput"
                                       class="form-control"
                                       value="{{ ucfirst($incidencia->tipo) }}"
                                       readonly>

                                {{-- Campo oculto (para enviar el valor al backend) --}}
                                <input type="hidden" name="tipo" value="{{ $incidencia->tipo }}">
                            </div>
                        </div>



                        <!-- Agentes involucrados -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Empleados involucrados</label>

                            <div class="card">
                                <div class="card-body" style="max-height: 200px; overflow-y: auto; overflow-x: hidden;">
                                    <div>
                                        @foreach($empleados as $empleado)
                                            @if(in_array($empleado->categoria, ['Tecnico', 'Vigilancia']))
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           name="agente_id[]"
                                                           value="{{ $empleado->id }}"
                                                           id="agente_{{ $empleado->id }}"
                                                        {{
                                                            (
                                                                (is_array(old('agente_id')) && in_array($empleado->id, old('agente_id'))) ||
                                                                (!old('agente_id') && isset($incidencia) && $incidencia->agentes->contains('id', $empleado->id))
                                                            ) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="agente_{{ $empleado->id }}">
                                                        {{ $empleado->nombre }}  ({{ ucfirst($empleado->categoria) }})
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            @error('agente_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Reportado por --}}
                        <div class="col-md-6">
                            <label for="reportadoPorInput" class="form-label">Reportado por</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill-check"></i></span>

                                {{-- Campo visible (solo lectura) --}}
                                <input type="text"
                                       id="reportadoPorInput"
                                       name="reportado_por_nombre"
                                       class="form-control"
                                       value="{{ $incidencia->reportadoPorEmpleado->nombre ?? '' }}"
                                       readonly>

                                {{-- Campo oculto (ID del empleado, se mantiene para enviar al backend) --}}
                                <input type="hidden"
                                       name="reportado_por"
                                       id="reportado_por"
                                       value="{{ $incidencia->reportado_por ?? '' }}">
                            </div>
                        </div>



                        {{-- Fecha --}}
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                                       value="{{ old('fecha', $incidencia->fecha) }}" required>

                            </div>
                            @error('fecha')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado (editable en editar) --}}
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-clipboard-check-fill"></i></span>
                                <select name="estado" class="form-select">
                                    <option value="en proceso" {{ $incidencia->estado == 'en proceso' ? 'selected' : '' }}>En proceso</option>
                                    <option value="resuelta" {{ $incidencia->estado == 'resuelta' ? 'selected' : '' }}>Resuelta</option>
                                    <option value="cerrada" {{ $incidencia->estado == 'cerrada' ? 'selected' : '' }}>Cerrada</option>
                                </select>
                            </div>
                        </div>


                        {{-- Descripción --}}
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <textarea id="descripcion"
                                          name="descripcion"
                                          class="form-control auto-expand @error('descripcion') is-invalid @enderror"
                                          maxlength="250"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this); this.style.height=''; this.style.height=this.scrollHeight + 'px';"
                                          required>{{ old('descripcion', $incidencia->descripcion ?? '') }}</textarea>
                            </div>
                            @error('descripcion')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Ubicación --}}
                        <div class="col-md-6">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <textarea id="ubicacion"
                                          name="ubicacion"
                                          class="form-control auto-expand @error('ubicacion') is-invalid @enderror"
                                          maxlength="150"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this); this.style.height=''; this.style.height=this.scrollHeight + 'px';"
                                          required>{{ old('ubicacion', $incidencia->ubicacion ?? '') }}</textarea>
                            </div>
                            @error('ubicacion')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Botones --}}
                    <div class="text-center mt-5 d-flex justify-content-center gap-3">
                        <a href="{{ route('incidencias.index') }}" class="btn btn-danger">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>

                        <a href="{{ route('incidencias.edit', $incidencia->id) }}"
                           class="btn btn-warning">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                        </a>

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
    // Función para auto expandir un textarea
    function autoExpand(field) {
        field.style.height = 'auto'; // Resetea la altura
        field.style.height = field.scrollHeight + 'px'; // Ajusta según contenido
    }

    // Al cargar la página, ajusta la altura inicial y agrega evento input
    window.addEventListener('DOMContentLoaded', () => {
        const textareas = document.querySelectorAll('textarea.auto-expand');
        textareas.forEach(el => {
            autoExpand(el); // Ajuste inicial
            el.addEventListener('input', () => autoExpand(el)); // Ajusta mientras escribes
        });
    });
</script>
{{-- Incluye tus scripts JS personalizados --}}

<script>

    document.getElementById('clienteInput').addEventListener('input', function () {
        if (this.value.trim() === '') {
            document.getElementById('cliente_id').value = '';
        }
    });

    document.getElementById('reportadoPorInput').addEventListener('input', function () {
        document.getElementById('reportado_por').value = '';
    });
    function soloLetras(e) {
        const key = e.key;
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]$/.test(key) && !['Backspace','Tab','ArrowLeft','ArrowRight','Delete'].includes(key)) {
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
</script>




<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

@endsection

