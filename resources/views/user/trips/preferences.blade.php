<x-user.layout title="Preferensi Trip" active-page="trip-planner" :show-footer="false" :viewport-locked="true">
    @php
        $categoryPresentation = [
            'Nature' => ['image' => 'sanur.webp', 'icon' => 'fa-leaf', 'description' => 'Pantai, taman, dan mangrove.'],
            'Culture' => ['image' => 'bajra.jpe', 'icon' => 'fa-landmark', 'description' => 'Pura, situs bersejarah, dan budaya lokal.'],
            'Art' => ['image' => 'museum.jpg', 'icon' => 'fa-building-columns', 'description' => 'Museum, galeri, dan seni budaya.'],
            'Culinary' => ['image' => 'pasar.jpg', 'icon' => 'fa-store', 'description' => 'Makanan lokal dan kuliner tradisional.'],
            'Shopping' => ['image' => 'living.jpe', 'icon' => 'fa-bag-shopping', 'description' => 'Pasar tradisional, produk lokal, dan mal.'],
        ];
        $checkedCategories = old('categories', $selectedCategoryIds);
    @endphp
    <section class="relative isolate box-border flex h-svh w-full flex-col justify-center pb-3 pt-[82px] text-[#142230] dark:text-[#F5F2EB] max-[720px]:h-auto max-[720px]:min-h-svh max-[720px]:justify-start max-[720px]:pb-5 max-[720px]:pt-[88px]" aria-labelledby="trip-preferences-title" data-trip-step-view>
        <img class="pointer-events-none absolute inset-0 -z-20 h-full w-full bg-[#F7F3EC] object-contain object-center dark:hidden" src="{{ asset('images/preference.png') }}" alt="" aria-hidden="true">
        <img class="pointer-events-none absolute inset-0 -z-20 hidden h-full w-full bg-[#101D1B] object-contain object-center dark:block" src="{{ asset('images/preference-dark.png') }}" alt="" aria-hidden="true">
        <div class="pointer-events-none absolute inset-0 -z-10 bg-[linear-gradient(180deg,rgba(247,243,236,.32),rgba(247,243,236,.66))] dark:bg-[linear-gradient(180deg,rgba(12,24,23,.42),rgba(12,24,23,.72))]" aria-hidden="true"></div>
        <div class="relative z-10 mx-auto flex h-full w-[min(100%_-_48px,_1112px)] flex-col justify-center max-[1079px]:w-[calc(100%_-_32px)] max-[720px]:h-auto max-[720px]:w-[calc(100%_-_32px)] max-[720px]:justify-start max-[520px]:w-[calc(100%_-_20px)]">
        <div class="-translate-y-8 max-[720px]:translate-y-0">
            @include('user.trips.partials.stepper', ['currentStep' => 2, 'glass' => true])
        </div>
        <form class="mx-auto w-full rounded-[24px] border border-white/70 bg-[linear-gradient(145deg,rgba(255,255,255,.64),rgba(255,252,248,.42))] px-6 pb-4 pt-4 text-left shadow-[0_18px_44px_rgba(31,45,54,.1),inset_0_1px_0_rgba(255,255,255,.92)] backdrop-blur-xl dark:border-white/20 dark:bg-[linear-gradient(145deg,rgba(18,31,32,.68),rgba(18,31,32,.52))] dark:shadow-[0_24px_64px_rgba(0,0,0,.24),inset_0_1px_0_rgba(255,255,255,.1)] max-[720px]:px-4 max-[720px]:pb-4 max-[720px]:pt-4 max-[720px]:rounded-[20px] max-[480px]:px-3" method="POST" action="{{ route('trips.preferences.update', $trip) }}" data-trip-step-form>
            @csrf
            @method('PUT')
            <h1 id="trip-preferences-title" class="text-center m-0 font-display text-[clamp(27px,3vw,38px)] font-semibold leading-tight tracking-[-.035em] text-[#142230] dark:text-[#F5F2EB]">Apa yang kamu <span class="text-[#B95737] dark:text-[#E99574]">minati</span>?</h1>
            <p class="text-center mx-auto mb-6 mt-1.5 max-w-3xl text-[12px] leading-relaxed text-[#62696D] dark:text-[#D1D9D5]">Pilih satu atau beberapa kategori untuk menemukan destinasi yang sesuai dengan gaya liburanmu.</p>
            @error('categories')<div class="mb-4 rounded-lg border border-[#E5C4B9] bg-[#FFF2EE] px-3 py-2.5 text-left text-xs text-[#913E2D] dark:border-[#713F35] dark:bg-[#3A2825] dark:text-[#F2B7A5]" role="alert">{{ $message }}</div>@enderror
            <div class="grid grid-cols-5 gap-3 text-left max-[1050px]:grid-cols-3 max-[720px]:grid-cols-2 max-[720px]:gap-2.5 max-[420px]:grid-cols-1">
                @foreach ($categories as $category)
                    @php($presentation = $categoryPresentation[$category->name] ?? null)
                    @if ($presentation)
                        <label class="group relative flex min-h-[218px] min-w-0 cursor-pointer flex-col overflow-hidden rounded-[18px] border border-white/80 bg-[linear-gradient(145deg,rgba(255,255,255,.76),rgba(255,252,248,.52))] shadow-[0_10px_26px_rgba(25,38,41,.09),inset_0_1px_0_rgba(255,255,255,.95)] backdrop-blur-lg transition-[transform,box-shadow,border-color,background-color] duration-300 hover:-translate-y-1 hover:shadow-[0_16px_30px_rgba(25,38,41,.14)] has-[:checked]:border-[#5B9D8D] has-[:checked]:bg-[linear-gradient(145deg,rgba(227,244,237,.88),rgba(239,249,244,.72))] has-[:checked]:shadow-[0_12px_28px_rgba(31,92,77,.14),inset_0_1px_0_rgba(255,255,255,.92)] has-[:checked]:ring-1 has-[:checked]:ring-[#5B9D8D]/40 has-[:focus-visible]:outline has-[:focus-visible]:outline-2 has-[:focus-visible]:outline-offset-2 has-[:focus-visible]:outline-[#C66A4A] dark:border-white/15 dark:bg-[linear-gradient(145deg,rgba(32,51,49,.8),rgba(20,34,33,.72))] dark:has-[:checked]:border-[#6DB6A2] dark:has-[:checked]:bg-[linear-gradient(145deg,rgba(35,79,68,.82),rgba(20,48,42,.76))] dark:has-[:checked]:shadow-[0_12px_28px_rgba(0,0,0,.28),inset_0_1px_0_rgba(255,255,255,.12)] max-[720px]:last:col-span-2 max-[720px]:last:w-1/2 max-[720px]:last:justify-self-center max-[420px]:last:col-span-1 max-[420px]:last:w-full max-[420px]:last:justify-self-stretch max-[420px]:min-h-[200px]">
                            <input class="sr-only" type="checkbox" name="categories[]" value="{{ $category->id }}" @checked(in_array($category->id, $checkedCategories))>
                            <span class="block h-[108px] shrink-0 overflow-hidden bg-[#EEEAE3] max-[720px]:h-[100px] max-[420px]:h-[120px]"><img class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04] motion-reduce:transition-none" src="{{ asset('images/' . $presentation['image']) }}" alt="{{ $category->name }} di Denpasar" loading="lazy"></span>
                            <span class="absolute left-3 top-[92px] z-[1] grid h-9 w-9 place-items-center rounded-full border-[3px] border-white bg-[#F7E7D3] text-sm text-[#17483F] shadow-[0_3px_10px_rgba(20,34,48,.12)] dark:border-[#213432] dark:bg-[#DDECE4] dark:text-[#123B35]"><i class="fa-solid {{ $presentation['icon'] }}" aria-hidden="true"></i></span>
                            <span class="grid flex-1 content-start gap-1 px-3 pb-3 pt-7"><strong class="text-sm font-bold text-[#142230] dark:text-[#F5F2EB]">{{ $category->name }}</strong><small class="text-[11px] leading-[1.35] text-[#62696D] dark:text-[#D1D9D5]">{{ $presentation['description'] }}</small></span>
                        </label>
                    @endif
                @endforeach
            </div>
            @error('categories.*')<div class="mt-3 rounded-lg border border-[#E5C4B9] bg-[#FFF2EE] px-3 py-2.5 text-left text-xs text-[#913E2D] dark:border-[#713F35] dark:bg-[#3A2825] dark:text-[#F2B7A5]" role="alert">{{ $message }}</div>@enderror
            <div class="mt-6 flex justify-center gap-3 max-[480px]:gap-2">
                <a class="inline-flex min-h-[44px] min-w-[180px] items-center justify-center gap-2.5 rounded-full border border-[#6B9C8F] bg-white/35 px-5 text-[13px] font-bold text-[#17483F] shadow-[inset_0_1px_0_rgba(255,255,255,.85)] backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:bg-white/55 hover:shadow-[0_9px_22px_rgba(23,72,63,.12)] active:scale-[.98] dark:border-[#75AA9C]/70 dark:bg-white/[.06] dark:text-[#D9EEE5] dark:hover:bg-white/10 max-[480px]:min-w-0 max-[480px]:flex-1" href="{{ route('trips.edit', $trip) }}" data-trip-step-link><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                <button class="inline-flex min-h-[44px] min-w-[180px] items-center justify-center gap-2.5 rounded-full border border-white/60 bg-[linear-gradient(145deg,rgba(20,78,66,.96),rgba(12,55,48,.94))] px-5 text-[13px] font-bold text-white shadow-[0_12px_26px_rgba(18,59,53,.22),inset_0_1px_0_rgba(255,255,255,.28)] transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_16px_30px_rgba(18,59,53,.28)] active:scale-[.98] dark:border-white/15 dark:bg-[linear-gradient(145deg,rgba(43,112,93,.95),rgba(19,76,65,.96))] max-[480px]:min-w-0 max-[480px]:flex-1" type="submit">Selanjutnya <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </form>
        </div>
    </section>
</x-user.layout>
