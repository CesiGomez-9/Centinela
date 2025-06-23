@extends("plantilla")
@section('titulo', 'Proveedores')

@section('content')
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

    <div style="
   background-image: url('{{ asset('seguridad/fondolino.png') }}');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    padding: 40px;
    border-radius: 15px;
">
            <div class="card shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center"
                     style="background-color:#4682b4; font-family: 'Lora';">
                    <h4 class="mb-0 text-dark">Proveedores</h4>

                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light text-center">
                            <tr>
                                <th>Nombre de la empresa</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Representante</th>
                                <th>Identificación</th>
                                <th>Categoría o rubro</th>
                            </tr>
                            </thead>
                            <tbody class="text-center align-middle">
                            @forelse($proveedores as $proveedor)
                                <tr>
                                    <td>{{ $proveedor->nombreEmpresa }}</td>
                                    <td>{{ $proveedor->direccion }}</td>
                                    <td>{{ $proveedor->telefonodeempresa }}</td>
                                    <td>{{ $proveedor->correoempresa }}</td>
                                    <td>{{ $proveedor->nombrerepresentante }}</td>
                                    <td>{{ $proveedor->identificacion }}</td>
                                    <td>{{ $proveedor->categoriarubro }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-muted">No hay proveedores registrados.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

@endsection









