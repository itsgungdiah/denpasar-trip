<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Explore | DenpasarTrip</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="explore-page" class="min-h-screen overflow-x-hidden bg-[#F7F3EC] font-sans antialiased text-[#101F2D] dark:bg-[#14211F] dark:text-[#F5F2EB] motion-reduce:scroll-auto motion-reduce:animate-none motion-reduce:transition-none">
    @include('user.partials.navbar', ['activePage' => 'explore'])

    <main>
        <form method="GET" action="{{ route('explore.index') }}">
            <section id="explore-hero" aria-labelledby="explore-title" style="--explore-background:url('{{ asset('images/explore.png') }}')" class="relative flex min-h-[300px] items-end bg-[image:linear-gradient(90deg,rgba(255,245,226,.72),rgba(255,245,226,.12)_65%,rgba(16,31,45,.06)),linear-gradient(0deg,rgba(10,31,28,.28),transparent_65%),var(--explore-background)] bg-cover bg-[position:center_52%] bg-no-repeat pb-7 pt-[110px] max-[720px]:min-h-[420px] max-[720px]:bg-[position:58%_center] max-[720px]:pb-6 max-[480px]:min-h-[450px]">
                <div class="mx-auto w-[min(100%_-_48px,_1112px)] max-[1079px]:w-[calc(100%_-_32px)] max-[520px]:w-[calc(100%_-_20px)]">
                    <p data-explore-reveal class="m-0 text-[13px] font-bold leading-[1.3] tracking-[.12em] text-[#142230] dark:text-[#142230]">EXPLORE</p>
                    <h1 id="explore-title" data-explore-reveal class="mt-1.5 text-[clamp(42px,6vw,66px)] font-bold leading-[.98] tracking-[-.04em] text-[#142230] [font-family:var(--font-display),Georgia,serif] max-[720px]:text-[clamp(40px,9vw,58px)]">Jelajahi Denpasar</h1>
                    <p data-explore-reveal class="mb-4 mt-2 max-w-[560px] text-[16px] leading-[1.35] text-[#26333A] max-[480px]:text-[14px]">Temukan destinasi menakjubkan, tempat tersembunyi, dan pengalaman unik di Denpasar.</p>
                    <label class="flex min-h-12 items-center gap-3 rounded-full border border-white/75 bg-[linear-gradient(135deg,rgba(255,255,255,.88),rgba(250,247,242,.72))] py-1 pl-4 pr-1.5 shadow-[0_10px_28px_rgba(24,34,38,.15),inset_0_1px_0_rgba(255,255,255,.92)] backdrop-blur-xl transition-[border-color,box-shadow,background-color] duration-300 dark:border-white/15 dark:bg-[linear-gradient(135deg,rgba(28,43,40,.84),rgba(20,33,31,.72))] dark:shadow-[0_10px_28px_rgba(0,0,0,.25),inset_0_1px_0_rgba(255,255,255,.1)] max-[480px]:gap-2 max-[480px]:pl-3">
                        <svg class="h-5 w-5 shrink-0 text-[#5D6063]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"></circle><path d="m16 16 5 5"></path></svg>
                        <span class="sr-only">Cari destinasi berdasarkan nama</span>
                        <input class="min-w-0 flex-1 border-0 bg-transparent px-1 py-2 text-sm text-[#142230] outline-none placeholder:text-[#747979] focus:ring-0 dark:text-[#F5F2EB]" type="search" name="search" value="{{ $search }}" placeholder="Cari destinasi..." maxlength="100">
                        <button class="min-w-[110px] rounded-full bg-[#B96142] px-6 py-2 text-sm font-bold text-white transition hover:bg-[#a85236] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#123B35] max-[480px]:min-w-[78px] max-[480px]:px-4" type="submit">Cari</button>
                    </label>
                    <div class="relative z-20 mt-3 flex w-full flex-wrap items-center gap-1.5 overflow-visible min-[1080px]:flex-nowrap" aria-label="Filter destinasi">
                    <div class="flex min-w-0 flex-wrap items-center gap-1 min-[1080px]:min-w-0 min-[1080px]:flex-1 min-[1080px]:flex-nowrap" aria-label="Filter kategori destinasi">
                        <a class="inline-flex min-h-[40px] shrink-0 items-center justify-center gap-1.5 rounded-full border border-white/80 bg-[linear-gradient(135deg,rgba(255,255,255,.78),rgba(220,232,229,.66))] px-2.5 text-[13px] font-bold text-[#123B35] shadow-[0_5px_16px_rgba(20,40,38,.12),inset_0_1px_0_rgba(255,255,255,.95)] backdrop-blur-xl no-underline transition duration-300 hover:-translate-y-0.5 hover:border-white hover:bg-white/85 hover:shadow-[0_9px_22px_rgba(20,40,38,.16),inset_0_1px_0_rgba(255,255,255,1)] active:scale-[.98] dark:border-white/25 dark:bg-[linear-gradient(135deg,rgba(28,57,50,.78),rgba(18,42,37,.68))] dark:text-[#F5F2EB] dark:shadow-[0_5px_16px_rgba(0,0,0,.22),inset_0_1px_0_rgba(255,255,255,.14)] min-[1080px]:flex-1 max-[480px]:min-h-[38px] max-[480px]:gap-1.5 max-[480px]:px-3 max-[480px]:text-[11px] {{ $selectedCategories === [] && ! $categoryFilter ? 'ring-2 ring-white/90 ring-offset-1 ring-offset-[#123B35]' : '' }}" href="{{ route('explore.index', ['search' => $search ?: null, 'min_rating' => $minRating, 'sort' => $sort]) }}">
                            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="4" y="4" width="6" height="6"></rect><rect x="14" y="4" width="6" height="6"></rect><rect x="4" y="14" width="6" height="6"></rect><rect x="14" y="14" width="6" height="6"></rect></svg>Semua
                        </a>
                        @foreach (['Nature', 'Culture', 'Art', 'Culinary', 'Shopping'] as $categoryName)
                            @php
                                $categoryStyle = [
                                    'Nature' => 'bg-[rgba(220,235,221,.62)] text-[#187E1F] dark:bg-[rgba(24,76,39,.48)]',
                                    'Culture' => 'bg-[rgba(242,227,199,.66)] text-[#875800] dark:bg-[rgba(112,75,17,.48)]',
                                    'Art' => 'bg-[rgba(233,221,244,.64)] text-[#894AC3] dark:bg-[rgba(83,48,112,.48)]',
                                    'Culinary' => 'bg-[rgba(248,223,210,.66)] text-[#D85E1F] dark:bg-[rgba(118,55,27,.48)]',
                                    'Shopping' => 'bg-[rgba(220,234,245,.66)] text-[#134D7A] dark:bg-[rgba(25,67,98,.48)]',
                                ][$categoryName];
                                $isCategorySelected = in_array($categoryName, $selectedCategories, true);
                            @endphp
                            <label class="relative inline-flex min-h-[40px] shrink-0 cursor-pointer items-center justify-center gap-1.5 rounded-full border border-white/75 px-2.5 text-[13px] font-bold shadow-[0_5px_16px_rgba(20,40,38,.1),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:border-white hover:shadow-[0_9px_22px_rgba(20,40,38,.15),inset_0_1px_0_rgba(255,255,255,1)] active:scale-[.98] {{ $categoryStyle }} {{ $isCategorySelected ? 'ring-2 ring-white/90 ring-offset-1 ring-offset-[#123B35] shadow-[0_7px_18px_rgba(20,40,38,.18),inset_0_1px_0_rgba(255,255,255,1)]' : '' }} min-[1080px]:flex-1 max-[480px]:min-h-[38px] max-[480px]:gap-1.5 max-[480px]:px-3 max-[480px]:text-[11px] dark:border-white/30">
                                <input class="peer sr-only" type="checkbox" name="categories[]" value="{{ $categoryName }}" @checked($isCategorySelected) onchange="this.form.requestSubmit()">
                                @if ($categoryName === 'Nature')
                                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.8 3.2c-8.4.1-13.5 1.9-15.7 6.1-1.6 3.1-.4 6.1 2.3 7.3 2.7 1.2 5.6-.2 6.9-3.2.8-1.8 1.1-4.3 1.2-6.2 1.1 3.8.3 8.5-2.5 12.9h2.1c4-5.4 5.8-11.2 5.7-16.9Z"></path></svg>
                                @elseif ($categoryName === 'Culture' || $categoryName === 'Art')
                                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 20h18M5 18V9h14v9M3 7l9-4 9 4H3Zm5 4v6m4-6v6m4-6v6"></path></svg>
                                @elseif ($categoryName === 'Culinary')
                                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 10h16l-1-5H5l-1 5Zm1 0v9h14v-9M9 19v-5h6v5M4 10a2 2 0 0 0 4 0 2 2 0 0 0 4 0 2 2 0 0 0 4 0 2 2 0 0 0 4 0"></path></svg>
                                @else
                                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 8V6a6 6 0 0 1 12 0v2m-14 0h16l-1 13H5L4 8Z"></path></svg>
                                @endif
                                {{ $categoryName }}
                            </label>
                        @endforeach
                    </div>
                    <div class="ml-auto flex min-w-0 max-w-full flex-wrap items-center justify-end gap-1.5 min-[1080px]:shrink-0 min-[1080px]:flex-nowrap max-[720px]:ml-0 max-[720px]:w-full max-[720px]:justify-start" aria-label="Filter urutan dan rating destinasi">
                        @php
                            $sortOptions = [
                                'name_asc' => 'Nama A–Z',
                                'name_desc' => 'Nama Z–A',
                                'spending_asc' => 'Harga terendah',
                                'spending_desc' => 'Harga tertinggi',
                            ];
                            $ratingOptions = [
                                '' => 'Semua rating',
                                '3' => 'Rating ≥ 3.0',
                                '4' => 'Rating ≥ 4.0',
                                '4.5' => 'Rating ≥ 4.5',
                                '5' => 'Rating ≥ 5.0',
                            ];
                        @endphp
                        <input type="hidden" name="sort" value="{{ $sort }}" data-explore-filter-value="sort">
                        <input type="hidden" name="min_rating" value="{{ $minRating ?? '' }}" data-explore-filter-value="min_rating">

                        <div class="relative order-2 w-[168px] max-w-full max-[480px]:w-full" data-explore-dropdown>
                            <button type="button" class="inline-flex h-[40px] w-full min-w-0 items-center gap-2 rounded-full border border-white/80 bg-[linear-gradient(135deg,rgba(255,255,255,.88),rgba(247,249,248,.68))] px-3 text-left text-[13px] font-semibold text-[#33434A] shadow-[0_8px_24px_rgba(22,38,41,.12),inset_0_1px_0_rgba(255,255,255,.98)] backdrop-blur-2xl transition duration-300 hover:-translate-y-0.5 hover:border-white hover:bg-white/90 hover:shadow-[0_11px_28px_rgba(22,38,41,.16),inset_0_1px_0_white] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#123B35] active:scale-[.99] aria-expanded:border-[#83B5A8] aria-expanded:bg-white/90 dark:border-white/25 dark:bg-[linear-gradient(135deg,rgba(31,48,45,.88),rgba(24,39,36,.76))] dark:text-[#F5F2EB] dark:shadow-[0_8px_24px_rgba(0,0,0,.24),inset_0_1px_0_rgba(255,255,255,.12)] dark:aria-expanded:border-[#6EAA99] max-[480px]:px-3" data-explore-dropdown-trigger aria-haspopup="menu" aria-expanded="false" aria-label="Pilih pengurutan destinasi">
                                <svg class="h-[18px] w-[18px] shrink-0 text-[#728080]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 6h11M4 12h8M4 18h5M18 4v16m0 0-3-3m3 3 3-3"></path></svg>
                                <span class="min-w-0 flex-1 truncate" data-explore-dropdown-label>{{ $sortOptions[$sort] ?? 'Nama A–Z' }}</span>
                                <svg class="h-4 w-4 shrink-0 text-[#6D797A] transition-transform duration-200" data-explore-dropdown-chevron viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m5 7 5 5 5-5"></path></svg>
                            </button>
                            <div class="invisible pointer-events-none absolute right-0 top-[calc(100%+10px)] z-30 w-[min(270px,calc(100vw-36px))] origin-top-right translate-y-1 scale-[.98] rounded-[24px] border border-white/85 bg-[linear-gradient(145deg,rgba(255,255,255,.78),rgba(239,246,242,.65))] p-2 opacity-0 shadow-[0_20px_46px_rgba(25,39,44,.18),inset_0_1px_0_rgba(255,255,255,.98),inset_0_-1px_0_rgba(255,255,255,.45)] backdrop-blur-2xl transition duration-200 ease-out motion-reduce:transition-none dark:border-white/20 dark:bg-[linear-gradient(145deg,rgba(32,49,46,.92),rgba(20,33,31,.88))] dark:shadow-[0_20px_46px_rgba(0,0,0,.38),inset_0_1px_0_rgba(255,255,255,.12)]" data-explore-dropdown-menu aria-hidden="true" inert>
                                @foreach ($sortOptions as $value => $label)
                                    <button type="button" class="flex min-h-11 w-full items-center justify-between rounded-2xl px-3.5 text-left text-sm font-medium text-[#405057] transition duration-200 hover:bg-white/65 hover:text-[#123B35] focus-visible:bg-white/70 focus-visible:outline-none aria-checked:bg-[#E6F0EA]/85 aria-checked:text-[#123B35] dark:text-[#E5ECE8] dark:hover:bg-white/10 dark:hover:text-white dark:aria-checked:bg-white/10 dark:aria-checked:text-white motion-reduce:transition-none" data-explore-filter-option data-filter-name="sort" data-filter-value="{{ $value }}" aria-checked="{{ $sort === $value ? 'true' : 'false' }}" role="menuitemradio"><span>{{ $label }}</span><svg class="h-4 w-4 {{ $sort === $value ? 'opacity-100' : 'opacity-0' }} text-[#176653] dark:text-[#9AC7B8]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m4 10 4 4 8-8"></path></svg></button>
                                @endforeach
                            </div>
                        </div>

                        <div class="relative order-1 w-[168px] max-w-full max-[480px]:w-full" data-explore-dropdown>
                            <button type="button" class="inline-flex h-[40px] w-full min-w-0 items-center gap-2 rounded-full border border-white/80 bg-[linear-gradient(135deg,rgba(255,255,255,.88),rgba(247,249,248,.68))] px-3 text-left text-[13px] font-semibold text-[#33434A] shadow-[0_8px_24px_rgba(22,38,41,.12),inset_0_1px_0_rgba(255,255,255,.98)] backdrop-blur-2xl transition duration-300 hover:-translate-y-0.5 hover:border-white hover:bg-white/90 hover:shadow-[0_11px_28px_rgba(22,38,41,.16),inset_0_1px_0_white] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#123B35] active:scale-[.99] aria-expanded:border-[#83B5A8] aria-expanded:bg-white/90 dark:border-white/25 dark:bg-[linear-gradient(135deg,rgba(31,48,45,.88),rgba(24,39,36,.76))] dark:text-[#F5F2EB] dark:shadow-[0_8px_24px_rgba(0,0,0,.24),inset_0_1px_0_rgba(255,255,255,.12)] dark:aria-expanded:border-[#6EAA99] max-[480px]:px-3" data-explore-dropdown-trigger aria-haspopup="menu" aria-expanded="false" aria-label="Pilih rating minimum">
                                <svg class="h-[18px] w-[18px] shrink-0 fill-[#E4B300] text-[#E4B300]" viewBox="0 0 20 20" aria-hidden="true"><path d="m10 1.5 2.55 5.17 5.7.83-4.12 4.02.97 5.68L10 14.52l-5.1 2.68.97-5.68L1.75 7.5l5.7-.83L10 1.5Z"></path></svg>
                                <span class="min-w-0 flex-1 truncate" data-explore-dropdown-label>{{ $ratingOptions[(string) ($minRating ?? '')] ?? 'Semua rating' }}</span>
                                <svg class="h-4 w-4 shrink-0 text-[#6D797A] transition-transform duration-200" data-explore-dropdown-chevron viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m5 7 5 5 5-5"></path></svg>
                            </button>
                            <div class="invisible pointer-events-none absolute right-0 top-[calc(100%+10px)] z-30 w-[min(270px,calc(100vw-36px))] origin-top-right translate-y-1 scale-[.98] rounded-[24px] border border-white/85 bg-[linear-gradient(145deg,rgba(255,255,255,.78),rgba(239,246,242,.65))] p-2 opacity-0 shadow-[0_20px_46px_rgba(25,39,44,.18),inset_0_1px_0_rgba(255,255,255,.98),inset_0_-1px_0_rgba(255,255,255,.45)] backdrop-blur-2xl transition duration-200 ease-out motion-reduce:transition-none dark:border-white/20 dark:bg-[linear-gradient(145deg,rgba(32,49,46,.92),rgba(20,33,31,.88))] dark:shadow-[0_20px_46px_rgba(0,0,0,.38),inset_0_1px_0_rgba(255,255,255,.12)]" data-explore-dropdown-menu aria-hidden="true" inert>
                                @foreach ($ratingOptions as $value => $label)
                                    <button type="button" class="flex min-h-11 w-full items-center justify-between rounded-2xl px-3.5 text-left text-sm font-medium text-[#405057] transition duration-200 hover:bg-white/65 hover:text-[#123B35] focus-visible:bg-white/70 focus-visible:outline-none aria-checked:bg-[#E6F0EA]/85 aria-checked:text-[#123B35] dark:text-[#E5ECE8] dark:hover:bg-white/10 dark:hover:text-white dark:aria-checked:bg-white/10 dark:aria-checked:text-white motion-reduce:transition-none" data-explore-filter-option data-filter-name="min_rating" data-filter-value="{{ $value }}" aria-checked="{{ (string) ($minRating ?? '') === (string) $value ? 'true' : 'false' }}" role="menuitemradio"><span>{{ $label }}</span><svg class="h-4 w-4 {{ (string) ($minRating ?? '') === (string) $value ? 'opacity-100' : 'opacity-0' }} text-[#176653] dark:text-[#9AC7B8]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m4 10 4 4 8-8"></path></svg></button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </section>

        </form>

        <section data-explore-reveal class="mx-auto mb-12 mt-8 w-[min(calc(100%_-_48px),1112px)] rounded-xl border border-white/75 bg-[linear-gradient(145deg,rgba(255,255,255,.72),rgba(250,247,242,.54))] px-6 pb-7 pt-6 shadow-[0_14px_34px_rgba(31,45,54,.08),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-xl dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.76),rgba(20,33,31,.62))] dark:shadow-[0_16px_36px_rgba(0,0,0,.24),inset_0_1px_0_rgba(255,255,255,.08)] max-[1079px]:w-[calc(100%_-_32px)] max-[720px]:px-5 max-[520px]:w-[calc(100%_-_20px)] max-[480px]:px-3" aria-labelledby="results-title" data-destination-favorites data-user-id="{{ auth()->id() }}">
            <div class="mb-5 flex items-end justify-between gap-4 max-[620px]:items-start max-[620px]:flex-col max-[620px]:gap-1">
                <h2 id="results-title" class="m-0 text-[clamp(28px,3vw,38px)] font-bold leading-tight tracking-[-.035em] text-[#142230] [font-family:var(--font-display),Georgia,serif] dark:text-[#F5F2EB]">Destinasi Pilihan</h2>
                <p class="m-0 text-xs font-medium text-[#123B35] dark:text-[#9AC7B8]">Menampilkan {{ $destinations->count() }} dari {{ $destinations->total() }} destinasi</p>
            </div>

            <div class="grid grid-cols-4 gap-5 max-[760px]:grid-cols-3 max-[620px]:grid-cols-2 max-[620px]:gap-3.5 max-[480px]:grid-cols-1" data-explore-stagger>
                @forelse ($destinations as $destination)
                    @php
                        $destinationCategories = $destination->categories;
                        $formatAmount = static fn ($amount) => is_numeric($amount) ? 'Rp' . number_format((float) $amount, 0, ',', '.') : '';
                        $formatCost = static function ($value, bool $entrance = false) use ($formatAmount): string {
                            if (! is_array($value)) return '';
                            $type = $value['type'] ?? null;
                            if ($entrance && $type === 'free') return 'Gratis';
                            if ($type === 'fixed') return $formatAmount($value['amount'] ?? null);
                            if ($type === 'range') {
                                $minimum = $formatAmount($value['min'] ?? null);
                                $maximum = $formatAmount($value['max'] ?? null);
                                return $minimum !== '' && $maximum !== '' ? $minimum . ' â€“ ' . $maximum : '';
                            }
                            return '';
                        };
                        $entranceFee = $formatCost($destination->entrance_fee, true);
                        $averageSpending = $formatCost($destination->average_spending);
                        $averageRating = $destination->reviews_avg_rating;
                    @endphp
                    <article data-explore-reveal class="group relative flex min-w-0 min-h-[324px] flex-col overflow-hidden rounded-[15px] border border-white/80 bg-[linear-gradient(145deg,rgba(255,255,255,.9),rgba(255,252,248,.74))] shadow-[0_8px_22px_rgba(25,35,40,.1),inset_0_1px_0_rgba(255,255,255,.92)] backdrop-blur-lg transition duration-300 hover:-translate-y-1 hover:border-white hover:shadow-[0_14px_30px_rgba(25,35,40,.15),inset_0_1px_0_rgba(255,255,255,.96)] dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.82),rgba(20,33,31,.7))] dark:shadow-[0_10px_24px_rgba(0,0,0,.24),inset_0_1px_0_rgba(255,255,255,.08)] max-[480px]:min-h-0">
                        <div class="relative h-[122px] shrink-0 overflow-hidden bg-[#EEE8E0] max-[480px]:h-[180px]">
                            @if ($destination->image)
                                <img class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($destination->image) }}" alt="{{ $destination->name }}" loading="lazy">
                            @else
                                <div class="grid h-full w-full place-items-center text-xs text-[#92877D]">Gambar belum tersedia</div>
                            @endif
                            <button type="button" class="absolute right-3 top-3 z-20 grid h-9 w-9 place-items-center rounded-full border border-white/80 bg-white/90 text-[#142230] shadow-[0_4px_14px_rgba(20,31,40,.18)] backdrop-blur transition duration-200 hover:scale-105 hover:text-[#B94C4C] active:scale-95 dark:border-white/20 dark:bg-[#14211F]/90 dark:text-[#F5F2EB] dark:hover:text-[#FF8A8A]" data-destination-favorite data-destination-id="{{ $destination->id }}" data-user-id="{{ auth()->id() }}" data-name="{{ $destination->name }}" data-image="{{ $destination->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($destination->image) : '' }}" data-categories="{{ $destinationCategories->pluck('name')->implode(', ') }}" data-description="{{ \Illuminate\Support\Str::limit(strip_tags($destination->description), 150) }}" data-detail-url="{{ route('user.destinations.detail', $destination) }}" aria-label="Tambahkan {{ $destination->name }} ke favorit" aria-pressed="false">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"></path></svg>
                            </button>
                        </div>
                        <button type="button" class="absolute inset-0 z-10 cursor-pointer rounded-[inherit] border-0 bg-transparent focus-visible:outline-2 focus-visible:outline-offset-[-4px] focus-visible:outline-[#C66A4A]" data-destination-detail data-detail-url="{{ route('user.destinations.detail', $destination) }}" aria-label="Lihat detail {{ $destination->name }}"></button>
                        <div class="flex flex-1 flex-col p-3.5">
                            <div class="mb-2 flex min-h-5 flex-wrap gap-1" aria-label="Kategori destinasi">
                                @foreach ($destinationCategories as $category)
                                    @php($badgeStyle = ['Nature' => 'bg-[rgba(220,235,221,.62)] text-[#187E1F] dark:bg-[rgba(24,76,39,.48)]', 'Culture' => 'bg-[rgba(242,227,199,.66)] text-[#875800] dark:bg-[rgba(112,75,17,.48)]', 'Art' => 'bg-[rgba(233,221,244,.64)] text-[#894AC3] dark:bg-[rgba(83,48,112,.48)]', 'Culinary' => 'bg-[rgba(248,223,210,.66)] text-[#D85E1F] dark:bg-[rgba(118,55,27,.48)]', 'Shopping' => 'bg-[rgba(220,234,245,.66)] text-[#134D7A] dark:bg-[rgba(25,67,98,.48)]'][ $category->name ] ?? 'bg-[#E8E5E1] text-[#575757]')
                                    <span class="inline-flex min-h-[18px] items-center rounded-full px-2.5 py-0.5 text-[9px] font-bold leading-tight {{ $badgeStyle }}">{{ $category->name }}</span>
                                @endforeach
                            </div>
                            <h3 class="m-0 line-clamp-2 text-[14px] font-bold leading-[1.3] text-[#111820] dark:text-[#F5F2EB]">{{ $destination->name }}</h3>
                            @if ($averageRating !== null && $destination->reviews_count > 0)
                                <div class="mt-1.5 flex min-h-[16px] items-center gap-1 text-[10px] text-[#60666A] dark:text-[#C5CBC8]" aria-label="Rating {{ number_format((float) $averageRating, 1) }} dari 5 dari {{ $destination->reviews_count }} ulasan">
                                    <span class="inline-flex shrink-0 items-center gap-0.5" aria-hidden="true">
                                        @for ($star = 1; $star <= 5; $star++)
                                            <svg class="h-3 w-3 {{ $star <= (int) round((float) $averageRating) ? 'text-[#F2C400]' : 'text-[#D4D8D6] dark:text-[#59645F]' }}" viewBox="0 0 20 20" fill="currentColor"><path d="m10 1.7 2.55 5.17 5.7.83-4.12 4.02.97 5.68L10 14.72l-5.1 2.68.97-5.68L1.75 7.7l5.7-.83L10 1.7Z"/></svg>
                                        @endfor
                                    </span>
                                    <strong class="ml-1 font-semibold text-[#17232A] dark:text-[#F5F2EB]">{{ number_format((float) $averageRating, 1) }}</strong><span>({{ number_format($destination->reviews_count, 0, ',', '.') }} ulasan)</span>
                                </div>
                            @else
                                <div class="mt-1.5 min-h-[16px]" aria-hidden="true"></div>
                            @endif
                            <p class="mb-2 mt-1.5 line-clamp-3 min-h-[44px] text-[10px] leading-[1.35] text-[#666A6E] dark:text-[#C5CBC8]">{{ \Illuminate\Support\Str::limit(strip_tags($destination->description), 100) }}</p>
                            <div class="mt-auto grid gap-1" aria-label="Informasi biaya">
                                <div class="flex min-h-[15px] items-center gap-1.5 text-[10px] leading-tight text-[#4F585B] dark:text-[#C5CBC8]"><svg class="h-3.5 w-3.5 shrink-0 text-[#111820] dark:text-[#F5F2EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 6h16v12H4z"></path><path d="M8 6v4l-2 2 2 2v4m8-12v4l2 2-2 2v4"></path></svg><span class="truncate">Tiket Masuk: {{ $entranceFee }}</span></div>
                                <div class="flex min-h-[15px] items-center gap-1.5 text-[10px] leading-tight text-[#4F585B] dark:text-[#C5CBC8]"><svg class="h-3.5 w-3.5 shrink-0 text-[#B96142]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M3 10h18m-13 5h4"></path></svg><span class="truncate">Perkiraan: {{ $averageSpending }}</span></div>
                            </div>
                            <span class="relative z-20 mt-3 ml-auto inline-flex min-h-7 pointer-events-none items-center justify-end gap-1.5 pt-2 text-[11px] font-bold leading-tight text-[#123B35] transition-colors duration-200 group-hover:text-[#B96142] dark:text-[#9AC7B8] dark:group-hover:text-[#E38B6D]">Lihat Detail <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 10h13M11 5l5 5-5 5"></path></svg></span>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-[14px] border border-dashed border-[#DCCBBB] px-5 py-12 text-center text-[#5D6063] dark:text-[#C5CBC8]">
                        <h3 class="text-lg font-semibold">Destinasi tidak ditemukan</h3>
                        <p class="mt-2 text-sm">Coba ubah kata pencarian atau pilihan kategori.</p>
                    </div>
                @endforelse
            </div>

            @if ($destinations->hasPages())
                <nav class="mt-7 flex justify-center rounded-2xl border border-white/65 bg-white/25 p-2 shadow-[0_8px_22px_rgba(31,45,54,.045),inset_0_1px_0_rgba(255,255,255,.78)] backdrop-blur-lg dark:border-white/10 dark:bg-white/[.035]" aria-label="Pagination destinasi">{{ $destinations->links() }}</nav>
            @endif
        </section>

        <section data-explore-reveal style="--explore-cta-background:url('{{ asset('images/cta-explore.png') }}')" class="flex min-h-[310px] items-center bg-[image:linear-gradient(90deg,rgba(7,51,43,.92),rgba(7,51,43,.65)_48%,rgba(7,51,43,.08)),var(--explore-cta-background)] bg-cover bg-center bg-no-repeat py-9 max-[480px]:min-h-[330px] max-[480px]:bg-[position:63%_center]" aria-labelledby="explore-cta-title">
            <div class="mx-auto w-[min(100%_-_48px,_1112px)] max-[1079px]:w-[calc(100%_-_32px)] max-[520px]:w-[calc(100%_-_20px)]">
                <p class="m-0 text-[11px] font-bold tracking-[.16em] text-white/75">PERJALANANMU MULAI DARI SINI</p>
                <h2 id="explore-cta-title" class="mt-2.5 max-w-[560px] text-[clamp(36px,4.5vw,54px)] font-semibold leading-[.99] tracking-[-.035em] text-white [font-family:var(--font-display),Georgia,serif]">Siap Merencanakan <span class="text-[#C66A4A]">Perjalananmu</span>?</h2>
                <p class="mt-3 max-w-[470px] text-sm leading-[1.45] text-white/90">Pilih minatmu, temukan destinasi yang sesuai, dan susun rencana perjalananmu hari demi hari.</p>
                @if (\Illuminate\Support\Facades\Route::has('trips.create'))
                <a href="{{ route('trips.create') }}" class="group mt-5 inline-flex min-h-12 min-w-[220px] items-center justify-center gap-2.5 rounded-2xl border border-white/75 bg-[linear-gradient(135deg,rgba(255,255,255,.76),rgba(245,248,245,.48))] px-5 text-sm font-bold text-[#123B35] no-underline shadow-[0_10px_26px_rgba(4,26,22,.22),inset_0_1px_0_rgba(255,255,255,.96),inset_0_-1px_0_rgba(255,255,255,.32)] backdrop-blur-2xl transition duration-300 hover:-translate-y-1 hover:border-white hover:bg-[linear-gradient(135deg,rgba(255,255,255,.9),rgba(245,248,245,.62))] hover:shadow-[0_16px_32px_rgba(4,26,22,.28),inset_0_1px_0_white] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white active:scale-[.98] dark:border-white/25 dark:bg-[linear-gradient(135deg,rgba(236,245,241,.18),rgba(214,230,223,.1))] dark:text-white dark:shadow-[0_10px_26px_rgba(0,0,0,.28),inset_0_1px_0_rgba(255,255,255,.3)] dark:hover:bg-white/25 motion-reduce:transform-none motion-reduce:transition-none">Mulai Rencanakan <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 motion-reduce:transition-none" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 10h13M11 5l5 5-5 5"></path></svg></a>
                @else
                    <span class="mt-5 inline-flex min-h-12 min-w-[220px] items-center justify-center rounded-xl border border-[#D9CFC3] bg-[#FFFCF8] px-5 text-sm font-bold text-[#123B35] dark:bg-[#14211F] dark:text-[#9AC7B8]" aria-disabled="true" title="Trip Planner belum tersedia">Mulai Rencanakan</span>
                @endif
            </div>
        </section>
    </main>

    <div id="destination-detail-modal" class="fixed inset-0 z-[100] grid place-items-center p-4 max-[600px]:p-2" data-destination-modal hidden>
        <div class="absolute inset-0 bg-[#18352F]/25 backdrop-blur-lg transition-opacity duration-300 motion-reduce:transition-none" data-modal-overlay></div>
        <section class="relative z-[1] max-h-[90vh] w-full max-w-[960px] overflow-auto overscroll-contain rounded-2xl border border-white/85 bg-[linear-gradient(145deg,rgba(255,255,255,.86),rgba(250,247,242,.76))] shadow-[0_24px_64px_rgba(27,43,45,.2),inset_0_1px_0_rgba(255,255,255,.98)] backdrop-blur-2xl transition duration-300 motion-reduce:transition-none dark:border-white/20 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.9),rgba(20,33,31,.84))] dark:shadow-[0_24px_64px_rgba(0,0,0,.34),inset_0_1px_0_rgba(255,255,255,.12)] max-[760px]:max-h-[94vh]" role="dialog" aria-modal="true" aria-label="Detail destinasi" tabindex="-1">
            <button type="button" class="sticky top-3 z-[2] float-right -mb-10 mr-3 mt-3 grid h-9 w-9 place-items-center rounded-full border border-white/80 bg-white/75 text-[#123B35] shadow-md backdrop-blur-md transition duration-200 hover:rotate-90 hover:bg-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#C66A4A] motion-reduce:transition-none dark:border-white/10 dark:bg-[#14211F]/80 dark:text-[#B8DFD1] dark:hover:bg-[#263A34]" data-modal-close aria-label="Tutup detail destinasi"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"></path></svg></button>
            <div class="p-5 sm:p-6 max-[760px]:p-4" data-destination-detail-content></div>
        </section>
    </div>

    @include('user.partials.footer')
</body>
</html>



