<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Verifica credenciales vía AJAX antes de mostrar el captcha.
     * NO inicia sesión, solo confirma que usuario y contraseña son válidos.
     */
    public function checkCredentials(Request $request)
    {
        $request->validate([
            'usuario'  => ['required', 'string', 'min:3', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:64'],
        ]);

        if (Auth::validate($request->only('usuario', 'password'))) {
            return response()->json(['ok' => true]);
        }

        usleep(500000);
        return response()->json(['ok' => false, 'message' => 'Credenciales incorrectas.'], 422);
    }

    /**
     * Genera un token firmado de captcha y lo guarda en sesión.
     * El JS lo llama cuando el usuario completa el desafío visual.
     */
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

        // Validar token de captcha: debe existir en sesión, coincidir y tener menos de 5 minutos
        $sessionToken = session('captcha_token');
        $tokenAt      = session('captcha_token_at', 0);
        $tokenValid   = $sessionToken
            && hash_equals($sessionToken, $request->captcha_token)
            && (now()->timestamp - $tokenAt) < 300;

        // Invalidar el token para que no se reutilice
        session()->forget(['captcha_token', 'captcha_token_at']);

        if (! $tokenValid) {
            return back()->withErrors([
                'captcha_token' => 'La verificación de seguridad expiró o es inválida. Inténtelo de nuevo.',
            ])->withInput($request->except('password', 'captcha_token'));
        }

        $credentials = $request->only('usuario', 'password');

        if (Auth::validate($credentials)) {
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
