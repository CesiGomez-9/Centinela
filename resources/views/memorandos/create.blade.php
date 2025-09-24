@extends('plantilla')
@section('content')

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-file-earmark-text position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:4rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-journal-text me-2"></i>Crear un nuevo memorandum
            </h3>

            @if(session('success'))
                <div class="alert alert-success">¡Memorandum guardado correctamente!</div>
            @endif

            <form action="{{ route('memorandos.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Empleado:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <select name="destinatario_id" class="form-select @error('destinatario_id') is-invalid @enderror" required>
                                <option value="">Seleccione un empleado</option>
                                @foreach($destinatarios as $destinatario)
                                    <option value="{{ $destinatario->id }}" {{ old('destinatario_id') == $destinatario->id ? 'selected' : '' }}>
                                        {{ $destinatario->nombre }} {{ $destinatario->apellido }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('destinatario_id') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Autor:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                            <select name="autor_id" class="form-select @error('autor_id') is-invalid @enderror" required>
                                <option value="">Seleccione un empleado</option>
                                @foreach($autores as $autor)
                                    <option value="{{ $autor->id }}" {{ old('autor_id') == $autor->id ? 'selected' : '' }}>
                                        {{ $autor->nombre }} {{ $autor->apellido }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('autor_id') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Fecha de la incidencia:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
                            <input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                                   value="{{ old('fecha', date('Y-m-d')) }}">
                            <div class="invalid-feedback d-block" id="fechaError">@error('fecha') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tipo:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-exclamation-triangle-fill"></i></span>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="leve" {{ old('tipo') == 'leve' ? 'selected' : '' }}>Leve</option>
                                <option value="media" {{ old('tipo') == 'media' ? 'selected' : '' }}>Media</option>
                                <option value="grave" {{ old('tipo') == 'grave' ? 'selected' : '' }}>Grave</option>
                            </select>
                            <div class="invalid-feedback d-block" id="tipoError">@error('tipo') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Asunto:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                            <input type="text" id="titulo" name="titulo"
                                   class="form-control @error('titulo') is-invalid @enderror"
                                   value="{{ old('titulo') }}">
                            <div class="invalid-feedback d-block" id="tituloError">@error('titulo') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Motivo del memorandum:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pencil-fill"></i></span>
                            <textarea id="contenido" name="contenido"
                                      class="form-control @error('contenido') is-invalid @enderror"
                                      style="overflow:hidden; resize:none;">{{ old('contenido') }}</textarea>
                            <div class="invalid-feedback d-block" id="contenidoError">@error('contenido') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Sanción:</label>
                        <div class="input-group">
                            <span class="input-group-text text-dark"><i class="bi bi-hammer"></i></span>
                            <textarea id="sancion" name="sancion"
                                      class="form-control @error('sancion') is-invalid @enderror"
                                      style="overflow:hidden; resize:none;">{{ old('sancion') }}</textarea>
                        </div>
                        <div class="invalid-feedback d-block" id="sancionError">
                            @error('sancion') {{ $message }} @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Adjunto (opcional):</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-paperclip"></i></span>
                            <input type="file" name="adjunto" class="form-control @error('adjunto') is-invalid @enderror" accept=".pdf,.doc,.docx,.jpg,.png">
                            <div class="invalid-feedback">@error('adjunto') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Observaciones (opcional):</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-chat-left-text-fill"></i></span>
                            <textarea id="observaciones" name="observaciones" rows="2"
                                      class="form-control @error('observaciones') is-invalid @enderror"
                                      style="overflow:hidden; resize:none;">{{ old('observaciones') }}</textarea>
                            <div class="invalid-feedback d-block">@error('observaciones') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="text-center mt-4 col-12">
                        <a href="{{ route('memorandos.index') }}" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="reset" class="btn btn-warning me-2" id="btnLimpiar">
                            <i class="bi bi-eraser-fill me-2"></i>Limpiar
                        </button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-2"></i>Guardar</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        function limitarCaracteres(campoId, maxCaracteres) {
            const campo = document.getElementById(campoId);

            campo.addEventListener('input', function(e) {
                if (campo.value.length > maxCaracteres) {
                    campo.value = campo.value.slice(0, maxCaracteres);
                }
            });
        }

        limitarCaracteres("titulo", 100);
        limitarCaracteres("contenido", 250);
        limitarCaracteres("sancion", 250);
        limitarCaracteres("observaciones", 250);

        document.getElementById('btnLimpiar').addEventListener('click', function () {
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.textContent = '';
            });

            const alerta = document.querySelector('.alert');
            if (alerta) {
                alerta.remove();
            }
        });

        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        ['contenido', 'sancion', 'observaciones'].forEach(id => {
            const campo = document.getElementById(id);
            if (campo) {
                campo.addEventListener('input', () => autoResize(campo));
                autoResize(campo);
            }
        });

        document.getElementById('btnLimpiar').addEventListener('click', function () {
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });

            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.textContent = '';
            });

            const alerta = document.querySelector('.alert');
            if (alerta) {
                alerta.remove();
            }
        });

        document.getElementById('btnLimpiar').addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            const alerta = document.querySelector('.alert');
            if (alerta) alerta.remove();

            window.location.href = "{{ route('memorandos.create') }}";
        });
    </script>
    </body>
@endsection
