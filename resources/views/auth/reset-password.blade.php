<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Buat Password Baru | DenpasarTrip</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh bg-[#14211F] font-sans">
    <main class="relative isolate flex min-h-dvh items-center justify-center overflow-hidden px-4 py-10 sm:px-8">
        <img src="{{ asset('images/login.png') }}" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-[#10252b]/35 dark:bg-[#081713]/55" aria-hidden="true"></div>
        <a href="{{ route('login') }}" class="absolute left-5 top-5 z-10 flex items-center gap-2.5 text-xl font-extrabold tracking-tight text-white drop-shadow sm:left-8 sm:top-7" aria-label="DenpasarTrip — halaman masuk">
            <img src="{{ asset('images/logo.png') }}" alt="" class="h-9 w-9 object-contain">
            <span>Denpasar<span class="text-[#C76D4C]">Trip</span></span>
        </a>
        <section class="relative z-10 w-full max-w-md rounded-[1.75rem] border border-white/85 bg-[linear-gradient(145deg,rgba(255,255,255,.86),rgba(247,243,236,.74))] p-6 shadow-[0_28px_80px_rgba(8,28,35,.28),inset_0_1px_0_rgba(255,255,255,.95)] backdrop-blur-2xl dark:border-white/25 dark:bg-[linear-gradient(145deg,rgba(23,39,35,.9),rgba(13,30,26,.82))] sm:p-8">
            <h1 class="font-display text-3xl font-bold tracking-tight text-[#152535] dark:text-[#F5F2EB]">Buat password baru</h1>
            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Gunakan password minimal 8 karakter yang mengandung huruf dan angka.</p>
            <form action="{{ route('password.update') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $email) }}" autocomplete="email" required autofocus class="w-full rounded-xl border {{ $errors->has('email') ? 'border-red-500' : 'border-white/90 dark:border-white/20' }} bg-white/70 px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-[#123F38] focus:ring-2 focus:ring-[#123F38]/20 dark:bg-[#1D2B28]/75 dark:text-slate-100 dark:focus:border-[#9AC7B8]">
                    @error('email')<p class="mt-1 text-sm text-red-600 dark:text-red-300" role="alert">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700 dark:text-slate-200">Password baru</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required class="w-full rounded-xl border {{ $errors->has('password') ? 'border-red-500' : 'border-white/90 dark:border-white/20' }} bg-white/70 px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-[#123F38] focus:ring-2 focus:ring-[#123F38]/20 dark:bg-[#1D2B28]/75 dark:text-slate-100 dark:focus:border-[#9AC7B8]">
                    @error('password')<p class="mt-1 text-sm text-red-600 dark:text-red-300" role="alert">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-slate-700 dark:text-slate-200">Konfirmasi password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="w-full rounded-xl border border-white/90 bg-white/70 px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-[#123F38] focus:ring-2 focus:ring-[#123F38]/20 dark:border-white/20 dark:bg-[#1D2B28]/75 dark:text-slate-100 dark:focus:border-[#9AC7B8]">
                </div>
                <button type="submit" class="w-full rounded-xl border border-white/30 bg-[linear-gradient(135deg,rgba(18,63,56,.96),rgba(13,48,43,.88))] px-5 py-3 text-sm font-semibold text-white shadow-[0_10px_24px_rgba(18,63,56,.24),inset_0_1px_0_rgba(255,255,255,.24)] transition hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#123F38] focus:ring-offset-2 motion-reduce:transition-none">Simpan password baru</button>
            </form>
        </section>
    </main>
</body>
</html>
