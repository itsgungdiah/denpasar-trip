@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="space-y-6 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
    {{-- JUDUL DASHBOARD --}}
    <h1 class="font-display text-4xl font-bold text-brand-orange md:text-5xl motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Dashboard</h1>
    {{-- AKSES CEPAT --}}
    <section class="flex flex-col gap-4 rounded-lg bg-brand-admin-cream px-6 py-4 dark:bg-[#263732] lg:flex-row lg:items-center lg:justify-between motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
        <div>
            <h2 class="font-display text-xl font-semibold text-brand-black dark:text-white motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Akses Cepat</h2>
            <p class="mt-1 text-sm text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Pilih menu untuk mengelola data destinasi.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <a href="{{ route('admin.destinations.create') }}" class="inline-flex items-center justify-center gap-3 rounded-lg bg-brand-green px-6 py-3 text-sm font-semibold text-white transition hover:opacity-90 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white text-brand-green motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"><i class="fa-solid fa-plus motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"></i></span>
                Tambah Destinasi
            </a>
            <a href="{{ route('admin.destinations.index') }}" class="inline-flex items-center justify-center gap-3 rounded-lg border border-brand-gray/50 bg-white px-6 py-3 text-sm font-semibold text-brand-black transition hover:bg-brand-admin-cream dark:border-white/20 dark:bg-[#1D2B28] dark:text-white dark:hover:bg-white/5 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <i class="fa-solid fa-list-ul motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"></i>
                Lihat Semua Destinasi
            </a>
        </div>
    </section>
    {{-- KARTU STATISTIK --}}
    <section class="grid grid-cols-1 gap-4 md:grid-cols-2 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
        <div class="flex items-center gap-6 rounded-lg border border-white/75 bg-[linear-gradient(145deg,rgba(255,255,255,.78),rgba(250,247,242,.6))] p-5 shadow-[0_10px_26px_rgba(31,45,54,.07),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-xl dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.8),rgba(20,33,31,.68))] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-nature-bg text-nature-text motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <i class="fa-solid fa-location-dot text-3xl motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"></i>
            </div>
            <div>
                <p class="text-sm text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Total Destinasi</p>
                <p class="font-display text-4xl font-bold text-brand-black dark:text-white motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $totalDestinations }}</p>
            </div>
        </div>
        <div class="flex items-center gap-6 rounded-lg border border-white/75 bg-[linear-gradient(145deg,rgba(255,255,255,.78),rgba(250,247,242,.6))] p-5 shadow-[0_10px_26px_rgba(31,45,54,.07),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-xl dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.8),rgba(20,33,31,.68))] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-culinary-bg text-culinary-text motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <i class="fa-solid fa-border-all text-3xl motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"></i>
            </div>
            <div>
                <p class="text-sm text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Total Kategori</p>
                <p class="font-display text-4xl font-bold text-brand-black dark:text-white motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $totalCategories }}</p>
            </div>
        </div>
    </section>
    {{-- DAFTAR TERBARU DAN STATISTIK KATEGORI --}}
    <section class="grid grid-cols-1 gap-5 xl:grid-cols-3 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
        {{-- DAFTAR DESTINASI TERBARU --}}
        <div class="rounded-lg border border-white/75 bg-[linear-gradient(145deg,rgba(255,255,255,.78),rgba(250,247,242,.6))] p-5 shadow-[0_10px_26px_rgba(31,45,54,.07),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-xl dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.8),rgba(20,33,31,.68))] xl:col-span-2 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <div class="mb-4 flex items-center justify-between gap-3 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <h2 class="font-display text-xl font-bold text-brand-black dark:text-white motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Daftar Terbaru</h2>
                <a href="{{ route('admin.destinations.index') }}" class="inline-flex shrink-0 items-center gap-2 rounded-lg border border-brand-gray/40 px-4 py-2 text-xs font-semibold text-brand-black transition hover:bg-brand-admin-cream dark:border-white/20 dark:text-white dark:hover:bg-white/5 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    Lihat Semua <i class="fa-solid fa-arrow-right motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"></i>
                </a>
            </div>
            <div class="overflow-x-auto motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <table class="w-full min-w-[450px] text-left text-sm motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    <thead class="bg-brand-admin-cream text-brand-black dark:bg-[#263732] dark:text-gray-200 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <tr>
                            <th class="px-3 py-3 text-center font-semibold motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">No</th>
                            <th class="px-3 py-3 font-semibold motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Nama Destinasi</th>
                            <th class="px-3 py-3 font-semibold motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Kategori</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/10 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        @forelse ($latestDestinations as $destination)
                            <tr class="hover:bg-brand-admin-cream/50 dark:hover:bg-white/5 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                <td class="px-3 py-2 text-center text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                    <div class="flex items-center gap-3 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                        @if ($destination->image)
                                            <img src="{{ asset('storage/' . $destination->image) }}" alt="Foto {{ $destination->name }}" class="h-10 w-14 shrink-0 rounded-md object-cover motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                        @else
                                            <div class="flex h-10 w-14 shrink-0 items-center justify-center rounded-md bg-brand-admin-cream dark:bg-[#263732] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"><i class="fa-regular fa-image text-brand-gray motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"></i></div>
                                        @endif
                                        <span class="font-medium text-brand-black dark:text-gray-100 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $destination->name }}</span>
                                    </div>
                                </td>
                                <td class="px-3 py-2 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                    <div class="flex flex-wrap gap-1.5 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                        @forelse ($destination->categories as $category)
                                            @php
                                                $categoryStyles = [
                                                    'Nature' => 'bg-nature-bg text-nature-text',
                                                    'Culture' => 'bg-culture-bg text-culture-text',
                                                    'Art' => 'bg-art-bg text-art-text',
                                                    'Culinary' => 'bg-culinary-bg text-culinary-text',
                                                    'Shopping' => 'bg-shopping-bg text-shopping-text',
                                                ];
                                            @endphp
                                            <span class="rounded-full px-2.5 py-1 text-[10px] font-medium {{ $categoryStyles[$category->name] ?? 'bg-gray-100 text-gray-700' }} motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $category->name }}</span>
                                        @empty
                                            <span class="text-xs text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Belum ada kategori</span>
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-10 text-center text-sm text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Belum ada destinasi wisata.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- STATISTIK KATEGORI --}}
        <div class="rounded-lg border border-white/75 bg-[linear-gradient(145deg,rgba(255,255,255,.78),rgba(250,247,242,.6))] p-5 shadow-[0_10px_26px_rgba(31,45,54,.07),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-xl dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.8),rgba(20,33,31,.68))] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <h2 class="font-display text-xl font-bold text-brand-black dark:text-white motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Destinasi per Kategori</h2>
            <p class="mt-1 text-sm text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Jumlah destinasi di setiap kategori</p>
            <div class="mt-5 space-y-5 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                @php
                    $categoryIcons = [
                        'Nature' => 'fa-solid fa-leaf',
                        'Culture' => 'fa-solid fa-landmark',
                        'Art' => 'fa-solid fa-palette',
                        'Culinary' => 'fa-solid fa-utensils',
                        'Shopping' => 'fa-solid fa-bag-shopping',
                    ];
                    $categoryTextColors = [
                        'Nature' => 'text-nature-text',
                        'Culture' => 'text-culture-text',
                        'Art' => 'text-art-text',
                        'Culinary' => 'text-culinary-text',
                        'Shopping' => 'text-shopping-text',
                    ];
                    $maxCategoryCount = max(1, $categoryStats->max('destinations_count') ?? 0);
                @endphp
                @foreach ($categoryStats as $category)
                    <div class="flex items-center gap-3 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <i class="{{ $categoryIcons[$category->name] ?? 'fa-solid fa-tag' }} w-6 text-lg {{ $categoryTextColors[$category->name] ?? 'text-brand-gray' }} motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"></i>
                        <span class="w-20 shrink-0 text-sm font-semibold text-brand-black dark:text-gray-200 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $category->name }}</span>
                        <span class="ml-auto text-sm text-brand-black dark:text-gray-200 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $category->destinations_count }}</span>
                        <div class="h-1.5 w-16 shrink-0 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-600 sm:w-20 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <div class="h-full rounded-full {{ $categoryTextColors[$category->name] ?? 'bg-brand-green' }} {{ $category->name === 'Nature' ? 'bg-nature-text' : ($category->name === 'Culture' ? 'bg-culture-text' : ($category->name === 'Art' ? 'bg-art-text' : ($category->name === 'Culinary' ? 'bg-culinary-text' : 'bg-shopping-text'))) }} motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" style="width: {{ ($category->destinations_count / $maxCategoryCount) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection