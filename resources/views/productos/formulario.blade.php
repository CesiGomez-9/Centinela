@extends('layouts.plantilla')
@section('titulo','Registrar un nuevo producto')
@section('content')

    <style>
        body {
            background-color: #e6f0ff;
            margin: 0;
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
                                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" maxlength="30" value="{{ old('nombre', $producto->nombre ?? '') }}" onkeypress="return soloLetras(event)" required>
                                </div>
                                @error('nombre')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="serie" class="form-label">Serie del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" name="serie" class="form-control @error('serie') is-invalid @enderror" maxlength="10" value="{{ old('serie', $producto->serie ?? '') }}" onkeypress="validarTexto(event)" required>
                                </div>
                                @error('serie')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="codigo" class="form-label">Código del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi-qr-code"></i></span>
                                    <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror"
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
                                        <input type="text" name="marca" class="form-control @error('marca') is-invalid @enderror" maxlength="30" value="{{ old('marca', $producto->marca ?? '') }}" onkeypress="return validarDescripcion(event)" required>
                                    </div>
                                    @error('marca')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>


                                    <div class="col-md-6">
                                        <label for="modelo" class="form-label">Modelo del producto</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi-cpu"></i></span>
                                            <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror" maxlength="30" value="{{ old('modelo', $producto->modelo ?? '') }}" onkeypress="return validarDescripcion(event)" required>
                                        </div>
                                        @error('modelo')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                        @enderror
                                    </div>


                                <div class="col-md-6">
                                <label for="categoria" class="form-label">Categoría</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                    <select name="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
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
                                <label for="iva" class="form-label">IVA</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                    <select name="iva" class="form-select @error('iva') is-invalid @enderror" required>
                                        <option value="">Seleccione una opción</option>
                                        @php
                                            $ivas = [
                                                'Exento',
                                                'No exento'
                                            ];
                                        @endphp
                                        @foreach ($ivas as $cat)
                                            <option value="{{ $cat }}" {{ old('iva', $producto->iva ?? '') === $cat ? 'selected' : '' }}>
                                                {{ $cat }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('iva')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 ">
                                <label for="descripcion" class="form-label">Descripción del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-earmark-text-fill"></i></span>
                                    <textarea name="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror" maxlength="255" onkeypress="return validarDescripcion(event)" required>{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
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

    <!-- Boton Limpiar -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const resetBtn = document.querySelector('button[type="reset"]');

            if (resetBtn) {
                resetBtn.addEventListener('click', function (e) {
                    e.preventDefault(); // evita el comportamiento por defecto del botón reset

                    const form = this.closest('form');
                    if (!form) return;

                    // Limpiar manualmente cada campo
                    form.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(el => {
                        el.value = '';
                    });

                    form.querySelectorAll('select').forEach(el => {
                        el.selectedIndex = 0;
                    });

                    // Remover clases de validación
                    form.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                        el.classList.remove('is-valid', 'is-invalid');
                    });

                    // Limpiar mensajes de error si hay
                    form.querySelectorAll('.text-danger').forEach(el => {
                        el.innerText = '';
                    });
                });
            }
        });
    </script>



    <!-- Validaciones JS -->
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

        function soloNumeros(e) {
            const permitidos = ['Backspace', 'ArrowLeft', 'ArrowRight', 'Delete'];
            if (/\d/.test(e.key) || permitidos.includes(e.key)) {
                return true;
            }
            if (e.key === '.' && !e.target.value.includes('.')) {
                return true;
            }
            e.preventDefault();
            return false;
        }

        document.addEventListener("DOMContentLoaded", function () {
            const codigoInput = document.querySelector('input[name="codigo"]');

            if (codigoInput) {
                codigoInput.addEventListener('keypress', function (e) {
                    const key = e.key;
                    const pos = this.selectionStart;

                    // Solo permite letras, números y guiones
                    const permitido = /^[A-Za-z0-9\-]$/;

                    // Si el primer carácter no es letra o número, se bloquea
                    if (pos === 0 && !/^[A-Za-z0-9]$/.test(key)) {
                        e.preventDefault();
                        return false;
                    }

                    // Si en cualquier posición se escribe algo no permitido, se bloquea
                    if (!permitido.test(key)) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
        });

        function validarTexto(e) {
            const key = e.keyCode || e.which;
            const tecla = String.fromCharCode(key);
            const input = e.target;

            // Evitar espacio al inicio
            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }

            // Evitar múltiples espacios seguidos
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

            // 1. Bloquear si primer carácter no es letra (solo letras al inicio)
            if (pos === 0 && !/^[A-Za-zÁÉÍÓÚáéíóúÑñ]$/.test(char)) {
                e.preventDefault();
                return false;
            }

            // 2. Bloquear espacio al inicio
            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }

            // 3. Bloquear espacios dobles
            if (key === 32) {
                const pos = input.selectionStart;
                if (input.value.charAt(pos - 1) === ' ') {
                    e.preventDefault();
                    return false;
                }
            }

            // Permitir resto de caracteres
            return true;
        }


    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
