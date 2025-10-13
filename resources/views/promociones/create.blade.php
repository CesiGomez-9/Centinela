@extends('plantilla')
@section('content')

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-badge-ad-fill position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:4rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-badge-ad me-2"></i>Registrar nueva promoción
            </h3>

            @if(session('success'))
                <div class="alert alert-success">¡Promoción guardada correctamente!</div>
            @endif

            <form action="{{ route('promociones.store') }}" method="POST" enctype="multipart/form-data" novalidate id="promocionForm">
                @csrf
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre de la promoción:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                            <input type="text" id="nombre" name="nombre"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   value="{{ old('nombre') }}">
                            <div class="invalid-feedback d-block">@error('nombre') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Fecha inicio:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                                   class="form-control @error('fecha_inicio') is-invalid @enderror"
                                   value="{{ old('fecha_inicio') }}">
                            <div class="invalid-feedback d-block">@error('fecha_inicio') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Fecha fin:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar2-check-fill"></i></span>
                            <input type="date" name="fecha_fin" id="fecha_fin"
                                   class="form-control @error('fecha_fin') is-invalid @enderror"
                                   value="{{ old('fecha_fin') }}">
                            <div class="invalid-feedback d-block">@error('fecha_fin') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Descripción:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pencil-fill"></i></span>
                            <textarea name="descripcion" id="descripcion"
                                      class="form-control @error('descripcion') is-invalid @enderror"
                                      rows="3" style="overflow:hidden; resize:none;">{{ old('descripcion') }}</textarea>
                            <div class="invalid-feedback d-block">@error('descripcion') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Subir plantilla de promoción (opcional):</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-image"></i></span>
                            <input type="file" name="imagen" id="imagenInput"
                                   class="form-control @error('imagen') is-invalid @enderror"
                                   accept="image/*">
                            <div class="invalid-feedback d-block">@error('imagen') {{ $message }} @enderror</div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Vista previa:</label>
                        <div class="preview-container border rounded shadow-sm overflow-hidden p-2 bg-light" id="previewCard">
                            <img id="previewImagen" src="{{ asset('imagenes/plantilla_promocion.jpg') }}"
                                 alt="Vista previa" class="w-100 rounded mb-3" style="object-fit:cover; max-height:200px;">
                            <div class="text-center">
                                <h5 id="previewNombre" class="fw-bold text-primary mb-1">Nombre de la promoción</h5>
                                <p id="previewDescripcion" class="mb-1">Aquí aparecerá la descripción.</p>
                                <p id="previewFechas" class="small text-muted">
                                    <i class="bi bi-calendar3"></i>
                                    <span id="fechaInicioText"></span> - <span id="fechaFinText"></span>
                                </p>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnAmpliar">
                                <i class="bi bi-arrows-fullscreen"></i> Ampliar vista
                            </button>
                        </div>
                    </div>

                    <div class="text-center mt-4 col-12">
                        <a href="{{ route('promociones.index') }}" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="reset" class="btn btn-warning me-2" id="btnRestablecer">
                            <i class="bi bi-eraser-fill me-2"></i>Limpiar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i>Guardar
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">Vista completa de la promoción</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center bg-black overflow-auto" style="min-height: 60vh;">
                    <div class="position-relative text-center" style="max-width:30%; max-height:50%;">
                        <img id="modalImagen" src="{{ asset('imagenes/plantilla_promocion.jpg') }}"
                             class="w-100 h-auto rounded shadow" style="object-fit: contain;">

                        <div class="text-white mt-2">
                            <h3 id="modalNombre" class="fw-bold">Nombre de la promoción</h3>
                            <p id="modalDescripcion" class="mb-2">Aquí aparecerá la descripción.</p>
                            <p id="modalFechas" class="small">
                                <i class="bi bi-calendar3"></i>
                                <span id="modalInicio"></span> - <span id="modalFin"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const hoy = new Date();
            const yyyy = hoy.getFullYear();
            const mm = String(hoy.getMonth() + 1).padStart(2, '0');
            const dd = String(hoy.getDate()).padStart(2, '0');
            const hoyStr = `${yyyy}-${mm}-${dd}`;

            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');

            fechaInicio.value = hoyStr;
            fechaFin.value = hoyStr;
            fechaInicio.min = hoyStr;
            fechaFin.min = hoyStr;

            const descripcion = document.getElementById('descripcion');
            const nombreInput = document.getElementById('nombre');
            const imagenInput = document.getElementById('imagenInput');

            const previewNombre = document.getElementById('previewNombre');
            const previewDescripcion = document.getElementById('previewDescripcion');
            const previewImagen = document.getElementById('previewImagen');
            const fechaInicioText = document.getElementById('fechaInicioText');
            const fechaFinText = document.getElementById('fechaFinText');

            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            const modalImagen = document.getElementById('modalImagen');
            const modalNombre = document.getElementById('modalNombre');
            const modalDescripcion = document.getElementById('modalDescripcion');
            const modalInicio = document.getElementById('modalInicio');
            const modalFin = document.getElementById('modalFin');

            previewNombre.textContent = nombreInput.value || 'Nombre de la promoción';
            previewDescripcion.textContent = descripcion.value || 'Aquí aparecerá la descripción.';
            fechaInicioText.textContent = fechaInicio.value;
            fechaFinText.textContent = fechaFin.value;

            modalNombre.textContent = previewNombre.textContent;
            modalDescripcion.textContent = previewDescripcion.textContent;
            modalInicio.textContent = fechaInicio.value;
            modalFin.textContent = fechaFin.value;

            nombreInput.addEventListener('input', e => {
                previewNombre.textContent = e.target.value || 'Nombre de la promoción';
                modalNombre.textContent = previewNombre.textContent;
            });

            descripcion.addEventListener('input', e => {
                descripcion.style.height = 'auto';
                descripcion.style.height = descripcion.scrollHeight + 'px';
                previewDescripcion.textContent = e.target.value || 'Aquí aparecerá la descripción.';
                modalDescripcion.textContent = previewDescripcion.textContent;
            });

            fechaInicio.addEventListener('input', e => {
                fechaInicioText.textContent = e.target.value;
                modalInicio.textContent = e.target.value;

                if (fechaFin.value < e.target.value) {
                    fechaFin.value = e.target.value;
                    fechaFinText.textContent = fechaFin.value;
                    modalFin.textContent = fechaFin.value;
                }

                fechaFin.min = e.target.value;
            });

            fechaFin.addEventListener('input', e => {
                fechaFinText.textContent = e.target.value;
                modalFin.textContent = e.target.value;
            });

            imagenInput.addEventListener('change', function() {
                if(this.files && this.files[0]){
                    const reader = new FileReader();
                    reader.onload = e => {
                        previewImagen.src = e.target.result;
                        modalImagen.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    previewImagen.src = "{{ asset('imagenes/plantilla_promocion.jpg') }}";
                    modalImagen.src = "{{ asset('imagenes/plantilla_promocion.jpg') }}";
                }
            });

            document.getElementById('btnAmpliar').addEventListener('click', () => modal.show());
            document.getElementById('btnRestablecer').addEventListener('click', e => {
                e.preventDefault();

                nombreInput.value = '';
                descripcion.value = '';
                fechaInicio.value = hoyStr;
                fechaFin.value = hoyStr;
                imagenInput.value = '';

                previewNombre.textContent = 'Nombre de la promoción';
                previewDescripcion.textContent = 'Aquí aparecerá la descripción.';
                fechaInicioText.textContent = hoyStr;
                fechaFinText.textContent = hoyStr;
                previewImagen.src = "{{ asset('imagenes/plantilla_promocion.jpg') }}";

                modalNombre.textContent = previewNombre.textContent;
                modalDescripcion.textContent = previewDescripcion.textContent;
                modalInicio.textContent = fechaInicio.value;
                modalFin.textContent = fechaFin.value;
                modalImagen.src = previewImagen.src;

                const feedbacks = document.querySelectorAll('.invalid-feedback');
                feedbacks.forEach(f => f.textContent = '');
                const errores = document.querySelectorAll('.is-invalid');
                errores.forEach(el => el.classList.remove('is-invalid'));
            });

            const form = document.getElementById('promocionForm');
            form.addEventListener('submit', function(e) {
                let error = false;

                const feedbacks = form.querySelectorAll('.invalid-feedback');
                feedbacks.forEach(f => f.textContent = '');
                const errores = form.querySelectorAll('.is-invalid');
                errores.forEach(el => el.classList.remove('is-invalid'));

                if(nombreInput.value.trim() === '') {
                    const feedback = nombreInput.closest('.input-group').querySelector('.invalid-feedback');
                    feedback.textContent = 'Debe ingresar el nombre de la promoción';
                    nombreInput.classList.add('is-invalid');
                    error = true;
                }

                if(descripcion.value.trim() === '') {
                    const feedback = descripcion.closest('.input-group').querySelector('.invalid-feedback');
                    feedback.textContent = 'Debe ingresar una descripción';
                    descripcion.classList.add('is-invalid');
                    error = true;
                }

                if(fechaInicio.value === '') {
                    const feedback = fechaInicio.closest('.input-group').querySelector('.invalid-feedback');
                    feedback.textContent = 'Debe seleccionar una fecha';
                    fechaInicio.classList.add('is-invalid');
                    error = true;
                }

                if(fechaFin.value === '') {
                    const feedback = fechaFin.closest('.input-group').querySelector('.invalid-feedback');
                    feedback.textContent = 'Debe seleccionar una fecha';
                    fechaFin.classList.add('is-invalid');
                    error = true;
                }

                if(error) e.preventDefault();
            });
        });
    </script>
    </body>
@endsection
