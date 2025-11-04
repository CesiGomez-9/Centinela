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
            max-width: 900px;
            margin: 2rem auto;
            transition: transform 0.2s ease-in-out;
        }
        .card:hover { transform: scale(1.01); }

        .card-header {
            background-color: #0d1b2a;
            padding: 1.75rem;
            border-bottom: 4px solid #cda34f;
            color: white;
            position: relative;
            border-top-left-radius: 1.25rem;
            border-top-right-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .card-header img {
            width: 90px;
            position: absolute;
            left: 1.75rem;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 0.5rem;
        }
        .card-header h5 {
            font-weight: 700;
            font-size: 1.4rem;
            margin: 0;
            text-align: center;
        }
        .card-header small.created {
            position: absolute;
            right: 1.75rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.85rem;
            color: #f0e6d2;
        }

        .card-body hr {
            border: none;
            height: 2px;
            background-color: #cda34f;
            opacity: 1;
            margin: 1.5rem 0;
        }

        .card-body { padding: 2.25rem 2rem; font-size: 1rem; box-shadow: inset 0 0 10px rgba(0,0,0,0.05); border-radius: 0; }
        .card-footer { background-color: #1b263b; padding: 0.9rem 1.5rem; font-size: 0.9rem; color: #f5f5f5; text-align: right; border-radius: 0 0 1.25rem 1.25rem; border: none; }

        .info-container { display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 1.5rem; }
        .info-box {
            flex: 1;
            min-width: 250px;
            padding: 15px 20px;
            border-radius: 8px;
            background-color: #fdfdfd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .info-box p {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            position: relative;
            padding-left: 20px;
        }
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
        .btn-return, .btn-edit {
            background-color: #cda34f;
            color: #fff;
            border: none;
        }
        .btn-return:hover, .btn-return:focus,
        .btn-edit:hover, .btn-edit:focus {
            background-color: #0d1b2a;
            color: #ffffff;
        }
        .info-box strong { color: #0d1b2a; font-weight: 600; }
        .adjunto img, .adjunto iframe { max-width: 100%; margin-top: 0.5rem; border-radius: 0.5rem; box-shadow: 0 2px 8px rgb(205 163 79 / 0.15); }
    </style>

    <?php
        /** @var \App\Models\Memorando $memorando */
        $memNumeros = $memorando->destinatario->memorandosRecibidos->sortBy('created_at')->values();
        $numeroPorEmpleado = $memNumeros->search(fn($m) => $m->id === $memorando->id) + 1;
    ?>

    <div class="card">
        <div class="card-header">
            <img src="<?php echo e(asset('centinela.jpg')); ?>" alt="Logo Centinela">
            <h5>Memorandum</h5>
            <small class="created">Creado: <?php echo e($memorando->created_at->diffForHumans()); ?></small>
        </div>

        <div class="card-body">
            <div class="text-center mb-3">
                <h5 class="fw-bold">GRUPO CENTINELA</h5>
                <small>Memorandum N° <?php echo e($numeroPorEmpleado); ?></small>
            </div>

            <div class="info-container">
                <div class="info-box">
                    <p><i class="bi bi-person-fill me-2"></i><strong>Empleado Sancionado:</strong> <?php echo e($memorando->destinatario->nombre ?? ''); ?> <?php echo e($memorando->destinatario->apellido ?? ''); ?></p>
                    <p><i class="bi bi-person-fill me-2"></i><strong>Creador del memorandum:</strong> <?php echo e($memorando->autor->nombre ?? ''); ?> <?php echo e($memorando->autor->apellido ?? ''); ?></p>
                    <p><i class="bi bi-card-heading"></i><strong>Asunto:</strong> <?php echo e($memorando->titulo); ?></p>
                </div>

                <div class="info-box">
                    <p><i class="bi bi-exclamation-triangle-fill"></i><strong>Tipo:</strong> <?php echo e($memorando->tipo); ?></p>
                    <p><i class="bi bi-calendar-date-fill"></i><strong>Fecha:</strong> <?php echo e(\Carbon\Carbon::parse($memorando->fecha)->format('d/m/Y')); ?></p>
                    <p><i class="bi bi-hammer"></i><strong>Sanción:</strong> <?php echo e($memorando->sancion); ?></p>
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <p><i class="bi bi-pencil-fill"></i><strong>Motivo del memorandum:</strong> <?php echo e($memorando->contenido ?? '---'); ?></p>
            </div>

            <hr>

            <div class="info-container">
                <div class="info-box mb-3 p-3 border rounded shadow-sm adjunto">
                    <p class="mb-2"><i class="bi bi-paperclip me-2"></i><strong>Adjunto:</strong></p>

                    <?php if($memorando->adjunto): ?>
                        <?php
                            // Limpiar el prefijo 'public/' si existe
                            $rutaAdjunto = $memorando->adjunto ? str_replace('public/', '', $memorando->adjunto) : null;
                        ?>

                        <?php if($rutaAdjunto && file_exists(storage_path('app/public/' . $rutaAdjunto))): ?>
                            <?php $extension = strtolower(pathinfo($rutaAdjunto, PATHINFO_EXTENSION)); ?>

                            <?php if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                <img src="<?php echo e(asset('storage/' . $rutaAdjunto)); ?>" alt="Adjunto" class="img-fluid rounded shadow" style="max-height:300px;">
                            <?php elseif($extension === 'pdf'): ?>
                                <iframe src="<?php echo e(asset('storage/' . $rutaAdjunto)); ?>" width="100%" height="400px" class="border rounded mt-2"></iframe>
                            <?php else: ?>
                                <a href="<?php echo e(asset('storage/' . $rutaAdjunto)); ?>" target="_blank" class="btn btn-outline-primary mt-2">
                                    <i class="bi bi-paperclip me-1"></i> Descargar adjunto
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-danger ms-1">⚠️ El archivo adjunto no se encuentra o fue eliminado.</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="text-muted ms-1">No hay archivo adjunto.</span>
                    <?php endif; ?>
                </div>

                <div class="info-box mb-3 p-2 border rounded shadow-sm" style="min-height: auto;">
                    <p class="text-muted mb-0"><i class="bi bi-chat-left-text-fill me-2"></i><strong>Observaciones:</strong></p>
                    <?php if($memorando->observaciones): ?>
                        <?php echo e($memorando->observaciones); ?>

                    <?php else: ?>
                        <span class="text-muted">No hay observaciones</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card-footer">
            Última actualización: <?php echo e($memorando->updated_at->diffForHumans()); ?>

        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
        <a href="<?php echo e(route('memorandos.index')); ?>" class="btn btn-return">
            <i class="bi bi-arrow-left me-2"></i>Volver a la lista
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/memorandos/show.blade.php ENDPATH**/ ?>