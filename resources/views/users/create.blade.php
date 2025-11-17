@extends('plantilla')
@section('content')

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-person-badge position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:4rem;"></i>
            <div class="position-relative mb-4" style="padding-top: 5px;">

                <!-- BOTÓN A LA IZQUIERDA -->
                <button type="button"
                        class="btn btn-sm btn-outline-primary position-absolute"
                        style="top: 0; left: 0; transform: translateY(2px);">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
                </button>

                <!-- TÍTULO CENTRADO -->
                <h3 class="text-center m-0" style="color:#09457f; line-height:1;">
                    <i class="bi bi-person-fill me-2"></i>
                    @isset($user) Editar usuario @else Registrar usuario @endisset
                </h3>

            </div>


        @if(session('guardado'))
                <div class="alert alert-success">¡Usuario guardado correctamente!</div>
            @endif
            <form method="POST" action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" id="userForm" novalidate>
                @csrf
                @isset($user) @method('PUT') @endisset

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" id="name" name="name" maxlength="50"
                                   value="{{ old('name', $user->name ?? '') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   oninput="validarTexto(this,50)" />
                            <div class="invalid-feedback">@error('name') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Apellido:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" id="apellido" name="apellido" maxlength="50"
                                   value="{{ old('apellido', $user->apellido ?? '') }}"
                                   class="form-control @error('apellido') is-invalid @enderror"
                                   oninput="validarTexto(this,50)" />
                            <div class="invalid-feedback">@error('apellido') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Usuario:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" id="apellido" name="apellido" maxlength="50"
                                   value="{{ old('apellido', $user->apellido ?? '') }}"
                                   class="form-control @error('apellido') is-invalid @enderror"
                                   oninput="validarTexto(this,50)" />
                            <div class="invalid-feedback">@error('apellido') {{ $message }} @enderror</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Teléfono:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                            <input type="text" id="telefono" name="telefono" maxlength="8"
                                   value="{{ old('telefono') }}"
                                   class="form-control @error('telefono') is-invalid @enderror"
                                   oninput="formatearTelefono(this)" />
                            <div class="invalid-feedback">@error('telefono') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Correo electrónico:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" id="email" name="email" maxlength="50"
                                   value="{{ old('email', $user->email ?? '') }}"
                                   class="form-control @error('email') is-invalid @enderror" />
                            <div class="invalid-feedback" id="emailError">
                                @error('email') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Contraseña:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="password" name="password" maxlength="50"
                                   class="form-control @error('password') is-invalid @enderror"
                                   value="{{ old('password') }}"
                                   @isset($user) placeholder="Dejar vacío si no desea cambiar" @endisset />

                            <div class="invalid-feedback" id="passwordError">
                                @error('password') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Confirmar contraseña:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="password" name="password" maxlength="50"
                                   class="form-control @error('password') is-invalid @enderror"
                                   value="{{ old('password') }}"
                                   @isset($user) placeholder="Dejar vacío si no desea cambiar" @endisset />

                            <div class="invalid-feedback" id="passwordError">
                                @error('password') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>


                    <div class="text-center mt-4 col-12">
                        <a href="{{ route('users.index') }}" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="reset" class="btn btn-warning me-2"><i class="bi bi-eraser-fill me-2"></i>Limpiar</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-2"></i>Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validarTexto(input, max) {
            input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s.,\-]/g, '')
                .replace(/\s+/g,' ')
                .slice(0, max);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const formulario = document.getElementById('userForm');

            formulario.addEventListener('reset', function () {
                setTimeout(() => {
                    const campos = formulario.querySelectorAll('input');
                    campos.forEach(campo => {
                        if (campo.type !== 'hidden' && campo.name !== '_token') {
                            campo.value = '';
                            campo.classList.remove('is-invalid');
                        }
                    });
                }, 10);
            });
        });
    </script>
@endsection

