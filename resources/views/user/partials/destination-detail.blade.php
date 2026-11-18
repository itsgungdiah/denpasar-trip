@php
    $openingHours = is_array($destination->opening_hours) ? $destination->opening_hours : [];
    $schedules = is_array($openingHours['schedules'] ?? null) ? $openingHours['schedules'] : [];
    $formatAmount = static fn ($amount) => is_numeric($amount) ? 'Rp' . number_format((float) $amount, 0, ',', '.') : null;
    $formatCost = static function ($value, bool $entrance = false) use ($formatAmount): ?string {
        if (! is_array($value)) return null;

        $type = $value['type'] ?? null;
        if ($entrance && $type === 'free') return 'Gratis';
        if ($type === 'fixed') return $formatAmount($value['amount'] ?? null);
        if ($type === 'range') {
            $minimum = $formatAmount($value['min'] ?? null);
            $maximum = $formatAmount($value['max'] ?? null);

            return $minimum !== null && $maximum !== null ? $minimum . ' – ' . $maximum : null;
        }

        return null;
    };
    $entranceFee = $formatCost($destination->entrance_fee, true);
    $averageSpending = $formatCost($destination->average_spending);
    $categoryClasses = [
        'nature' => 'bg-nature-bg text-nature-text',
        'culture' => 'bg-culture-bg text-culture-text',
        'art' => 'bg-art-bg text-art-text',
        'culinary' => 'bg-culinary-bg text-culinary-text',
        'shopping' => 'bg-shopping-bg text-shopping-text',
    ];
@endphp

