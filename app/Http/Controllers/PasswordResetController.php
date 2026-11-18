<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        $request->validate(['email' => ['required', 'email', 'max:255']]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Tautan reset password telah dikirim ke email Anda.');
        }

        return back()->withErrors([
            'email' => $status === Password::RESET_THROTTLED
                ? 'Mohon tunggu sebelum meminta tautan reset baru.'
                : 'Kami tidak menemukan akun dengan email tersebut.',
        ])->onlyInput('email');
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function reset(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);

        $credentials = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed', 'string', PasswordRule::min(8)->letters()->numbers()],
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.letters' => 'Password harus mengandung huruf.',
            'password.numbers' => 'Password harus mengandung angka.',
        ]);

        $status = Password::reset(
            $credentials,
            function ($user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            },
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan masuk dengan password baru.');
        }

        return back()->withErrors([
            'email' => $status === Password::INVALID_TOKEN
                ? 'Tautan reset tidak valid atau sudah kedaluwarsa. Minta tautan baru.'
                : 'Kami tidak menemukan akun dengan email tersebut.',
        ])->withInput($request->only('email'));
    }
}
