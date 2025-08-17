@extends('plantilla')
@section('content')


    <!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Cliente</title>
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
                    <i class="bi bi-person-plus-fill me-2"></i> Registrar un cliente
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
                <form action="{{ route('Clientes.update', $cliente->id) }}" method="POST" id="form-cliente" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Nombre --}}
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre', $cliente->nombre) }}"
                                       maxlength="50"
                                       onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this); this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                                       required>
                                @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Apellido --}}
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="apellido"
                                       class="form-control @error('apellido') is-invalid @enderror"
                                       value="{{ old('apellido', $cliente->apellido) }}"
                                       maxlength="50"
                                       onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this); this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                                       required>
                                @error('apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Identidad --}}
                        <div class="col-md-6">
                            <label for="identidad" class="form-label">Identidad</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
                                <input type="text" id="identidad" name="identidad" maxlength="13"
                                       value="{{ old('identidad', $cliente->identidad) }}"
                                       class="form-control @error('identidad') is-invalid @enderror"
                                       oninput="formatearIdentidad(this)">
                                @error('identidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="errorIdentidad" class="invalid-feedback"></div>
                            </div>
                        </div>

                        {{-- Correo --}}
                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" name="correo"
                                       class="form-control @error('correo') is-invalid @enderror"
                                       value="{{ old('correo', $cliente->correo) }}"
                                       maxlength="50"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                                @error('correo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Teléfono --}}
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="text" name="telefono"
                                       class="form-control @error('telefono') is-invalid @enderror"
                                       value="{{ old('telefono', $cliente->telefono) }}"
                                       maxlength="8"
                                       onkeypress="soloNumeros(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this); this.value = this.value.replace(/[^0-9]/g, '')"
                                       required>
                                @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Departamento --}}
                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <select name="departamento" class="form-select @error('departamento') is-invalid @enderror">
                                    <option value="">Seleccione un departamento</option>
                                    @foreach([
                                        'Atlántida','Choluteca','Colón','Comayagua','Copán','Cortés','El Paraíso',
                                        'Francisco Morazán','Gracias a Dios','Intibucá','Islas de la Bahía','La Paz',
                                        'Lempira','Ocotepeque','Olancho','Santa Bárbara','Valle','Yoro'
                                    ] as $dep)
                                        <option value="{{ $dep }}" {{ old('departamento', $cliente->departamento) == $dep ? 'selected' : '' }}>{{ $dep }}</option>
                                    @endforeach
                                </select>
                                @error('departamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Dirección --}}
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <textarea name="direccion" id="direccion"
                                          class="form-control @error('direccion') is-invalid @enderror"
                                          maxlength="250"
                                          style="resize: none; overflow: hidden;"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this); autoExpand(this);"
                                >{{ old('direccion', $cliente->direccion) }}</textarea>
                                @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Sexo --}}
                        <div class="col-md-6">
                            <label for="sexo" class="form-label">Sexo</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                <select name="sexo" id="sexo" class="form-select @error('sexo') is-invalid @enderror">
                                    <option value="">Seleccione su sexo</option>
                                    <option value="Hombre" {{ old('sexo', $cliente->sexo) == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                                    <option value="Mujer" {{ old('sexo', $cliente->sexo) == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                                    <option value="Otros" {{ old('sexo', $cliente->sexo) == 'Otros' ? 'selected' : '' }}>Otros</option>
                                </select>
                                @error('sexo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="text-center mt-5 d-flex justify-content-center gap-3">
                            <a href="{{ route('Clientes.indexCliente') }}" class="btn btn-danger">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>
                            <a href="{{ route('Clientes.edit', $cliente->id) }}"
                               class="btn btn-warning">
                                <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save-fill me-2"></i> Guardar cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Incluye tus scripts JS personalizados --}}
@push('scripts')
    <script>
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
@endpush

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

@endsection

