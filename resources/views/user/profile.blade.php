<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Profile | DenpasarTrip</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/profile.js'])
</head>
<body class="[min-height:100vh] [margin:0] [color:#142230] dark:[color:#F5F2EB] [background:#F7F3EC] dark:[background:#14211F] [font-family:var(--font-sans,_Arial,_sans-serif)] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
    @include('user.partials.navbar', ['activePage' => 'profile'])

    <main>
        <section class="[position:relative] [min-height:290px] [display:flex] [align-items:flex-end] [box-sizing:border-box] [overflow:hidden] [padding:32px_24px_38px] [background:#F7F3EC] before:[position:absolute] before:[z-index:1] before:[inset:0] before:[background:linear-gradient(90deg,_rgba(247,243,236,.46),_rgba(247,243,236,.04)_76%),linear-gradient(0deg,_#F7F3EC_0%,_rgba(247,243,236,.68)_17%,_rgba(247,243,236,0)_60%)] dark:before:[background:linear-gradient(90deg,_rgba(20,33,31,.42),_rgba(20,33,31,.04)_76%),linear-gradient(0deg,_#14211F_0%,_rgba(20,33,31,.72)_17%,_rgba(20,33,31,0)_60%)] before:[content:""] before:[pointer-events:none] max-[760px]:[min-height:310px] max-[760px]:[padding:30px_20px_38px] max-[480px]:[min-height:350px] max-[480px]:[padding-inline:14px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-labelledby="profile-name">
            <img class="[position:absolute] [inset:0] [width:100%] [height:100%] [object-fit:cover] [object-position:center_45%] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" src="{{ asset('images/explore.png') }}" alt="" aria-hidden="true" fetchpriority="high">
            <div class="[position:relative] [z-index:2] [width:min(100%,_1120px)] [display:flex] [align-items:center] [justify-content:space-between] [gap:24px] [margin:0_auto] max-[760px]:[align-items:flex-end] max-[760px]:[flex-wrap:wrap] max-[760px]:[gap:15px] max-[480px]:[align-items:center] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <div class="[display:flex] [align-items:center] [gap:16px] [min-width:0] max-[480px]:[gap:10px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                    <div class="[width:88px] [height:88px] [flex:none] [display:grid] [place-items:center] [border:3px_solid_#fff] [border-radius:50%] [background:#C66A4A] [box-shadow:0_2px_12px_rgba(20,34,48,.14)] [color:#fff] [font-size:27px] [font-weight:700] max-[760px]:[width:68px] max-[760px]:[height:68px] max-[760px]:[font-size:22px] max-[480px]:[width:60px] max-[480px]:[height:60px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-label="Avatar {{ $user->name }}">
                        {{ collect(explode(' ', trim($user->name)))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('') }}
                    </div>
                    <div class="[min-width:0] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <h1 id="profile-name" class="[margin:0_0_3px] [color:#142230] dark:[color:#F5F2EB] [font-family:var(--font-display,_Georgia,_serif)] [font-size:clamp(24px,3vw,34px)] [font-weight:700] [line-height:1.08] [letter-spacing:-.025em]">{{ $user->name }}</h1>
                        <p class="[max-width:100%] [margin:0] [overflow-wrap:anywhere] [color:#293640] dark:[color:#E6EAE7] [font-size:13px] [font-weight:600] [text-decoration:underline] [text-underline-offset:3px] max-[480px]:[font-size:11px]">{{ $user->email }}</p>
                        <p class="[margin:7px_0_0] [color:#50595F] dark:[color:#F1F1EC] [font-family:var(--font-display,_Georgia,_serif)] [font-size:11px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">Bergabung Sejak {{ $user->created_at?->locale('id')->translatedFormat('j F Y') ?? '—' }}</p>
                    </div>
                </div>

                <div class="[display:flex] [min-width:180px] [padding:12px_4px] [border:1px_solid_rgba(255,255,255,.72)] dark:[border-color:rgba(255,255,255,.14)] [border-radius:15px] [background:rgba(255,255,255,.70)] dark:[background:rgba(20,33,31,.72)] [backdrop-filter:blur(18px)] [box-shadow:0_10px_28px_rgba(27,42,49,.12),inset_0_1px_0_rgba(255,255,255,.82)] max-[760px]:[margin-left:auto] max-[480px]:[width:100%] max-[480px]:[justify-content:center] max-[480px]:[margin:0]" aria-label="Statistik akun">
                    <div class="[min-width:82px] [display:grid] [justify-items:center] [gap:3px] [padding:0_14px] [.profile-stat_&]:[border-left:1px_solid_#E3DED8] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <i class="fa-solid fa-star [color:#D9AE00] [font-size:18px]" aria-hidden="true"></i>
                        <strong class="[color:#142230] dark:[color:#F5F2EB] [font-size:22px] [line-height:1.1]">{{ $user->reviews_count }}</strong>
                        <span class="[color:#687078] dark:[color:#C5CBC8] [font-size:11px]">Ulasan</span>
                    </div>
                    <div class="[min-width:82px] [display:grid] [justify-items:center] [gap:3px] [padding:0_14px] [.profile-stat_&]:[border-left:1px_solid_#E3DED8] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <i class="fa-regular fa-map [color:#173A36] dark:[color:#E4ECE8] [font-size:18px]" aria-hidden="true"></i>
                        <strong class="[color:#142230] dark:[color:#F5F2EB] [font-size:22px] [line-height:1.1]">{{ $user->trips_count }}</strong>
                        <span class="[color:#687078] dark:[color:#C5CBC8] [font-size:11px]">Trip Dibuat</span>
                    </div>
                </div>
            </div>
        </section>

        <div class="[width:min(calc(100%_-_40px),_1120px)] [margin:0_auto] [padding:5px_0_42px] max-[760px]:[width:calc(100%_-_28px)] max-[480px]:[width:calc(100%_-_24px)] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
            @if (session('success'))
                <p class="[margin:0_0_14px] [padding:11px_14px] [border-radius:9px] [font-size:13px] [border:1px_solid_#B7D7C6] [background:#EEF7F0] [color:#18523E] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" role="status">{{ session('success') }}</p>
            @endif
            @if ($errors->any())
                <div class="[margin:0_0_14px] [padding:11px_14px] [border-radius:9px] [font-size:13px] [border:1px_solid_#E4B9AF] [background:#FFF1ED] [color:#8C3426] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" role="alert">
                    <p>Profil belum dapat disimpan. Periksa kembali informasi yang dimasukkan.</p>
                </div>
            @endif

            <div class="[display:grid] [grid-template-columns:minmax(280px,_.72fr)_minmax(0,_1.28fr)] [align-items:stretch] [gap:28px] max-[760px]:[grid-template-columns:1fr] max-[760px]:[gap:16px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                <section class="[min-width:0] [padding:18px_20px] [border:1px_solid_#EEE8DF] [border-radius:15px] [border:1px_solid_rgba(255,255,255,.78)] [background:linear-gradient(145deg,rgba(255,255,255,.84),rgba(255,252,248,.68))] [box-shadow:0_12px_30px_rgba(31,45,54,.07),inset_0_1px_0_rgba(255,255,255,.92)] [backdrop-filter:blur(16px)] dark:[border-color:rgba(255,255,255,.1)] dark:[background:linear-gradient(145deg,rgba(35,52,48,.82),rgba(20,33,31,.7))] max-[480px]:[padding:16px_14px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-labelledby="profile-information-title">
                    <div class="[display:flex] [align-items:center] [gap:10px] [margin-bottom:15px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <span class="[width:34px] [height:34px] [flex:none] [display:grid] [place-items:center] [border-radius:8px] [background:#E9E9E8] [color:#202729] [font-size:15px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"><i class="fa-solid fa-user motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i></span>
                        <div>
                            <h2 class="[margin:0] [color:#142230] dark:[color:#F5F2EB] [font-size:15px] [font-weight:700] [line-height:1.25]" id="profile-information-title">Informasi Profil</h2>
                            <p class="[margin:2px_0_0] [color:#70777A] dark:[color:#BFC8C3] [font-size:11px]">Kelola informasi akun Anda di sini.</p>
                        </div>
                    </div>

                    <form class="[display:grid] [gap:12px]" id="profile-update-form" method="POST" action="{{ route('profile.update') }}" data-profile-form>
                        @csrf
                        @method('PUT')

                        <label class="[display:grid] [gap:5px] [color:#293640] dark:[color:#E7ECE9] [font-size:11px] [font-weight:700]">
                            <span>Nama Lengkap</span>
                            <input class="[width:100%] [min-height:40px] [box-sizing:border-box] [padding:9px_11px] [border:1px_solid_rgba(192,177,159,.62)] [border-radius:9px] [background:rgba(255,255,255,.58)] dark:[background:rgba(12,25,23,.52)] [color:#142230] dark:[color:#F5F2EB] [font:inherit] [font-size:13px] [outline:none] [transition:background-color_.2s,border-color_.2s,box-shadow_.2s] focus:[border-color:#1C6A61] focus:[box-shadow:0_0_0_3px_rgba(28,106,97,.12)] read-only:[pointer-events:none] read-only:[cursor:default] aria-invalid:[border-color:#C94C3B]" type="text" name="name" value="{{ old('name', $user->name) }}" data-saved-value="{{ $user->name }}" maxlength="255" readonly tabindex="-1" required autocomplete="name" @error('name') aria-invalid="true" @enderror>
                            @error('name') <small class="[color:#A53227] dark:[color:#FF9C8F] [font-size:11px]">{{ $message }}</small> @enderror
                        </label>

                        <label class="[display:grid] [gap:5px] [color:#293640] dark:[color:#E7ECE9] [font-size:11px] [font-weight:700]">
                            <span>Email</span>
                            <input class="[width:100%] [min-height:40px] [box-sizing:border-box] [padding:9px_11px] [border:1px_solid_rgba(192,177,159,.62)] [border-radius:9px] [background:rgba(255,255,255,.58)] dark:[background:rgba(12,25,23,.52)] [color:#142230] dark:[color:#F5F2EB] [font:inherit] [font-size:13px] [outline:none] [transition:background-color_.2s,border-color_.2s,box-shadow_.2s] focus:[border-color:#1C6A61] focus:[box-shadow:0_0_0_3px_rgba(28,106,97,.12)] read-only:[pointer-events:none] read-only:[cursor:default] aria-invalid:[border-color:#C94C3B]" type="email" name="email" value="{{ old('email', $user->email) }}" data-saved-value="{{ $user->email }}" maxlength="255" readonly tabindex="-1" required autocomplete="email" @error('email') aria-invalid="true" @enderror>
                            @error('email') <small class="[color:#A53227] dark:[color:#FF9C8F] [font-size:11px]">{{ $message }}</small> @enderror
                        </label>

                        <label class="[display:grid] [gap:5px] [color:#293640] dark:[color:#E7ECE9] [font-size:11px] [font-weight:700]" data-password-display>
                            <span>Password</span>
                            <input class="[width:100%] [min-height:40px] [box-sizing:border-box] [padding:9px_11px] [border:1px_solid_rgba(192,177,159,.62)] [border-radius:9px] [background:rgba(255,255,255,.58)] dark:[background:rgba(12,25,23,.52)] [color:#687078] dark:[color:#C5CBC8] [font:inherit] [font-size:13px]" type="password" value="••••••••••••" readonly aria-label="Password tersimpan dalam bentuk tersembunyi">
                        </label>

                        <div class="[gap:10px]" data-password-fields hidden>
                            <label class="[display:grid] [gap:5px] [color:#293640] dark:[color:#E7ECE9] [font-size:11px] [font-weight:700]">
                                <span>Password Saat Ini</span>
                                <input class="[width:100%] [min-height:40px] [box-sizing:border-box] [padding:9px_11px] [border:1px_solid_rgba(192,177,159,.62)] [border-radius:9px] [background:rgba(255,255,255,.58)] dark:[background:rgba(12,25,23,.52)] [color:#142230] dark:[color:#F5F2EB] [font:inherit] [font-size:13px] [outline:none] focus:[border-color:#1C6A61] aria-invalid:[border-color:#C94C3B]" type="password" name="current_password" autocomplete="current-password" placeholder="Diperlukan jika mengganti password" @error('current_password') aria-invalid="true" @enderror>
                                @error('current_password') <small class="[color:#A53227] dark:[color:#FF9C8F] [font-size:11px]">{{ $message }}</small> @enderror
                            </label>
                            <label class="[display:grid] [gap:5px] [color:#293640] dark:[color:#E7ECE9] [font-size:11px] [font-weight:700]">
                                <span>Password Baru</span>
                                <input class="[width:100%] [min-height:40px] [box-sizing:border-box] [padding:9px_11px] [border:1px_solid_rgba(192,177,159,.62)] [border-radius:9px] [background:rgba(255,255,255,.58)] dark:[background:rgba(12,25,23,.52)] [color:#142230] dark:[color:#F5F2EB] [font:inherit] [font-size:13px] [outline:none] focus:[border-color:#1C6A61] aria-invalid:[border-color:#C94C3B]" type="password" name="new_password" autocomplete="new-password" placeholder="Kosongkan jika tidak ingin mengganti password" @error('new_password') aria-invalid="true" @enderror>
                                @error('new_password') <small class="[color:#A53227] dark:[color:#FF9C8F] [font-size:11px]">{{ $message }}</small> @enderror
                            </label>
                            <label class="[display:grid] [gap:5px] [color:#293640] dark:[color:#E7ECE9] [font-size:11px] [font-weight:700]">
                                <span>Konfirmasi Password Baru</span>
                                <input class="[width:100%] [min-height:40px] [box-sizing:border-box] [padding:9px_11px] [border:1px_solid_rgba(192,177,159,.62)] [border-radius:9px] [background:rgba(255,255,255,.58)] dark:[background:rgba(12,25,23,.52)] [color:#142230] dark:[color:#F5F2EB] [font:inherit] [font-size:13px] [outline:none] focus:[border-color:#1C6A61] aria-invalid:[border-color:#C94C3B]" type="password" name="new_password_confirmation" autocomplete="new-password" placeholder="Ulangi password baru" @error('new_password_confirmation') aria-invalid="true" @enderror>
                                @error('new_password_confirmation') <small class="[color:#A53227] dark:[color:#FF9C8F] [font-size:11px]">{{ $message }}</small> @enderror
                            </label>
                        </div>

                        <p class="[margin:-3px_0_0] [color:#687078] dark:[color:#C5CBC8] [font-size:10px]" data-password-note hidden>Kosongkan password baru jika tidak ingin menggantinya.</p>
                    </form>
                    <div class="[display:flex] [justify-content:flex-end] [gap:9px] [margin-top:15px] max-[480px]:[flex-wrap:wrap] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="[position:relative] [isolation:isolate] [overflow:hidden] [min-height:42px] [display:inline-flex] [align-items:center] [justify-content:center] [gap:8px] [padding:0_17px] [border:1px_solid_rgba(255,255,255,.82)] [border-radius:12px] [font-family:var(--font-sans,_Arial,_sans-serif)] [font-size:13px] [font-weight:700] [letter-spacing:.01em] [cursor:pointer] [background:linear-gradient(145deg,rgba(255,255,255,.58),rgba(255,239,235,.32))] dark:[background:linear-gradient(145deg,rgba(255,255,255,.1),rgba(150,57,49,.2))] [backdrop-filter:blur(18px)_saturate(145%)] [box-shadow:0_7px_20px_rgba(145,60,50,.12),inset_0_1px_0_rgba(255,255,255,.95),inset_0_-1px_0_rgba(163,61,50,.08)] [color:#A33D32] dark:[color:#FFC0B5] hover:[background:linear-gradient(145deg,rgba(255,255,255,.76),rgba(252,225,219,.52))] dark:hover:[background:linear-gradient(145deg,rgba(255,255,255,.15),rgba(150,57,49,.32))] hover:[transform:translateY(-1px)] hover:[box-shadow:0_10px_24px_rgba(145,60,50,.16),inset_0_1px_0_rgba(255,255,255,1)] active:[transform:scale(.97)] [transition:all_.22s_ease] motion-reduce:transition-none" type="submit"><i class="fa-solid fa-right-from-bracket [font-size:13px]" aria-hidden="true"></i> Keluar</button>
                        </form>
                        <button class="[position:relative] [isolation:isolate] [overflow:hidden] [min-height:42px] [display:inline-flex] [align-items:center] [justify-content:center] [gap:7px] [padding:0_20px] [border:1px_solid_rgba(255,255,255,.72)] [border-radius:12px] [font-family:var(--font-sans,_Arial,_sans-serif)] [font-size:14px] [font-weight:700] [letter-spacing:.01em] [cursor:pointer] [background:linear-gradient(145deg,rgba(26,111,96,.82),rgba(14,73,66,.68))] dark:[background:linear-gradient(145deg,rgba(56,119,107,.7),rgba(14,73,66,.8))] [backdrop-filter:blur(18px)_saturate(145%)] [box-shadow:0_8px_22px_rgba(14,73,66,.18),inset_0_1px_0_rgba(255,255,255,.58),inset_0_-1px_0_rgba(4,52,46,.14)] [color:#fff] hover:[background:linear-gradient(145deg,rgba(36,132,114,.9),rgba(14,73,66,.78))] hover:[transform:translateY(-1px)] hover:[box-shadow:0_11px_25px_rgba(14,73,66,.22),inset_0_1px_0_rgba(255,255,255,.72)] active:[transform:scale(.97)] [transition:all_.22s_ease] motion-reduce:transition-none" type="button" data-profile-edit aria-pressed="false">Edit</button>
                        <button class="hidden [min-height:38px] [display:inline-flex] [align-items:center] [justify-content:center] [gap:7px] [padding:0_15px] [border:1px_solid_rgba(255,255,255,.82)] [border-radius:10px] [font:inherit] [font-size:12px] [font-weight:700] [cursor:pointer] [background:linear-gradient(145deg,rgba(255,255,255,.62),rgba(247,243,236,.4))] dark:[background:linear-gradient(145deg,rgba(255,255,255,.1),rgba(255,255,255,.04))] [backdrop-filter:blur(16px)_saturate(140%)] [box-shadow:0_5px_15px_rgba(31,45,54,.08),inset_0_1px_0_rgba(255,255,255,.92)] [color:#14544D] dark:[color:#E5F0EB] hover:[background:linear-gradient(145deg,rgba(255,255,255,.82),rgba(247,243,236,.6))] dark:hover:[background:rgba(255,255,255,.14)] hover:[transform:translateY(-1px)] active:[transform:scale(.97)] [transition:all_.2s_ease] motion-reduce:transition-none" type="button" data-profile-cancel hidden>Batal</button>
                        <button class="hidden [min-height:38px] [display:inline-flex] [align-items:center] [justify-content:center] [gap:7px] [padding:0_15px] [border:1px_solid_rgba(255,255,255,.62)] [border-radius:10px] [font:inherit] [font-size:12px] [font-weight:700] [cursor:pointer] [background:linear-gradient(145deg,rgba(26,111,96,.82),rgba(14,73,66,.72))] dark:[background:linear-gradient(145deg,rgba(56,119,107,.72),rgba(14,73,66,.84))] [backdrop-filter:blur(18px)_saturate(145%)] [box-shadow:0_7px_18px_rgba(14,73,66,.18),inset_0_1px_0_rgba(255,255,255,.5)] [color:#fff] hover:[background:linear-gradient(145deg,rgba(36,132,114,.92),rgba(14,73,66,.82))] hover:[transform:translateY(-1px)] active:[transform:scale(.97)] [transition:all_.2s_ease] motion-reduce:transition-none disabled:[cursor:wait] disabled:[opacity:.65]" type="submit" form="profile-update-form" data-profile-save hidden>Simpan</button>
                    </div>
                </section>

                <section class="[min-width:0] [padding:18px_20px] [border:1px_solid_#EEE8DF] [border-radius:15px] [border:1px_solid_rgba(255,255,255,.78)] [background:linear-gradient(145deg,rgba(255,255,255,.84),rgba(255,252,248,.68))] [box-shadow:0_12px_30px_rgba(31,45,54,.07),inset_0_1px_0_rgba(255,255,255,.92)] [backdrop-filter:blur(16px)] dark:[border-color:rgba(255,255,255,.1)] dark:[background:linear-gradient(145deg,rgba(35,52,48,.82),rgba(20,33,31,.7))] [display:flex] [flex-direction:column] max-[480px]:[padding:16px_14px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-labelledby="profile-reviews-title">
                    <div class="[display:flex] [align-items:center] [gap:10px] [margin-bottom:15px] [margin-bottom:12px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                        <span class="[width:34px] [height:34px] [flex:none] [display:grid] [place-items:center] [border-radius:8px] [background:#E9E9E8] [color:#202729] [font-size:15px] [background:#EAF1EF] [color:#123B35] dark:[color:#9AC7B8] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!"><i class="fa-regular fa-comment-dots motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i></span>
                        <div>
                            <h2 class="[margin:0] [color:#142230] dark:[color:#F5F2EB] [font-size:15px] [font-weight:700] [line-height:1.25]" id="profile-reviews-title">Riwayat Review</h2>
                            <p class="[margin:2px_0_0] [color:#70777A] dark:[color:#BFC8C3] [font-size:11px]">Lihat semua ulasan yang pernah Anda berikan.</p>
                        </div>
                    </div>

                    @forelse ($reviews as $review)
                        <article class="[display:grid] [grid-template-columns:84px_minmax(0,1fr)] [gap:14px] [align-items:center] [padding:0_0_12px] [.profile-review-item_&]:[padding-top:11px] [.profile-review-item_&]:[border-top:1px_solid_#F0ECE6] max-[480px]:[grid-template-columns:70px_minmax(0,1fr)] max-[480px]:[gap:10px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <div class="[width:84px] [height:68px] [overflow:hidden] [border-radius:9px] [background:#F1EEE9] dark:[background:#14211F] max-[480px]:[width:70px] max-[480px]:[height:64px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                @if ($review->destination?->image)
                                    <img class="[width:100%] [height:100%] [object-fit:cover]" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($review->destination->image) }}" alt="{{ $review->destination->name }}" loading="lazy">
                                @else
                                    <span aria-label="Gambar destinasi belum tersedia"><i class="fa-regular fa-image motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i></span>
                                @endif
                            </div>
                            <div class="motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                <div class="[display:flex] [align-items:baseline] [justify-content:space-between] [gap:10px] max-[480px]:[display:block] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                                    <h3 class="[margin:0] [color:#142230] dark:[color:#F5F2EB] [font-size:13px] [font-weight:700] [line-height:1.3]">{{ $review->destination?->name ?? 'Destinasi tidak tersedia' }}</h3>
                                    <time class="[color:#888B8B] dark:[color:#AEB8B3] [font-size:10px] [white-space:nowrap]" datetime="{{ $review->created_at?->toDateString() }}">{{ $review->created_at?->locale('id')->translatedFormat('j M Y') }}</time>
                                </div>
                                <div class="[display:flex] [gap:1px] [margin-top:2px] [color:#D7D5D0] [font-size:15px] [line-height:1] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-label="{{ $review->rating }} dari 5 bintang">
                                    @for ($star = 1; $star <= 5; $star++)
                                        <span class="{{ $star <= $review->rating ? 'filled' : '' }} [&.filled]:[color:#E7C400] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true">★</span>
                                    @endfor
                                </div>
                                <p class="[margin:4px_0_0] [color:#596267] dark:[color:#CFD5D1] [font-size:11px] [line-height:1.45]">{{ $review->review }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="[flex:1] [display:grid] [justify-items:center] [align-content:center] [gap:8px] [min-height:150px] [color:#83817E] [text-align:center] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!">
                            <i class="fa-regular fa-comment-dots [color:#9A9A94] [font-size:22px] motion-reduce:[scroll-behavior:auto]! motion-reduce:[animation-duration:.01ms]! motion-reduce:[animation-iteration-count:1]! motion-reduce:[transition-duration:.01ms]!" aria-hidden="true"></i>
                            <p>Anda belum memberikan ulasan destinasi.</p>
                            <a href="{{ route('explore.index') }}">Jelajahi destinasi</a>
                        </div>
                    @endforelse
                </section>
            </div>
        </div>
        <section class="mx-auto mb-8 mt-6 w-[min(calc(100%_-_48px),1120px)] rounded-2xl border border-white/80 bg-[linear-gradient(145deg,rgba(255,255,255,.84),rgba(255,252,248,.68))] p-5 shadow-[0_12px_30px_rgba(31,45,54,.07),inset_0_1px_0_rgba(255,255,255,.92)] backdrop-blur-xl dark:border-white/10 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.82),rgba(20,33,31,.7))] max-[760px]:w-[calc(100%_-_32px)] max-[480px]:w-[calc(100%_-_20px)] max-[480px]:p-4" aria-labelledby="profile-favorites-title" data-profile-favorites data-user-id="{{ $user->id }}">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <h2 id="profile-favorites-title" class="m-0 text-lg font-bold text-[#142230] dark:text-[#F5F2EB]">Destinasi Favorit</h2>
                    <p class="mb-0 mt-1 text-sm text-[#70777A] dark:text-[#BFC8C3]">Destinasi yang Anda simpan dari rekomendasi Home.</p>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-4 max-[900px]:grid-cols-3 max-[620px]:grid-cols-2 max-[480px]:grid-cols-1" data-profile-favorites-list>
                <p class="col-span-full m-0 rounded-xl border border-dashed border-[#D8CCBD] px-4 py-7 text-center text-sm text-[#70777A] dark:border-white/15 dark:text-[#BFC8C3]" data-profile-favorites-empty>Belum ada destinasi favorit.</p>
            </div>
        </section>
    </main>

    @include('user.partials.footer')
</body>
</html>
