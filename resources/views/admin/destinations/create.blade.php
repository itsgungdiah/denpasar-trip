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

<div class="mx-auto w-full max-w-7xl space-y-8 px-4 py-6 sm:px-6 lg:px-8">

    {{-- HEADER HALAMAN --}}
    <div class="flex flex-col gap-2">
        <p class="text-sm font-medium text-brand-gray dark:text-gray-400">DenpasarTrip / Admin / Kelola Destinasi</p>
        <h1 class="font-display text-3xl font-bold text-brand-orange sm:text-4xl">Tambah Destinasi</h1>
        <p class="text-sm text-brand-gray dark:text-gray-400 sm:text-base">Lengkapi informasi destinasi wisata yang akan ditambahkan.</p>
    </div>

    {{-- PESAN VALIDASI --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-900 dark:bg-red-950/40 dark:text-red-300">
            <p class="mb-2 font-semibold">Ada data yang perlu diperbaiki:</p>
            <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM TAMBAH DESTINASI --}}
    <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- INFORMASI DESTINASI --}}
        <section class="rounded-2xl border border-black/10 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-[#1D2B28] sm:p-7">
            <div class="mb-6">
                <h2 class="font-display text-2xl font-bold text-brand-black dark:text-brand-admin-cream">Informasi Destinasi</h2>
                <p class="mt-1 text-sm text-brand-gray dark:text-gray-400">Informasi utama tentang tempat wisata.</p>
            </div>

            {{-- Nama Destinasi --}}
            <div class="mb-6">
                <label for="name" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream">Nama Destinasi <span class="text-red-600 dark:text-red-400">*</span></label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255" placeholder="Contoh: Monumen Bajra Sandhi" class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500">
            </div>

            {{-- Kategori Destinasi --}}
            <fieldset class="mb-6">
                <legend class="mb-3 text-sm font-semibold text-brand-black dark:text-brand-admin-cream">Kategori <span class="text-red-600 dark:text-red-400">*</span></legend>
                <div class="flex flex-wrap gap-3">
                    @foreach ($categories as $category)
                        @php
                            $icon = $categoryIcons[$category->name] ?? ['icon' => 'fa-solid fa-tag', 'color' => 'text-brand-gray'];
                        @endphp
                        <label class="inline-flex cursor-pointer items-center gap-3 rounded-xl border border-black/15 bg-white px-4 py-3 text-sm font-medium text-brand-black transition hover:border-brand-green has-[:checked]:border-brand-green has-[:checked]:bg-brand-green/5 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:hover:border-brand-green dark:has-[:checked]:bg-brand-green/20">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" @checked(in_array($category->id, old('categories', []))) class="h-4 w-4 accent-brand-green">
                            <i class="{{ $icon['icon'] }} {{ $icon['color'] }}" aria-hidden="true"></i>
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                <p class="mt-2 text-xs text-brand-gray dark:text-gray-400">Pilih satu atau lebih kategori.</p>
            </fieldset>

            {{-- Deskripsi Destinasi --}}
            <div class="mb-6">
                <div class="mb-2 flex items-center justify-between gap-4">
                    <label for="description" class="text-sm font-semibold text-brand-black dark:text-brand-admin-cream">Deskripsi <span class="text-red-600 dark:text-red-400">*</span></label>
                    <span class="text-xs text-brand-gray dark:text-gray-400"><span id="description-count">{{ strlen(old('description', '')) }}</span>/1000</span>
                </div>
                <textarea id="description" name="description" rows="5" maxlength="1000" required placeholder="Tuliskan deskripsi destinasi wisata di sini..." class="w-full resize-y rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500">{{ old('description') }}</textarea>
            </div>

            {{-- Foto Destinasi --}}
            <div>
                <label for="image" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream">Foto Destinasi</label>
                <label for="image" class="flex min-h-40 cursor-pointer flex-col items-center justify-center rounded-xl border border-dashed border-black/20 bg-brand-admin-cream px-5 py-8 text-center transition hover:border-brand-green dark:border-white/20 dark:bg-[#172321]">
                    <i class="fa-regular fa-image mb-3 text-3xl text-brand-gray dark:text-gray-400" aria-hidden="true"></i>
                    <span class="text-sm font-medium text-brand-black dark:text-brand-admin-cream">Klik untuk mengunggah foto</span>
                    <span class="mt-1 text-xs text-brand-gray dark:text-gray-400">JPG, JPEG, PNG, atau WEBP (maksimal 2 MB)</span>
                    <span id="image-filename" class="mt-2 break-all text-xs font-medium text-brand-green"></span>
                    <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="sr-only">
                </label>
            </div>

            {{-- Link Google Maps --}}
            <div class="mt-6">
                <label for="google_maps_url" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream">Link Lokasi (Google Maps)</label>
                <div class="flex items-center gap-3 rounded-lg border border-black/15 bg-white px-4 focus-within:border-brand-green focus-within:ring-2 focus-within:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321]">
                    <i class="fa-solid fa-link text-brand-gray dark:text-gray-400" aria-hidden="true"></i>
                    <input id="google_maps_url" name="google_maps_url" type="url" value="{{ old('google_maps_url') }}" placeholder="Contoh: https://maps.google.com/..." class="w-full border-0 bg-transparent py-3 text-sm text-brand-black outline-none placeholder:text-gray-400 focus:ring-0 dark:text-brand-admin-cream dark:placeholder:text-gray-500">
                </div>
            </div>
        </section>

        {{-- JAM OPERASIONAL --}}
        <section class="rounded-2xl border border-black/10 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-[#1D2B28] sm:p-7">
            <div class="mb-5">
                <h2 class="font-display text-2xl font-bold text-brand-black dark:text-brand-admin-cream">Jam Operasional</h2>
                <p class="mt-1 text-sm text-brand-gray dark:text-gray-400">Tambahkan satu atau beberapa jadwal operasional destinasi.</p>
            </div>

            {{-- Daftar Jadwal --}}
            <div id="operating-hours-container" class="space-y-4">
                @php
                    $oldSchedules = old('operating_hours', [['days' => [], 'time' => '']]);
                @endphp

                @foreach ($oldSchedules as $index => $schedule)
                    <div class="operating-hours-item rounded-xl border border-black/10 bg-brand-admin-cream/40 p-4 dark:border-white/10 dark:bg-[#172321]">
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <h3 class="text-sm font-bold text-brand-black dark:text-brand-admin-cream">Jadwal <span class="schedule-number">{{ $loop->iteration }}</span> <span class="text-red-500">*</span></h3>
                            <button type="button" class="remove-schedule rounded-lg px-3 py-2 text-sm text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/40" title="Hapus jadwal" aria-label="Hapus jadwal"><i class="fa-solid fa-trash-can" aria-hidden="true"></i></button>
                        </div>

                        {{-- Pilihan Hari --}}
                        <div class="mb-4">
                            <label class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream">Hari <span class="text-red-500">*</span></label>
                            <div class="flex flex-wrap gap-2">
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <label class="day-option cursor-pointer">
                                        <input type="checkbox" name="operating_hours[{{ $index }}][days][]" value="{{ $day }}" @checked(in_array($day, $schedule['days'] ?? [])) class="peer sr-only">
                                        <span class="inline-flex rounded-lg border border-black/15 px-3 py-2 text-sm text-brand-gray transition hover:border-brand-green peer-checked:border-brand-green peer-checked:bg-brand-green peer-checked:text-white dark:border-white/15 dark:text-gray-300">{{ $day }}</span>
                                    </label>
                                @endforeach

                                {{-- Setiap Hari --}}
                                <label class="day-option cursor-pointer">
                                    <input type="checkbox" name="operating_hours[{{ $index }}][every_day]" value="1" @checked(count($schedule['days'] ?? []) === 7) class="every-day-checkbox peer sr-only">
                                    <span class="inline-flex rounded-lg border border-black/15 px-3 py-2 text-sm text-brand-gray transition hover:border-brand-green peer-checked:border-brand-green peer-checked:bg-brand-green peer-checked:text-white dark:border-white/15 dark:text-gray-300">Setiap Hari</span>
                                </label>
                            </div>
                        </div>

                        {{-- Jam --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream">Jam <span class="text-red-500">*</span></label>
                            <input type="text" name="operating_hours[{{ $index }}][time]" value="{{ $schedule['time'] ?? '' }}" placeholder="08.00-17.00" class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#1D2B28] dark:text-brand-admin-cream dark:placeholder:text-gray-500">
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tombol Tambah Jadwal --}}
            <button type="button" id="add-operating-hours" class="mt-4 flex w-full items-center justify-center gap-2 rounded-full border border-brand-green/40 bg-brand-admin-cream px-4 py-3 text-sm font-semibold text-brand-green transition hover:bg-brand-green hover:text-white dark:border-brand-green/50 dark:bg-[#172321]">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                Tambah Jadwal
            </button>

            {{-- Catatan Operasional --}}
            <div class="mt-5">
                <label for="operating_hours_note" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream">Catatan Operasional (Opsional)</label>
                <textarea id="operating_hours_note" name="operating_hours_note" rows="3" placeholder="Contoh: Jam operasional dapat berubah saat hari raya." class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500">{{ old('operating_hours_note') }}</textarea>
            </div>
        </section>

        {{-- INFORMASI BIAYA --}}
        <section class="rounded-2xl border border-black/10 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-[#1D2B28] sm:p-7">
            <div class="mb-6">
                <h2 class="font-display text-2xl font-bold text-brand-black dark:text-brand-admin-cream">Informasi Biaya</h2>
                <p class="mt-1 text-sm text-brand-gray dark:text-gray-400">Isi informasi tiket masuk dan perkiraan pengeluaran pengunjung.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                {{-- Tiket Masuk --}}
                <fieldset class="rounded-xl border border-black/10 p-5 dark:border-white/10">
                    <legend class="px-1 font-display text-xl font-bold text-brand-black dark:text-brand-admin-cream">Tiket Masuk <span class="text-red-600 dark:text-red-400">*</span></legend>

                    <div class="mt-3 space-y-4">
                        <label class="flex cursor-pointer items-center gap-3 text-sm text-brand-black dark:text-brand-admin-cream">
                            <input type="radio" name="entrance_fee_type" value="free" @checked(old('entrance_fee_type', 'fixed') === 'free') class="h-4 w-4 accent-brand-green">
                            <span>Gratis</span>
                        </label>

                        <label class="flex cursor-pointer items-center gap-3 text-sm text-brand-black dark:text-brand-admin-cream">
                            <input type="radio" name="entrance_fee_type" value="fixed" @checked(old('entrance_fee_type', 'fixed') === 'fixed') class="h-4 w-4 accent-brand-green">
                            <span>Satu harga</span>
                        </label>

                        <div id="entrance-fixed-fields" class="ml-7">
                            <label for="entrance_fee_fixed" class="sr-only">Nominal tiket masuk</label>
                            <input id="entrance_fee_fixed" name="entrance_fee_fixed" type="number" min="0" step="1" value="{{ old('entrance_fee_fixed') }}" placeholder="Contoh: 25000" class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500">
                        </div>

                        <label class="flex cursor-pointer items-center gap-3 text-sm text-brand-black dark:text-brand-admin-cream">
                            <input type="radio" name="entrance_fee_type" value="range" @checked(old('entrance_fee_type') === 'range') class="h-4 w-4 accent-brand-green">
                            <span>Rentang harga</span>
                        </label>

                        <div id="entrance-range-fields" class="ml-7 grid grid-cols-[1fr_auto_1fr] items-center gap-2">
                            <input name="entrance_fee_min" type="number" min="0" step="1" value="{{ old('entrance_fee_min') }}" placeholder="Min" aria-label="Harga tiket minimum" class="min-w-0 rounded-lg border border-black/15 bg-white px-3 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500">
                            <span class="text-brand-gray dark:text-gray-400">–</span>
                            <input name="entrance_fee_max" type="number" min="0" step="1" value="{{ old('entrance_fee_max') }}" placeholder="Maks" aria-label="Harga tiket maksimum" class="min-w-0 rounded-lg border border-black/15 bg-white px-3 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500">
                        </div>
                    </div>

                    {{-- Catatan Tiket Masuk --}}
                    <div class="mt-5">
                        <label for="entrance_fee_note" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream">Catatan (Opsional)</label>
                        <textarea id="entrance_fee_note" name="entrance_fee_note" rows="3" placeholder="Contoh: Harga berbeda untuk anak-anak dan dewasa." class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500">{{ old('entrance_fee_note') }}</textarea>
                    </div>
                </fieldset>

                {{-- Perkiraan Pengeluaran --}}
                <fieldset class="rounded-xl border border-black/10 p-5 dark:border-white/10">
                    <legend class="px-1 font-display text-xl font-bold text-brand-black dark:text-brand-admin-cream">Perkiraan Pengeluaran</legend>

                    <div class="mt-3 space-y-4">
                        <label class="flex cursor-pointer items-center gap-3 text-sm text-brand-black dark:text-brand-admin-cream">
                            <input type="radio" name="average_spending_type" value="fixed" @checked(old('average_spending_type', 'fixed') === 'fixed') class="h-4 w-4 accent-brand-green">
                            <span>Satu harga</span>
                        </label>

                        <div id="spending-fixed-fields" class="ml-7">
                            <label for="average_spending_fixed" class="sr-only">Nominal perkiraan pengeluaran</label>
                            <input id="average_spending_fixed" name="average_spending_fixed" type="number" min="0" step="1" value="{{ old('average_spending_fixed') }}" placeholder="Contoh: 25000" class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500">
                        </div>

                        <label class="flex cursor-pointer items-center gap-3 text-sm text-brand-black dark:text-brand-admin-cream">
                            <input type="radio" name="average_spending_type" value="range" @checked(old('average_spending_type') === 'range') class="h-4 w-4 accent-brand-green">
                            <span>Rentang harga</span>
                        </label>

                        <div id="spending-range-fields" class="ml-7 grid grid-cols-[1fr_auto_1fr] items-center gap-2">
                            <input name="average_spending_min" type="number" min="0" step="1" value="{{ old('average_spending_min') }}" placeholder="Min" aria-label="Pengeluaran minimum" class="min-w-0 rounded-lg border border-black/15 bg-white px-3 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500">
                            <span class="text-brand-gray dark:text-gray-400">–</span>
                            <input name="average_spending_max" type="number" min="0" step="1" value="{{ old('average_spending_max') }}" placeholder="Maks" aria-label="Pengeluaran maksimum" class="min-w-0 rounded-lg border border-black/15 bg-white px-3 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500">
                        </div>
                    </div>

                    {{-- Catatan Perkiraan Pengeluaran --}}
                    <div class="mt-5">
                        <label for="average_spending_note" class="mb-2 block text-sm font-semibold text-brand-black dark:text-brand-admin-cream">Catatan (Opsional)</label>
                        <textarea id="average_spending_note" name="average_spending_note" rows="3" placeholder="Contoh: Pengeluaran bergantung pada aktivitas yang dipilih." class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-brand-black outline-none transition placeholder:text-gray-400 focus:border-brand-green focus:ring-2 focus:ring-brand-green/15 dark:border-white/15 dark:bg-[#172321] dark:text-brand-admin-cream dark:placeholder:text-gray-500">{{ old('average_spending_note') }}</textarea>
                    </div>
                </fieldset>
            </div>
        </section>

        {{-- TOMBOL AKSI --}}
        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">
            <a href="{{ route('admin.destinations.index') }}" class="inline-flex items-center justify-center rounded-lg border border-brand-green px-6 py-3 text-sm font-semibold text-brand-admin-cream transition hover:bg-brand-green/5 dark:hover:bg-brand-/10">Batal</a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-green px-6 py-3 text-sm font-semibold text-white transition hover:opacity-90">
                <i class="fa-regular fa-floppy-disk" aria-hidden="true"></i>
                Simpan Destinasi
            </button>
        </div>
    </form>
</div>

@endsection