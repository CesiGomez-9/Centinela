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
            <th scope="col">Nombre de la empresa</th>
            <th scope="col">Direccion</th>
            <th scope="col">Telefono de la empresa</th>
            <th scope="col">Correo de la empresa</th>
            <th scope="col">Nombre del representante</th>
            <th scope="col">Identidad de respresentante</th>
            <th scope="col">Categoria o rubro</th>
        </tr>
        </thead>
        <tbody>
        @foreach($proveedores as $proveedor)
            <tr>
                <td>{{  $proveedor->nombreEmpresa  }}</td>
                <td>{{  $proveedor->direccion  }}</td>
                <td>{{  $proveedor->telefonodeempresa  }}</td>
                <td>{{  $proveedor->correoempresa  }}</td>
                <td>{{  $proveedor->nombrerepresentante }}</td>
                <td>{{  $proveedor->identificacion  }}</td>
                <td>{{  $proveedor->categoriarubro  }}</td>


            </tr>
        @endforeach
        </tbody>
    </table>



@endsection








