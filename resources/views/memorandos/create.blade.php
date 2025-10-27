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

            <form id="memorandoForm" action="{{ route('memorandos.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="destinatarioInput" class="form-label fw-bold">Empleado Sancionado:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text"
                                   id="destinatarioInput"
                                   name="destinatario_nombre"
                                   class="form-control @error('destinatario_id') is-invalid @enderror"
                                   placeholder="Buscar empleado..."
                                   autocomplete="off"
                                   value="{{ old('destinatario_nombre', $destinatarioSeleccionado ?? '') }}">
                            <input type="hidden" name="destinatario_id" id="destinatario_id" value="{{ old('destinatario_id') }}">
                        </div>
                        <div class="invalid-feedback d-block">@error('destinatario_id') {{ $message }} @enderror</div>
                        <div id="destinatarioResults" class="list-group" style="max-height:200px; overflow-y:auto;"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="autorInput" class="form-label fw-bold">Creador del memorandum:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text"
                                   id="autorInput"
                                   name="autor_nombre"
                                   class="form-control @error('autor_id') is-invalid @enderror"
                                   placeholder="Buscar empleado..."
                                   autocomplete="off"
                                   value="{{ old('autor_nombre', $autorSeleccionado ?? '') }}">
                            <input type="hidden" name="autor_id" id="autor_id" value="{{ old('autor_id') }}">
                        </div>
                        <div class="invalid-feedback d-block">@error('autor_id') {{ $message }} @enderror</div>
                        <div id="autorResults" class="list-group" style="max-height:200px; overflow-y:auto;"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Fecha de la incidencia:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
                            <input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                                   value="{{ old('fecha') }}">
                        </div>
                        <div class="invalid-feedback d-block">@error('fecha') {{ $message }} @enderror</div>
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
                        </div>
                        <div class="invalid-feedback d-block">@error('tipo') {{ $message }} @enderror</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Asunto:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                            <input type="text" id="titulo" name="titulo"
                                   class="form-control @error('titulo') is-invalid @enderror"
                                   value="{{ old('titulo') }}">
                        </div>
                        <div class="invalid-feedback d-block">@error('titulo') {{ $message }} @enderror</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Motivo del memorandum:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pencil-fill"></i></span>
                            <textarea id="contenido" name="contenido"
                                      class="form-control @error('contenido') is-invalid @enderror"
                                      style="overflow:hidden; resize:none;">{{ old('contenido') }}</textarea>
                        </div>
                        <div class="invalid-feedback d-block">@error('contenido') {{ $message }} @enderror</div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Sanción:</label>
                        <div class="input-group">
                            <span class="input-group-text text-dark"><i class="bi bi-hammer"></i></span>
                            <textarea id="sancion" name="sancion"
                                      class="form-control @error('sancion') is-invalid @enderror"
                                      style="overflow:hidden; resize:none;">{{ old('sancion') }}</textarea>
                        </div>
                        <div class="invalid-feedback d-block">@error('sancion') {{ $message }} @enderror</div>
                    </div>

                    <div class="col-md-12">
                        <label for="adjuntoInput" class="form-label fw-bold">
                            <i class="bi bi-paperclip me-2"></i>Adjunto (opcional):
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-paperclip"></i></span>
                            @if (old('base64_adjunto'))
                                <div id="persistedFileDisplay" class="form-control text-muted d-flex align-items-center bg-light">
                                    {{ old('old_file_name', 'Archivo cargado') }}
                                </div>

                                <input type="file" name="adjunto" id="adjuntoInput" style="display:none;"
                                       class="form-control @error('adjunto') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                            @else
                                <input type="file" name="adjunto" id="adjuntoInput"
                                       class="form-control @error('adjunto') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png,.pdf">
                                <div id="persistedFileDisplay" class="form-control text-muted d-flex align-items-center bg-light" style="display:none;">
                                </div>
                            @endif
                        </div>
                        <div class="invalid-feedback d-block">@error('adjunto') {{ $message }} @enderror</div>
                    </div>

                    <input type="hidden" name="base64_adjunto" id="base64Adjunto" value="{{ old('base64_adjunto') }}">
                    <input type="hidden" name="old_file_name" id="oldFileName" value="{{ old('old_file_name') }}">

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Observaciones (opcional):</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-chat-left-text-fill"></i></span>
                            <textarea id="observaciones" name="observaciones" rows="2"
                                      class="form-control @error('observaciones') is-invalid @enderror"
                                      style="overflow:hidden; resize:none;">{{ old('observaciones') }}</textarea>
                        </div>
                        <div class="invalid-feedback d-block">@error('observaciones') {{ $message }} @enderror</div>
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
            campo.addEventListener('input', function() {
                if (campo.value.length > maxCaracteres) {
                    campo.value = campo.value.slice(0, maxCaracteres);
                }
            });
        }
        ['titulo','contenido','sancion','observaciones'].forEach(id => limitarCaracteres(id, id==='titulo'?100:250));

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

        function getFechaLocal() {
            const hoy = new Date();
            const year = hoy.getFullYear();
            const month = String(hoy.getMonth() + 1).padStart(2, '0');
            const day = String(hoy.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        const hoyStr = getFechaLocal();
        const fechaInput = document.getElementById('fecha');
        const adjuntoInput = document.getElementById('adjuntoInput');
        const base64AdjuntoInput = document.getElementById('base64Adjunto');
        const oldFileNameInput = document.getElementById('oldFileName');
        const persistedFileDisplay = document.getElementById('persistedFileDisplay');

        let tempAdjuntoData = "{{ old('base64_adjunto') }}";
        let tempFileName = "{{ old('old_file_name') }}";

        if (!fechaInput.value && !fechaInput.classList.contains('is-invalid')) {
            fechaInput.value = hoyStr;
        }


        function actualizarVistaAdjunto() {

            if (tempAdjuntoData) {
                if(persistedFileDisplay) {
                    persistedFileDisplay.style.display = 'flex';
                    persistedFileDisplay.textContent = tempFileName || 'Archivo cargado';
                }
                if(adjuntoInput) adjuntoInput.style.display = 'none';
                if(adjuntoInput) adjuntoInput.classList.remove('is-invalid');
            } else {

                if(adjuntoInput) adjuntoInput.style.display = 'block';
                if(persistedFileDisplay) persistedFileDisplay.style.display = 'none';
            }
        }

        if(adjuntoInput) {
            adjuntoInput.addEventListener('change', function(){
                if(this.files && this.files[0]){
                    const file = this.files[0];
                    const reader = new FileReader();

                    tempFileName = file.name;
                    oldFileNameInput.value = file.name;

                    if (file.type.match('image.*')) {
                        reader.onload = e => {
                            tempAdjuntoData = e.target.result;
                            base64AdjuntoInput.value = e.target.result;
                            actualizarVistaAdjunto();
                        };
                        reader.readAsDataURL(file);
                    } else {

                        tempAdjuntoData = 'file_placeholder';
                        base64AdjuntoInput.value = 'placeholder_non_image';
                        actualizarVistaAdjunto();
                    }
                } else {

                    tempAdjuntoData = null;
                    tempFileName = null;
                    base64AdjuntoInput.value = '';
                    oldFileNameInput.value = '';
                    actualizarVistaAdjunto();
                }
            });
        }
        document.getElementById('btnLimpiar').addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            const alerta = document.querySelector('.alert');
            if (alerta) alerta.remove();

            ['destinatarioInput','autorInput','destinatario_id','autor_id','titulo','contenido','sancion','observaciones'].forEach(id=>{
                const el=document.getElementById(id);
                if(el) el.value='';
            });
            ['destinatarioResults','autorResults'].forEach(id=>document.getElementById(id).innerHTML='');
            document.getElementById('tipo').selectedIndex=0;
            document.getElementById('fecha').value=hoyStr;

            if(adjuntoInput) adjuntoInput.value='';
            tempAdjuntoData = null;
            tempFileName = null;
            base64AdjuntoInput.value = '';
            oldFileNameInput.value = '';
            actualizarVistaAdjunto();

            ['contenido','sancion','observaciones'].forEach(id=>autoResize(document.getElementById(id)));
        });

        document.getElementById('memorandoForm').addEventListener('submit', function(e){
            let hasError = false;

            const destinatarioId = document.getElementById('destinatario_id');
            const destinatarioInput = document.getElementById('destinatarioInput');
            const destinatarioFeedback = destinatarioId.nextElementSibling;

            if(!destinatarioId.value){
                destinatarioFeedback.textContent = 'Debes seleccionar un empleado sancionado de la lista.';
                destinatarioInput.classList.add('is-invalid');
                hasError = true;
            } else {
                destinatarioFeedback.textContent = '';
                destinatarioInput.classList.remove('is-invalid');
            }

            const autorId = document.getElementById('autor_id');
            const autorInput = document.getElementById('autorInput');
            const autorFeedback = autorId.nextElementSibling;

            if(!autorId.value){
                autorFeedback.textContent = 'Debes seleccionar un autor de la lista.';
                autorInput.classList.add('is-invalid');
                hasError = true;
            } else {
                autorFeedback.textContent = '';
                autorInput.classList.remove('is-invalid');
            }

            if(hasError) e.preventDefault();
        });

        function setupAutocomplete(inputId, resultsId, hiddenId, url, extraParams = {}) {
            const input = document.getElementById(inputId);
            const results = document.getElementById(resultsId);
            const hidden = document.getElementById(hiddenId);
            const feedback = hidden.nextElementSibling;

            input.addEventListener('input', function () {
                const query = this.value.trim();
                hidden.value = '';
                if (!query) {
                    results.innerHTML = '';
                    return;
                }
                fetch(url + '?' + new URLSearchParams({ q: query, ...extraParams }))
                    .then(res => res.json())
                    .then(data => {
                        results.innerHTML = '';
                        if (data.length === 0) return;
                        data.forEach(emp => {
                            const item = document.createElement('button');
                            item.type = 'button';
                            item.classList.add('list-group-item', 'list-group-item-action');
                            item.textContent = emp.nombre + ' ' + emp.apellido;
                            item.addEventListener('click', () => {
                                input.value = emp.nombre + ' ' + emp.apellido;
                                hidden.value = emp.id;
                                results.innerHTML = '';

                                input.classList.remove('is-invalid');
                                feedback.textContent = '';
                            });
                            results.appendChild(item);
                        });
                    });
            });
            document.addEventListener('click', function(e){
                if (!results.contains(e.target) && e.target !== input) {
                    results.innerHTML = '';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupAutocomplete('destinatarioInput', 'destinatarioResults', 'destinatario_id', '{{ route("empleados.buscar") }}', { tipo: 'todos' });
            setupAutocomplete('autorInput', 'autorResults', 'autor_id', '{{ route("empleados.buscar") }}', { tipo: 'administracion' });
            actualizarVistaAdjunto();
            ['contenido', 'sancion', 'observaciones'].forEach(id => autoResize(document.getElementById(id)));
        });
    </script>
    </body>
@endsection
