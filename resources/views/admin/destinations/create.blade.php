{{-- resources/views/admin/destinations/create.blade.php --}}

@extends('layouts.admin')

@section('title', 'Tambah Destinasi')

@section('content')

@php
    $categoryIcons = [
        'Nature' => ['icon' => 'fa-solid fa-leaf', 'color' => 'text-nature-text'],
        'Culture' => ['icon' => 'fa-solid fa-landmark', 'color' => 'text-culture-text'],
        'Art' => ['icon' => 'fa-solid fa-palette', 'color' => 'text-art-text'],
        'Culinary' => ['icon' => 'fa-solid fa-utensils', 'color' => 'text-culinary-text'],
        'Shopping' => ['icon' => 'fa-solid fa-bag-shopping', 'color' => 'text-shopping-text'],
    ];
@endphp

<div class="mx-auto w-full max-w-7xl space-y-8 px-4 py-6 sm:px-6 lg:px-8 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">

    {{-- HEADER HALAMAN --}}
    <div class="flex flex-col gap-2 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
        <p class="text-sm font-medium text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">DenpasarTrip / Admin / Kelola Destinasi</p>
        <h1 class="font-display text-3xl font-bold text-brand-orange sm:text-4xl motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Tambah Destinasi</h1>
        <p class="text-sm text-brand-gray dark:text-gray-400 sm:text-base motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Lengkapi informasi destinasi wisata yang akan ditambahkan.</p>
    </div>

    {{-- PESAN VALIDASI --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-900 dark:bg-red-950/40 dark:text-red-300 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <p class="mb-2 font-semibold motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Ada data yang perlu diperbaiki:</p>
            <ul class="list-inside list-disc space-y-1 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM TAMBAH DESTINASI --}}
    <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
        @csrf

        {{-- INFORMASI DESTINASI --}}
        <section class="rounded-2xl border border-white/75 bg-[linear-gradient(145deg,rgba(255,255,255,.82),rgba(250,247,242,.64))] p-5 shadow-[0_12px_30px_rgba(31,45,54,.08),inset_0_1px_0_rgba(255,255,255,.92)] backdrop-blur-xl dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.82),rgba(20,33,31,.7))] sm:p-7 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <div class="mb-6 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <h2 class="font-display text-2xl font-bold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Informasi Destinasi</h2>
                <p class="mt-1 text-sm text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Informasi utama tentang tempat wisata.</p>
            </div>

            {{-- Nama Destinasi --}}
            <div class="mb-6 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <label for="name" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Nama Destinasi <span class="text-red-600 dark:text-red-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">*</span></label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255" placeholder="Contoh: Monumen Bajra Sandhi" class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            </div>

            {{-- Kategori Destinasi --}}
            <fieldset class="mb-6 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <legend class="mb-3 text-sm font-semibold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Kategori <span class="text-red-600 dark:text-red-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">*</span></legend>
                <div class="flex flex-wrap gap-3 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    @foreach ($categories as $category)
                        @php
                            $icon = $categoryIcons[$category->name] ?? ['icon' => 'fa-solid fa-tag', 'color' => 'text-brand-gray'];
                        @endphp
                        <label class="inline-flex cursor-pointer items-center gap-3 rounded-xl border border-black/15 bg-white px-4 py-3 text-sm font-medium text-brand-black transition hover:border-brand-green has-[:checked]:border-brand-green has-[:checked]:bg-brand-green/5 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:hover:border-brand-green dark:has-[:checked]:bg-brand-green/20 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" @checked(in_array($category->id, old('categories', []))) class="h-4 w-4 accent-brand-green">
                            <i class="{{ $icon['icon'] }} {{ $icon['color'] }} motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i>
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                <p class="mt-2 text-xs text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Pilih satu atau lebih kategori.</p>
            </fieldset>

            {{-- Deskripsi Destinasi --}}
            <div class="mb-6 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <div class="mb-2 flex items-center justify-between gap-4 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    <label for="description" class="text-sm font-semibold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Deskripsi <span class="text-red-600 dark:text-red-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">*</span></label>
                    <span class="text-xs text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"><span id="description-count">{{ strlen(old('description', '')) }}</span>/1000</span>
                </div>
                <textarea id="description" name="description" rows="5" maxlength="1000" required placeholder="Tuliskan deskripsi destinasi wisata di sini..." class="w-full resize-y rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ old('description') }}</textarea>
            </div>

            {{-- Foto Destinasi --}}
            <div>
                <label for="image" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Foto Destinasi</label>
                <label for="image" class="flex min-h-40 cursor-pointer flex-col items-center justify-center rounded-xl border border-dashed border-black/20 bg-brand-admin-cream px-5 py-8 text-center transition hover:border-brand-green dark:border-white/20 dark:bg-[#172321] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    <i class="fa-regular fa-image mb-3 text-3xl text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i>
                    <span class="text-sm font-medium text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Klik untuk mengunggah foto</span>
                    <span class="mt-1 text-xs text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">JPG, JPEG, PNG, atau WEBP (maksimal 2 MB)</span>
                    <span id="image-filename" class="mt-2 break-all text-xs font-medium text-brand-green motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"></span>
                    <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="sr-only motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                </label>
            </div>

            {{-- Link Google Maps --}}
            <div class="mt-6 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <label for="google_maps_url" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Link Lokasi (Google Maps)</label>
                <div class="flex items-center gap-3 rounded-lg border border-black/15 bg-white px-4 focus-within:border-brand-green focus-within:ring-2 focus-within:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    <i class="fa-solid fa-link text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i>
                    <input id="google_maps_url" name="google_maps_url" type="url" value="{{ old('google_maps_url') }}" placeholder="Contoh: https://maps.google.com/..." class="w-full border-0 bg-transparent py-3 text-sm text-brand-black outline-none placeholder:text-gray-400 focus:ring-0 dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                </div>
            </div>
        </section>

        {{-- JAM OPERASIONAL --}}
        <section class="rounded-2xl border border-white/75 bg-[linear-gradient(145deg,rgba(255,255,255,.82),rgba(250,247,242,.64))] p-5 shadow-[0_12px_30px_rgba(31,45,54,.08),inset_0_1px_0_rgba(255,255,255,.92)] backdrop-blur-xl dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.82),rgba(20,33,31,.7))] sm:p-7 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <div class="mb-5 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <h2 class="font-display text-2xl font-bold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Jam Operasional</h2>
                <p class="mt-1 text-sm text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Tambahkan satu atau beberapa jadwal operasional destinasi.</p>
            </div>

            {{-- Daftar Jadwal --}}
            <div id="operating-hours-container" class="space-y-4 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                @php
                    $oldSchedules = old('operating_hours', [['days' => [], 'time' => '']]);
                @endphp

                @foreach ($oldSchedules as $index => $schedule)
                    <div class="operating-hours-item rounded-xl border border-black/10 bg-brand-admin-cream/40 p-4 dark:border-white/10 dark:bg-[#172321] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <div class="mb-3 flex items-center justify-between gap-3 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <h3 class="text-sm font-bold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Jadwal <span class="schedule-number motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $loop->iteration }}</span> <span class="text-red-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">*</span></h3>
                            <button type="button" class="remove-schedule rounded-lg px-3 py-2 text-sm text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/40 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" title="Hapus jadwal" aria-label="Hapus jadwal"><i class="fa-solid fa-trash-can motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i></button>
                        </div>

                        {{-- Pilihan Hari --}}
                        <div class="mb-4 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <label class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Hari <span class="text-red-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">*</span></label>
                            <div class="flex flex-wrap gap-2 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <label class="day-option cursor-pointer motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                        <input type="checkbox" name="operating_hours[{{ $index }}][days][]" value="{{ $day }}" @checked(in_array($day, $schedule['days'] ?? [])) class="peer sr-only motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                        <span class="inline-flex rounded-lg border border-black/15 px-3 py-2 text-sm text-brand-gray transition hover:border-brand-green peer-checked:border-brand-green peer-checked:bg-brand-green peer-checked:text-white dark:border-white/15 dark:text-gray-300 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $day }}</span>
                                    </label>
                                @endforeach

                                {{-- Setiap Hari --}}
                                <label class="day-option cursor-pointer motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                    <input type="checkbox" name="operating_hours[{{ $index }}][every_day]" value="1" @checked(count($schedule['days'] ?? []) === 7) class="every-day-checkbox peer sr-only motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                    <span class="inline-flex rounded-lg border border-black/15 px-3 py-2 text-sm text-brand-gray transition hover:border-brand-green peer-checked:border-brand-green peer-checked:bg-brand-green peer-checked:text-white dark:border-white/15 dark:text-gray-300 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Setiap Hari</span>
                                </label>
                            </div>
                        </div>

                        {{-- Jam --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Jam <span class="text-red-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">*</span></label>
                            <input type="text" name="operating_hours[{{ $index }}][time]" value="{{ $schedule['time'] ?? '' }}" placeholder="08.00-17.00" class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#1D2B28] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tombol Tambah Jadwal --}}
            <button type="button" id="add-operating-hours" class="mt-4 flex w-full items-center justify-center gap-2 rounded-full border border-brand-green/40 bg-brand-admin-cream px-4 py-3 text-sm font-semibold text-brand-green transition hover:bg-brand-green hover:text-white dark:border-brand-green/50 dark:bg-[#172321] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <i class="fa-solid fa-plus motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i>
                Tambah Jadwal
            </button>

            {{-- Catatan Operasional --}}
            <div class="mt-5 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <label for="operating_hours_note" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Catatan Operasional (Opsional)</label>
                <textarea id="operating_hours_note" name="operating_hours_note" rows="3" placeholder="Contoh: Jam operasional dapat berubah saat hari raya." class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ old('operating_hours_note') }}</textarea>
            </div>
        </section>

        {{-- INFORMASI BIAYA --}}
        <section class="rounded-2xl border border-white/75 bg-[linear-gradient(145deg,rgba(255,255,255,.82),rgba(250,247,242,.64))] p-5 shadow-[0_12px_30px_rgba(31,45,54,.08),inset_0_1px_0_rgba(255,255,255,.92)] backdrop-blur-xl dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.82),rgba(20,33,31,.7))] sm:p-7 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <div class="mb-6 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <h2 class="font-display text-2xl font-bold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Informasi Biaya</h2>
                <p class="mt-1 text-sm text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Isi informasi tiket masuk dan perkiraan pengeluaran pengunjung.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">

                {{-- Tiket Masuk --}}
                <fieldset class="rounded-xl border border-black/10 p-5 dark:border-white/10 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    <legend class="px-1 font-display text-xl font-bold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Tiket Masuk <span class="text-red-600 dark:text-red-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">*</span></legend>

                    <div class="mt-3 space-y-4 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <label class="flex cursor-pointer items-center gap-3 text-sm text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <input type="radio" name="entrance_fee_type" value="free" @checked(old('entrance_fee_type', 'fixed') === 'free') class="h-4 w-4 accent-brand-green motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <span>Gratis</span>
                        </label>

                        <label class="flex cursor-pointer items-center gap-3 text-sm text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <input type="radio" name="entrance_fee_type" value="fixed" @checked(old('entrance_fee_type', 'fixed') === 'fixed') class="h-4 w-4 accent-brand-green motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <span>Satu harga</span>
                        </label>

                        <div id="entrance-fixed-fields" class="ml-7 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <label for="entrance_fee_fixed" class="sr-only motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Nominal tiket masuk</label>
                            <input id="entrance_fee_fixed" name="entrance_fee_fixed" type="number" min="0" step="1" value="{{ old('entrance_fee_fixed') }}" placeholder="Contoh: 25000" class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        </div>

                        <label class="flex cursor-pointer items-center gap-3 text-sm text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <input type="radio" name="entrance_fee_type" value="range" @checked(old('entrance_fee_type') === 'range') class="h-4 w-4 accent-brand-green motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <span>Rentang harga</span>
                        </label>

                        <div id="entrance-range-fields" class="ml-7 grid grid-cols-[1fr_auto_1fr] items-center gap-2 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <input name="entrance_fee_min" type="number" min="0" step="1" value="{{ old('entrance_fee_min') }}" placeholder="Min" aria-label="Harga tiket minimum" class="min-w-0 rounded-lg border border-black/15 bg-white px-3 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <span class="text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">–</span>
                            <input name="entrance_fee_max" type="number" min="0" step="1" value="{{ old('entrance_fee_max') }}" placeholder="Maks" aria-label="Harga tiket maksimum" class="min-w-0 rounded-lg border border-black/15 bg-white px-3 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        </div>
                    </div>

                    {{-- Catatan Tiket Masuk --}}
                    <div class="mt-5 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <label for="entrance_fee_note" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Catatan (Opsional)</label>
                        <textarea id="entrance_fee_note" name="entrance_fee_note" rows="3" placeholder="Contoh: Harga berbeda untuk anak-anak dan dewasa." class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ old('entrance_fee_note') }}</textarea>
                    </div>
                </fieldset>

                {{-- Perkiraan Pengeluaran --}}
                <fieldset class="rounded-xl border border-black/10 p-5 dark:border-white/10 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    <legend class="px-1 font-display text-xl font-bold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Perkiraan Pengeluaran</legend>

                    <div class="mt-3 space-y-4 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <label class="flex cursor-pointer items-center gap-3 text-sm text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <input type="radio" name="average_spending_type" value="fixed" @checked(old('average_spending_type', 'fixed') === 'fixed') class="h-4 w-4 accent-brand-green motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <span>Satu harga</span>
                        </label>

                        <div id="spending-fixed-fields" class="ml-7 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <label for="average_spending_fixed" class="sr-only motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Nominal perkiraan pengeluaran</label>
                            <input id="average_spending_fixed" name="average_spending_fixed" type="number" min="0" step="1" value="{{ old('average_spending_fixed') }}" placeholder="Contoh: 25000" class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        </div>

                        <label class="flex cursor-pointer items-center gap-3 text-sm text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <input type="radio" name="average_spending_type" value="range" @checked(old('average_spending_type') === 'range') class="h-4 w-4 accent-brand-green motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <span>Rentang harga</span>
                        </label>

                        <div id="spending-range-fields" class="ml-7 grid grid-cols-[1fr_auto_1fr] items-center gap-2 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <input name="average_spending_min" type="number" min="0" step="1" value="{{ old('average_spending_min') }}" placeholder="Min" aria-label="Pengeluaran minimum" class="min-w-0 rounded-lg border border-black/15 bg-white px-3 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <span class="text-brand-gray dark:text-gray-400 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">–</span>
                            <input name="average_spending_max" type="number" min="0" step="1" value="{{ old('average_spending_max') }}" placeholder="Maks" aria-label="Pengeluaran maksimum" class="min-w-0 rounded-lg border border-black/15 bg-white px-3 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        </div>
                    </div>

                    {{-- Catatan Perkiraan Pengeluaran --}}
                    <div class="mt-5 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <label for="average_spending_note" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Catatan (Opsional)</label>
                        <textarea id="average_spending_note" name="average_spending_note" rows="3" placeholder="Contoh: Pengeluaran bergantung pada aktivitas yang dipilih." class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ old('average_spending_note') }}</textarea>
                    </div>
                </fieldset>
            </div>
        </section>

        {{-- TOMBOL AKSI --}}
        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <a href="{{ route('admin.destinations.index') }}" class="inline-flex items-center justify-center rounded-lg border border-brand-green px-6 py-3 text-sm font-semibold text-brand-admin-cream transition hover:bg-brand-green/5 dark:hover:bg-brand-/10 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Batal</a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-green px-6 py-3 text-sm font-semibold text-white transition hover:opacity-90 motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <i class="fa-regular fa-floppy-disk motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i>
                Simpan Destinasi
            </button>
        </div>
    </form>
</div>

@endsection