<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    // ─── VERIFICACIÓN DURANTE LOGIN ──────────────────────────────────────────

    public function showVerify()
    {
        if (!session('two_factor_pending_user')) {
            return redirect()->route('login');
        }
        return view('auth.two_factor_verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ], [
            'code.required' => 'Ingrese el código de verificación.',
        ]);

        $userId = session('two_factor_pending_user');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::findOrFail($userId);
        $code = preg_replace('/\s+/', '', $request->code);

        // Intentar con código TOTP
        $valid = $this->google2fa->verifyKey($user->two_factor_secret, $code);

        // Intentar con código de recuperación
        if (!$valid) {
            $recoveryCodes = json_decode($user->two_factor_recovery_codes ?? '[]', true);
            if (in_array($code, $recoveryCodes)) {
                $valid = true;
                // Invalidar el código de recuperación usado
                $recoveryCodes = array_values(array_filter($recoveryCodes, fn($c) => $c !== $code));
                $user->update(['two_factor_recovery_codes' => json_encode($recoveryCodes)]);
            }
        }

        if (!$valid) {
            return back()->withErrors(['code' => 'Código incorrecto. Intente de nuevo.']);
        }

        Auth::loginUsingId($userId);
        $request->session()->forget('two_factor_pending_user');
        $request->session()->put('two_factor_verified', true);
        $request->session()->regenerate();

        return redirect()->intended(route('index'));
    }

    // ─── CONFIGURACIÓN DE 2FA ────────────────────────────────────────────────

    public function showSetup()
    {
        $user = Auth::user();

        if ($user->hasTwoFactorEnabled()) {
            return redirect()->route('two-factor.manage');
        }

        $secret = $this->google2fa->generateSecretKey();
        session(['two_factor_setup_secret' => $secret]);

        $qrUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email ?? $user->usuario,
            $secret
        );

        // Generar QR como imagen base64
        $qrCode = $this->generateQrCodeBase64($qrUrl);

        return view('auth.two_factor_setup', compact('secret', 'qrCode'));
    }

    public function enable(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'digits:6'],
        ], [
            'code.required' => 'Ingrese el código de la app.',
            'code.digits'   => 'El código debe tener 6 dígitos.',
        ]);

        $secret = session('two_factor_setup_secret');
        if (!$secret) {
            return redirect()->route('two-factor.setup')->withErrors(['code' => 'Sesión expirada. Intente de nuevo.']);
        }

        $valid = $this->google2fa->verifyKey($secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Código incorrecto. Verifique que su app esté sincronizada.']);
        }

        $recoveryCodes = $this->generateRecoveryCodes();

        Auth::user()->update([
            'two_factor_secret'         => $secret,
            'two_factor_enabled'        => true,
            'two_factor_recovery_codes' => json_encode($recoveryCodes),
        ]);

        session()->forget('two_factor_setup_secret');
        session(['two_factor_verified' => true]);

        return redirect()->route('two-factor.recovery-codes')
            ->with('status', 'Autenticación de dos factores activada correctamente.');
    }

    public function showManage()
    {
        $user = Auth::user();
        if (!$user->hasTwoFactorEnabled()) {
            return redirect()->route('two-factor.setup');
        }
        return view('auth.two_factor_manage');
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [
            'password.required'         => 'Ingrese su contraseña para confirmar.',
            'password.current_password' => 'Contraseña incorrecta.',
        ]);

        Auth::user()->update([
            'two_factor_secret'         => null,
            'two_factor_enabled'        => false,
            'two_factor_recovery_codes' => null,
        ]);

        return redirect()->route('index')
            ->with('status', 'Autenticación de dos factores desactivada.');
    }

    public function showRecoveryCodes()
    {
        $user = Auth::user();
        if (!$user->hasTwoFactorEnabled()) {
            return redirect()->route('two-factor.setup');
        }
        $recoveryCodes = json_decode($user->two_factor_recovery_codes ?? '[]', true);
        return view('auth.two_factor_recovery_codes', compact('recoveryCodes'));
    }

    // ─── HELPERS ─────────────────────────────────────────────────────────────

    private function generateRecoveryCodes(): array
    {
        return array_map(fn() => strtoupper(Str::random(5) . '-' . Str::random(5)), range(1, 8));
    }

    private function generateQrCodeBase64(string $url): string
    {
        try {
            $renderer = new \BaconQrCode\Renderer\ImageRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200),
                new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
            );
            $writer = new \BaconQrCode\Writer($renderer);
            $svg = $writer->writeString($url);
            return 'data:image/svg+xml;base64,' . base64_encode($svg);
        } catch (\Throwable $e) {
            return '';
        }
    }
}
