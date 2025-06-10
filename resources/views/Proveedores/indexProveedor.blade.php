@extends("plantilla")
@section('titulo', 'Proveedores')
@section('content')

    @if(session('exito'))
        <div class="alert alert-success" role="alert">
            {{ session('exito') }}
        </div>
    @endif
    @if(session('fracaso'))
        <div class="alert alert-danger" role="alert">
            {{ session('fracaso') }}
        </div>
    @endif

    <h1 style="font-family: 'Copperplate Gothic Light'">Proveedores</h1>


    <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
        <thead>
        <tr>
            <th scope="col">Nombres</th>
            <th scope="col">Apellidos</th>
            <th scope="col">Direccion</th>
            <th scope="col">Telefono</th>
            <th scope="col">Correo</th>
            <th scope="col">Identidad</th>
            <th scope="col">Cargo de contacto</th>
            <th scope="col">Categoria o rubro</th>
        </tr>
        </thead>
        <tbody>
        @foreach($proveedores as $proveedor)
            <tr>
                <td>{{  $proveedor->nombres  }}</td>
                <td>{{  $proveedor->apellidos  }}</td>
                <td>{{  $proveedor->direccion  }}</td>
                <td>{{  $proveedor->telefono  }}</td>
                <td>{{  $proveedor->correo  }}</td>
                <td>{{  $proveedor->identificacion  }}</td>
                <td>{{  $proveedor->cargocontacto  }}</td>
                <td>{{  $proveedor->categoriarubro  }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>



@endsection








