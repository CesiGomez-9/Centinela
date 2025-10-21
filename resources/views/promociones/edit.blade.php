@extends('plantilla')
@section('content')

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-badge-ad-fill position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:4rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-pencil-square me-2"></i>Editar promoción
            </h3>

            @if(session('success'))
                <div class="alert alert-success">¡Promoción actualizada correctamente!</div>
            @endif

            <form action="{{ route('promociones.update', $promocion->id) }}" method="POST" enctype="multipart/form-data" id="promocionForm" novalidate>
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre de la promoción:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                            <input type="text" id="nombre" name="nombre"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   value="{{ old('nombre', $promocion->nombre) }}">
                            <div class="invalid-feedback d-block">@error('nombre') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Fecha inicio:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                                   class="form-control @error('fecha_inicio') is-invalid @enderror"
                                   value="{{ old('fecha_inicio', $promocion->fecha_inicio) }}">
                            <div class="invalid-feedback d-block">@error('fecha_inicio') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Fecha fin:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar2-check-fill"></i></span>
                            <input type="date" name="fecha_fin" id="fecha_fin"
                                   class="form-control @error('fecha_fin') is-invalid @enderror"
                                   value="{{ old('fecha_fin', $promocion->fecha_fin) }}">
                            <div class="invalid-feedback d-block">@error('fecha_fin') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Descripción:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pencil-fill"></i></span>
                            <textarea name="descripcion" id="descripcion"
                                      class="form-control @error('descripcion') is-invalid @enderror"
                                      rows="3" style="overflow:hidden; resize:none;">{{ old('descripcion', $promocion->descripcion) }}</textarea>
                            <div class="invalid-feedback d-block">@error('descripcion') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Plantilla de promoción:</label>
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
                            <img id="previewImagen"
                                 src="{{ $promocion->imagen ? asset('storage/' . $promocion->imagen) : asset('imagenes/plantilla_promocion.jpg') }}"
                                 alt="Vista previa" class="w-100 rounded mb-3" style="object-fit:cover; max-height:200px;">
                            <div class="text-center">
                                <h5 id="previewNombre" class="fw-bold text-primary mb-1">{{ $promocion->nombre }}</h5>
                                <p id="previewDescripcion" class="mb-1">{{ $promocion->descripcion }}</p>
                                <p id="previewFechas" class="small text-muted">
                                    <i class="bi bi-calendar3"></i>
                                    <span id="fechaInicioText">{{ $promocion->fecha_inicio }}</span> -
                                    <span id="fechaFinText">{{ $promocion->fecha_fin }}</span>
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
                        <button type="button" class="btn btn-warning me-2" id="btnRestablecer">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Restablecer
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i> Guardar
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Modal de vista ampliada --}}
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">Vista completa de la promoción</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center bg-black overflow-auto" style="min-height: 60vh;">
                    <div class="position-relative text-center" style="max-width:30%; max-height:50%;">
                        <img id="modalImagen"
                             src="{{ $promocion->imagen ? asset('storage/' . $promocion->imagen) : asset('imagenes/plantilla_promocion.jpg') }}"
                             class="w-100 h-auto rounded shadow" style="object-fit: contain;">
                        <div class="text-white mt-2">
                            <h3 id="modalNombre" class="fw-bold">{{ $promocion->nombre }}</h3>
                            <p id="modalDescripcion" class="mb-2">{{ $promocion->descripcion }}</p>
                            <p id="modalFechas" class="small">
                                <i class="bi bi-calendar3"></i>
                                <span id="modalInicio">{{ $promocion->fecha_inicio }}</span> -
                                <span id="modalFin">{{ $promocion->fecha_fin }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script dinámico igual que el del create --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nombreInput = document.getElementById('nombre');
            const descripcion = document.getElementById('descripcion');
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const imagenInput = document.getElementById('imagenInput');

            const previewNombre = document.getElementById('previewNombre');
            const previewDescripcion = document.getElementById('previewDescripcion');
            const previewImagen = document.getElementById('previewImagen');
            const fechaInicioText = document.getElementById('fechaInicioText');
            const fechaFinText = document.getElementById('fechaFinText');

            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            document.getElementById('btnAmpliar').addEventListener('click', () => modal.show());
            const modalImagen = document.getElementById('modalImagen');
            const modalNombre = document.getElementById('modalNombre');
            const modalDescripcion = document.getElementById('modalDescripcion');
            const modalInicio = document.getElementById('modalInicio');
            const modalFin = document.getElementById('modalFin');

            const originalData = {
                nombre: @json($promocion->nombre),
                descripcion: @json($promocion->descripcion),
                inicio: @json($promocion->fecha_inicio),
                fin: @json($promocion->fecha_fin),
                imagen: "{{ $promocion->imagen ? asset('storage/' . $promocion->imagen) : asset('imagenes/plantilla_promocion.jpg') }}"
            };



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
                    previewImagen.src = originalData.imagen;
                    modalImagen.src = originalData.imagen;
                }
            });

            document.getElementById('btnRestablecer').addEventListener('click', e => {
                e.preventDefault();

                // Restaurar valores originales
                nombreInput.value = originalData.nombre;
                descripcion.value = originalData.descripcion;
                fechaInicio.value = originalData.inicio;
                fechaFin.value = originalData.fin;
                previewImagen.src = originalData.imagen;
                modalImagen.src = originalData.imagen;

                previewNombre.textContent = originalData.nombre;
                previewDescripcion.textContent = originalData.descripcion;
                fechaInicioText.textContent = originalData.inicio;
                fechaFinText.textContent = originalData.fin;
                modalNombre.textContent = originalData.nombre;
                modalDescripcion.textContent = originalData.descripcion;
                modalInicio.textContent = originalData.inicio;
                modalFin.textContent = originalData.fin;

                // Borrar mensajes de error
                const feedbacks = document.querySelectorAll('.invalid-feedback');
                feedbacks.forEach(f => f.textContent = '');

                // Quitar clase is-invalid
                const errores = document.querySelectorAll('.is-invalid');
                errores.forEach(el => el.classList.remove('is-invalid'));
            });


        });
    </script>

    </body>
@endsection
