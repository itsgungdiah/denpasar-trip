<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->merge([
            'email' => is_string($request->input('email'))
                ? strtolower(trim($request->input('email')))
                : $request->input('email'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'string', Password::min(8)->letters()->numbers()],
            'password_confirmation' => ['required', 'same:password'],
            'terms' => 'accepted',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.letters' => 'Password harus mengandung huruf.',
            'password.numbers' => 'Password harus mengandung angka.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok.',
            'terms.accepted' => 'Kamu harus menyetujui Syarat & Ketentuan dan Kebijakan Privasi.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Akun berhasil dibuat! Silakan masuk menggunakan akunmu.');
    }

    public function login(Request $request)
    {
        $request->merge([
            'email' => is_string($request->input('email'))
                ? strtolower(trim($request->input('email')))
                : $request->input('email'),
        ]);

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectForRole(Auth::user(), $request);
        }

        return back()->withErrors([
            'email' => 'Email atau password yang kamu masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function redirectToProvider(Request $request, string $provider)
    {
        abort_unless(in_array($provider, ['google', 'apple'], true), 404);

        if ($provider === 'apple') {
            return redirect()->route('login');
        }

        if (! $this->providerIsConfigured($provider)) {
            return redirect()->route('login')->withErrors([
                'oauth' => 'Login ' . ucfirst($provider) . ' belum dikonfigurasi. Silakan hubungi admin.',
            ]);
        }

        try {
            // Bind the OAuth state to a short-lived, encrypted, HttpOnly cookie.
            // This avoids relying on the Laravel session surviving Google's
            // cross-site redirect while retaining the state/CSRF check.
            $state = Str::random(40);
            $redirect = Socialite::driver($provider)
                ->stateless()
                ->with(['state' => $state])
                ->redirect();

            $callbackIsSecure = parse_url((string) config("services.{$provider}.redirect"), PHP_URL_SCHEME) === 'https';

            return $redirect->withCookie(cookie(
                'google_oauth_state',
                $state,
                5,
                '/auth/google/callback',
                null,
                $callbackIsSecure,
                true,
                false,
                'lax'
            ));
        } catch (Throwable $exception) {
            Log::warning('OAuth redirect could not be started.', [
                'provider' => $provider,
                'exception' => $exception::class,
            ]);

            return redirect()->route('login')->withErrors([
                'oauth' => 'Login ' . ucfirst($provider) . ' gagal dimulai. Silakan coba lagi.',
            ]);
        }
    }

    public function handleProviderCallback(Request $request, string $provider)
    {
        abort_unless(in_array($provider, ['google', 'apple'], true), 404);

        if ($provider === 'apple') {
            return redirect()->route('login');
        }

        if ($request->filled('error')) {
            return redirect()->route('login')->withErrors([
                'oauth' => 'Login ' . ucfirst($provider) . ' dibatalkan atau tidak disetujui.',
            ])->withCookie(Cookie::forget('google_oauth_state', '/auth/google/callback'));
        }

        $expectedState = $request->cookie('google_oauth_state');
        $receivedState = $request->query('state');

        if (! is_string($expectedState) || ! is_string($receivedState) || ! hash_equals($expectedState, $receivedState)) {
            Log::warning('OAuth callback state validation failed.', [
                'provider' => $provider,
            ]);

            return redirect()->route('login')->withErrors([
                'oauth' => 'Login ' . ucfirst($provider) . ' gagal. Silakan coba lagi.',
            ])->withCookie(Cookie::forget('google_oauth_state', '/auth/google/callback'));
        }

        try {
            $driver = Socialite::driver($provider)->stateless();
            $providerUser = $driver->user();
            $raw = $providerUser->getRaw();
            $emailVerified = filter_var(
                $raw['email_verified'] ?? $raw['verified_email'] ?? false,
                FILTER_VALIDATE_BOOLEAN
            );
            $email = strtolower(trim((string) $providerUser->getEmail()));

            if (! $emailVerified || ! filter_var($email, FILTER_VALIDATE_EMAIL) || ! $providerUser->getId()) {
                return redirect()->route('login')->withErrors([
                    'oauth' => 'Penyedia tidak memberikan identitas email terverifikasi yang diperlukan.',
                ])->withCookie(Cookie::forget('google_oauth_state', '/auth/google/callback'));
            }

            $user = User::where('email', $email)->first();

            if (! $user) {
                $name = trim(strip_tags((string) $providerUser->getName()));
                if ($name === '') {
                    $name = Str::before($email, '@');
                }

                try {
                    $user = User::create([
                        'name' => Str::limit($name, 255, ''),
                        'email' => $email,
                        'password' => Hash::make(Str::random(64)),
                        'role' => 'user',
                    ]);
                    $user->forceFill(['email_verified_at' => now()])->save();
                } catch (QueryException $exception) {
                    $user = User::where('email', $email)->first();

                    if (! $user) {
                        throw $exception;
                    }
                }
            }

            if (! in_array($user->role, ['user', 'admin'], true)) {
                return redirect()->route('login')->withErrors([
                    'oauth' => 'Akun tidak memiliki akses ke sistem.',
                ])->withCookie(Cookie::forget('google_oauth_state', '/auth/google/callback'));
            }

            if (! $user->email_verified_at) {
                $user->forceFill(['email_verified_at' => now()])->save();
            }

            Auth::login($user);
            $request->session()->regenerate();

            return $this->redirectForRole($user, $request)
                ->withCookie(Cookie::forget('google_oauth_state', '/auth/google/callback'));
        } catch (Throwable $exception) {
            Log::warning('OAuth callback could not be completed.', [
                'provider' => $provider,
                'exception' => $exception::class,
            ]);

            return redirect()->route('login')->withErrors([
                'oauth' => 'Login ' . ucfirst($provider) . ' gagal. Silakan coba lagi.',
            ])->withCookie(Cookie::forget('google_oauth_state', '/auth/google/callback'));
        }
    }

    private function providerIsConfigured(string $provider): bool
    {
        return filled(config("services.{$provider}.client_id"))
            && filled(config("services.{$provider}.client_secret"))
            && filled(config("services.{$provider}.redirect"));
    }

    private function redirectForRole(User $user, Request $request)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'user') {
            return redirect()->intended(route('user.dashboard'));
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withErrors([
            'oauth' => 'Akun tidak memiliki akses ke sistem.',
        ]);
    }
}
