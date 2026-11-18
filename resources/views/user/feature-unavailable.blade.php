<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $feature }} | DenpasarTrip</title>
    @vite(['resources/css/app.css'])
</head>
<body class="[min-height:100vh] [margin:0] [color:#142230] dark:[color:#F5F2EB] [background:#F7F3EC] dark:[background:#14211F] [font-family:var(--font-sans,_Arial,_sans-serif)] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
    @include('user.partials.navbar', ['activePage' => ''])
    <main class="[width:min(calc(100%_-_40px),_1120px)] [margin:70px_auto] [padding:30px] [border:1px_solid_#EEE8DF] [border-radius:14px] [background:#FFFEFC] [text-align:center] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
        <h1>{{ $feature }}</h1>
        <p>{{ $feature }} belum tersedia.</p>
        <a href="{{ route('user.dashboard') }}">Kembali ke Home</a>
    </main>
    @include('user.partials.footer')
</body>
</html>
