@props(['title' => 'DenpasarTrip', 'activePage' => 'home', 'showFooter' => true, 'viewportLocked' => false, 'transparentFooter' => false, 'plannerBackdrop' => false, 'tripBackdrop' => false, 'modalLayer' => false])
<!DOCTYPE html>
<html lang="id" class="{{ $viewportLocked ? 'h-svh overflow-hidden' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>{{ $title }} | DenpasarTrip</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative isolate [min-height:100vh] [margin:0] [color:#142230] dark:[color:#F5F2EB] [background:#F7F3EC] dark:[background:#14211F] [font-family:var(--font-sans,_Arial,_sans-serif)] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]! {{ $viewportLocked ? 'h-svh overflow-hidden' : '' }}">
    @if ($tripBackdrop)
        <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden bg-[#F7F3EC] dark:bg-[#101D1B]" aria-hidden="true">
            <img class="h-full w-full object-cover object-center dark:hidden" src="{{ asset('images/trip.png') }}" alt="">
            <img class="hidden h-full w-full object-cover object-center dark:block" src="{{ asset('images/trip-dark.png') }}" alt="">
            <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(247,243,236,.36),rgba(247,243,236,.58))] dark:bg-[linear-gradient(180deg,rgba(12,24,23,.44),rgba(12,24,23,.72))]"></div>
        </div>
    @endif
    @if ($plannerBackdrop)
        <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden bg-[#F7F3EC] dark:bg-[#101D1B]" aria-hidden="true">
            <img class="h-full w-full object-contain object-center dark:hidden" src="{{ asset('images/preference.png') }}" alt="">
            <img class="hidden h-full w-full object-contain object-center dark:block" src="{{ asset('images/preference-dark.png') }}" alt="">
            <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(247,243,236,.30),rgba(247,243,236,.55))] dark:bg-[linear-gradient(180deg,rgba(12,24,23,.38),rgba(12,24,23,.68))]"></div>
        </div>
    @endif
    @include('user.partials.navbar', ['activePage' => $activePage])
    <main class="relative z-10 {{ $viewportLocked ? 'h-svh overflow-hidden overscroll-none max-[720px]:overflow-y-auto' : '' }}" @if ($modalLayer) data-modal-layer-root @endif>{{ $slot }}</main>
    @if ($showFooter)
        @include('user.partials.footer', ['transparent' => $transparentFooter])
    @endif
</body>
</html>
