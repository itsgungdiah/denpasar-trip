<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | DenpasarTrip</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
        }
    </style>
</head>
<body class="h-screen w-screen overflow-hidden font-sans">
    <main class="relative h-screen w-full overflow-hidden bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/login.png') }}');">
        <div class="grid h-full w-full grid-cols-1 items-start gap-4 overflow-hidden px-5 py-8 sm:px-8 lg:grid-cols-2 lg:gap-8 lg:px-12 lg:py-12">
            <section class="hidden pt-4 text-white lg:block">
                <h1 class="text-5xl font-black leading-tight xl:text-6xl">
                    Mulai
                    <span class="block">Petualanganmu</span>
                    di <span class="text-[#C76D4C]">Denpasar</span>
                </h1>
                <p class="mt-4 max-w-lg text-base font-medium leading-relaxed xl:text-lg">
                    Buat akun sekarang dan temukan destinasi terbaik, susun rencana perjalananmu, dan nikmati pengalaman wisata yang tak terlupakan di Denpasar, Bali.
                </p>
            </section>

            <section class="mx-auto w-full max-w-sm rounded-2xl bg-white px-6 py-5 shadow-xl sm:px-7 sm:py-6">
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo DenpasarTrip" class="h-11 w-11 object-contain">
                    <h2 class="text-2xl font-extrabold tracking-tight text-[#152535]">
                        Denpasar<span class="text-[#C76D4C]">Trip</span>
                    </h2>
                </div>
                <div class="mb-3">
                    <h1 class="text-3xl font-bold tracking-tight text-[#152535]">Buat Akun Baru</h1>
                    <p class="mt-1 text-base leading-snug text-gray-500">
                        Mulai rencanakan perjalananmu di Denpasar bersama kami.
                    </p>
                </div>
                @if ($errors->any())
                    <div class="mb-3 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-600">
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('register.submit') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="name" class="mb-1 block text-sm font-semibold text-gray-600">Nama</label>
                        <div class="flex items-center gap-3 rounded-xl border border-gray-400 px-4 focus-within:border-[#123F38] focus-within:ring-1 focus-within:ring-[#123F38]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="shrink-0 text-gray-500">
                                <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.42 0-8 2.24-8 5v2h16v-2c0-2.76-3.58-5-8-5Z"/>
                            </svg>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama" autocomplete="name" required autofocus class="min-w-0 flex-1 border-0 bg-transparent py-2.5 text-sm text-gray-800 outline-none placeholder:text-gray-400 focus:ring-0">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="mb-1 block text-sm font-semibold text-gray-600">Email</label>
                        <div class="flex items-center gap-3 rounded-xl border border-gray-400 px-4 focus-within:border-[#123F38] focus-within:ring-1 focus-within:ring-[#123F38]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 text-gray-500">
                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                <path d="m3 7 9 6 9-6"></path>
                            </svg>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email" autocomplete="email" required class="min-w-0 flex-1 border-0 bg-transparent py-2.5 text-sm text-gray-800 outline-none placeholder:text-gray-400 focus:ring-0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="mb-1 block text-sm font-semibold text-gray-600">Password</label>
                        <div class="flex items-center gap-3 rounded-xl border border-gray-400 px-4 focus-within:border-[#123F38] focus-within:ring-1 focus-within:ring-[#123F38]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 text-gray-500">
                                <rect x="4" y="10" width="16" height="11" rx="2"></rect>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"></path>
                                <path d="M12 14v3"></path>
                            </svg>
                            <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="new-password" required class="min-w-0 flex-1 border-0 bg-transparent py-2.5 text-sm text-gray-800 outline-none placeholder:text-gray-400 focus:ring-0">
                            <button type="button" id="toggle-password" aria-label="Tampilkan password" aria-pressed="false" class="flex shrink-0 items-center justify-center p-1 text-gray-500 hover:text-[#123F38]">
                                <svg id="password-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mt-1.5 mb-2 space-y-1 text-xs">
    <p class="font-medium text-gray-500">Persyaratan password:</p>
    <p id="password-length" class="text-gray-500">
        ○ Minimal 8 karakter
    </p>
    <p id="password-number" class="text-gray-500">
        ○ Mengandung huruf dan angka
    </p>
