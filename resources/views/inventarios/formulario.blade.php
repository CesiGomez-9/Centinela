@extends('layouts.plantilla')
@section('titulo','Registrar nuevo producto al inventario')
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
                        @isset($inventario)
                            Editar producto
                        @else
                            Registrar nuevo producto
                        @endisset
                    </h3>


                    <form method="POST" action="{{ isset($inventario) ? route('inventarios.update', $inventario->id) : route('inventarios.store') }}" novalidate>
                        @csrf
                        @isset($inventario)
                            @method('PUT')
                        @endisset

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="codigo" class="form-label">Código del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror" maxlength="10" value="{{ old('codigo', $inventario->codigo ?? '') }}" onkeypress="validarTexto(event)" required>
                                </div>
                                @error('codigo')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" maxlength="30" value="{{ old('nombre', $inventario->nombre ?? '') }}" onkeypress="return soloLetras(event)" required>
                                </div>
                                @error('nombre')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-123"></i></span>
                                    <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" min="1" max="999" maxlength="3" value="{{ old('cantidad', $inventario->cantidad ?? '') }}" required onkeypress="return soloNumeros(event)">
                                </div>
                                @error('cantidad')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="precio_unitario" class="form-label">Precio unitario</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                    <input type="text" name="precio_unitario" class="form-control @error('precio_unitario') is-invalid @enderror"  maxlength="9" inputmode="decimal"
                                           pattern="^\d{1,6}(\.\d{1,2})?$"
                                           value="{{ old('precio_unitario', $inventario->precio_unitario ?? '') }}"
                                           required oninput="validarPrecio(this)">
                                </div>
                                @error('precio_unitario')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-earmark-text-fill"></i></span>
                                    <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" maxlength="255" onkeypress="return validarDescripcion(event)" required>{{ old('descripcion', $inventario->descripcion ?? '') }}</textarea>
                                </div>
                                @error('descripcion')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <a href="{{ route('inventarios.index') }}" class="btn btn-danger me-2"
                               onclick="return confirm('¿Estás seguro que deseas cancelar? Se perderán los cambios no guardados.');">
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

        function limitarPrecio(input) {
            let valor = input.value.replace(/[^0-9.]/g, '');
            let partes = valor.split('.');
            if (partes[0].length > 6) partes[0] = partes[0].substring(0, 6);
            if (partes[1]) {
                partes[1] = partes[1].substring(0, 2);
                input.value = partes[0] + '.' + partes[1];
            } else {
                input.value = partes[0];
            }
        }

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

        // Limitar cantidad a 3 dígitos máximo (1 a 999)
        document.addEventListener("DOMContentLoaded", function () {
            const cantidadInput = document.querySelector('input[name="cantidad"]');

            if (cantidadInput) {
                cantidadInput.addEventListener('input', function () {
                    if (this.value.length > 3) {
                        this.value = this.value.slice(0, 3);
                    }

                    // Asegurarse de que sea máximo 999
                    if (parseInt(this.value) > 999) {
                        this.value = '999';
                    }
                });
            }
        });

            document.addEventListener("DOMContentLoaded", function () {
            const cantidadInput = document.querySelector('input[name="cantidad"]');

            if (cantidadInput) {
            cantidadInput.addEventListener('input', function () {
            // Evitar 0 inicial o valores mayores a 999
            let valor = this.value.replace(/^0+/, ''); // quita ceros a la izquierda

            if (parseInt(valor) > 999) valor = '999';
            this.value = valor;
                    });
                }
            });

        function validarPrecio(input) {
            let valor = input.value;

            // Quitar caracteres no permitidos (solo números y punto)
            valor = valor.replace(/[^\d.]/g, '');

            // Separar entero y decimal
            let partes = valor.split('.');

            // Limitar parte entera a 6 dígitos
            partes[0] = partes[0].substring(0, 6);

            // Limitar parte decimal a 2 dígitos
            if (partes[1]) {
                partes[1] = partes[1].substring(0, 2);
                valor = partes[0] + '.' + partes[1];
            } else {
                valor = partes[0];
            }

            // Si el valor es 0 o 0.00, forzar a vacío
            if (parseFloat(valor) === 0) {
                input.value = '';
            } else {
                input.value = valor;
            }
        }

        document.querySelector('input[name="codigo"]').addEventListener('input', function () {
            if (this.value.match(/^0+$/)) {
                this.value = '';
            }
        });


        function validarDescripcion(e) {
            const key   = e.keyCode || e.which;
            const char  = String.fromCharCode(key);
            const input = e.target;

            // 1. Bloquear '0' como primer carácter
            if (char === '0' && input.selectionStart === 0) {
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
