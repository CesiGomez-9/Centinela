@extends('layouts.plantilla')
@section('titulo', 'Lista de inventarios')
@section('content')

    <style>
        table {
            width: 100%;
            border-collapse: collapse;

        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #090909;
            text-align: center;
        }

    </style>

    <h1 class="text-center mb-4" style="color: #09457f;">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <i class="bi bi-boxes me-2"></i>Lista de inventarios
    </h1>



    <!-- Botón de volver y buscador -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form id="formBuscar" action="{{ route('inventarios.index') }}" method="GET" class="d-flex flex-column flex-md-row align-items-center gap-2" style="max-width: 100%;">
            <div class="input-group" style="max-width: 350px;">
                <input type="text" id="campoBuscar" name="search" class="form-control" placeholder="Buscar por nombre..." maxlength="30" value="{{ request('search') }}"
                       onkeydown="bloquearEspacioAlInicio(event, this)"
                       oninput="eliminarEspaciosIniciales(this)">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
                <!-- Botón refrescar -->
                <a href="{{ route('inventarios.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>

        <!-- Botón nuevo producto -->
        <a href="{{ route('inventarios.create') }}" class="btn btn-outline-primary btn-md">
            <i class="bi bi-pencil-square me-2"></i>Registrar un nuevo producto
        </a>
    </div>


    @if(session()->has('status'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong></strong>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif



    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
            <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @forelse($inventarios as $inventario)
            <tr>

                <td>{{ $inventario->codigo }}</td>
                <td>{{ $inventario->nombre }}</td>
                <td>{{ $inventario->cantidad }}</td>
                <td>Lps. {{ number_format($inventario->precio_unitario, 2) }}</td>
                <td>
                    <a href="{{ route('inventarios.show', $inventario->id) }}" class="btn btn-info btn-sm">Ver</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No hay productos en el inventario.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const error = document.getElementById('error-search');

        // Regex: letras y espacios, sin espacios dobles
        const regex = /^[A-Za-z]+(?: [A-Za-z]+)*$/;
        // Explicación: una o más letras, seguido opcionalmente por bloques de un espacio + letras

        searchForm.addEventListener('submit', function (e) {
            const value = searchInput.value.trim();

            // Validar longitud máxima aquí también
            if (value.length > 25 || !regex.test(value)) {
                e.preventDefault();
                error.classList.remove('d-none');
                searchInput.classList.add('is-invalid');
            } else {
                error.classList.add('d-none');
                searchInput.classList.remove('is-invalid');
            }
        });

        searchInput.addEventListener('input', function () {
            let val = this.value;
            val = val.replace(/[^A-Za-z ]/g, '');
            while (val.includes('  ')) {
                val = val.replace(/  /g, ' ');
            }
            if (val.length > 25) {
                val = val.slice(0, 25);
            }

            this.value = val;
            if (regex.test(val.trim())) {
                error.classList.add('d-none');
                this.classList.remove('is-invalid');
            }
        });

        function bloquearEspacioAlInicio(e, input) {
            if (e.key === ' ' && input.selectionStart === 0) {
                e.preventDefault();
            }
        }

        function eliminarEspaciosIniciales(input) {
            input.value = input.value.replace(/^\s+/, '');
        }
    </script>



    {{ $inventarios->links() }}
@endsection

