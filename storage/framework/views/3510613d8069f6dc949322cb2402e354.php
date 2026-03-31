<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Sistema de Seguridad Centinela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            position: relative;
            overflow: hidden;
            background: url('<?php echo e(asset("camara.jpg")); ?>') no-repeat center center fixed;
            background-size: cover;
        }

        body::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 900px;
            height: 700px;
            background: radial-gradient(circle, rgba(59,130,246,0.2), transparent 70%);
            z-index: 0;
        }

        .login-card {
            width: 400px;
            padding: 3rem;
            background: #112b52;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.5);
            color: #ffffff;
            text-align: center;
            animation: fadeIn 0.8s ease-out;
            position: relative;
            z-index: 1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card .icon {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #3b82f6;
        }

        .login-card h2 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-card p {
            margin-bottom: 1.5rem;
            color: #cbd5e1;
        }

        .form-control {
            background: transparent !important;
            border: 1px solid #3b82f6;
            border-radius: 10px;
            color: #ffffff;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 8px rgba(59,130,246,0.5);
            color: #ffffff;
        }

        .form-control::placeholder {
            color: #ffffff;
            opacity: 1;
        }

        .btn-login {
            width: 100%;
            background: #3b82f6;
            color: #ffffff;
            border: none;
            font-weight: bold;
            padding: 0.8rem;
            border-radius: 12px;
            font-size: 1rem;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #1e40af;
            color: #ffffff;
        }

        .text-small {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-top: 15px;
        }

        @media (max-width: 450px) {
            .login-card {
                width: 90%;
                padding: 2.5rem;
            }
        }

        /* ───── MODAL CAPTCHA ───── */
        .captcha-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(5, 15, 35, 0.85);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(4px);
        }

        .captcha-overlay.active {
            display: flex;
        }

        .captcha-modal {
            background: #112b52;
            border: 1px solid #3b82f6;
            border-radius: 20px;
            padding: 2rem;
            width: 360px;
            max-width: 95vw;
            box-shadow: 0 0 40px rgba(59,130,246,0.3);
            animation: popIn 0.3s ease-out;
            text-align: center;
            color: #fff;
        }

        @keyframes popIn {
            from { opacity: 0; transform: scale(0.85); }
            to   { opacity: 1; transform: scale(1); }
        }

        .captcha-modal .captcha-title {
            font-size: 1rem;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 0.3rem;
        }

        .captcha-instruction {
            font-size: 1.15rem;
            font-weight: 700;
            color: #60a5fa;
            margin-bottom: 1.2rem;
            min-height: 1.8rem;
        }

        .captcha-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 1.2rem;
        }

        .captcha-cell {
            background: #0f1f3d;
            border: 2px solid #1e3a6e;
            border-radius: 12px;
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s, transform 0.15s;
            font-size: 2.8rem;
            user-select: none;
        }

        .captcha-cell:hover {
            border-color: #3b82f6;
            background: #162f5c;
            transform: scale(1.05);
        }

        .captcha-cell.selected-correct {
            border-color: #22c55e;
            background: rgba(34,197,94,0.15);
        }

        .captcha-cell.selected-wrong {
            border-color: #ef4444;
            background: rgba(239,68,68,0.15);
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            25%      { transform: translateX(-6px); }
            75%      { transform: translateX(6px); }
        }

        .captcha-feedback {
            font-size: 0.9rem;
            min-height: 1.4rem;
            margin-bottom: 0.8rem;
        }

        .captcha-feedback.ok  { color: #22c55e; }
        .captcha-feedback.err { color: #ef4444; }

        .captcha-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .btn-captcha-refresh {
            background: transparent;
            border: 1px solid #3b82f6;
            border-radius: 8px;
            color: #3b82f6;
            padding: 0.4rem 0.75rem;
            cursor: pointer;
            font-size: 0.9rem;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-captcha-refresh:hover {
            background: #3b82f6;
            color: #fff;
        }

        .captcha-dots {
            display: flex;
            gap: 6px;
        }

        .captcha-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #1e3a6e;
            transition: background 0.3s;
        }

        .captcha-dot.done {
            background: #22c55e;
        }

        .captcha-dot.active {
            background: #3b82f6;
        }
    </style>
</head>
<body>

<div class="login-card">
    <i class="bi bi-shield-lock-fill icon"></i>
    <h2>Bienvenido</h2>
    <p>Grupo Centinela</p>

    <form id="login-form" action="<?php echo e(route('login.process')); ?>" method="POST" novalidate autocomplete="off">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="captcha_token" id="captcha_token">

        <!-- Usuario -->
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text"
                   class="form-control"
                   id="usuario"
                   name="usuario"
                   minlength="3"
                   maxlength="50"
                   placeholder="Ingrese su usuario"
                   value="<?php echo e(old('usuario')); ?>" required
                   autocomplete="off">
            <?php $__errorArgs = ['usuario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="text-danger mt-1" style="font-size:0.9rem;"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Contraseña -->
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password"
                   class="form-control"
                   id="password"
                   name="password"
                   minlength="8"
                   maxlength="64"
                   placeholder="Ingrese su contraseña" required
                   autocomplete="new-password">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="text-danger mt-1" style="font-size:0.9rem;"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <?php $__errorArgs = ['captcha_token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="text-danger mb-2" style="font-size:0.9rem;"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <button type="button" class="btn btn-login" id="btn-open-captcha">
            <i class="bi bi-box-arrow-in-right"></i> Ingresar
        </button>
    </form>

    <p class="text-small">
        <a href="<?php echo e(route('password.request')); ?>" style="color:#3b82f6; text-decoration:none;">
            ¿Olvidaste tu contraseña?
        </a>
    </p>
</div>


<!-- ───── MODAL CAPTCHA ───── -->
<div class="captcha-overlay" id="captcha-overlay">
    <div class="captcha-modal">
        <p class="captcha-title"><i class="bi bi-shield-check" style="color:#3b82f6;"></i> Verificación de seguridad</p>
        <div class="captcha-instruction" id="captcha-instruction">Cargando...</div>

        <div class="captcha-grid" id="captcha-grid"></div>

        <div class="captcha-feedback" id="captcha-feedback"></div>

        <div class="captcha-footer">
            <button type="button" class="btn-captcha-refresh" id="btn-captcha-refresh">
                <i class="bi bi-arrow-clockwise"></i> Nuevo desafío
            </button>
            <div class="captcha-dots" id="captcha-dots"></div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {

    // ── Definición de manos y sus emojis
    const HANDS = {
        derecha: { emoji: '👉', label: 'apunta a la DERECHA' },
        izquierda: { emoji: '👈', label: 'apunta a la IZQUIERDA' },
        arriba:  { emoji: '👆', label: 'apunta hacia ARRIBA'  },
        abajo:   { emoji: '👇', label: 'apunta hacia ABAJO'   },
    };

    const DIRECTIONS = Object.keys(HANDS);
    const TOTAL_ROUNDS = 3;   // cuántos aciertos se necesitan

    let rounds = [];          // lista de rondas generadas
    let currentRound = 0;
    let locked = false;       // bloquear clicks mientras se anima

    // ── Genera el captcha completo (N rondas)
    function generateCaptcha() {
        rounds = [];
        for (let i = 0; i < TOTAL_ROUNDS; i++) {
            const target = DIRECTIONS[Math.floor(Math.random() * DIRECTIONS.length)];
            // Crear 9 celdas: una con la dirección correcta, las demás aleatorias
            let cells = [];
            const correctPos = Math.floor(Math.random() * 9);
            for (let j = 0; j < 9; j++) {
                if (j === correctPos) {
                    cells.push(target);
                } else {
                    // Dirección aleatoria diferente a la anterior del mismo slot
                    let rand;
                    do { rand = DIRECTIONS[Math.floor(Math.random() * DIRECTIONS.length)]; }
                    while (rand === target);
                    cells.push(rand);
                }
            }
            rounds.push({ target, correctPos, cells });
        }
        currentRound = 0;
    }

    // ── Renderiza la ronda actual
    function renderRound() {
        locked = false;
        const round = rounds[currentRound];
        const hand  = HANDS[round.target];

        document.getElementById('captcha-instruction').innerHTML =
            `Selecciona la mano que <strong>${hand.label}</strong>`;

        const grid = document.getElementById('captcha-grid');
        grid.innerHTML = '';

        round.cells.forEach((dir, idx) => {
            const cell = document.createElement('div');
            cell.className = 'captcha-cell';
            cell.textContent = HANDS[dir].emoji;
            cell.dataset.idx = idx;
            cell.addEventListener('click', () => onCellClick(cell, idx, round));
            grid.appendChild(cell);
        });

        renderDots();
        setFeedback('', '');
    }

    // ── Renderiza los puntos de progreso
    function renderDots() {
        const container = document.getElementById('captcha-dots');
        container.innerHTML = '';
        for (let i = 0; i < TOTAL_ROUNDS; i++) {
            const dot = document.createElement('div');
            dot.className = 'captcha-dot' +
                (i < currentRound  ? ' done'   : '') +
                (i === currentRound ? ' active' : '');
            container.appendChild(dot);
        }
    }

    // ── Maneja clic en una celda
    function onCellClick(cell, idx, round) {
        if (locked) return;
        locked = true;

        if (idx === round.correctPos) {
            cell.classList.add('selected-correct');
            setFeedback('¡Correcto!', 'ok');

            setTimeout(() => {
                currentRound++;
                if (currentRound >= TOTAL_ROUNDS) {
                    // Captcha completado — obtener token y enviar form
                    captchaSuccess();
                } else {
                    renderRound();
                }
            }, 600);
        } else {
            cell.classList.add('selected-wrong');
            setFeedback('Incorrecto, intenta de nuevo.', 'err');
            setTimeout(() => {
                generateCaptcha();
                renderRound();
            }, 900);
        }
    }

    function setFeedback(msg, type) {
        const el = document.getElementById('captcha-feedback');
        el.textContent = msg;
        el.className = 'captcha-feedback' + (type ? ' ' + type : '');
    }

    // ── Éxito: generar token firmado en servidor y enviar
    function captchaSuccess() {
        setFeedback('Verificado ✓', 'ok');

        fetch('<?php echo e(route("captcha.token")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            },
        })
        .then(r => r.json())
        .then(data => {
            document.getElementById('captcha_token').value = data.token;
            setTimeout(() => {
                document.getElementById('captcha-overlay').classList.remove('active');
                document.getElementById('login-form').submit();
            }, 500);
        });
    }

    // ── Abrir modal al presionar "Ingresar"
    document.getElementById('btn-open-captcha').addEventListener('click', function () {
        const usuario  = document.getElementById('usuario').value.trim();
        const password = document.getElementById('password').value;

        if (usuario.length < 3 || password.length < 8) {
            // Dejar que el form muestre sus propias validaciones
            document.getElementById('login-form').reportValidity();
            return;
        }

        generateCaptcha();
        renderRound();
        document.getElementById('captcha-overlay').classList.add('active');
    });

    // ── Botón "Nuevo desafío"
    document.getElementById('btn-captcha-refresh').addEventListener('click', function () {
        generateCaptcha();
        renderRound();
    });

    // ── bfcache: limpiar campos al volver con botón Atrás
    window.addEventListener('pageshow', function (e) {
        if (e.persisted) {
            document.getElementById('usuario').value = '';
            document.getElementById('password').value = '';
            document.getElementById('captcha_token').value = '';
        }
    });

})();
</script>
</body>
</html>
<?php /**PATH C:\laragon\www\Centinela\resources\views/auth/login.blade.php ENDPATH**/ ?>