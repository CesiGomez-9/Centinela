@extends("plantilla")
@section('titulo', 'Asistencias')

@section('content')
    <style>
        body {
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }

         .btn-outline-custom {
             border: 2px solid #09457f; /* borde azul */
             background-color: transparent; /* transparente por defecto */
             color: #09457f; /* texto azul */
             font-weight: bold;
             transition: all 0.3s ease;
         }

        .btn-outline-custom:hover {
            background-color: #09457f; /* fondo azul al pasar el cursor */
            color: white; /* texto blanco cuando el fondo es azul */
        }
    </style>

    @if(session('exito'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('exito') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-journal-check me-2"></i>
                Lista de asistencias
            </h3>

            <div class="row mb-4">
                <div class="col d-flex justify-content-between align-items-center">
                    <!-- Buscador a la izquierda -->
                    <div style="max-width: 400px; width: 100%;">
                        <div class="input-group">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Buscar por nombre, apellido, identidad"
                            >
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>

                    <!-- Botón a la derecha -->
                    <a href="{{ route('asistencias.crear') }}" class="btn btn-md btn-outline-primary mb-2">
                        <i class="bi bi-arrow-left-circle me-1"></i>Control de asistencia
                    </a>
                </div>
            </div>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Identidad</th>
                    <th>Tipo de Turno</th>
                    <th>Hora de entrada</th>
                    <th>Hora de salida</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($asistencias as $asistencia)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $asistencia->nombre }}</td>
                        <td>{{ $asistencia->apellido }}</td>
                        <td>{{ $asistencia->identidad }}</td>
                        <td>{{ $asistencia->turno ? $asistencia->turno->tipo_turno : 'Sin turno' }}</td>
                        <td>{{ $asistencia->hora_entrada ? $asistencia->hora_entrada->format('H:i:s') : '-' }}</td>
                        <td>{{ $asistencia->hora_salida ? $asistencia->hora_salida->format('H:i:s') : 'No marcada' }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-4">
                {{ $asistencias->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');

            if (searchInput.value !== '') {
                searchInput.focus();
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }

            let timeout = null;

            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    const search = this.value.trim();
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', search);
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                }, 750);
            });
        });
    </script>
@endsection
