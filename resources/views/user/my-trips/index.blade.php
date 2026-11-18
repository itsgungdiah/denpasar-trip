<x-user.layout title="My Trip" active-page="my-trips" trip-backdrop="true" transparent-footer="true">
    <section class="relative isolate mx-auto my-7 box-border min-h-[490px] w-[min(calc(100%_-_48px),_1120px)] overflow-hidden rounded-[28px] border border-white/75 bg-white/15 px-9 shadow-[0_20px_50px_rgba(31,45,54,.12),inset_0_1px_0_rgba(255,255,255,.95)] backdrop-blur-xl pb-10 pt-5 max-[620px]:my-5 max-[620px]:min-h-0 max-[620px]:w-[calc(100%_-_24px)] max-[620px]:rounded-[22px] max-[620px]:px-3.5 max-[620px]:pb-7 dark:border-white/15 dark:bg-[#14211F]/35 dark:shadow-[0_20px_50px_rgba(0,0,0,.24),inset_0_1px_0_rgba(255,255,255,.12)]" aria-labelledby="my-trips-title">
        <div class="relative z-10">
        <div class="mb-2.5 flex items-center justify-between gap-6 max-[620px]:items-start max-[620px]:flex-col max-[620px]:gap-3">
            <div>
                <h1 id="my-trips-title" class="m-0 font-display text-[40px] font-bold leading-none tracking-[-.03em] text-[#142230] dark:text-[#F5F2EB]">My <span class="text-[#C66A4A]">Trip</span></h1>
                <p class="mb-0 mt-2 text-xs text-[#686D71] dark:text-[#C5CBC8]">Simpan dan lihat kembali rencana perjalananmu di Denpasar.</p>
            </div>
            <a class="inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl border border-white/35 bg-[linear-gradient(135deg,rgba(18,59,53,.94),rgba(10,75,62,.84))] px-[18px] text-xs font-bold text-white no-underline shadow-[0_8px_20px_rgba(14,59,49,.2),inset_0_1px_0_rgba(255,255,255,.28)] backdrop-blur-md transition duration-300 hover:-translate-y-0.5 hover:border-white/55 hover:bg-[linear-gradient(135deg,rgba(18,70,59,.96),rgba(9,87,70,.9))] hover:shadow-[0_12px_24px_rgba(14,59,49,.25),inset_0_1px_0_rgba(255,255,255,.35)] active:translate-y-0 active:scale-[.98] dark:border-white/20 dark:bg-[linear-gradient(135deg,rgba(20,67,57,.9),rgba(8,45,39,.85))]" href="{{ route('trips.create') }}"><i class="fa-solid fa-plus" aria-hidden="true"></i> Buat trip baru</a>
        </div>

        @if (session('success'))
            <p class="mb-3 rounded-xl border border-emerald-200/70 bg-emerald-50/70 px-3 py-2 text-xs text-[#185344] shadow-[inset_0_1px_0_rgba(255,255,255,.8)] backdrop-blur-md dark:border-emerald-100/15 dark:bg-emerald-950/35 dark:text-[#CBE9D6]" role="status">{{ session('success') }}</p>
        @endif

        @if ($trips->isEmpty())
            <div class="grid min-h-[265px] content-center justify-items-center gap-2.5 p-6 text-center">
                <span class="grid size-[58px] place-items-center rounded-full border border-white/70 bg-white/55 text-[22px] text-[#C66A4A] shadow-[0_8px_18px_rgba(31,45,54,.08),inset_0_1px_0_rgba(255,255,255,.95)] backdrop-blur-lg dark:border-white/15 dark:bg-white/[.08] dark:text-[#E38B6D]"><i class="fa-regular fa-map" aria-hidden="true"></i></span>
                <h2 class="m-0 font-display text-2xl font-semibold text-[#142230] dark:text-[#F5F2EB]">Belum ada trip tersimpan</h2>
                <p class="mb-1 mt-0 max-w-lg text-sm text-[#686D71] dark:text-[#C5CBC8]">Trip akan muncul di sini setelah kamu memilih destinasi dan menyimpan itinerary.</p>
                <a class="inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl border border-white/35 bg-[linear-gradient(135deg,rgba(18,59,53,.94),rgba(10,75,62,.84))] px-[18px] text-xs font-bold text-white no-underline shadow-[0_8px_20px_rgba(14,59,49,.2),inset_0_1px_0_rgba(255,255,255,.28)] backdrop-blur-md transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_12px_24px_rgba(14,59,49,.25)] active:scale-[.98] dark:border-white/20 dark:bg-[linear-gradient(135deg,rgba(20,67,57,.9),rgba(8,45,39,.85))]" href="{{ route('trips.create') }}"><i class="fa-solid fa-plus" aria-hidden="true"></i> Mulai merencanakan</a>
            </div>
        @else
            <div class="mt-3.5 grid grid-cols-2 content-start gap-x-[22px] gap-y-[18px] max-[900px]:grid-cols-1">
                @foreach ($trips as $trip)
                    @php
                        $coverItinerary = $trip->itineraries->first(fn ($item) => filled($item->destination?->image)) ?? $trip->itineraries->first();
                        $coverDestination = $coverItinerary?->destination;
                        $minimumTotal = 0;
                        $maximumTotal = 0;
                        $hasCompleteEstimate = $trip->itineraries->isNotEmpty();
                        foreach ($trip->itineraries as $tripItem) {
                            $spending = $tripItem->destination?->average_spending;
                            if (! is_array($spending)) { $hasCompleteEstimate = false; break; }
                            if (($spending['type'] ?? null) === 'fixed' && is_numeric($spending['amount'] ?? null)) {
                                $low = $high = (float) $spending['amount'];
                            } elseif (($spending['type'] ?? null) === 'range' && is_numeric($spending['min'] ?? null) && is_numeric($spending['max'] ?? null)) {
                                $low = (float) $spending['min'];
                                $high = (float) $spending['max'];
                            } else { $hasCompleteEstimate = false; break; }
                            $minimumTotal += $low;
                            $maximumTotal += $high;
                        }
                    @endphp
                    <article class="grid min-h-[120px] min-w-0 grid-cols-[116px_minmax(0,1fr)] gap-3 rounded-2xl border border-white/75 bg-[linear-gradient(145deg,rgba(255,255,255,.68),rgba(255,250,246,.46))] p-1 shadow-[0_12px_28px_rgba(26,34,37,.12),inset_0_1px_0_rgba(255,255,255,.96)] backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_16px_32px_rgba(26,34,37,.16),inset_0_1px_0_rgba(255,255,255,.98)] dark:border-white/15 dark:bg-[linear-gradient(145deg,rgba(28,47,42,.78),rgba(17,34,30,.66))] dark:shadow-[0_12px_28px_rgba(0,0,0,.2),inset_0_1px_0_rgba(255,255,255,.12)] max-[620px]:grid-cols-[96px_minmax(0,1fr)] max-[620px]:gap-2.5">
                        <a class="h-28 overflow-hidden rounded-[7px] bg-[#F1EEE9] dark:bg-[#14211F] max-[620px]:h-[108px]" href="{{ route('my-trips.show', $trip) }}" data-trip-open="{{ $trip->id }}" aria-label="Lihat trip {{ $trip->trip_name }}">
                            @if ($coverDestination?->image)
                                <img class="h-full w-full object-cover" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($coverDestination->image) }}" alt="{{ $coverDestination->name }}" loading="lazy">
                            @else
                                <span class="grid h-full place-content-center justify-items-center gap-1 text-[#8C8984]"><i class="fa-regular fa-image text-[22px]" aria-hidden="true"></i><small>Gambar belum tersedia</small></span>
                            @endif
                        </a>
                        <div class="grid min-w-0 content-start grid-cols-1 py-1.5 pr-1">
                            <h2 class="mb-1 mt-0 truncate font-display text-sm font-bold leading-tight text-[#142230] dark:text-[#F5F2EB]">{{ $trip->trip_name }}</h2>
                            <p class="mb-1.5 mt-0 flex items-center gap-[7px] text-[10px] leading-tight text-[#777B7D] dark:text-[#C5CBC8]"><i class="fa-regular fa-calendar w-[13px] text-center text-[#818587]" aria-hidden="true"></i><span>{{ $trip->start_date->translatedFormat('d M Y') }} – {{ $trip->end_date->translatedFormat('d M Y') }}</span></p>
                            <p class="mb-1 mt-0 flex items-center gap-[7px] text-[10px] leading-tight text-[#777B7D] dark:text-[#C5CBC8]"><i class="fa-solid fa-location-dot w-[13px] text-center text-[#818587]" aria-hidden="true"></i>{{ $trip->itineraries_count }} Tempat</p>
                            <a class="mt-1 inline-flex min-h-[29px] min-w-[104px] items-center justify-between justify-self-end gap-2 rounded-lg border border-white/30 bg-[linear-gradient(135deg,rgba(18,59,53,.94),rgba(10,75,62,.82))] px-[11px] text-[10px] font-bold text-white no-underline shadow-[0_5px_12px_rgba(14,59,49,.18),inset_0_1px_0_rgba(255,255,255,.28)] backdrop-blur-md transition duration-300 hover:-translate-y-px hover:shadow-[0_8px_16px_rgba(14,59,49,.24)] active:scale-[.98] dark:border-white/15 dark:bg-[linear-gradient(135deg,rgba(20,67,57,.9),rgba(8,45,39,.85))]" href="{{ route('my-trips.show', $trip) }}" data-trip-open="{{ $trip->id }}">Lihat Trip <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </article>

                    <dialog id="trip-detail-{{ $trip->id }}" class="m-auto max-h-[min(92vh,900px)] w-[min(92vw,760px)] max-w-none overflow-y-auto rounded-2xl border border-white/75 bg-[linear-gradient(145deg,rgba(255,255,255,.78),rgba(248,246,241,.66))] p-0 text-[#142230] shadow-[0_28px_80px_rgba(14,28,35,.25),inset_0_1px_0_rgba(255,255,255,.96)] backdrop-blur-3xl backdrop:bg-black/40 dark:border-white/20 dark:bg-[linear-gradient(145deg,rgba(28,47,42,.84),rgba(17,31,28,.78))] dark:text-[#F5F2EB]" data-trip-detail-modal="{{ $trip->id }}" aria-labelledby="trip-modal-title-{{ $trip->id }}">
                        <div class="relative p-5 sm:p-6">
                            <button class="absolute right-3 top-3 grid size-9 place-items-center rounded-full border border-white/75 bg-white/55 text-xl text-[#142230] shadow-[0_6px_16px_rgba(20,34,48,.12),inset_0_1px_0_rgba(255,255,255,.95)] backdrop-blur-xl transition duration-200 hover:bg-white/80 active:scale-95 dark:border-white/20 dark:bg-white/[.10] dark:text-[#F5F2EB] dark:hover:bg-white/[.16]" type="button" data-trip-modal-close aria-label="Tutup detail trip"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
                            <div class="mb-4 grid grid-cols-[128px_minmax(0,1fr)] gap-4 pr-9 max-[520px]:grid-cols-1">
                                <div class="h-[126px] overflow-hidden rounded-lg bg-[#F1EEE9] dark:bg-[#263632]">
                                    @if ($coverDestination?->image)
                                        <img class="h-full w-full object-cover" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($coverDestination->image) }}" alt="{{ $coverDestination->name }}">
                                    @else
                                        <span class="grid h-full place-items-center text-[#8C8984]"><i class="fa-regular fa-image text-3xl" aria-hidden="true"></i></span>
                                    @endif
                                </div>
                                <div class="self-center">
                                    <h2 id="trip-modal-title-{{ $trip->id }}" class="mb-2 mt-0 font-display text-xl font-bold text-[#142230] dark:text-[#F5F2EB]">{{ $trip->trip_name }}</h2>
                                    <p class="mb-1 flex items-center gap-2 text-xs text-[#686D71] dark:text-[#C5CBC8]"><i class="fa-regular fa-calendar" aria-hidden="true"></i>{{ $trip->start_date->translatedFormat('d M Y') }} – {{ $trip->end_date->translatedFormat('d M Y') }}</p>
                                    <p class="mb-1 flex items-center gap-2 text-xs text-[#686D71] dark:text-[#C5CBC8]"><i class="fa-solid fa-location-dot" aria-hidden="true"></i>{{ $trip->itineraries_count }} Tempat</p>
                                    @if ($hasCompleteEstimate)
                                        <p class="mb-3 flex items-center gap-2 text-xs text-[#686D71] dark:text-[#C5CBC8]"><i class="fa-solid fa-wallet" aria-hidden="true"></i>Estimasi pengeluaran: Rp{{ number_format($minimumTotal, 0, ',', '.') }}@if ($maximumTotal !== $minimumTotal) – Rp{{ number_format($maximumTotal, 0, ',', '.') }}@endif</p>
                                    @endif
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <a class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-white/35 bg-[linear-gradient(135deg,rgba(18,59,53,.92),rgba(10,75,62,.78))] px-3.5 text-xs font-bold text-white no-underline shadow-[0_6px_14px_rgba(14,59,49,.16),inset_0_1px_0_rgba(255,255,255,.28)] backdrop-blur-lg transition duration-200 hover:-translate-y-px hover:shadow-[0_9px_18px_rgba(14,59,49,.2)] active:scale-[.98] dark:border-white/20 dark:bg-[linear-gradient(135deg,rgba(25,70,60,.86),rgba(10,45,39,.82))]" href="{{ route('trips.edit', $trip) }}"><i class="fa-regular fa-pen-to-square" aria-hidden="true"></i>Edit Trip</a>
                                        <form method="POST" action="{{ route('my-trips.destroy', $trip) }}" data-trip-delete-form>
                                            @csrf @method('DELETE')
                                            <button class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-rose-300/60 bg-[linear-gradient(135deg,rgba(255,247,246,.76),rgba(254,226,226,.62))] px-3.5 text-xs font-bold text-[#A34437] shadow-[0_5px_13px_rgba(127,29,29,.08),inset_0_1px_0_rgba(255,255,255,.92)] backdrop-blur-lg transition duration-200 hover:-translate-y-px hover:border-rose-400/70 hover:bg-[linear-gradient(135deg,rgba(255,241,239,.88),rgba(254,215,215,.76))] active:scale-[.98] dark:border-rose-200/20 dark:bg-[linear-gradient(135deg,rgba(102,42,39,.48),rgba(74,31,30,.42))] dark:text-[#FFC0B5] dark:hover:bg-rose-950/50" type="submit"><i class="fa-regular fa-trash-can" aria-hidden="true"></i>Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-2">
                                @foreach ($trip->itinerary_days as $day)
                                    <details class="group rounded-xl border border-white/65 bg-white/35 shadow-[0_5px_16px_rgba(28,43,48,.045),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-xl open:pb-2 dark:border-white/15 dark:bg-white/[.055] dark:shadow-[inset_0_1px_0_rgba(255,255,255,.08)]" @if ($day['number'] === 1) open @endif>
                                        <summary class="flex cursor-pointer list-none items-center gap-3 px-3 py-2.5 [&::-webkit-details-marker]:hidden">
                                            <span class="grid size-8 shrink-0 place-items-center rounded-full bg-[#123B35] text-xs font-semibold text-white dark:bg-[#0B2823]">{{ $day['number'] }}</span>
                                            <span class="min-w-0 flex-1"><strong class="block text-xs text-[#142230] dark:text-[#F5F2EB]">Day {{ $day['number'] }}</strong><small class="mt-0.5 block text-[10px] text-[#5E666C] dark:text-[#C5CBC8]">{{ $day['date']->translatedFormat('d M Y') }} · {{ $day['items']->count() }} Tempat</small></span>
                                            <i class="fa-solid fa-chevron-down text-xs text-[#5E666C] transition group-open:rotate-180 dark:text-[#C5CBC8]" aria-hidden="true"></i>
                                        </summary>
                                        @if ($day['items']->isEmpty())
                                            <p class="mb-1 ml-[60px] mr-3 mt-1 rounded-lg border border-white/55 bg-white/35 px-3 py-2 text-xs text-[#6E7477] backdrop-blur-md dark:border-white/10 dark:bg-white/[.035] dark:text-[#C5CBC8]">Belum ada destinasi ditambahkan untuk hari ini.</p>
                                        @else
                                            <form class="mx-3 ml-[60px] grid gap-1.5" action="{{ route('trips.itineraries.reorder', $trip) }}" method="POST" data-trip-reorder-form>
                                                @csrf @method('PUT')
                                                <input type="hidden" name="date" value="{{ $day['date']->toDateString() }}">
                                                <ol class="m-0 grid list-none gap-1.5 p-0" data-trip-sort-list>
                                                    @foreach ($day['items'] as $item)
                                                        <li class="grid grid-cols-[66px_minmax(0,1fr)_24px] items-center gap-2 rounded-lg border border-white/60 bg-white/40 p-1.5 shadow-[0_4px_12px_rgba(28,43,48,.04),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-lg dark:border-white/10 dark:bg-white/[.045] dark:shadow-[inset_0_1px_0_rgba(255,255,255,.07)]" draggable="true" data-trip-sort-item data-itinerary-id="{{ $item->id }}">
                                                            <div class="h-10 overflow-hidden rounded bg-[#F1EEE9] dark:bg-[#263632]">
                                                                @if ($item->destination?->image)
                                                                    <img class="h-full w-full object-cover" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->destination->image) }}" alt="{{ $item->destination->name }}" loading="lazy">
                                                                @else
                                                                    <span class="grid h-full place-items-center text-[#8C8984]"><i class="fa-regular fa-image" aria-hidden="true"></i></span>
                                                                @endif
                                                            </div>
                                                            <span class="min-w-0"><strong class="block truncate text-[11px] text-[#26333A] dark:text-[#F5F2EB]">{{ $item->destination?->name ?? 'Destinasi tidak tersedia' }}</strong><small class="mt-0.5 block text-[9px] text-[#52606A] dark:text-[#C5CBC8]">{{ $item->duration ? $item->duration . ' Menit' : 'Durasi belum tersedia' }} · {{ $item->start_time ? \Illuminate\Support\Carbon::parse($item->start_time)->format('H:i') : 'Waktu belum tersedia' }}@if ($item->start_time && $item->duration) s/d {{ \Illuminate\Support\Carbon::parse($item->start_time)->addMinutes($item->duration)->format('H:i') }}@endif</small></span>
                                                            <span class="cursor-grab text-center text-[#123B35] active:cursor-grabbing dark:text-[#9AC7B8]" aria-label="Seret untuk mengubah urutan"><i class="fa-solid fa-grip-vertical" aria-hidden="true"></i></span>
                                                        </li>
                                                    @endforeach
                                                </ol>
                                                <p class="hidden text-[11px] text-[#185344] dark:text-[#CBE9D6]" data-trip-reorder-status role="status"></p>
                                            </form>
                                        @endif
                                    </details>
                                @endforeach
                            </div>
                        </div>
                    </dialog>
                @endforeach
            </div>
            @if ($trips->hasPages())
                <div class="mt-6 flex justify-center rounded-2xl border border-white/70 bg-white/35 p-2 text-xs shadow-[0_10px_24px_rgba(31,45,54,.08),inset_0_1px_0_rgba(255,255,255,.92)] backdrop-blur-xl dark:border-white/15 dark:bg-[#132622]/45 dark:shadow-[0_10px_24px_rgba(0,0,0,.2),inset_0_1px_0_rgba(255,255,255,.1)]">{{ $trips->links() }}</div>
            @endif
        @endif
        </div>
    </section>
</x-user.layout>