<div class="grid min-w-0 grid-cols-1 gap-4 font-sans text-[#142230] dark:text-[#F5F2EB] md:grid-cols-[minmax(0,1.4fr)_minmax(250px,.9fr)] md:gap-5">
    <div class="min-w-0">
        <div class="h-[clamp(170px,24vw,240px)] overflow-hidden rounded-xl bg-[#F1EEE9] ring-1 ring-inset ring-white/70 dark:bg-[#14211F] dark:ring-white/10">
            @if ($destination->image)
                <img class="h-full w-full object-cover" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($destination->image) }}" alt="{{ $destination->name }}">
            @else
                <div class="grid h-full place-content-center justify-items-center gap-2 text-sm text-[#817970] dark:text-[#C5CBC8]" role="img" aria-label="Gambar destinasi belum tersedia">
                    <svg class="h-10 w-10" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="5" y="7" width="38" height="34" rx="4"></rect><circle cx="17" cy="19" r="3"></circle><path d="m7 36 12-11 8 7 5-5 9 9"></path></svg>
                    <span>Gambar belum tersedia</span>
                </div>
            @endif
        </div>

        <h2 id="destination-modal-title" class="mb-1.5 mt-3 font-display text-[clamp(1.4rem,2.2vw,1.8rem)] font-semibold leading-tight tracking-[-.025em] text-[#101F2D] dark:text-[#F5F2EB]">{{ $destination->name }}</h2>
        <div class="flex min-h-6 flex-wrap gap-1.5" aria-label="Kategori destinasi">
            @foreach ($destination->categories as $category)
                <span class="inline-flex min-h-5 items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold leading-none {{ $categoryClasses[strtolower($category->name)] ?? 'bg-[#EAE7E1] text-[#4F5658] dark:bg-[#354541] dark:text-[#E3E8E5]' }}">{{ $category->name }}</span>
            @endforeach
        </div>

        <section class="mt-3 border-t border-[#E7DED3] pt-3 dark:border-white/10" aria-labelledby="destination-description-title">
            <h3 id="destination-description-title" class="font-display text-[15px] font-semibold text-[#A95C40] dark:text-[#D98A6E]">Deskripsi</h3>
            @if (filled($destination->description))
                <p class="mt-1.5 whitespace-pre-line text-[13px] leading-[1.65] text-[#62686B] dark:text-[#C8D0CC]">{{ $destination->description }}</p>
            @else
                <p class="mt-1.5 text-[13px] leading-relaxed text-[#7C7C7C] dark:text-[#C5CBC8]">Deskripsi belum tersedia.</p>
            @endif
        </section>

        @include('user.partials.destination-reviews-section', compact('destination', 'reviews'))
    </div>

    <aside class="grid min-w-0 content-start grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-1" aria-label="Informasi destinasi">
        <section class="rounded-xl border border-white/90 bg-[linear-gradient(145deg,rgba(244,250,246,.82),rgba(232,242,236,.64))] p-3.5 shadow-[0_8px_22px_rgba(34,67,57,.06),inset_0_1px_0_rgba(255,255,255,.88)] backdrop-blur-xl transition duration-200 hover:shadow-[0_10px_26px_rgba(34,67,57,.1)] dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(38,61,54,.72),rgba(27,45,40,.66))]" aria-labelledby="destination-hours-title">
            <div class="flex items-center gap-3">
                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-[#123B35]/10 text-[#123B35] dark:bg-[#9AC7B8]/15 dark:text-[#9AC7B8]"><svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3.5 2"></path></svg></span>
                <h3 id="destination-hours-title" class="text-[13px] font-semibold tracking-[-.01em] text-[#1B2C2D] dark:text-[#F2F5F1]">Jam Operasional</h3>
            </div>
            @if ($schedules !== [])
                <dl class="mt-3 space-y-1.5 text-[11px] text-[#626B68] dark:text-[#C8D0CC]">
                    @foreach ($schedules as $schedule)
                        @php
                            $days = is_array($schedule['days'] ?? null) ? array_filter($schedule['days'], 'is_string') : [];
                            $hours = is_string($schedule['hours'] ?? null) ? trim($schedule['hours']) : '';
                        @endphp
                        <div class="flex items-start justify-between gap-3 border-b border-[#DED8D0]/70 pb-1.5 last:border-0 last:pb-0 dark:border-[#354541]"><dt>{{ implode(', ', $days) }}</dt><dd class="shrink-0 text-right">{{ $hours }}</dd></div>
                    @endforeach
                </dl>
            @else
                <p class="mt-3 text-xs leading-relaxed text-[#727B78] dark:text-[#C8D0CC]">Informasi jam operasional belum tersedia.</p>
            @endif
            @if (filled($openingHours['notes'] ?? null))
                <p class="mt-2 text-[11px] leading-relaxed text-[#626B68] dark:text-[#C8D0CC]"><strong class="font-semibold">Catatan / hari libur:</strong> {{ $openingHours['notes'] }}</p>
            @endif
        </section>

        <section class="rounded-xl border border-white/90 bg-[linear-gradient(145deg,rgba(255,249,245,.84),rgba(248,237,229,.68))] p-3.5 shadow-[0_8px_22px_rgba(115,70,48,.055),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-xl transition duration-200 hover:shadow-[0_10px_26px_rgba(115,70,48,.09)] dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(65,48,41,.74),rgba(47,36,31,.66))]" aria-labelledby="destination-entrance-title">
            <div class="flex items-center gap-3">
                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-[#C66A4A]/15 text-[#B96142] dark:bg-[#E38B6D]/15 dark:text-[#E38B6D]"><svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m4 8 4-4 12 12-4 4L4 8Z"></path><path d="m8 4 3-3m9 17 3-3M7 11l2-2"></path></svg></span>
                <h3 id="destination-entrance-title" class="text-[13px] font-semibold tracking-[-.01em] text-[#1B2C2D] dark:text-[#F2F5F1]">Tiket Masuk</h3>
            </div>
            <p class="ml-12 mt-2 font-display text-base font-bold leading-snug text-[#17232A] dark:text-[#F5F2EB]">{{ $entranceFee ?? 'Informasi tiket belum tersedia.' }}</p>
            @if (is_array($destination->entrance_fee) && filled($destination->entrance_fee['notes'] ?? null))
                <p class="ml-12 mt-1.5 text-[11px] leading-relaxed text-[#626B68] dark:text-[#C8D0CC]">{{ $destination->entrance_fee['notes'] }}</p>
            @endif
        </section>

        <section class="rounded-xl border border-white/90 bg-[linear-gradient(145deg,rgba(246,250,253,.84),rgba(235,243,248,.68))] p-3.5 shadow-[0_8px_22px_rgba(40,85,112,.055),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-xl transition duration-200 hover:shadow-[0_10px_26px_rgba(40,85,112,.09)] dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(37,56,66,.74),rgba(27,43,51,.66))]" aria-labelledby="destination-spending-title">
            <div class="flex items-center gap-3">
                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-[#3A7CA3]/15 text-[#286B96] dark:bg-[#72B6D6]/15 dark:text-[#8CCCE8]"><svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M3 10h18m-13 5h4"></path></svg></span>
                <h3 id="destination-spending-title" class="text-[13px] font-semibold tracking-[-.01em] text-[#1B2C2D] dark:text-[#F2F5F1]">Rata-Rata Pengeluaran</h3>
            </div>
            <p class="ml-12 mt-2 font-display text-base font-bold leading-snug text-[#17232A] dark:text-[#F5F2EB]">{{ $averageSpending ?? 'Informasi belum tersedia.' }}</p>
            @if (is_array($destination->average_spending) && filled($destination->average_spending['notes'] ?? null))
                <p class="ml-12 mt-1.5 text-[11px] leading-relaxed text-[#626B68] dark:text-[#C8D0CC]">{{ $destination->average_spending['notes'] }}</p>
            @endif
        </section>

        @if (filled($destination->google_maps_url))
            <a class="group flex min-h-11 items-center justify-center gap-2.5 rounded-xl border border-white/90 bg-[linear-gradient(145deg,rgba(255,255,255,.78),rgba(247,249,246,.62))] px-3 text-center text-[13px] font-semibold text-[#123B35] shadow-[0_7px_18px_rgba(29,61,53,.07),inset_0_1px_0_rgba(255,255,255,.92)] backdrop-blur-xl transition duration-200 hover:-translate-y-0.5 hover:border-white hover:bg-white/90 hover:shadow-[0_10px_24px_rgba(29,61,53,.12)] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#123B35] dark:border-white/15 dark:bg-[linear-gradient(145deg,rgba(45,67,60,.72),rgba(30,49,44,.62))] dark:text-[#D2E9DF] dark:hover:bg-[#203A33] sm:col-span-2 md:col-span-1" href="{{ $destination->google_maps_url }}" target="_blank" rel="noopener noreferrer">
                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:-translate-y-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="2.5"></circle></svg>
                Buka di Google Maps
                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M14 4h6v6m-1-5-9 9"></path><path d="M18 13v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6"></path></svg>
            </a>
        @else
            <span class="flex min-h-12 items-center justify-center gap-2 rounded-xl border border-[#C8C2BB] bg-white/40 px-3 text-center text-sm font-semibold text-[#777] dark:border-[#52605B] dark:bg-white/5 dark:text-[#AAB4B0] sm:col-span-2 md:col-span-1" aria-disabled="true" title="Tautan Google Maps belum tersedia">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="2.5"></circle></svg>
                Tautan Google Maps belum tersedia
            </span>
        @endif
    </aside>
</div>
