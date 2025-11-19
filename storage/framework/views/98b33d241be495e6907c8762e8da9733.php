<?php $__env->startSection('content'); ?>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-person-badge position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:4rem;"></i>
            <div class="position-relative mb-4" style="padding-top: 5px;">
                
                <button type="button"
                        class="btn btn-sm btn-outline-primary position-absolute"
                        style="top: 0; left: 0; transform: translateY(2px);">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
                </button>
                <h3 class="text-center m-0" style="color:#09457f; line-height:1;">
                    <i class="bi bi-person-fill me-2"></i>
                    <?php if(isset($user)): ?> Editar usuario <?php else: ?> Registrar usuario <?php endif; ?>
                </h3>

            </div>


        <?php if(session('guardado')): ?>
                <div class="alert alert-success">¡Usuario guardado correctamente!</div>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(isset($user) ? route('users.update', $user->id) : route('users.store')); ?>" id="userForm" novalidate>
                <?php echo csrf_field(); ?>
                <?php if(isset($user)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" id="name" name="name" maxlength="50"
                                   value="<?php echo e(old('name', $user->name ?? '')); ?>"
                                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   oninput="validarTexto(this,50)" />
                            <div class="invalid-feedback"><?php $__errorArgs = ['name'];
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
                        <label class="form-label fw-bold">Apellido:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" id="apellido" name="apellido" maxlength="50"
                                   value="<?php echo e(old('apellido', $user->apellido ?? '')); ?>"
                                   class="form-control <?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
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

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Usuario:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" id="apellido" name="apellido" maxlength="50"
                                   value="<?php echo e(old('apellido', $user->apellido ?? '')); ?>"
                                   class="form-control <?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
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
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Teléfono:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                            <input type="text" id="telefono" name="telefono" maxlength="8"
                                   value="<?php echo e(old('telefono')); ?>"
                                   class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   oninput="formatearTelefono(this)" />
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

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Correo electrónico:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" id="email" name="email" maxlength="50"
                                   value="<?php echo e(old('email', $user->email ?? '')); ?>"
                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" />
                            <div class="invalid-feedback" id="emailError">
                                <?php $__errorArgs = ['email'];
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

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Contraseña:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="password" name="password" maxlength="50"
                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('password')); ?>"
                                   <?php if(isset($user)): ?> placeholder="Dejar vacío si no desea cambiar" <?php endif; ?> />

                            <div class="invalid-feedback" id="passwordError">
                                <?php $__errorArgs = ['password'];
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

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Confirmar contraseña:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="password" name="password" maxlength="50"
                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('password')); ?>"
                                   <?php if(isset($user)): ?> placeholder="Dejar vacío si no desea cambiar" <?php endif; ?> />

                            <div class="invalid-feedback" id="passwordError">
                                <?php $__errorArgs = ['password'];
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


                    <div class="text-center mt-4 col-12">
                        <a href="<?php echo e(route('users.index')); ?>" class="btn btn-danger me-2">
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/users/create.blade.php ENDPATH**/ ?>