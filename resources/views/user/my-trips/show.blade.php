<x-user.layout title="Detail Trip" active-page="my-trips">
    <section class="[box-sizing:border-box] [width:min(calc(100%_-_48px),_1120px)] [margin:0_auto] [padding-top:104px] [padding-bottom:48px] [max-width:1000px] max-[620px]:[width:calc(100%_-_24px)] max-[620px]:[padding-top:92px] max-[620px]:[padding-bottom:32px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-labelledby="trip-detail-title">
        <a class="[display:inline-flex] [align-items:center] [gap:7px] [margin-bottom:17px] [color:#53605F] dark:[color:#C5CBC8] [font-size:12px] [font-weight:600] [text-decoration:none] hover:[color:#123B35] dark:hover:[color:#9AC7B8] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" href="{{ route('my-trips.index') }}"><i class="fa-solid fa-arrow-left motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i> Kembali ke My Trip</a>
        <div class="[display:flex] [align-items:center] [justify-content:space-between] [gap:24px] [margin-bottom:10px] [align-items:flex-end] [margin-bottom:22px] [padding:21px_24px] [border:1px_solid_#F0E2D5] [border-radius:12px] [background:#FBF9F6] dark:[background:#14211F] max-[620px]:[align-items:flex-start] max-[620px]:[flex-direction:column] max-[620px]:[gap:13px] max-[620px]:[padding:17px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            <div>
                <p class="[margin:0_0_8px] [color:#777A7C] [font-size:10px] [line-height:1.3] [font-weight:700] [letter-spacing:.13em] [.trip-current-itinerary_&]:[margin-bottom:3px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">ITINERARY PERJALANAN</p>
                <h1 id="trip-detail-title">{{ $trip->trip_name }}</h1>
                <p class="[display:flex] [align-items:center] [gap:8px] [margin:9px_0_0] [color:#686D71] dark:[color:#C5CBC8] [font-size:12px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"><i class="fa-regular fa-calendar motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i>{{ $trip->start_date->translatedFormat('d F Y') }} – {{ $trip->end_date->translatedFormat('d F Y') }}</p>
            </div>
            <a class="[display:inline-flex] [min-height:42px] [align-items:center] [justify-content:center] [gap:9px] [padding:0_18px] [border:1px_solid_transparent] [border-radius:9px] [font:inherit] [font-size:12px] [font-weight:700] [text-decoration:none] [cursor:pointer] [transition:transform_180ms_ease,_background_180ms_ease,_box-shadow_180ms_ease] [border-color:#1B665D] [background:#fff] dark:[background:#1D2B28] [color:#123B35] dark:[color:#9AC7B8] hover:[background:#F2F7F3] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" href="{{ route('trips.discover', $trip) }}">Tambah destinasi</a>
        </div>

        @if ($trip->itineraries->isEmpty())
            <div class="[min-height:265px] [display:grid] [align-content:center] [justify-items:center] [gap:10px] [padding:24px] [text-align:center] [min-height:200px] [border:1px_solid_#F0E2D5] [border-radius:12px] [background:#FBF9F6] dark:[background:#14211F] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <h2>Belum ada destinasi di itinerary</h2>
                <p>Pilih kategori minat lalu tambahkan destinasi yang kamu inginkan.</p>
                <a class="[display:inline-flex] [min-height:42px] [align-items:center] [justify-content:center] [gap:9px] [padding:0_18px] [border:1px_solid_transparent] [border-radius:9px] [font:inherit] [font-size:12px] [font-weight:700] [text-decoration:none] [cursor:pointer] [transition:transform_180ms_ease,_background_180ms_ease,_box-shadow_180ms_ease] [background:#123B35] dark:[background:#0B2823] [color:#fff] hover:[transform:translateY(-1px)] hover:[background:#0D302B] hover:[box-shadow:0_5px_12px_rgba(18,59,53,.14)] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" href="{{ route('trips.preferences.edit', $trip) }}">Lanjutkan Trip Planner</a>
            </div>
        @else
            <div class="[display:grid] [gap:12px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                @foreach ($trip->itineraries as $index => $item)
                    <article class="[display:grid] [grid-template-columns:180px_minmax(0,1fr)] [gap:17px] [padding:10px] [border:1px_solid_#EEE8DF] [border-radius:12px] [background:#fff] dark:[background:#1D2B28] [box-shadow:0_4px_12px_rgba(25,38,41,.055)] max-[620px]:[grid-template-columns:96px_minmax(0,1fr)] max-[620px]:[gap:10px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <div class="[min-height:132px] [overflow:hidden] [border-radius:8px] [background:#F1EEE9] dark:[background:#14211F] max-[620px]:[min-height:100px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            @if ($item->destination?->image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->destination->image) }}" alt="{{ $item->destination->name }}" loading="lazy">
                            @else
                                <span><i class="fa-regular fa-image motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i></span>
                            @endif
                        </div>
                        <div class="[align-self:center] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <p class="[margin:0_0_4px] [color:#C66A4A] dark:[color:#E38B6D] [font-size:10px] [font-weight:700] [letter-spacing:.06em] [text-transform:uppercase] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Tempat {{ $item->sort_order ?: $index + 1 }}</p>
                            <h2>{{ $item->destination?->name ?? 'Destinasi tidak tersedia' }}</h2>
                            <p class="[display:flex] [flex-wrap:wrap] [align-items:center] [gap:7px] [margin:0_0_9px] [color:#656B6E] [font-size:11px] max-[620px]:[font-size:10px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"><i class="fa-regular fa-calendar motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i>{{ $item->date->translatedFormat('d F Y') }} <span>·</span> {{ $item->start_time ? \Illuminate\Support\Carbon::parse($item->start_time)->format('H:i') : 'Waktu belum tersedia' }} <span>·</span> {{ $item->duration ? $item->duration . ' menit' : 'Durasi belum tersedia' }}</p>
                            @if ($item->destination?->categories->isNotEmpty())
                                <div class="[display:flex] [flex-wrap:wrap] [gap:5px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                    @foreach ($item->destination->categories as $category)
                                        <span>{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                            @if (filled($item->note))
                                <p class="[margin:8px_0_0] [color:#686D71] dark:[color:#C5CBC8] [font-size:12px] [line-height:1.5] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">{{ $item->note }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</x-user.layout>
