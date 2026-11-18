@props(['currentStep' => 1, 'glass' => false])
<nav class="mx-auto mb-6 flex w-max max-w-full items-center justify-center gap-3 text-[#6F7476] {{ $glass ? 'rounded-full border border-white/75 bg-white/45 px-5 py-2.5 shadow-[0_12px_32px_rgba(31,45,54,.08),inset_0_1px_0_rgba(255,255,255,.92)] backdrop-blur-xl transition-colors duration-300 dark:border-white/15 dark:bg-white/[.06] dark:shadow-[0_12px_32px_rgba(0,0,0,.2),inset_0_1px_0_rgba(255,255,255,.1)]' : '' }} max-[720px]:gap-[7px] max-[480px]:gap-[5px] {{ $glass ? 'max-[480px]:px-3 max-[480px]:py-2' : '' }}" aria-label="Progres Trip Planner">
    @foreach ([1 => 'Trip Detail', 2 => 'Preferensi', 3 => 'Itinerary'] as $step => $label)
        @if ($step > 1)<span class="h-px w-[38px] bg-[#B9B9B3] max-[720px]:w-[22px] max-[480px]:w-3" aria-hidden="true"></span>@endif
        @php($isComplete = $step < $currentStep)
        <span class="inline-flex items-center gap-2 whitespace-nowrap text-[11px] {{ $step === $currentStep || $isComplete ? 'font-bold text-[#123B35] dark:text-[#ffffff]' : 'text-[#6F7476] dark:text-[#AEB8B4]' }} {{ $glass && $step === $currentStep ? 'rounded-full bg-white/55 px-3 py-1.5 shadow-[inset_0_1px_0_rgba(255,255,255,.85)] dark:bg-white/10' : '' }} max-[720px]:gap-[5px] max-[720px]:text-[9px] max-[480px]:text-[8px]" @if ($step === $currentStep) aria-current="step" @endif>
            <span class="grid h-[25px] w-[25px] place-items-center rounded-full border text-[10px] {{ $step <= $currentStep ? ($glass ? 'border-[#123B35] bg-[#123B35] text-white shadow-[0_2px_8px_rgba(18,59,53,.2)] dark:border-[#0B2823] dark:bg-[#0B2823]' : 'border-[#123B35] bg-[#123B35] text-white dark:border-[#0B2823] dark:bg-[#0B2823]') : 'border-[#D2D0CA] bg-[#FBF9F6] text-[#73797B] dark:border-[#4A5A55] dark:bg-[#1D2B28] dark:text-[#C5CBC8]' }} max-[720px]:h-[22px] max-[720px]:w-[22px] max-[720px]:text-[9px] max-[480px]:h-5 max-[480px]:w-5" aria-hidden="true">@if ($isComplete)<i class="fa-solid fa-check"></i>@else{{ $step }}@endif</span>
            <span>{{ $label }}</span>
        </span>
    @endforeach
</nav>
