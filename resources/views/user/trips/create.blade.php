<x-user.layout title="Rencanakan Trip" active-page="trip-planner" :show-footer="false" :viewport-locked="true">
    <section class="relative isolate box-border grid h-svh min-h-svh grid-cols-[minmax(0,1.08fr)_minmax(440px,.92fr)] items-center overflow-hidden bg-[#F7F3EC] px-[max(6vw,32px)] pb-6 pt-[92px] text-[#142230] dark:bg-[#14211F] dark:text-[#F5F2EB] max-[980px]:grid-cols-[minmax(0,.7fr)_minmax(400px,1fr)] max-[980px]:px-7 max-[720px]:h-auto max-[720px]:min-h-svh max-[720px]:grid-cols-1 max-[720px]:items-start max-[720px]:overflow-visible max-[720px]:px-5 max-[720px]:pb-[28px] max-[720px]:pt-[96px] max-[480px]:px-[14px]" aria-labelledby="trip-planner-title" data-trip-step-view>
        <div class="absolute inset-0 z-0 overflow-hidden" role="img" aria-label="Pemandangan Denpasar">
            <img src="{{ asset('images/login.png') }}" alt="" class="absolute inset-0 h-full w-full object-cover object-[center_48%]">
            <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(10,36,34,.03)_0%,rgba(10,36,34,.02)_39%,rgba(247,243,236,.22)_58%,rgba(247,243,236,.94)_100%)] dark:bg-[linear-gradient(90deg,rgba(10,36,34,.15)_0%,rgba(10,36,34,.24)_39%,rgba(20,33,31,.62)_58%,rgba(20,33,31,.97)_100%)] max-[720px]:bg-[linear-gradient(90deg,rgba(247,243,236,.8),rgba(247,243,236,.94))] dark:max-[720px]:bg-[linear-gradient(90deg,rgba(20,33,31,.82),rgba(20,33,31,.96))]"></div>
        </div>
        <div class="relative z-10 col-start-2 w-[min(100%,560px)] justify-self-end max-[720px]:col-start-1 max-[720px]:w-[min(100%,540px)] max-[720px]:justify-self-center">
            @include('user.trips.partials.stepper', ['currentStep' => 1, 'glass' => true])
            <div class="mb-[18px]">
                <h1 id="trip-planner-title" class="m-0 font-display text-[clamp(34px,3.5vw,54px)] font-semibold leading-[1.08] tracking-[-.035em] text-[#142230] dark:text-[#F5F2EB]">Rencanakan Perjalananmu<br>ke <span class="text-[#C66A4A]">Denpasar</span></h1>
                <p class="mb-0 mt-2 max-w-[430px] text-[13px] leading-[1.5] text-[#59646B] dark:text-[#C5CBC8]">Temukan tempat terbaik dan susun rencana perjalananmu sendiri di Denpasar, Bali.</p>
            </div>
            <form class="grid gap-[13px] rounded-[18px] border border-white/75 bg-[linear-gradient(145deg,rgba(255,252,248,.88),rgba(255,248,239,.72))] p-[22px] shadow-[0_18px_48px_rgba(24,38,39,.15),inset_0_1px_0_rgba(255,255,255,.94)] backdrop-blur-2xl dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.88),rgba(20,33,31,.8))] dark:shadow-[0_20px_48px_rgba(0,0,0,.26),inset_0_1px_0_rgba(255,255,255,.08)] max-[620px]:px-[14px] max-[620px]:py-[18px]" method="POST" action="{{ isset($trip) ? route('trips.update', $trip) : route('trips.store') }}" novalidate data-trip-step-form>
                @csrf @if (isset($trip)) @method('PUT') @endif
                <div>
                    <h2 class="m-0 font-display text-[21px] font-semibold leading-tight text-[#142230] dark:text-[#F5F2EB]">Beri Nama Trip-mu</h2>
                    <p class="mb-0 mt-1 text-[12px] text-[#747879] dark:text-[#C5CBC8]">Tentukan nama untuk rencana perjalananmu.</p>
                </div>
                @if ($errors->any())<div class="rounded-lg border border-[#E5C4B9] bg-[#FFF2EE] px-3 py-2.5 text-xs text-[#913E2D] dark:border-[#713F35] dark:bg-[#3A2825] dark:text-[#F2B7A5]" role="alert">{{ $errors->first() }}</div>@endif
                <label class="grid gap-[5px] text-[11px] font-bold text-[#28333A] dark:text-[#E4E8E5]"><span>Nama Trip</span><input class="min-w-0 rounded-[10px] border border-[#D9D0C7] bg-white px-4 py-3 text-sm font-medium text-[#142230] outline-none transition focus:border-[#1B665D] focus:ring-2 focus:ring-[#1B665D]/15 dark:border-[#40504B] dark:bg-[#1D2B28] dark:text-[#F5F2EB]" type="text" name="trip_name" value="{{ old('trip_name', $trip->trip_name ?? '') }}" maxlength="255" required placeholder="Contoh: First Trip to Denpasar" data-trip-name>@error('trip_name')<small class="font-normal text-red-700 dark:text-red-300">{{ $message }}</small>@enderror<span class="hidden rounded-lg border border-[#E8C5BB] bg-[#FFF3EF] px-3 py-2 text-[11px] font-medium text-[#9B4637] dark:border-[#713F35] dark:bg-[#3A2825] dark:text-[#F2B7A5]" data-trip-name-error role="alert"></span></label>
                <div class="grid grid-cols-2 gap-3 max-[520px]:grid-cols-1" data-trip-date-range>
                    @include('user.trips.partials.date-picker', ['field' => 'start'])
                    @include('user.trips.partials.date-picker', ['field' => 'end'])
                    <p class="col-span-2 hidden rounded-md border border-[#E5C4B9] bg-[#FFF2EE] px-2.5 py-2 text-[11px] font-medium text-[#913E2D] dark:border-[#713F35] dark:bg-[#3A2825] dark:text-[#F2B7A5] max-[520px]:col-span-1" data-range-error role="alert"></p>
                </div>
                <button class="group mt-1 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-white/40 bg-[linear-gradient(145deg,rgba(20,78,66,.94),rgba(12,55,48,.86))] px-[18px] text-xs font-bold text-white shadow-[0_10px_24px_rgba(18,59,53,.2),inset_0_1px_0_rgba(255,255,255,.32)] backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:bg-[linear-gradient(145deg,rgba(27,94,79,.96),rgba(15,65,56,.9))] hover:shadow-[0_14px_28px_rgba(18,59,53,.26),inset_0_1px_0_rgba(255,255,255,.42)] active:translate-y-0 active:scale-[.99] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#C66A4A] dark:border-white/15 dark:bg-[linear-gradient(145deg,rgba(43,112,93,.95),rgba(19,76,65,.9))] dark:hover:bg-[linear-gradient(145deg,rgba(52,128,105,.96),rgba(24,88,74,.94))] motion-reduce:transition-none" type="submit">Lanjut <i class="fa-solid fa-arrow-right transition-transform duration-300 group-hover:translate-x-1 motion-reduce:transition-none" aria-hidden="true"></i></button>
            </form>
        </div>
    </section>
</x-user.layout>
