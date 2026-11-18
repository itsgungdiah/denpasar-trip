@php
    $inputValue = $field === 'start'
        ? old('start_date', isset($trip) ? $trip->start_date->toDateString() : '')
        : old('end_date', isset($trip) ? $trip->end_date->toDateString() : '');
    $calendarId = 'trip-' . $field . '-date-calendar';
    $labelId = 'trip-' . $field . '-date-label';
@endphp
<div class="relative grid min-w-0 gap-[5px] text-[11px] font-bold text-[#28333A] dark:text-[#E4E8E5]" data-date-picker="{{ $field }}">
    <span id="{{ $labelId }}">Tanggal {{ $field === 'start' ? 'Mulai' : 'Selesai' }} <span class="text-[#C66A4A]">*</span></span>
    <input type="hidden" name="{{ $field === 'start' ? 'start_date' : 'end_date' }}" value="{{ $inputValue }}" data-date-input="{{ $field }}">
    <button class="flex min-h-[44px] w-full min-w-0 items-center gap-2.5 rounded-[10px] border border-white/80 bg-white/65 px-3 text-left text-[12px] font-medium text-[#142230] shadow-[inset_0_1px_0_rgba(255,255,255,.88)] outline-none backdrop-blur-md transition hover:border-[#B9C9C2] focus-visible:border-[#1B665D] focus-visible:ring-2 focus-visible:ring-[#1B665D]/15 dark:border-white/10 dark:bg-white/[.06] dark:text-[#F5F2EB] dark:hover:border-white/20" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="{{ $calendarId }}" data-date-trigger="{{ $field }}">
        <i class="fa-regular fa-calendar text-[#667276] dark:text-[#B9C5C0]" aria-hidden="true"></i>
        <span class="min-w-0 flex-1 truncate" data-date-value="{{ $field }}" aria-live="polite">Pilih tanggal</span>
        <i class="fa-solid fa-chevron-down text-[9px] text-[#667276] dark:text-[#B9C5C0]" aria-hidden="true"></i>
    </button>
    @if ($field === 'start')
        @error('start_date')<small class="font-normal text-red-700 dark:text-red-300">{{ $message }}</small>@enderror
    @else
        @error('end_date')<small class="font-normal text-red-700 dark:text-red-300">{{ $message }}</small>@enderror
    @endif
    <div class="fixed z-[100] max-h-[min(80svh,380px)] w-[min(320px,calc(100vw-24px))] overflow-y-auto rounded-2xl border border-white/80 bg-[linear-gradient(145deg,rgba(255,252,248,.97),rgba(248,243,235,.92))] p-3.5 text-[#142230] shadow-[0_22px_56px_rgba(20,34,48,.22),inset_0_1px_0_rgba(255,255,255,.96)] backdrop-blur-2xl transition duration-200 dark:border-[#40504B] dark:bg-[rgba(22,36,33,.98)] dark:text-[#F5F2EB]" id="{{ $calendarId }}" role="dialog" aria-modal="false" aria-labelledby="{{ $calendarId }}-month" aria-hidden="true" data-date-calendar="{{ $field }}" style="display: none">
        <div class="mb-2.5 flex items-center justify-between gap-3">
            <h3 class="m-0 text-[13px] font-bold capitalize" id="{{ $calendarId }}-month" data-date-month></h3>
            <div class="flex items-center gap-1">
                <button class="grid h-8 w-8 place-items-center rounded-full text-[#52615F] transition hover:bg-[#F1E5D9] focus-visible:outline-2 focus-visible:outline-[#C66A4A] dark:text-[#D2DAD6] dark:hover:bg-[#293C37]" type="button" aria-label="Bulan sebelumnya" data-date-prev><i class="fa-solid fa-chevron-left text-[10px]" aria-hidden="true"></i></button>
                <button class="grid h-8 w-8 place-items-center rounded-full text-[#52615F] transition hover:bg-[#F1E5D9] focus-visible:outline-2 focus-visible:outline-[#C66A4A] dark:text-[#D2DAD6] dark:hover:bg-[#293C37]" type="button" aria-label="Bulan berikutnya" data-date-next><i class="fa-solid fa-chevron-right text-[10px]" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="mb-1 grid grid-cols-7 text-center text-[9px] font-semibold uppercase tracking-wide text-[#7A8181] dark:text-[#AEB8B4]" aria-hidden="true"><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span></div>
        <div class="grid grid-cols-7 gap-y-0.5" data-date-days role="grid" aria-label="Pilih tanggal"></div>
        <div class="mt-2.5 flex items-center justify-between border-t border-[#EEE4DA] pt-2.5 text-[10px] font-medium text-[#70797A] dark:border-[#354541] dark:text-[#B9C5C0]">
            <span data-date-hint>Pilih tanggal</span>
            <button class="rounded-md px-2 py-1 text-[#1B665D] transition hover:bg-[#EAF1ED] focus-visible:outline-2 focus-visible:outline-[#C66A4A] dark:text-[#9AC7B8] dark:hover:bg-[#263833]" type="button" data-date-today>Hari ini</button>
        </div>
    </div>
</div>
