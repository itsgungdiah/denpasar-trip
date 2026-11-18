<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Login | DenpasarTrip</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh w-full bg-[#14211F] font-sans motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
    <main class="relative isolate min-h-dvh w-full overflow-hidden bg-[#14211F] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
        <img src="{{ asset('images/login.png') }}" alt="" aria-hidden="true" class="absolute inset-0 z-0 h-full w-full object-cover object-center motion-reduce:transition-none">
        <div class="absolute inset-0 z-[1] bg-gradient-to-r from-[#10252b]/45 via-[#10252b]/10 to-[#10252b]/20 dark:from-[#081713]/55 dark:via-[#081713]/25 dark:to-[#081713]/40" aria-hidden="true"></div>
        <a href="{{ route('login') }}" class="relative z-10 ml-4 flex w-fit items-center gap-2.5 pt-4 text-[#152535] dark:text-[#F5F2EB] drop-shadow-sm sm:ml-8 sm:pt-5 xl:absolute xl:left-8 xl:top-5 xl:ml-0 xl:pt-0 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-label="DenpasarTrip — halaman masuk">
                <img src="{{ asset('images/logo.png') }}" alt="" class="h-9 w-9 object-contain motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <span class="text-[#ffffff] text-xl font-extrabold tracking-tight motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Denpasar<span class="text-[#C76D4C] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Trip</span></span>
        </a>
        <div class="relative z-10 mx-auto flex min-h-dvh w-full max-w-[1520px] flex-col px-4 pb-5 sm:px-8 xl:px-12 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <div class="grid flex-1 grid-cols-1 items-center gap-6 py-5 sm:py-6 xl:grid-cols-[minmax(0,1fr)_28rem] xl:gap-10 xl:py-6 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <section class="hidden max-w-2xl text-white xl:block motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <h1 class="font-display text-5xl font-bold leading-tight drop-shadow-sm xl:text-6xl motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    Jelajahi Keindahan
                    <span class="block text-[#C76D4C] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Denpasar</span>
                </h1>
                <p class="mt-4 max-w-lg text-base font-medium leading-relaxed text-white/95 drop-shadow-sm xl:text-lg motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    Temukan tempat terbaik, susun rencana perjalananmu, dan ciptakan pengalaman berwisata yang tak terlupakan di Denpasar, Bali.
                </p>
            </section>
            <section class="mx-auto w-full max-w-md rounded-[2rem] border border-white/85 bg-[linear-gradient(145deg,rgba(255,255,255,.82),rgba(247,243,236,.66))] px-6 py-6 shadow-[0_28px_80px_rgba(8,28,35,.28),inset_0_1px_0_rgba(255,255,255,.95),inset_0_-1px_0_rgba(255,255,255,.35)] backdrop-blur-2xl dark:border-white/25 dark:bg-[linear-gradient(145deg,rgba(23,39,35,.84),rgba(13,30,26,.72))] sm:px-8 sm:py-7 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <div class="mb-4 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    <h1 class="text-3xl font-bold tracking-tight text-[#152535] dark:text-[#F5F2EB] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Selamat Datang!</h1>
                    <p class="mt-1.5 text-base leading-relaxed text-slate-700 dark:text-slate-200 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Masuk ke akunmu untuk melanjutkan petualangan di Denpasar.</p>
                </div>
                @if (session('success') || session('status'))
                    <div class="mb-4 rounded-xl border border-emerald-200/80 bg-emerald-50/80 px-4 py-3 text-sm text-emerald-800 shadow-sm dark:border-emerald-300/20 dark:bg-emerald-950/40 dark:text-emerald-200" role="status">
                        {{ session('success') ?? session('status') }}
                    </div>
                @endif
                @if ($errors->has('oauth'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        {{ $errors->first('oauth') }}
                    </div>
                @endif
                <form action="{{ route('login.submit') }}" method="POST" novalidate data-auth-form="login">
                    @csrf
                    <div class="mb-3 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-200 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Email</label>
                        <div class="auth-input-shell flex items-center gap-3 rounded-xl border {{ $errors->has('email') ? 'border-2 !border-red-500' : 'border-white/90 dark:border-white/20' }} bg-white/35 dark:bg-[#1D2B28]/75 px-3.5 shadow-sm backdrop-blur-md focus-within:border-[#123F38] dark:focus-within:border-[#9AC7B8] focus-within:ring-2 focus-within:ring-[#123F38]/20 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 text-gray-500 dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                <path d="m3 7 9 6 9-6"></path>
                            </svg>
                            <input type="email" id="email" name="email" data-auth-field="email" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" aria-describedby="email-error" value="{{ old('email') }}" placeholder="Masukkan alamat email" autocomplete="username" required autofocus class="min-w-0 flex-1 border-0 bg-transparent py-2.5 text-sm text-gray-800 dark:text-gray-100 outline-none placeholder:text-gray-400 focus:ring-0 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        </div>
                        <p id="email-error" data-field-error="email" class="mt-1.5 text-xs text-red-600 {{ $errors->has('email') ? '' : 'hidden' }} motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $errors->first('email') }}</p>
                    </div>
                    <div class="mb-1 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <label for="password" class="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-200 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Password</label>
                        <div class="auth-input-shell flex items-center gap-3 rounded-xl border {{ $errors->has('password') ? 'border-2 !border-red-500' : 'border-white/90 dark:border-white/20' }} bg-white/35 dark:bg-[#1D2B28]/75 px-3.5 shadow-sm backdrop-blur-md focus-within:border-[#123F38] dark:focus-within:border-[#9AC7B8] focus-within:ring-2 focus-within:ring-[#123F38]/20 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 text-gray-500 dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                <rect x="4" y="10" width="16" height="11" rx="2"></rect>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"></path>
                                <path d="M12 14v3"></path>
                            </svg>
                            <input type="password" id="password" name="password" data-auth-field="password" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" aria-describedby="password-error" placeholder="Masukkan password" autocomplete="current-password" required class="min-w-0 flex-1 border-0 bg-transparent py-2.5 text-sm text-gray-800 dark:text-gray-100 outline-none placeholder:text-gray-400 focus:ring-0 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <button type="button" id="toggle-password" aria-label="Tampilkan password" aria-pressed="false" class="flex shrink-0 items-center justify-center p-1 text-gray-500 dark:text-gray-400 hover:text-[#123F38] dark:text-[#9AC7B8] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                <svg id="password-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <p id="password-error" data-field-error="password" class="mt-1.5 text-xs text-red-600 {{ $errors->has('password') ? '' : 'hidden' }} motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $errors->first('password') }}</p>
                    </div>
                    <div class="mb-3 flex justify-end motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <a href="{{ route('password.request') }}" class="rounded-md text-xs font-semibold text-[#123F38] underline-offset-4 transition hover:text-[#C76D4C] hover:underline focus:outline-none focus:ring-2 focus:ring-[#123F38]/40 dark:text-[#9AC7B8] dark:hover:text-[#F0A080]">Lupa password?</a>
                    </div>
                    <button type="submit" class="flex w-full items-center justify-center gap-3 rounded-xl border border-white/35 bg-[linear-gradient(135deg,rgba(18,63,56,.96),rgba(13,48,43,.88))] px-5 py-3 text-sm font-semibold text-white shadow-[0_10px_24px_rgba(18,63,56,.24),inset_0_1px_0_rgba(255,255,255,.24)] backdrop-blur-xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_14px_30px_rgba(18,63,56,.32),inset_0_1px_0_rgba(255,255,255,.36)] active:translate-y-0 active:scale-[.99] focus:outline-none focus:ring-2 focus:ring-[#123F38] focus:ring-offset-2 motion-reduce:transition-none">
                        <span data-submit-label>Masuk</span>
                        <span data-loading-spinner class="hidden h-4 w-4 animate-spin rounded-full border-2 border-white/40 border-t-white motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></span>
                    </button>
                </form>
                <div class="my-4 flex items-center gap-3 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    <div class="h-px flex-1 bg-white/90 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"></div>
                    <span class="whitespace-nowrap text-xs text-slate-700 dark:text-slate-200 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">atau masuk dengan</span>
                    <div class="h-px flex-1 bg-white/90 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"></div>
                </div>
                <div class="grid grid-cols-1 gap-3 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    <a href="{{ route('oauth.redirect', ['provider' => 'google']) }}" class="flex items-center justify-center gap-2 rounded-xl border border-white/90 bg-white/55 px-3 py-3 text-sm font-semibold text-[#152535] shadow-[0_8px_20px_rgba(20,34,48,.08),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-xl transition-all duration-300 hover:-translate-y-0.5 hover:bg-white/75 hover:shadow-[0_12px_24px_rgba(20,34,48,.12),inset_0_1px_0_white] active:translate-y-0 active:scale-[.99] focus:outline-none focus:ring-2 focus:ring-[#123F38] dark:border-white/25 dark:bg-white/10 dark:text-[#F5F2EB] dark:hover:bg-white/15 motion-reduce:transition-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5Z" transform="translate(0 4)"></path>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.73 7.18l7.66 5.94c4.47-4.13 7.11-10.2 7.11-17.59Z"></path>
                            <path fill="#FBBC05" d="M10.53 28.59A14.4 14.4 0 0 1 9.75 24c0-1.59.27-3.13.75-4.59l-7.98-6.19A23.9 23.9 0 0 0 0 24c0 3.87.93 7.52 2.56 10.78l7.97-6.19Z" transform="translate(1 0)"></path>
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.9-5.81l-7.66-5.94c-2.13 1.43-4.86 2.27-8.24 2.27-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48Z" transform="translate(0 -4)"></path>
                        </svg>
                        Google
                    </a>
                </div>
                <p class="mt-3 text-center text-xs text-gray-500 dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold text-[#123F38] dark:text-[#9AC7B8] hover:underline motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        Daftar sekarang
                    </a>
                </p>
            </section>
            </div>
        </div>
    </main>
    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('toggle-password');
        const passwordIcon = document.getElementById('password-icon');

        togglePassword.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            togglePassword.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
            togglePassword.setAttribute('aria-pressed', String(isHidden));

            if (isHidden) {
                passwordIcon.innerHTML = '<path d="M3 3l18 18"></path><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"></path><path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a16 16 0 0 1-3 3.8"></path><path d="M6.2 6.2C3.5 8 2 12 2 12s3.6 7 10 7a10.7 10.7 0 0 0 4-.8"></path>';
            } else {
                passwordIcon.innerHTML = '<path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        });
    </script>
</body>
</html>
