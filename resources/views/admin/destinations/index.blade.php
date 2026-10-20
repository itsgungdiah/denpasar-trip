@extends('layouts.admin')

@section('title', 'Kelola Destinasi')
@section('page-heading', 'Kelola Destinasi')

@section('content')
<div class="space-y-6">

    {{-- HEADER TEXT --}}
    <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
        <div>
            <h1 class="font-display text-4xl font-bold text-brand-orange md:text-5xl">
                Kelola Destinasi
            </h1>
            <p class="mt-2 text-sm text-brand-gray dark:text-gray-400">
                Tambah, ubah, atau hapus informasi destinasi wisata di DenpasarTrip.
            </p>
        </div>
        <a href="{{ route('admin.destinations.create') }}" class="inline-flex shrink-0 items-center justify-center gap-3 rounded-lg bg-brand-green px-7 py-4 text-sm font-semibold text-white transition hover:opacity-90">
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white text-brand-green">
                <i class="fa-solid fa-plus"></i>
            </span>
            <span>Tambah Destinasi</span>
        </a>
    </div>

    {{-- SEARCH DAN FILTER --}}
    <form action="{{ route('admin.destinations.index') }}" method="GET" class="mb-5 flex flex-col gap-3 sm:flex-row">
        <div class="relative flex-1">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-lg text-brand-gray dark:text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama destinasi..." class="w-full rounded-lg border border-black/10 bg-white py-3 pl-11 pr-4 text-sm text-brand-black outline-none transition placeholder:text-brand-gray/80 focus:border-brand-green focus:ring-1 focus:ring-brand-green dark:border-white/10 dark:bg-[#1D2B28] dark:text-white dark:placeholder:text-gray-400 dark:focus:border-green-400">
        </div>
        <div class="relative sm:w-56">
            <select name="category" onchange="this.form.submit()" class="w-full cursor-pointer appearance-none rounded-lg border border-black/5 bg-white px-4 py-3 pr-10 text-sm text-brand-gray shadow-sm outline-none transition hover:border-brand-green/40 focus:border-brand-green focus:ring-2 focus:ring-brand-green/10 dark:border-white/10 dark:bg-[#1D2B28] dark:text-gray-200 dark:hover:border-green-300/40 dark:focus:border-green-300">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <i class="fa-solid fa-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-brand-gray dark:text-gray-400"></i>
        </div>
        @if (request('search') || request('category'))
            <a href="{{ route('admin.destinations.index') }}" title="Reset pencarian dan filter" aria-label="Reset pencarian dan filter" class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-black/10 bg-white text-brand-gray transition hover:border-brand-orange hover:bg-brand-admin-cream hover:text-brand-orange dark:border-white/10 dark:bg-[#1D2B28] dark:text-gray-300 dark:hover:bg-white/5">
                <i class="fa-solid fa-rotate-left text-lg"></i>
            </a>
        @endif
    </form>

    {{-- TABEL DESTINASI --}}
    <div class="overflow-hidden rounded-lg border border-black/5 bg-white dark:border-white/10 dark:bg-[#1D2B28]">
        @if ($destinations->isEmpty())
            <div class="px-6 py-16 text-center">
                <h3 class="font-display text-xl font-semibold">Belum Ada Destinasi</h3>
                <p class="mt-2 text-sm text-brand-gray dark:text-gray-400">Mulai tambahkan destinasi wisata ke DenpasarTrip.</p>
                <a href="{{ route('admin.destinations.create') }}" class="mt-5 inline-block rounded-lg bg-brand-green px-5 py-3 text-sm font-medium text-white hover:opacity-90">Tambah Destinasi</a>
            </div>
        @else
            <div class="px-3 py-2">
                <div class="overflow-x-auto">
                    <table class="w-full table-fixed border-collapse text-left text-sm">
                        <colgroup>
                            <col class="w-[7%]">
                            <col class="w-[13%]">
                            <col class="w-[27%]">
                            <col class="w-[33%]">
                            <col class="w-[20%]">
                        </colgroup>
                        <thead class="bg-brand-admin-cream text-brand-black dark:bg-[#263732] dark:text-gray-200">
                            <tr>
                                <th class="px-2 py-3 text-center font-semibold">No</th>
                                <th class="px-2 py-3 text-center font-semibold">Gambar</th>
                                <th class="px-3 py-3 font-semibold">Nama Destinasi</th>
                                <th class="px-3 py-3 font-semibold">Kategori</th>
                                <th class="px-2 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-black/5 dark:divide-white/10">
                            @foreach ($destinations as $destination)
                                <tr class="transition hover:bg-brand-admin-cream/50 dark:hover:bg-white/5">
                                    <td class="px-2 py-2 text-center text-brand-black dark:text-gray-200">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-2">
                                        @if ($destination->image)
                                            <img src="{{ asset('storage/' . $destination->image) }}" alt="Foto {{ $destination->name }}" class="mx-auto h-12 w-12 rounded-md object-cover">
                                        @else
                                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-md bg-brand-admin-cream text-[10px] text-brand-gray dark:bg-[#263732] dark:text-gray-400">No Foto</div>
                                        @endif
                                    </td>
                                    <td class="wrap-break-word px-3 py-2 font-medium text-brand-black dark:text-gray-100" data-destination-name>{{ $destination->name }}</td>
                                    <td class="px-3 py-2">
                                        <div class="flex flex-wrap items-center gap-1.5">
                                            @forelse ($destination->categories as $category)
                                                @php
                                                    $categoryStyles = [
                                                        'Nature' => 'bg-nature-bg text-nature-text',
                                                        'Culture' => 'bg-culture-bg text-culture-text',
                                                        'Art' => 'bg-art-bg text-art-text',
                                                        'Culinary' => 'bg-culinary-bg text-culinary-text',
                                                        'Shopping' => 'bg-shopping-bg text-shopping-text',
                                                    ];
                                                    $badgeStyle = $categoryStyles[$category->name] ?? 'bg-gray-100 text-gray-700';
                                                @endphp
                                                <span class="rounded-full px-2.5 py-1 text-[12px] font-medium {{ $badgeStyle }}">{{ $category->name }}</span>
                                            @empty
                                                <span class="text-xs text-brand-gray dark:text-gray-400">Belum ada kategori</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-2 py-2">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.destinations.edit', $destination->id) }}" aria-label="Edit {{ $destination->name }}" title="Edit destinasi" class="flex h-9 w-9 items-center justify-center rounded border border-brand-green/30 text-brand-green transition hover:bg-brand-green hover:text-white dark:border-green-300/40 dark:text-green-300 dark:hover:bg-brand-green dark:hover:text-white">
                                                <i class="fa-solid fa-pen-to-square text-lg"></i>
                                            </a>
                                            <form action="{{ route('admin.destinations.destroy', $destination->id) }}" method="POST" class="delete-destination-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" aria-label="Hapus {{ $destination->name }}" title="Hapus destinasi" class="flex h-9 w-9 items-center justify-center rounded border border-red-300 text-red-500 transition hover:bg-red-500 hover:text-white dark:border-red-400/50 dark:text-red-400 dark:hover:bg-red-500 dark:hover:text-white">
                                                    <i class="fa-regular fa-trash-can text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="border-t border-black/5 px-5 py-3 text-xs text-brand-gray dark:border-white/10 dark:text-gray-400">
                Total {{ $destinations->count() }} destinasi wisata
            </div>
        @endif
    </div>

    {{-- FOOTER TABEL DAN PAGINATION --}}
    <div class="flex flex-col gap-4 border-t border-black/5 px-5 py-4 dark:border-white/10 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-xs text-brand-gray dark:text-gray-400">
            Menampilkan
            <span class="font-semibold text-brand-black dark:text-gray-200">{{ $destinations->firstItem() ?? 0 }}–{{ $destinations->lastItem() ?? 0 }}</span>
            dari
            <span class="font-semibold text-brand-black dark:text-gray-200">{{ $destinations->total() }}</span>
            destinasi wisata
        </p>
        @if ($destinations->hasPages())
            <nav class="flex flex-wrap items-center justify-center gap-1" aria-label="Navigasi halaman">
                @if ($destinations->onFirstPage())
                    <span class="flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-md text-brand-gray/40 dark:text-gray-600">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </span>
                @else
                    <a href="{{ $destinations->previousPageUrl() }}" aria-label="Halaman sebelumnya" class="flex h-9 w-9 items-center justify-center rounded-md text-brand-black transition hover:bg-brand-admin-cream dark:text-gray-200 dark:hover:bg-white/10">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </a>
                @endif
                @foreach ($destinations->getUrlRange(1, $destinations->lastPage()) as $page => $url)
                    @if ($page == $destinations->currentPage())
                        <span aria-current="page" class="flex h-9 min-w-9 items-center justify-center rounded-md bg-brand-black px-3 text-sm font-semibold text-white dark:bg-brand-admin-cream dark:text-brand-black">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="flex h-9 min-w-9 items-center justify-center rounded-md px-3 text-sm text-brand-black transition hover:bg-brand-admin-cream dark:text-gray-200 dark:hover:bg-white/10">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
                @if ($destinations->hasMorePages())
                    <a href="{{ $destinations->nextPageUrl() }}" aria-label="Halaman berikutnya" class="flex h-9 w-9 items-center justify-center rounded-md text-brand-black transition hover:bg-brand-admin-cream dark:text-gray-200 dark:hover:bg-white/10">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                @else
                    <span class="flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-md text-brand-gray/40 dark:text-gray-600">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </span>
                @endif
            </nav>
        @endif
    </div>
</div>
@endsection

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
    <div id="delete-modal-content" class="w-full max-w-md scale-95 rounded-2xl border border-black/10 bg-white p-6 opacity-0 shadow-2xl transition-all duration-200 dark:border-white/10 dark:bg-[#1D2B28] sm:p-8">
        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-950/50 dark:text-red-400">
            <i class="fa-regular fa-trash-can text-2xl" aria-hidden="true"></i>
        </div>
        <div class="text-center">
            <h2 class="text-xl font-bold text-brand-black dark:text-brand-admin-cream">Hapus Destinasi?</h2>
            <p class="mt-3 text-sm leading-6 text-brand-gray dark:text-gray-400">Apakah kamu yakin ingin menghapus destinasi <span id="delete-destination-name" class="font-semibold text-brand-black dark:text-brand-admin-cream"></span>?</p>
            <p class="mt-2 text-xs text-red-600 dark:text-red-400">Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row">
            <button type="button" id="cancel-delete" class="flex-1 rounded-xl border border-black/15 px-5 py-3 text-sm font-semibold text-brand-black transition hover:bg-black/5 dark:border-white/15 dark:text-brand-admin-cream dark:hover:bg-white/5">Batal</button>
            <button type="button" id="confirm-delete" class="flex-1 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-[#1D2B28]">
                <i class="fa-regular fa-trash-can mr-2" aria-hidden="true"></i>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>