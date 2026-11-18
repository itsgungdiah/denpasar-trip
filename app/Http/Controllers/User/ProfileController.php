<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        abort_unless($user?->role === 'user', 403);

        $user->loadCount([
            'reviews',
            'trips as trips_count' => fn ($query) => $query->whereHas('itineraries'),
        ]);
        $reviews = $user->reviews()
            ->with('destination:id,name,image')
            ->latest('created_at')
            ->latest('id')
            ->limit(3)
            ->get();

        return view('user.profile', compact('user', 'reviews'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        abort_unless($user?->role === 'user', 403);

        $request->merge([
            'email' => is_string($request->input('email'))
                ? strtolower(trim($request->input('email')))
                : $request->input('email'),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'required_with:new_password_confirmation', Password::min(8)->letters()->numbers(), 'confirmed'],
            'new_password_confirmation' => ['nullable', 'required_with:new_password'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'current_password.required_with' => 'Masukkan password saat ini untuk menggantinya.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'new_password.required_with' => 'Password baru wajib diisi jika konfirmasi diberikan.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new_password_confirmation.required_with' => 'Konfirmasi password baru wajib diisi.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (filled($validated['new_password'] ?? null)) {
            $user->password = $validated['new_password'];
        }
        $user->save();

        return redirect()
            ->route('profile.show')
            ->with('success', 'Informasi profil berhasil diperbarui.');
    }
}