</div>
                    
                    <div class="mb-3">
                        <label class="flex cursor-pointer items-start gap-2">
                            <input type="checkbox" name="terms" value="1" required class="mt-0.5 h-5 w-5 shrink-0 rounded border-gray-300 accent-[#123F38]">
                            <span class="text-[11px] leading-relaxed text-gray-500">
                                Saya setuju dengan <a href="#" class="font-semibold text-[#123F38]">Syarat & Ketentuan</a> serta <a href="#" class="font-semibold text-[#123F38]">Kebijakan Privasi</a> DenpasarTrip.
                            </span>
                        </label>
                    </div>
                    <button type="submit" class="flex w-full items-center justify-center gap-3 rounded-xl bg-[#123F38] px-5 py-2.5 font-semibold text-white transition hover:bg-[#0D302B] focus:outline-none focus:ring-2 focus:ring-[#123F38] focus:ring-offset-2">
                        Daftar
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </button>
                </form>
                <div class="my-3 flex items-center gap-3">
                    <div class="h-px flex-1 bg-gray-300"></div>
                    <span class="whitespace-nowrap text-xs text-gray-500">atau daftar dengan</span>
                    <div class="h-px flex-1 bg-gray-300"></div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" disabled title="Daftar Google belum tersedia" class="flex cursor-not-allowed items-center justify-center gap-2 rounded-xl border border-gray-300 px-3 py-2.5 text-sm font-semibold text-gray-500 opacity-70">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5Z" transform="translate(0 4)"></path>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.73 7.18l7.66 5.94c4.47-4.13 7.11-10.2 7.11-17.59Z"></path>
                            <path fill="#FBBC05" d="M10.53 28.59A14.4 14.4 0 0 1 9.75 24c0-1.59.27-3.13.75-4.59l-7.98-6.19A23.9 23.9 0 0 0 0 24c0 3.87.93 7.52 2.56 10.78l7.97-6.19Z" transform="translate(1 0)"></path>
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.9-5.81l-7.66-5.94c-2.13 1.43-4.86 2.27-8.24 2.27-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48Z" transform="translate(0 -4)"></path>
                        </svg>
                        Google
                    </button>
                    <button type="button" disabled title="Daftar Apple belum tersedia" class="flex cursor-not-allowed items-center justify-center gap-2 rounded-xl border border-gray-300 px-3 py-2.5 text-sm font-semibold text-gray-500 opacity-70">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16.37 12.48c.02 2.12 1.86 2.83 1.88 2.84-.02.05-.29 1.01-.96 2-.58.86-1.18 1.72-2.12 1.74-.92.02-1.22-.56-2.28-.56-1.05 0-1.39.54-2.26.58-.91.03-1.6-.93-2.18-1.79-1.19-1.72-2.1-4.87-.88-7 .6-1.06 1.67-1.73 2.82-1.75.88-.02 1.71.61 2.26.61.54 0 1.55-.75 2.62-.64.45.02 1.71.18 2.52 1.37-.07.04-1.51.88-1.5 2.6ZM14.67 5.87c.48-.58.8-1.38.71-2.18-.69.03-1.53.46-2.03 1.04-.45.52-.84 1.33-.73 2.11.77.06 1.57-.39 2.05-.97Z"></path>
                        </svg>
                        Apple
                    </button>
                </div>
                <p class="mt-3 text-center text-xs text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-bold text-[#123F38] hover:underline">Masuk sekarang</a>
                </p>
            </section>
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
                passwordIcon.innerHTML = '<path d="M3 3l18 18"></path><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"></path><path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7s-3.6 7-10 7a10.7 10.7 0 0 1-4-.8"></path><path d="M6.2 6.2C3.5 8 2 12 2 12s3.6 7 10 7a10.7 10.7 0 0 0 4-.8"></path>';
            } else {
                passwordIcon.innerHTML = '<path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        });
    </script>
</body>
</html>