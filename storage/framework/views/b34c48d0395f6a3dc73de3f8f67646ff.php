<?php $__env->startSection('content'); ?>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: url('https://www.transparenttextures.com/patterns/beige-paper.png') repeat fixed #f8f4ec;
            font-size: 16px;
        }
        .card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            background: #ffffff;
            max-width: 800px;
            margin: 2rem auto;
            transition: transform 0.2s ease-in-out;
        }
        .card:hover { transform: scale(1.01); }

        .card-header {
            background-color: #0d1b2a;
            padding: 1.5rem;
            border-bottom: 4px solid #cda34f;
            color: white;
            position: relative;
            border-top-left-radius: 1.25rem;
            border-top-right-radius: 1.25rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .card-header h5 { font-weight: 700; font-size: 1.3rem; margin: 0; }
        .card-header small.created {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.8rem;
            color: #f0e6d2;
        }

        .card-body { padding: 1.5rem 1.75rem; font-size: 0.95rem; }
        .card-footer { background-color: #1b263b; padding: 0.75rem 1.5rem; font-size: 0.85rem; color: #f5f5f5; text-align: right; border-radius: 0 0 1.25rem 1.25rem; border: none; }

        .info-container { display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 1rem; }
        .info-box {
            flex: 1;
            min-width: 220px;
            padding: 12px 16px;
            border-radius: 8px;
            background-color: #fdfdfd;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            font-size: 0.92rem;
        }
        .info-box p { margin-bottom: 0.5rem; position: relative; padding-left: 18px; }
        .info-box p::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 70%;
            background-color: #cda34f;
            border-radius: 1px;
        }

        .btn-return,
        .btn-edit {
            background-color: #cda34f;
            color: #fff;
            border: none;
            padding: 0.45rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            margin: 0 0.5rem;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            font-size: 0.9rem;
        }

        .btn-return:hover,
        .btn-edit:hover {
            background-color: #0d1b2a;
            color: #fff;
        }

        .adjunto img, .adjunto iframe { max-width: 100%; margin-top: 0.5rem; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(205,163,79,0.15); }
        .numero-incidencia { font-size: 0.85rem; color: #555; margin-top: -0.5rem; }
    </style>

    <?php
        $incidenciasEmpleado = $incapacidad->empleado->incapacidades ?? collect();
        $incidenciasEmpleado = $incidenciasEmpleado->sortBy('created_at')->values();
        $numeroPorEmpleado = $incidenciasEmpleado->search(fn($i) => $i->id === $incapacidad->id) + 1;

        $documento = $incapacidad->documento ?? null;
    ?>

    <div class="card">
        <div class="card-header">
            <h5>Detalle de incapacidad</h5>
            <small class="created">Creada: <?php echo e($incapacidad->created_at?->diffForHumans() ?? 'Fecha no disponible'); ?></small>
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
            <span class="numero-incidencia" style="font-size: 1.2rem; font-weight: 600; color: #0d1b2a;">
                Incapacidad N° <?php echo e($numeroPorEmpleado); ?>

            </span>
            </div>

            <div class="info-container">
                <div class="info-box">
                    <p><strong><i class="bi bi-person-fill me-2"></i> Empleado:</strong> <?php echo e($incapacidad->empleado?->nombre ?? '---'); ?> <?php echo e($incapacidad->empleado?->apellido ?? ''); ?></p>
                    <p><strong><i class="bi bi-card-heading me-2"></i> Identidad:</strong> <?php echo e($incapacidad->empleado?->identidad ?? '---'); ?></p>
                    <p><strong><i class="bi bi-briefcase me-2"></i> Cargo:</strong> <?php echo e($incapacidad->empleado?->categoria ?? '---'); ?></p>
                    <p><strong><i class="bi bi-heart-pulse me-2"></i> Motivo:</strong> <?php echo e($incapacidad->motivo ?? '---'); ?></p>
                    <p><strong><i class="bi bi-building me-2"></i> Institución médica:</strong> <?php echo e($incapacidad->institucion_medica ?? '---'); ?></p>
                </div>

                <div class="info-box">
                    <p><strong><i class="bi bi-calendar-event me-2"></i>Fecha inicio:</strong> <?php echo e($incapacidad->fecha_inicio ? \Carbon\Carbon::parse($incapacidad->fecha_inicio)->format('d/m/Y') : '---'); ?></p>
                    <p><strong><i class="bi bi-calendar-event me-2"></i>Fecha fin:</strong> <?php echo e($incapacidad->fecha_fin ? \Carbon\Carbon::parse($incapacidad->fecha_fin)->format('d/m/Y') : '---'); ?></p>
                    <p><strong><i class="bi bi-check-circle me-2"></i>Estado:</strong> <?php echo e($incapacidad->estado); ?></p>
                    <p><strong><i class="bi bi-file-text me-2"></i>Descripción:</strong> <?php echo e($incapacidad->descripcion ?? 'Sin descripción'); ?></p>
                </div>
            </div>

            <hr>

            <div class="info-container">
                <div class="info-box adjunto">
                    <p><strong><i class="bi bi-paperclip me-2"></i>Comprobante médico:</strong></p>
                    <?php if($documento && file_exists(storage_path('app/public/' . $documento))): ?>
                        <?php $extension = strtolower(pathinfo($documento, PATHINFO_EXTENSION)); ?>
                        <?php if(in_array($extension, ['jpg','jpeg','png','gif','webp'])): ?>
                            <img src="<?php echo e(asset('storage/' . $documento)); ?>" alt="Documento">
                        <?php elseif($extension === 'pdf'): ?>
                            <iframe src="<?php echo e(asset('storage/' . $documento)); ?>" width="100%" height="300px"></iframe>
                        <?php else: ?>
                            <a href="<?php echo e(asset('storage/' . $documento)); ?>" target="_blank" class="btn btn-outline-primary mt-2">Descargar archivo</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="text-muted">No hay documento</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card-footer">
            Última actualización: <?php echo e($incapacidad->updated_at?->diffForHumans() ?? 'Fecha no disponible'); ?>

        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center gap-3 mt-3 flex-wrap">
        <a href="<?php echo e(route('incapacidades.index')); ?>" class="btn btn-return">
            <i class="bi bi-arrow-left me-2"></i>Volver a la lista
        </a>
        <a href="<?php echo e(route('incapacidades.edit', $incapacidad->id)); ?>" class="btn btn-edit">
            <i class="bi bi-pencil-square me-2"></i>Editar incapacidad
        </a>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/incapacidades/show.blade.php ENDPATH**/ ?>