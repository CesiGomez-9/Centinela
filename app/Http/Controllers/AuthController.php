<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\LoginAttempt;

class AuthController extends Controller
{
    // ── Obtener o crear el registro de intentos para esta IP
    private function getAttemptRecord(Request $request): LoginAttempt
    {
        return LoginAttempt::firstOrCreate(
            ['ip' => $request->ip()],
            ['attempts' => 0]
        );
    }

    // ── Registrar un fallo y aplicar bloqueo si corresponde
    private function registerFailure(LoginAttempt $record): void
    {
        $record->attempts++;
        $record->last_attempt_at = now();

        // Aplicar bloqueo en los umbrales: 5, 10, 15
        if ($record->attempts === 5 || $record->attempts === 10 || $record->attempts >= 15) {
            $record->locked_until = now()->addSeconds($record->getLockDurationSeconds());
        }

        $record->save();
    }

    // ── Limpiar intentos tras login exitoso
    private function clearAttempts(LoginAttempt $record): void
    {
        $record->attempts     = 0;
        $record->locked_until = null;
        $record->save();
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    // ── Devuelve los segundos de bloqueo restantes para esta IP (polling del JS)
    public function lockStatus(Request $request)
    {
        $record = LoginAttempt::where('ip', $request->ip())->first();

        if (! $record || ! $record->isLocked()) {
            return response()->json(['locked' => false, 'seconds' => 0]);
        }

        return response()->json([
            'locked'  => true,
            'seconds' => $record->secondsRemaining(),
        ]);
    }

    // ── Verifica credenciales vía AJAX antes de mostrar el captcha
    public function checkCredentials(Request $request)
    {
        $record = $this->getAttemptRecord($request);

        if ($record->isLocked()) {
            return response()->json([
                'ok'      => false,
                'locked'  => true,
                'seconds' => $record->secondsRemaining(),
                'message' => 'IP bloqueada temporalmente.',
            ], 429);
        }

        $request->validate([
            'usuario'  => ['required', 'string', 'min:3', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:64'],
        ]);

        if (Auth::validate($request->only('usuario', 'password'))) {
            return response()->json(['ok' => true]);
        }

        $this->registerFailure($record);

        $response = ['ok' => false, 'locked' => false, 'message' => 'Credenciales incorrectas.'];

        if ($record->isLocked()) {
            $response['locked']  = true;
            $response['seconds'] = $record->secondsRemaining();
        }

        usleep(500000);
        return response()->json($response, 422);
    }

    // ── Emite token de captcha (se llama tras pasar el desafío visual)
    public function issueCaptchaToken(Request $request)
    {
        $token = Str::random(40);
        session(['captcha_token' => $token, 'captcha_token_at' => now()->timestamp]);
        return response()->json(['token' => $token]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario'       => ['required', 'string', 'min:3', 'max:50'],
            'password'      => ['required', 'string', 'min:8', 'max:64'],
            'captcha_token' => ['required', 'string'],
        ], [
            'usuario.required'       => 'Debe ingresar su usuario.',
            'password.required'      => 'Debe ingresar su contraseña.',
            'password.min'           => 'La contraseña no puede ser menor de 8 caracteres.',
            'password.max'           => 'La contraseña no puede ser mayor a 64 caracteres.',
            'usuario.min'            => 'El usuario debe tener al menos 3 caracteres.',
            'usuario.max'            => 'El usuario no debe ser más de 50 caracteres.',
            'captcha_token.required' => 'Debe completar la verificación de seguridad.',
        ]);

        // Validar token de captcha
        $sessionToken = session('captcha_token');
        $tokenAt      = session('captcha_token_at', 0);
        $tokenValid   = $sessionToken
            && hash_equals($sessionToken, $request->captcha_token)
            && (now()->timestamp - $tokenAt) < 300;

        session()->forget(['captcha_token', 'captcha_token_at']);

        if (! $tokenValid) {
            return back()->withErrors([
                'captcha_token' => 'La verificación de seguridad expiró o es inválida. Inténtelo de nuevo.',
            ])->withInput($request->except('password', 'captcha_token'));
        }

        $record = $this->getAttemptRecord($request);

        if (Auth::validate($request->only('usuario', 'password'))) {
            $this->clearAttempts($record);

            $user = \App\Models\User::where('usuario', $request->usuario)->first();

            if ($user->two_factor_enabled) {
                session(['two_factor_pending_user' => $user->id]);
                if ($request->filled('remember')) {
                    session(['two_factor_remember' => true]);
                }
                return redirect()->route('two-factor.verify');
            }

            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();

            return redirect()->route('index');
        }

        usleep(500000);

        return back()->withErrors([
            'usuario' => 'Credenciales incorrectas.',
        ])->withInput($request->except('password', 'captcha_token'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
