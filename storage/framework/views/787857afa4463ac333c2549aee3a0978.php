<?php $__env->startSection('content'); ?>

    <style>
        .invalid-feedback {
            display: block;
        }
    </style>

<body style="background-color: #e6f0ff;">
<div class="container bg-white p-5 rounded shadow mt-5 mb-5" style="max-width: 950px;">
    <div class="d-flex justify-content-center mb-4">
        <h3 class="mb-0 text-center" style="color: #09457f;">
            <i class="bi bi-person-badge-fill me-2"></i>Editar datos del empleado
        </h3>
    </div>

    <form  id="empleadoForm" action="<?php echo e(route('empleados.update', $empleado->id)); ?>" method="POST" onsubmit="return validarFormulario()" novalidate>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="row g-4">
            <div class="col-md-4">
                <label class="form-label fw-bold">Nombre:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" id="nombre" name="nombre"
                           value="<?php echo e(old('nombre', $empleado->nombre)); ?>"
                           class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           data-original="<?php echo e(old('nombre', $empleado->nombre)); ?>"
                           oninput="validarTexto(this,50)" />

                    <div class="invalid-feedback"><?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Apellido:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" id="apellido" name="apellido"
                           value="<?php echo e(old('apellido', $empleado->apellido)); ?>"
                           class="form-control <?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           data-original="<?php echo e(old('apellido', $empleado->apellido)); ?>"
                           oninput="validarTexto(this,50)" />
                    <div class="invalid-feedback"><?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Identidad:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
                    <input type="text" id="identidad" name="identidad"
                           value="<?php echo e(old('identidad', $empleado->identidad)); ?>"
                           class="form-control <?php $__errorArgs = ['identidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           oninput="formatearIdentidad(this)"
                           data-original="<?php echo e(old('identidad', $empleado->identidad)); ?>" />
                    <div class="invalid-feedback"><?php $__errorArgs = ['identidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    <div id="errorIdentidad" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Teléfono:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" id="telefono" name="telefono"
                           value="<?php echo e(old('telefono', $empleado->telefono)); ?>"
                           class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           maxlength="8" oninput="formatearTelefono(this)"
                           data-original="<?php echo e(old('telefono', $empleado->telefono)); ?>" />
                    <div class="invalid-feedback"><?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Correo electrónico:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" id="email" name="email" maxlength="50"
                           value="<?php echo e(old('email', $empleado->email)); ?>"
                           class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           data-original="<?php echo e(old('email', $empleado->email)); ?>"
                           oninput="validarCorreo(this, 50)" />
                    <div class="invalid-feedback"><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Tipo de sangre:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-droplet-fill"></i></span>
                    <select id="tipodesangre" name="tipodesangre"
                            class="form-select <?php $__errorArgs = ['tipodesangre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            data-original="<?php echo e(old('tipodesangre', $empleado->tipodesangre)); ?>">
                        <option value="">Seleccione...</option>
                        <?php $__currentLoopData = ['A+','A-','B+','B-','AB+','AB-','O+','O-']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tipo); ?>" <?php echo e(old('tipodesangre', $empleado->tipodesangre) == $tipo ? 'selected' : ''); ?>><?php echo e($tipo); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="invalid-feedback"><?php $__errorArgs = ['tipodesangre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Departamento</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                    <select id="departamento" name="departamento"
                            class="form-select <?php $__errorArgs = ['departamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Seleccione...</option>
                        <?php $__currentLoopData = ['Atlántida', 'Choluteca', 'Colón', 'Comayagua', 'Copán',
                            'Cortés', 'El Paraíso', 'Francisco Morazán', 'Gracias a Dios',
                            'Intibucá ', 'Islas de la Bahía', 'La Paz', 'Lempira',
                            'Ocotepeque', 'Olancho', 'Santa Bárbara', 'Valle', 'Yoro']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e(trim($tipo)); ?>" <?php echo e(trim(old('departamento', $empleado->departamento)) == trim($tipo) ? 'selected' : ''); ?>><?php echo e($tipo); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="invalid-feedback"><?php $__errorArgs = ['departamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                </div>
            </div>

            <div class="col-md-10">
                <label class="form-label fw-bold">
                    <i class="bi bi-exclamation-diamond-fill me-2"></i>
                    Seleccione las alergias:
                </label>
                <?php

                    $hayAlergiasOld = old() !== [] && array_key_exists('alergias', old());

                    if ($hayAlergiasOld) {
                        $alergiasRaw = old('alergias', []);
                    } else {
                        $alergiasRaw = $empleado->alergias ?? [];
                    }

                    $alergiasEmpleado = [];
                    $alergiaOtrosTexto = old('alergiaOtros', '');
                    $alergiaAlimentosTexto = old('alergiaAlimentos', '');
                    $alergiaMedicamentosTexto = old('alergiaMedicamentos', '');

                    foreach ($alergiasRaw as $a) {
                        if (str_starts_with($a, 'Otros:')) {
                            $alergiasEmpleado[] = 'Otros';
                            if ($alergiaOtrosTexto === '') {
                                $alergiaOtrosTexto = trim(substr($a, strlen('Otros:')));
                            }
                        } elseif (str_starts_with($a, 'Alimentos:')) {
                            $alergiasEmpleado[] = 'Alimentos';
                            if ($alergiaAlimentosTexto === '') {
                                $alergiaAlimentosTexto = trim(substr($a, strlen('Alimentos:')));
                            }
                        } elseif (str_starts_with($a, 'Medicamentos:')) {
                            $alergiasEmpleado[] = 'Medicamentos';
                            if ($alergiaMedicamentosTexto === '') {
                                $alergiaMedicamentosTexto = trim(substr($a, strlen('Medicamentos:')));
                            }
                        } else {
                            $alergiasEmpleado[] = $a;
                        }
                    }
                ?>

                <div id="alergias-container" data-original='<?php echo json_encode($alergiasEmpleado, 15, 512) ?>'>
                    <div class="row">
                        <div class="col-md-4 d-flex flex-column gap-2">
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input alergia-checkbox <?php $__errorArgs = ['alergias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="checkbox" value="Polvo" name="alergias[]"
                                       <?php echo e(in_array('Polvo', $alergiasEmpleado) ? 'checked' : ''); ?> id="alergiaPolvo">
                                <label class="form-check-label ms-2" for="alergiaPolvo">Polvo</label>
                            </div>
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input alergia-checkbox <?php $__errorArgs = ['alergias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="checkbox" value="Polen" name="alergias[]"
                                       <?php echo e(in_array('Polen', $alergiasEmpleado) ? 'checked' : ''); ?> id="alergiaPolen">
                                <label class="form-check-label ms-2" for="alergiaPolen">Polen</label>
                            </div>
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input alergia-checkbox <?php $__errorArgs = ['alergias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="checkbox" value="Ninguno" name="alergias[]"
                                       <?php echo e(in_array('Ninguno', $alergiasEmpleado) ? 'checked' : ''); ?> id="alergiaNinguno">
                                <label class="form-check-label ms-2" for="alergiaNinguno">Ninguno</label>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check me-2">
                                    <input class="form-check-input alergia-checkbox <?php $__errorArgs = ['alergias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="checkbox" value="Alimentos" name="alergias[]"
                                           <?php echo e(in_array('Alimentos', $alergiasEmpleado) ? 'checked' : ''); ?> id="alergiaAlimentosChk">
                                    <label class="form-check-label" for="alergiaAlimentosChk">Alimentos</label>
                                </div>
                                <input type="text" id="alergiaAlimentos" name="alergiaAlimentos" maxlength="150"
                                       value="<?php echo e(old('alergiaAlimentos', $empleado->alergiaAlimentos)); ?>"
                                       class="form-control solo-letras flex-grow-1 <?php $__errorArgs = ['alergiaAlimentos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="Especifique a qué alimentos es alérgico"
                                       data-original="<?php echo e(old('alergiaAlimentos', $empleado->alergiaAlimentos)); ?>"
                                       style="<?php echo e((is_array($alergiasEmpleado) && in_array('Alimentos', $alergiasEmpleado)) ? '' : 'display:none;  min-width: 400px;'); ?>" />
                                <div class="invalid-feedback">
                                    <?php $__errorArgs = ['alergiaAlimentos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check me-2">
                                    <input class="form-check-input alergia-checkbox <?php $__errorArgs = ['alergias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="checkbox" value="Medicamentos" name="alergias[]"
                                           <?php echo e(in_array('Medicamentos', $alergiasEmpleado) ? 'checked' : ''); ?> id="alergiaMedicamentosChk">
                                    <label class="form-check-label" for="alergiaMedicamentosChk">Medicamentos</label>
                                </div>
                                <input type="text" id="alergiaMedicamentos" name="alergiaMedicamentos" maxlength="150"
                                       value="<?php echo e(old('alergiaMedicamentos', $empleado->alergiaMedicamentos)); ?>"
                                       class="form-control solo-letras flex-grow-1 <?php $__errorArgs = ['alergiaMedicamentos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="Especifique a qué medicamentos es alérgico"
                                       data-original="<?php echo e(old('alergiaMedicamentos', $empleado->alergiaMedicamentos)); ?>"
                                       style="<?php echo e((is_array($alergiasEmpleado) && in_array('Medicamentos', $alergiasEmpleado)) ? '' : 'display:none;  min-width: 400px;'); ?>" />
                                <div class="invalid-feedback">
                                    <?php $__errorArgs = ['alergiaMedicamentos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="form-check me-2">
                                    <input class="form-check-input alergia-checkbox <?php $__errorArgs = ['alergias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="checkbox" value="Otros" name="alergias[]"
                                           <?php echo e(in_array('Otros', $alergiasEmpleado) ? 'checked' : ''); ?> id="alergiaOtrosChk">
                                    <label class="form-check-label" for="alergiaOtrosChk">Otros</label>
                                </div>
                                <input type="text" id="alergiaOtros" name="alergiaOtros" maxlength="150"
                                       value="<?php echo e(old('alergiaOtros', $empleado->alergiaOtros)); ?>"
                                       class="form-control solo-letras flex-grow-1 <?php $__errorArgs = ['alergiaOtros'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="Especifique otras alergias"
                                       data-original="<?php echo e(old('alergiaOtros', $empleado->alergiaOtros)); ?>"
                                       style="<?php echo e((is_array($alergiasEmpleado) && in_array('Otros', $alergiasEmpleado)) ? '' : 'display:none;  min-width: 400px;'); ?>" />
                                <div class="invalid-feedback">
                                    <?php $__errorArgs = ['alergiaOtros'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $__errorArgs = ['alergias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold" for="direccion">Dirección</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                        <textarea id="direccion" name="direccion" maxlength="250"
                                  class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  oninput="autoAjustarAltura(this); validarTexto(this, 250)"
                                  rows="1" style="resize: none; overflow: hidden;"><?php echo e(old('direccion', $empleado->direccion)); ?></textarea>
                        <div class="invalid-feedback"><?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="categoria" class="form-label fw-bold">Categoría</label>
                    <div class="input-group">
                        <span class="input-group-text" id="iconoCategoria">
                            <i class="bi bi-ui-checks"></i>
                        </span>
                        <select name="categoria" id="categoria" class="form-select <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">Seleccione una categoría...</option>
                            <option value="Administracion" <?php echo e(old('categoria', $empleado->categoria) == 'Administracion' ? 'selected' : ''); ?>>Administración</option>
                            <option value="Tecnico" <?php echo e(old('categoria', $empleado->categoria) == 'Tecnico' ? 'selected' : ''); ?>>Técnico</option>
                            <option value="Vigilancia" <?php echo e(old('categoria', $empleado->categoria) == 'Vigilancia' ? 'selected' : ''); ?>>Vigilancia</option>
                        </select>

                        <div class="invalid-feedback"><?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    </div>
                </div>
            </div>

            <h3 class="text-center mt-4 mb-4" style="color: #09457f;">
                <i class="bi bi-people-fill me-2"></i>Contacto de emergencia
            </h3>

            <div class="row">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Nombre completo:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                        <input type="text" id="contactodeemergencia" name="contactodeemergencia"
                               value="<?php echo e(old('contactodeemergencia', $empleado->contactodeemergencia)); ?>"
                               class="form-control <?php $__errorArgs = ['contactodeemergencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               data-original="<?php echo e(old('contactodeemergencia', $empleado->contactodeemergencia)); ?>"
                               oninput="validarTexto(this,100)" />
                        <div class="invalid-feedback"><?php $__errorArgs = ['contactodeemergencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Teléfono:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                        <input type="text" id="telefonodeemergencia" name="telefonodeemergencia"
                               value="<?php echo e(old('telefonodeemergencia', $empleado->telefonodeemergencia)); ?>"
                               class="form-control <?php $__errorArgs = ['telefonodeemergencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               maxlength="8" oninput="formatearTelefono(this)"
                               data-original="<?php echo e(old('telefonodeemergencia', $empleado->telefonodeemergencia)); ?>" />
                    </div>
                    <div class="invalid-feedback"><?php $__errorArgs = ['telefonodeemergencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                <a href="<?php echo e(route('empleados.index', $empleado->id)); ?>" class="btn btn-danger">
                    <i class="bi bi-x-circle me-2"></i> Cancelar
                </a>

                <button type="reset" class="btn btn-warning me-2">
                    <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save-fill me-2"></i> Guardar
                </button>
            </div>
        </div>
    </form>
</div>

<script>

    function autoAjustarAltura(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('direccion');
        if (textarea) {
            autoAjustarAltura(textarea);
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('empleadoForm');
        const resetBtn = form.querySelector('button[type="reset"]');
        form.querySelectorAll('input, select, textarea').forEach(el => {
            el.setAttribute('data-original', el.value);
        });
        ['alergiaOtros', 'alergiaAlimentos', 'alergiaMedicamentos'].forEach(id => {
            const campo = document.getElementById(id);
            if (campo) {
                campo.setAttribute('data-original', campo.value);
            }
        });
        const valoresOriginales = {
            nombre: <?php echo json_encode($empleado->nombre, 15, 512) ?>,
            apellido: <?php echo json_encode($empleado->apellido, 15, 512) ?>,
            identidad: <?php echo json_encode($empleado->identidad, 15, 512) ?>,
            telefono: <?php echo json_encode($empleado->telefono, 15, 512) ?>,
            email: <?php echo json_encode($empleado->email, 15, 512) ?>,
            tipodesangre: <?php echo json_encode($empleado->tipodesangre, 15, 512) ?>,
            alergias: <?php echo json_encode($empleado->alergias ?? [], 15, 512) ?>,
            alergiaAlimentos: <?php echo json_encode($empleado->alergiaAlimentos, 15, 512) ?>,
            alergiaMedicamentos: <?php echo json_encode($empleado->alergiaMedicamentos, 15, 512) ?>,
            alergiaOtros: <?php echo json_encode($empleado->alergiaOtros, 15, 512) ?>,
            departamento: <?php echo json_encode($empleado->departamento, 15, 512) ?>,
            direccion: <?php echo json_encode($empleado->direccion, 15, 512) ?>,
            contactodeemergencia: <?php echo json_encode($empleado->contactodeemergencia, 15, 512) ?>,
            telefonodeemergencia: <?php echo json_encode($empleado->telefonodeemergencia, 15, 512) ?>,
            categoria: <?php echo json_encode($empleado->categoria, 15, 512) ?>
        };

        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(div => div.textContent = '');
            form.querySelector('#nombre').value = valoresOriginales.nombre || '';
            form.querySelector('#apellido').value = valoresOriginales.apellido || '';
            form.querySelector('#identidad').value = valoresOriginales.identidad || '';
            form.querySelector('#telefono').value = valoresOriginales.telefono || '';
            form.querySelector('#email').value = valoresOriginales.email || '';
            form.querySelector('#tipodesangre').value = valoresOriginales.tipodesangre || '';
            form.querySelector('#departamento').value = valoresOriginales.departamento || '';
            form.querySelector('#direccion').value = valoresOriginales.direccion || '';
            form.querySelector('#contactodeemergencia').value = valoresOriginales.contactodeemergencia || '';
            form.querySelector('#telefonodeemergencia').value = valoresOriginales.telefonodeemergencia || '';
            form.querySelector('#categoria').value = valoresOriginales.categoria || '';

            const checkboxes = form.querySelectorAll('input.alergia-checkbox[type="checkbox"]');
            checkboxes.forEach(chk => {
                const val = chk.value;
                const match = valoresOriginales.alergias.some(orig => {
                    return orig === val || orig.startsWith(val + ':');
                });
                chk.checked = match;
            });
            form.querySelector('#alergiaAlimentos').value = valoresOriginales.alergiaAlimentos || '';
            form.querySelector('#alergiaMedicamentos').value = valoresOriginales.alergiaMedicamentos || '';
            form.querySelector('#alergiaOtros').value = valoresOriginales.alergiaOtros || '';
            toggleCamposAlergiasConValores(valoresOriginales.alergias);

        });
        document.addEventListener('DOMContentLoaded', function () {
            const formulario = document.getElementById('empleadoForm');
            const checkboxes = formulario.querySelectorAll('input.alergia-checkbox[type="checkbox"]');

            formulario.addEventListener('submit', function (e) {
                const algunoSeleccionado = Array.from(checkboxes).some(chk => chk.checked);

                if (!algunoSeleccionado) {
                    e.preventDefault();
                    checkboxes.forEach(chk => chk.classList.add('is-invalid'));
                    let errorDiv = document.getElementById('error-alergias');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.id = 'error-alergias';
                        errorDiv.classList.add('invalid-feedback');
                        checkboxes[0].parentNode.insertBefore(errorDiv, checkboxes[0].nextSibling);
                    }
                    errorDiv.textContent = 'Debe seleccionar al menos una alergia.';
                } else {

                    checkboxes.forEach(chk => chk.classList.remove('is-invalid'));
                    const errorDiv = document.getElementById('error-alergias');
                    if (errorDiv) errorDiv.textContent = '';
                }
            });

            checkboxes.forEach(chk => {
                chk.addEventListener('change', () => {
                    if (chk.checked) {
                        chk.classList.remove('is-invalid');
                        const errorDiv = document.getElementById('error-alergias');
                        if (errorDiv) errorDiv.textContent = '';
                    }
                });
            });
        });

        function toggleCamposAlergiasConValores(alergias) {
            const campos = {
                'Otros': document.getElementById('alergiaOtros'),
                'Alimentos': document.getElementById('alergiaAlimentos'),
                'Medicamentos': document.getElementById('alergiaMedicamentos')
            };

            for (const key in campos) {
                if (alergias.includes(key)) {
                    campos[key].style.display = '';
                    campos[key].value = campos[key].getAttribute('data-original') || '';
                } else {
                    campos[key].style.display = 'none';
                    campos[key].value = campos[key].getAttribute('data-original') || '';
                }
            }
        }
    });

    const codigosDep = Array.from({length:18}, (_,i) => String(i+1).padStart(2,'0'));

    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('input[name="alergias[]"]');
        const otrosCheckbox = document.querySelector('input[name="alergias[]"][value="Otros"]');
        const ningunoCheckbox = document.querySelector('input[name="alergias[]"][value="Ninguno"]');
        const alimentosCheckbox = document.querySelector('input[name="alergias[]"][value="Alimentos"]');
        const medicamentosCheckbox = document.querySelector('input[name="alergias[]"][value="Medicamentos"]');

        const campoAlimentos = document.getElementById('alergiaAlimentos');
        const campoMedicamentos = document.getElementById('alergiaMedicamentos');
        const campoOtros = document.getElementById('alergiaOtros');

        const categoriaSelect = document.getElementById('categoria');

        function actualizarCampos() {
            const otrosChecked = otrosCheckbox.checked;
            const ningunoChecked = ningunoCheckbox.checked;
            const alimentosChecked = alimentosCheckbox.checked;
            const medicamentosChecked = medicamentosCheckbox.checked;

            if (otrosChecked) {
                ningunoCheckbox.checked = false;
                ningunoCheckbox.disabled = true;
                checkboxes.forEach(chk => {
                    if (chk !== otrosCheckbox && chk !== ningunoCheckbox) {
                        chk.checked = false;
                        chk.disabled = true;
                    }
                });
                campoOtros.style.display = 'block';
                campoAlimentos.style.display = 'none';
                campoMedicamentos.style.display = 'none';
                campoAlimentos.value = '';
                campoMedicamentos.value = '';
            }

            else if (ningunoChecked) {
                otrosCheckbox.checked = false;
                otrosCheckbox.disabled = true;
                checkboxes.forEach(chk => {
                    if (chk !== ningunoCheckbox && chk !== otrosCheckbox) {
                        chk.checked = false;
                        chk.disabled = true;
                    }
                });
                campoOtros.style.display = 'none';
                campoAlimentos.style.display = 'none';
                campoMedicamentos.style.display = 'none';
                campoOtros.value = '';
                campoAlimentos.value = '';
                campoMedicamentos.value = '';
            }

            else {
                otrosCheckbox.disabled = false;
                ningunoCheckbox.disabled = false;
                checkboxes.forEach(chk => {
                    chk.disabled = false;
                });

                campoOtros.style.display = otrosCheckbox.checked ? 'block' : 'none';
                campoAlimentos.style.display = alimentosCheckbox.checked ? 'block' : 'none';
                campoMedicamentos.style.display = medicamentosCheckbox.checked ? 'block' : 'none';
            }
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', actualizarCampos);
        });

        actualizarCampos();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const campos = document.querySelectorAll('.solo-letras');

        campos.forEach(input => {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const checkboxOtros = document.querySelector('input[name="alergias[]"][value="Otros"]');
        const campoOtros = document.getElementById('alergiaOtros');
        const formulario = document.getElementById('empleadoForm');

        checkboxOtros.addEventListener('change', function () {
            if (this.checked) {
                campoOtros.style.display = 'block';
            } else {
                campoOtros.style.display = 'none';
                campoOtros.classList.remove('is-invalid');
            }
        });

        formulario.addEventListener('submit', function (e) {
            let errores = [];

            if (checkboxOtros.checked && campoOtros.value.trim() === '') {
                campoOtros.classList.add('is-invalid');
                errores.push('Debe especificar la alergia Otros');
            } else {
                campoOtros.classList.remove('is-invalid');
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });

        campoOtros.addEventListener('input', function () {
            if (campoOtros.value.trim() !== '') {
                campoOtros.classList.remove('is-invalid');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const checkboxOtros = document.querySelector('input[value="Otros"]');
        const campoOtros = document.getElementById('alergiaOtros');

        checkboxOtros.addEventListener('change', function () {
            if (this.checked) {
                campoOtros.style.display = 'block';
            } else {
                campoOtros.style.display = 'none';
                campoOtros.value = '';
            }
        });
    });

    function toggleCamposAlergias(alergias) {
        const campos = {
            'Otros': document.getElementById('alergiaOtros'),
            'Alimentos': document.getElementById('alergiaAlimentos'),
            'Medicamentos': document.getElementById('alergiaMedicamentos')
        };

        for (const key in campos) {
            if (alergias.includes(key)) {
                campos[key].style.display = '';
            } else {
                campos[key].style.display = 'none';
                campos[key].value = '';
            }
        }
    }

    function validarTexto(input, max) {
        input.value = input.value
            .replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s.,;#\-]/g, '')
            .replace(/\s+/g,' ')
            .slice(0, max);
    }

    const municipiosPorDepartamento = {
        "01": [ "01", "02", "03", "04", "05", "06", "07", "08" ], // Atlántida
        "02": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16" ], // Choluteca
        "03": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10" ], // Colón
        "04": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20","21" ], // Comayagua
        "05": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14","15", "16", "17", "18", "19", "20","21", "22", "23" ], // Copán
        "06": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12" ], // Cortés
        "07": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19" ], // El Paraíso
        "08": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18","19","20","21", "22", "23", "24", "25", "26", "27", "28" ], // Francisco Morazán
        "09": [ "01", "02", "03", "04", "05", "06" ], // Gracias a Dios (6 municipios)
        "10": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17" ], // Intibucá
        "11": [ "01", "02", "03", "04" ], // Islas de la Bahía (4 municipios)
        "12": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19" ], // La Paz
        "13": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26","27","28" ], // Lempira
        "14": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14","15", "16" ], // Ocotepeque
        "15": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"], // Olancho
        "16": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19","20","21", "22", "23", "24", "25", "26", "27", "28" ], // Santa Bárbara
        "17": [ "01", "02", "03", "04", "05", "06", "07", "08", "09" ], // Valle
        "18": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11"] // Yoro
    };

    function formatearIdentidad(i) {
        let v = i.value.replace(/[^0-9]/g, '');

        if (v.length >= 4) {
            const departamento = v.slice(0, 2);
            const municipio = v.slice(2, 4);

            if (!codigosDep.includes(departamento)) {
                i.classList.add('is-invalid');
                document.getElementById('errorIdentidad').textContent = 'Código de departamento inválido.';
            } else if (!municipiosPorDepartamento[departamento] || !municipiosPorDepartamento[departamento].includes(municipio)) {
                i.classList.add('is-invalid');
                document.getElementById('errorIdentidad').textContent = 'Código de municipio inválido para el departamento seleccionado.';
            } else {
                i.classList.remove('is-invalid');
                document.getElementById('errorIdentidad').textContent = '';
            }
        } else {
            i.classList.remove('is-invalid');
            document.getElementById('errorIdentidad').textContent = '';
        }

        if (v.length >= 8) {
            const anio = parseInt(v.slice(4, 8), 10);
            if (isNaN(anio) || anio < 1940 || anio > 2007) {
                i.classList.add('is-invalid');
                document.getElementById('errorIdentidad').textContent = 'El año debe estar entre 1940 y 2007.';
            } else if (v.length >= 4 && codigosDep.includes(v.slice(0,2)) && municipiosPorDepartamento[v.slice(0,2)] && !municipiosPorDepartamento[v.slice(0,2)].includes(v.slice(2,4))) {
                i.classList.add('is-invalid');
                document.getElementById('errorIdentidad').textContent = 'Código de municipio inválido para el departamento seleccionado.';
            } else {
                i.classList.remove('is-invalid');
                document.getElementById('errorIdentidad').textContent = '';
            }
        }
        i.value = v.slice(0, 13);
    }

    function configurarValidacionTelefono(id) {
        const input = document.getElementById(id);

        input.addEventListener('keydown', function (e) {
            const teclasPermitidas = [
                'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab', 'Home', 'End'
            ];
            if (teclasPermitidas.includes(e.key)) return;

            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
                return;
            }

            if (this.selectionStart === 0 && !['2', '3', '8', '9'].includes(e.key)) {
                e.preventDefault();
            }
        });

        input.addEventListener('input', function () {
            let valor = this.value.replace(/[^0-9]/g, '');

            if (valor.length > 8) {
                valor = valor.slice(0, 8);
            }

            if (/^(\d)\1{7}$/.test(valor)) {
                this.classList.add('is-invalid');
                mostrarError(this, 'No puede tener todos los dígitos iguales.');
            } else if (valor.length === 8 && !['2', '3', '8', '9'].includes(valor[0])) {
                this.classList.add('is-invalid');
                mostrarError(this, 'Debe comenzar con 2, 3, 8 o 9.');
            } else {
                this.classList.remove('is-invalid');
                limpiarError(this);
            }

            this.value = valor;
        });
    }

    function mostrarError(input, mensaje) {
        const errorId = 'error-' + input.id;
        let errorEl = document.getElementById(errorId);

        if (!errorEl) {
            errorEl = document.createElement('div');
            errorEl.classList.add('invalid-feedback');
            errorEl.id = errorId;
            input.parentNode.appendChild(errorEl);
        }

        errorEl.textContent = mensaje;
        input.classList.add('is-invalid');
    }

    function limpiarError(input) {
        const errorId = 'error-' + input.id;
        const errorEl = document.getElementById(errorId);
        if (errorEl) {
            errorEl.remove();
        }
        input.classList.remove('is-invalid');
    }

    configurarValidacionTelefono('telefono');
    configurarValidacionTelefono('telefonodeemergencia');

    document.addEventListener('DOMContentLoaded', function () {
        permitirSoloTelefonosValidos(document.getElementById('telefono'));
        permitirSoloTelefonosValidos(document.getElementById('telefonodeemergencia'));
    });

    document.querySelectorAll('.alergia-checkbox').forEach(chk => {
        chk.addEventListener('change', () => {
            document.getElementById('alergiaOtros').style.display =
                document.querySelector('.alergia-checkbox[value="Otros"]').checked ? 'block' : 'none';
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const checkboxOtros = document.querySelector('input[name="alergias[]"][value="Otros"]');
        const campoOtros = document.getElementById('alergiaOtros');
        const formulario = document.getElementById('empleadoForm');

        checkboxOtros.addEventListener('change', function () {
            if (this.checked) {
                campoOtros.style.display = 'block';
            } else {
                campoOtros.style.display = 'none';
                campoOtros.classList.remove('is-invalid');
            }
        });

        formulario.addEventListener('submit', function (e) {
            let errores = [];

            if (checkboxOtros.checked && campoOtros.value.trim() === '') {
                campoOtros.classList.add('is-invalid');
                errores.push('Debe especificar la alergia Otros');
            } else {
                campoOtros.classList.remove('is-invalid');
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });

        campoOtros.addEventListener('input', function () {
            if (campoOtros.value.trim() !== '') {
                campoOtros.classList.remove('is-invalid');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxOtros = document.querySelector('input[value="Otros"]');
        const campoOtros = document.getElementById('alergiaOtros');

        checkboxOtros.addEventListener('change', function () {
            if (this.checked) {
                campoOtros.style.display = 'block';
            } else {
                campoOtros.style.display = 'none';
                campoOtros.value = '';
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/empleados/edit.blade.php ENDPATH**/ ?>