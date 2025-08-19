@extends("plantilla")


@section('content')

    <style>
        body{
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }

    </style>
    @if(session('exito'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('exito') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if(session('fracaso'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('fracaso') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif


    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-people-fill me-2"></i>
                Lista de clientes
            </h3>

            <div class="row mb-4">
                <div class="col d-flex justify-content-start">
                    <div class="w-100" style="max-width: 400px;">
                        <div class="input-group">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                value="{{request('search')}}"
                                class="form-control"
                                placeholder="Buscar por nombre, identidad, departamento"
                            >
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-auto d-flex justify-content-end">
                    <a href="{{ route('Clientes.formulariocliente') }}" class="btn btn-sm btn-outline-primary mb-2">
                        <i class="bi bi-pencil-square me-2"></i>Registrar un nuevo cliente
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Identidad</th>
                    <th>Departamento</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($clientes as $cliente)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->apellido }}</td>
                        <td>{{ $cliente->identidad}}</td>
                        <td>{{ $cliente->departamento }}</td>
                        <td class="text-center">
                            <a href="{{ route('Clientes.detalleCliente', $cliente->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="{{ route('Clientes.edit', $cliente->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                <i class="bi bi-pencil-square"></i>Editar
                            </a>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No hay clientes registrados.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @if(request('search') && $clientes->total() > 0)
                <div class="mb-3 text-muted">
                    Mostrando {{ $clientes->count() }} de {{ $clientes->total() }} resultados encontrados para
                    "<strong>{{ request('search') }}</strong>".
                </div>
            @elseif(request('search') && $clientes->total() === 0)
                <div class="mb-3 text-danger">
                    No se encontraron resultados para "<strong>{{ request('search') }}</strong>".
                </div>
            @endif

            <div class="d-flex justify-content-center mt-4">
                {{ $clientes->links('pagination::bootstrap-5') }}


            </div>
        </div>
    </div>



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
                    url.searchParams.set('search', search); // ✅ deja espacios, los codifica automáticamente
                    url.searchParams.delete('page'); // ✅ reinicia a la página 1

                    window.location.href = url.toString();
                }, 750); // ⏱️ Espera 800ms para que puedas escribir tranquilo
            });
        });
    </script>





@endsection
