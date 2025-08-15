@extends('plantilla')
@section('titulo','Registrar un nuevo producto')
@section('content')

    <style>
        body {
            background-color: #e6f0ff;
            margin: 0;
        }
        .form-label, .form-control, .form-select, .input-group-text, .text-danger, .small {
            font-size: 0.875rem;
        }
        h3 {
            font-size: 1.5rem;
        }
    </style>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-white p-5 rounded shadow-lg position-relative">

                    <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                        <i class="bi bi-box-seam" style="font-size: 4rem;"></i>
                    </div>

                    <h3 class="text-center mb-4" style="color: #09457f;">
                        <i class="bi bi-boxes me-2"></i>
                        @isset($producto)
                            Editar un producto
                        @else
                            Registrar un nuevo producto
                        @endisset
                    </h3>


                    <form method="POST" action="{{ isset($producto) ? route('productos.update', $producto->id) : route('productos.store') }}" novalidate>
                        @csrf
                        @isset($producto)
                            @method('PUT')
                        @endisset

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" maxlength="30" value="{{ old('nombre', $producto->nombre ?? '') }}" onkeypress="return soloLetras(event)" required>
                                </div>
                                @error('nombre')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="serie" class="form-label">Serie del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" name="serie" id="serie" class="form-control @error('serie') is-invalid @enderror" maxlength="10" value="{{ old('serie', $producto->serie ?? '') }}" onkeypress="validarTexto(event)" required>
                                </div>
                                @error('serie')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="codigo" class="form-label">Código del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi-qr-code"></i></span>
                                    <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror"
                                           maxlength="10" value="{{ old('codigo', $producto->codigo ?? '') }}"
                                           onkeypress="validarTexto(event)" required>
                                </div>
                                @error('codigo')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="marca" class="form-label">Marca del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                    <input type="text" name="marca" id="marca" class="form-control @error('marca') is-invalid @enderror" maxlength="30" value="{{ old('marca', $producto->marca ?? '') }}" onkeypress="return validarDescripcion(event)" required>
                                </div>
                                @error('marca')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6">
                                <label for="modelo" class="form-label">Modelo del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi-cpu"></i></span>
                                    <input type="text" name="modelo" id="modelo" class="form-control @error('modelo') is-invalid @enderror" maxlength="30" value="{{ old('modelo', $producto->modelo ?? '') }}"
                                           onkeypress="return validarDescripcion(event)" required>
                                </div>
                                @error('modelo')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="categoria" class="form-label">Categoría</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                    <select name="categoria" id="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
                                        <option value="">Seleccione una opción</option>
                                        @php
                                            $categorias = [
                                                'Cámaras de seguridad',
                                                'Alarmas antirrobo',
                                                'Cerraduras inteligentes',
                                                'Sensores de movimiento',
                                                'Luces con sensor de movimiento',
                                                'Rejas o puertas de seguridad',
                                                'Sistema de monitoreo 24/7',
                                                'Implementos de seguridad',
                                            ];
                                        @endphp
                                        @foreach ($categorias as $cat)
                                            <option value="{{ $cat }}" {{ old('categoria', $producto->categoria ?? '') === $cat ? 'selected' : '' }}>
                                                {{ $cat }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="impuesto_id" class="form-label">Tipo de Impuesto</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-percent"></i></span>
                                    <select name="impuesto_id" id="impuesto_id" class="form-select @error('impuesto_id') is-invalid @enderror" required>
                                        <option value="">Seleccione una opción</option>
                                        {{-- $impuestos viene del controlador --}}
                                        @foreach($impuestos as $impuesto)
                                            <option value="{{ $impuesto->id }}"
                                                {{ old('impuesto_id', $producto->impuesto_id ?? '') == $impuesto->id ? 'selected' : '' }}>
                                                {{ $impuesto->nombre }} ({{ $impuesto->porcentaje }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('impuesto_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 ">
                                <label for="descripcion" class="form-label">Descripción del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-earmark-text-fill"></i></span>
                                    <textarea name="descripcion" id="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror" maxlength="255" onkeypress="return validarDescripcion(event)" required>{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                                </div>
                                @error('descripcion')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="text-center mt-5">
                            <a href="{{ route('productos.index') }}" class="btn btn-danger me-2">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>

                            <button type="reset" class="btn btn-warning me-2">
                                <i class="bi bi-eraser-fill me-2"></i> Limpiar
                            </button>

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
            const resetBtn = document.querySelector('button[type="reset"]');

            if (resetBtn) {
                resetBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const form = this.closest('form');
                    if (!form) return;
                    form.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(el => {
                        el.value = '';
                    });
                    form.querySelectorAll('select').forEach(el => {
                        el.selectedIndex = 0;
                    });
                    form.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                        el.classList.remove('is-valid', 'is-invalid');
                    });
                    form.querySelectorAll('.text-danger, .invalid-feedback').forEach(el => {
                        el.innerText = '';
                    });
                });
            }
        });
    </script>

    <script>
        function soloLetras(e) {
            let key = e.keyCode || e.which;
            let tecla = String.fromCharCode(key).toLowerCase();
            let letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            let especiales = [8, 37, 39, 46];
            let input = e.target;

            if (tecla === '.' || tecla === "'" || (letras.indexOf(tecla) === -1 && !especiales.includes(key))) {
                e.preventDefault();
                return false;
            }

            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }

            if (key === 32) {
                const valor = input.value;
                const pos = input.selectionStart;
                if (valor.charAt(pos - 1) === ' ') {
                    e.preventDefault();
                    return false;
                }
            }
            return true;
        }

        function validarTexto(e) {
            const key = e.keyCode || e.which;
            const tecla = String.fromCharCode(key);
            const input = e.target;
            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }
            const pos = input.selectionStart;
            if (key === 32 && input.value.charAt(pos - 1) === ' ') {
                e.preventDefault();
                return false;
            }

            return true;
        }

        document.querySelector('input[name="codigo"]').addEventListener('input', function () {
            if (this.value.match(/^0+$/)) {
                this.value = '';
            }
        });

        document.querySelector('input[name="serie"]').addEventListener('input', function () {
            if (this.value.match(/^0+$/)) {
                this.value = '';
            }
        });

        function validarDescripcion(e) {
            const key   = e.keyCode || e.which;
            const char  = String.fromCharCode(key);
            const input = e.target;
            const pos   = input.selectionStart;
            if (pos === 0 && !/^[A-Za-zÁÉÍÓÚáéíóúÑñ]$/.test(char)) {
                e.preventDefault();
                return false;
            }
            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }
            if (key === 32) {
                const pos = input.selectionStart;
                if (input.value.charAt(pos - 1) === ' ') {
                    e.preventDefault();
                    return false;
                }
            }
            return true;
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
