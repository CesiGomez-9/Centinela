<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showLinkForm()
    {
        return view('auth.forgotpassword');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Debes ingresar tu correo',
            'email.email' => 'El correo debe ser válido',
            'email.exists' => 'No existe un usuario con este correo',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Se ha enviado un enlace de recuperación a tu correo')
            : back()->withErrors(['email' => 'Error al enviar el enlace. Intenta de nuevo']);
    }

    public function showResetForm($token)
    {
        return view('auth.resetpassword', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|max:8|confirmed',
        ], [
            'password.required' => 'Debes ingresar tu nueva contraseña',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.max' => 'La contraseña no puede tener más de 8 caracteres',
            'password.confirmed' => 'La confirmación no coincide',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );


        if ($status === Password::PASSWORD_RESET) {
            // Aquí aseguramos que la sesión 'status' exista
            return redirect()->route('login')
                ->with('status', '¡Contraseña restablecida correctamente!');
        }


        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Contraseña restablecida correctamente')
            : back()->withErrors(['email' => 'Error al restablecer la contraseña']);
    }
}
