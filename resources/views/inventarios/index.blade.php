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

    <h1>Lista de Productos en Inventario
        @auth
            <a class="btn btn-success" href="{{ route('inventarios.create') }}">Nuevo Producto</a>
        @endauth
    </h1>

    @if(session()->has('status'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>¡Éxito! </strong>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
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
                <td>{{ $inventario->id }}</td>
                <td>{{ $inventario->codigo }}</td>
                <td>{{ $inventario->nombre }}</td>
                <td>{{ $inventario->cantidad }}</td>
                <td>L. {{ number_format($inventario->precio_unitario, 2) }}</td>
                <td>
                    <a href="{{ route('inventarios.show', $inventario->id) }}" class="btn btn-info btn-sm">Ver</a>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No hay productos en el inventario.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $inventarios->links() }}

@endsection

