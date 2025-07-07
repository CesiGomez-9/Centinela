@extends('plantilla')
@section('content')
    <!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Proveedor</title>
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
                    <i class="bi bi-person-plus-fill me-2"></i> Editar los datos del proveedor
                </h3>

                <form action="{{ route('Proveedores.update', $proveedor->id) }}" method="POST" id="form-proveedor" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Nombre Empresa --}}
                        <div class="col-md-6">
                            <label for="nombreEmpresa" class="form-label">Nombre de la empresa</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="nombreEmpresa"
                                       class="form-control @error('nombreEmpresa') is-invalid @enderror"
                                       value="{{ old('nombreEmpresa', $proveedor->nombreEmpresa) }}"
                                       maxlength="50" onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this); this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                                       required>
                                @error('nombreEmpresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Dirección --}}
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <textarea name="direccion"
                                          class="form-control @error('direccion') is-invalid @enderror"
                                          maxlength="250"
                                          style="resize: none; height: 38px;"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this)">{{ old('direccion', $proveedor->direccion) }}</textarea>
                                @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Teléfono empresa --}}
                        <div class="col-md-6">
                            <label for="telefonodeempresa" class="form-label">Teléfono de la empresa</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="text" name="telefonodeempresa"
                                       class="form-control @error('telefonodeempresa') is-invalid @enderror"
                                       value="{{ old('telefonodeempresa', $proveedor->telefonodeempresa) }}"
                                       maxlength="8" onkeypress="soloNumeros(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this); this.value = this.value.replace(/[^0-9]/g, '')"
                                       required>
                                @error('telefonodeempresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Correo --}}
                        <div class="col-md-6">
                            <label for="correoempresa" class="form-label">Correo Electrónico</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" name="correoempresa"
                                       class="form-control @error('correoempresa') is-invalid @enderror"
                                       value="{{ old('correoempresa', $proveedor->correoempresa) }}"
                                       maxlength="100"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                                @error('correoempresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Nombre representante --}}
                        <div class="col-md-6">
                            <label for="nombrerepresentante" class="form-label">Nombre del representante</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="nombrerepresentante"
                                       class="form-control @error('nombrerepresentante') is-invalid @enderror"
                                       value="{{ old('nombrerepresentante', $proveedor->nombrerepresentante) }}"
                                       maxlength="50" onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this); this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                                       required>
                                @error('nombrerepresentante')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Teléfono representante --}}
                        <div class="col-md-6">
                            <label for="telefonoderepresentante" class="form-label">Teléfono del representante</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="text" name="telefonoderepresentante"
                                       class="form-control @error('telefonoderepresentante') is-invalid @enderror"
                                       value="{{ old('telefonoderepresentante', $proveedor->telefonoderepresentante) }}"
                                       maxlength="8" onkeypress="soloNumeros(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this); this.value = this.value.replace(/[^0-9]/g, '')"
                                       required>
                                @error('telefonoderepresentante')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Rubro --}}
                        <div class="col-md-6">
                            <label for="categoriarubro" class="form-label">Categoría o rubro</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                <select name="categoriarubro" class="form-select @error('categoriarubro') is-invalid @enderror" required>
                                    <option value="">Seleccione una opción</option>
                                    @foreach([
                                        'Cámaras de seguridad',
                                        'Alarmas antirrobo',
                                        'Cerraduras inteligentes',
                                        'Sensores de movimiento',
                                        'Luces con sensor de movimiento',
                                        'Rejas o puertas de seguridad',
                                        'Sistema de monitoreo 24/7',
                                        'Otros'
                                    ] as $categoria)
                                        <option value="{{ $categoria }}" {{ old('categoriarubro', $proveedor->categoriarubro) == $categoria ? 'selected' : '' }}>
                                            {{ $categoria }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoriarubro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <select name="departamento" class="form-select @error('departamento') is-invalid @enderror" required>
                                    <option value="">Seleccione un departamento</option>
                                    <option value="Atlántida" {{ (old('departamento', $proveedor->departamento) == 'Atlántida') ? 'selected' : '' }}>Atlántida</option>
                                    <option value="Choluteca" {{ (old('departamento', $proveedor->departamento) == 'Choluteca') ? 'selected' : '' }}>Choluteca</option>
                                    <option value="Colón" {{ (old('departamento', $proveedor->departamento) == 'Colón') ? 'selected' : '' }}>Colón</option>
                                    <option value="Comayagua" {{ (old('departamento', $proveedor->departamento) == 'Comayagua') ? 'selected' : '' }}>Comayagua</option>
                                    <option value="Copán" {{ (old('departamento', $proveedor->departamento) == 'Copán') ? 'selected' : '' }}>Copán</option>
                                    <option value="Cortés" {{ (old('departamento', $proveedor->departamento) == 'Cortés') ? 'selected' : '' }}>Cortés</option>
                                    <option value="El Paraíso" {{ (old('departamento', $proveedor->departamento) == 'El Paraíso') ? 'selected' : '' }}>El Paraíso</option>
                                    <option value="Francisco Morazán" {{ (old('departamento', $proveedor->departamento) == 'Francisco Morazán') ? 'selected' : '' }}>Francisco Morazán</option>
                                    <option value="Gracias a Dios" {{ (old('departamento', $proveedor->departamento) == 'Gracias a Dios') ? 'selected' : '' }}>Gracias a Dios</option>
                                    <option value="Intibucá" {{ (old('departamento', $proveedor->departamento) == 'Intibucá') ? 'selected' : '' }}>Intibucá</option>
                                    <option value="Islas de la Bahía" {{ (old('departamento', $proveedor->departamento) == 'Islas de la Bahía') ? 'selected' : '' }}>Islas de la Bahía</option>
                                    <option value="La Paz" {{ (old('departamento', $proveedor->departamento) == 'La Paz') ? 'selected' : '' }}>La Paz</option>
                                    <option value="Lempira" {{ (old('departamento', $proveedor->departamento) == 'Lempira') ? 'selected' : '' }}>Lempira</option>
                                    <option value="Ocotepeque" {{ (old('departamento', $proveedor->departamento) == 'Ocotepeque') ? 'selected' : '' }}>Ocotepeque</option>
                                    <option value="Olancho" {{ (old('departamento', $proveedor->departamento) == 'Olancho') ? 'selected' : '' }}>Olancho</option>
                                    <option value="Santa Bárbara" {{ (old('departamento', $proveedor->departamento) == 'Santa Bárbara') ? 'selected' : '' }}>Santa Bárbara</option>
                                    <option value="Valle" {{ (old('departamento', $proveedor->departamento) == 'Valle') ? 'selected' : '' }}>Valle</option>
                                    <option value="Yoro" {{ (old('departamento', $proveedor->departamento) == 'Yoro') ? 'selected' : '' }}>Yoro</option>
                                </select>
                                @error('departamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- Botones --}}
                    <div class="text-center mt-5 d-flex justify-content-center gap-3">
                        <a href="{{ route('Proveedores.indexProveedor') }}" class="btn btn-danger">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>
                        <a href="{{ route('Proveedores.edit', $proveedor->id) }}"
                           class="btn btn-warning">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i> Guardar Cambios
                        </button>
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

