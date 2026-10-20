<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>@yield('title', 'Admin') | DenpasarTrip</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body class="min-h-screen bg-[#FFFCF8] font-sans text-brand-black antialiased dark:bg-[#172321] dark:text-brand-admin-cream">
    <div class="min-h-screen md:flex">

        {{-- SIDEBAR --}}
        <aside class="flex w-full shrink-0 flex-col border-r border-black/5 bg-admin-cream dark:border-white/10 dark:bg-[#1D2B28] md:fixed md:inset-y-0 md:left-0 md:w-64">
            {{-- LOGO --}}
            <div class="flex items-center gap-3 border-b border-black/10 px-6 py-6 dark:border-white/10">
                <img src="{{ asset('images/logo.png') }}" alt="Logo DenpasarTrip" class="h-11 w-11 object-contain">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Denpasar<span class="text-brand-orange">Trip</span></h1>
                </div>
            </div>
            {{-- NAVIGASI --}}
            <nav class="flex-1 space-y-2 px-4 py-6">
                <div class="mb-5 rounded-xl border border-brand-green/20 bg-brand-green/10 p-4 shadow-sm dark:border-white/10 dark:bg-white/5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-green text-white shadow-sm dark:bg-brand-admin-cream dark:text-brand-black">
                            <i class="fa-solid fa-user text-lg"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-brand-black dark:text-brand-admin-cream">
                                {{ auth()->user()->name }}
                            </p>
                            <span class="mt-2 inline-flex items-center gap-1 rounded-full bg-brand-green/10 px-2 py-1 text-[10px] font-semibold text-brand-green dark:bg-brand-admin-cream/10 dark:text-brand-admin-cream">
                                <i class="fa-solid fa-shield-halved"></i>
                                Administrator
                            </span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-green text-white' : 'text-brand-gray hover:bg-black/5 dark:text-gray-300 dark:hover:bg-white/5' }}">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.destinations.index') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.destinations.*') ? 'bg-brand-green text-white' : 'text-brand-gray hover:bg-black/5 dark:text-gray-300 dark:hover:bg-white/5' }}">
                    <i class="fa-solid fa-location-dot w-5 text-center"></i>
                    <span>Kelola Destinasi</span>
                </a>
            </nav>
            {{-- LOGOUT --}}
            <form action="{{ route('logout') }}" method="POST" class="mt-auto px-4 pb-6">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-red-500 transition hover:bg-red-500/10 hover:text-red-600 dark:text-red-400 dark:hover:bg-red-400/10">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </aside>

        {{-- MAIN PAGE --}}
        <main class="min-w-0 flex-1 md:ml-64">
            
            {{-- KONTEN HALAMAN --}}
            <section class="p-6 md:p-10">
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800 dark:border-green-800 dark:bg-green-950 dark:text-green-200">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>