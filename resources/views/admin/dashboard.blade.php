@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="space-y-6">
    {{-- JUDUL DASHBOARD --}}
    <h1 class="font-display text-4xl font-bold text-brand-orange md:text-5xl">Dashboard</h1>
    {{-- AKSES CEPAT --}}
    <section class="flex flex-col gap-4 rounded-lg bg-brand-admin-cream px-6 py-4 dark:bg-[#263732] lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h2 class="font-display text-xl font-semibold text-brand-black dark:text-white">Akses Cepat</h2>
            <p class="mt-1 text-sm text-brand-gray dark:text-gray-400">Pilih menu untuk mengelola data destinasi.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('admin.destinations.create') }}" class="inline-flex items-center justify-center gap-3 rounded-lg bg-brand-green px-6 py-3 text-sm font-semibold text-white transition hover:opacity-90">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white text-brand-green"><i class="fa-solid fa-plus"></i></span>
                Tambah Destinasi
            </a>
            <a href="{{ route('admin.destinations.index') }}" class="inline-flex items-center justify-center gap-3 rounded-lg border border-brand-gray/50 bg-white px-6 py-3 text-sm font-semibold text-brand-black transition hover:bg-brand-admin-cream dark:border-white/20 dark:bg-[#1D2B28] dark:text-white dark:hover:bg-white/5">
                <i class="fa-solid fa-list-ul"></i>
                Lihat Semua Destinasi
            </a>
        </div>
    </section>
    {{-- KARTU STATISTIK --}}
    <section class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div class="flex items-center gap-6 rounded-lg border border-black/5 bg-white p-5 dark:border-white/10 dark:bg-[#1D2B28]">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-nature-bg text-nature-text">
                <i class="fa-solid fa-location-dot text-3xl"></i>
            </div>
            <div>
                <p class="text-sm text-brand-gray dark:text-gray-400">Total Destinasi</p>
                <p class="font-display text-4xl font-bold text-brand-black dark:text-white">{{ $totalDestinations }}</p>
            </div>
        </div>
        <div class="flex items-center gap-6 rounded-lg border border-black/5 bg-white p-5 dark:border-white/10 dark:bg-[#1D2B28]">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-culinary-bg text-culinary-text">
                <i class="fa-solid fa-border-all text-3xl"></i>
            </div>
            <div>
                <p class="text-sm text-brand-gray dark:text-gray-400">Total Kategori</p>
                <p class="font-display text-4xl font-bold text-brand-black dark:text-white">{{ $totalCategories }}</p>
            </div>
        </div>
    </section>
    {{-- DAFTAR TERBARU DAN STATISTIK KATEGORI --}}
    <section class="grid grid-cols-1 gap-5 xl:grid-cols-3">
        {{-- DAFTAR DESTINASI TERBARU --}}
        <div class="rounded-lg border border-black/5 bg-white p-5 dark:border-white/10 dark:bg-[#1D2B28] xl:col-span-2">
            <div class="mb-4 flex items-center justify-between gap-3">
                <h2 class="font-display text-xl font-bold text-brand-black dark:text-white">Daftar Terbaru</h2>
                <a href="{{ route('admin.destinations.index') }}" class="inline-flex shrink-0 items-center gap-2 rounded-lg border border-brand-gray/40 px-4 py-2 text-xs font-semibold text-brand-black transition hover:bg-brand-admin-cream dark:border-white/20 dark:text-white dark:hover:bg-white/5">
                    Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[450px] text-left text-sm">
                    <thead class="bg-brand-admin-cream text-brand-black dark:bg-[#263732] dark:text-gray-200">
                        <tr>
                            <th class="px-3 py-3 text-center font-semibold">No</th>
                            <th class="px-3 py-3 font-semibold">Nama Destinasi</th>
                            <th class="px-3 py-3 font-semibold">Kategori</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/10">
                        @forelse ($latestDestinations as $destination)
                            <tr class="hover:bg-brand-admin-cream/50 dark:hover:bg-white/5">
                                <td class="px-3 py-2 text-center text-brand-gray dark:text-gray-400">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2">
                                    <div class="flex items-center gap-3">
                                        @if ($destination->image)
                                            <img src="{{ asset('storage/' . $destination->image) }}" alt="Foto {{ $destination->name }}" class="h-10 w-14 shrink-0 rounded-md object-cover">
                                        @else
                                            <div class="flex h-10 w-14 shrink-0 items-center justify-center rounded-md bg-brand-admin-cream dark:bg-[#263732]"><i class="fa-regular fa-image text-brand-gray"></i></div>
                                        @endif
                                        <span class="font-medium text-brand-black dark:text-gray-100">{{ $destination->name }}</span>
                                    </div>
                                </td>
                                <td class="px-3 py-2">
                                    <div class="flex flex-wrap gap-1.5">
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
                                            <span class="rounded-full px-2.5 py-1 text-[10px] font-medium {{ $categoryStyles[$category->name] ?? 'bg-gray-100 text-gray-700' }}">{{ $category->name }}</span>
                                        @empty
                                            <span class="text-xs text-brand-gray dark:text-gray-400">Belum ada kategori</span>
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-10 text-center text-sm text-brand-gray dark:text-gray-400">Belum ada destinasi wisata.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- STATISTIK KATEGORI --}}
        <div class="rounded-lg border border-black/5 bg-white p-5 dark:border-white/10 dark:bg-[#1D2B28]">
            <h2 class="font-display text-xl font-bold text-brand-black dark:text-white">Destinasi per Kategori</h2>
            <p class="mt-1 text-sm text-brand-gray dark:text-gray-400">Jumlah destinasi di setiap kategori</p>
            <div class="mt-5 space-y-5">
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
                    <div class="flex items-center gap-3">
                        <i class="{{ $categoryIcons[$category->name] ?? 'fa-solid fa-tag' }} w-6 text-lg {{ $categoryTextColors[$category->name] ?? 'text-brand-gray' }}"></i>
                        <span class="w-20 shrink-0 text-sm font-semibold text-brand-black dark:text-gray-200">{{ $category->name }}</span>
                        <span class="ml-auto text-sm text-brand-black dark:text-gray-200">{{ $category->destinations_count }}</span>
                        <div class="h-1.5 w-16 shrink-0 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-600 sm:w-20">
                            <div class="h-full rounded-full {{ $categoryTextColors[$category->name] ?? 'bg-brand-green' }} {{ $category->name === 'Nature' ? 'bg-nature-text' : ($category->name === 'Culture' ? 'bg-culture-text' : ($category->name === 'Art' ? 'bg-art-text' : ($category->name === 'Culinary' ? 'bg-culinary-text' : 'bg-shopping-text'))) }}" style="width: {{ ($category->destinations_count / $maxCategoryCount) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection