<section class="mt-4 border-t border-[#E7DED3] pt-3 dark:border-white/10" aria-labelledby="destination-reviews-title" data-destination-reviews>
    <div class="flex items-center justify-between gap-3">
        <div>
            <h3 id="destination-reviews-title" class="font-display text-[15px] font-semibold text-[#A95C40] dark:text-[#D98A6E]">Ulasan Pengunjung</h3>
            <span class="text-[11px] text-[#727B78] dark:text-[#C8D0CC]">{{ $destination->reviews_count }} ulasan</span>
        </div>
        @if (auth()->user()?->role === 'user')
            <button type="button" class="inline-flex min-h-8 shrink-0 items-center gap-1.5 rounded-lg border border-white/90 bg-white/55 px-2.5 text-[11px] font-semibold text-[#17443D] shadow-[0_5px_14px_rgba(29,61,53,.06),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-lg transition hover:-translate-y-px hover:bg-white/80 hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#17443D] motion-reduce:transition-none dark:border-white/15 dark:bg-white/[.06] dark:text-[#C7E3D8] dark:hover:bg-white/10" data-review-compose>
                <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M11.5 3.5H5.75A1.75 1.75 0 0 0 4 5.25v9A1.75 1.75 0 0 0 5.75 16h8.5A1.75 1.75 0 0 0 16 14.25V9.5M8 12l2.5-.5L17 4.5 15 2.5l-6.5 6.5L8 12Z"/></svg>
                Tulis Ulasan
            </button>
        @endif
    </div>

    <div class="mt-2 transition-opacity duration-200 motion-reduce:transition-none" data-review-content>
        @include('user.partials.destination-review-items', ['reviews' => $reviews])
    </div>

    @if ($destination->reviews_count > 2)
        <button type="button" class="mt-2 inline-flex min-h-8 items-center gap-1.5 rounded-lg border border-white/90 bg-white/55 px-2.5 text-[11px] font-semibold text-[#17443D] shadow-[0_5px_14px_rgba(29,61,53,.06),inset_0_1px_0_rgba(255,255,255,.9)] backdrop-blur-lg transition duration-200 hover:-translate-y-px hover:bg-white/80 hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#17443D] motion-reduce:transition-none dark:border-white/15 dark:bg-white/[.06] dark:text-[#C7E3D8] dark:hover:bg-white/10" data-review-toggle data-all-reviews-url="{{ route('user.destinations.reviews', $destination) }}" aria-expanded="false">
            Lihat Semua
            <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 10h13M11 5l5 5-5 5"></path></svg>
        </button>
    @endif

    @if (auth()->user()?->role === 'user')
        <div class="fixed inset-0 z-[220] hidden place-items-center p-3 sm:p-5" data-review-editor>
            <button class="absolute inset-0 cursor-default bg-[#102923]/35 backdrop-blur-md" type="button" data-review-editor-overlay aria-label="Tutup form ulasan"></button>
            <section class="relative z-[1] max-h-[94vh] w-full max-w-[700px] overflow-y-auto rounded-2xl border border-white/85 bg-[linear-gradient(145deg,rgba(255,255,255,.92),rgba(248,246,241,.84))] p-5 text-[#142230] shadow-[0_24px_70px_rgba(16,31,45,.24),inset_0_1px_0_rgba(255,255,255,.98)] backdrop-blur-2xl dark:border-white/15 dark:bg-[linear-gradient(145deg,rgba(35,52,48,.96),rgba(20,33,31,.92))] dark:text-[#F5F2EB] sm:p-7" role="dialog" aria-modal="true" aria-labelledby="review-editor-title" tabindex="-1">
                <button class="absolute right-4 top-4 grid h-9 w-9 place-items-center rounded-full border border-white/80 bg-white/70 text-[#173B36] shadow-sm backdrop-blur-lg transition hover:rotate-90 hover:bg-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#17443D] dark:border-white/15 dark:bg-white/10 dark:text-[#D2E9DF] dark:hover:bg-white/15" type="button" data-review-editor-close aria-label="Tutup form ulasan"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg></button>

                <header class="flex items-center gap-4 border-b border-[#E7DED3] pb-4 pr-10 dark:border-white/10">
                    <span class="grid h-14 w-14 shrink-0 place-items-center rounded-full bg-[#DDF3E5] text-[#123B35] dark:bg-[#285345] dark:text-[#C7E3D8]"><svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M21 11.5a8.5 8.5 0 0 1-8.5 8.5 9 9 0 0 1-4-.9L3 21l1.9-4.6a8.5 8.5 0 1 1 16.1-4.9Z"/><circle cx="8" cy="11.5" r=".7" fill="currentColor"/><circle cx="12.5" cy="11.5" r=".7" fill="currentColor"/><circle cx="17" cy="11.5" r=".7" fill="currentColor"/></svg></span>
                    <div>
                        <h4 class="font-display text-xl font-semibold leading-tight sm:text-2xl" id="review-editor-title" data-review-editor-title>Tulis Ulasan</h4>
                        <p class="mt-1 text-sm text-[#697276] dark:text-[#C8D0CC]">Bagikan pengalaman Anda di destinasi ini.</p>
                    </div>
                </header>

                <div class="my-4 grid grid-cols-[88px_minmax(0,1fr)] items-center gap-4 sm:grid-cols-[112px_minmax(0,1fr)]">
                    <div class="h-[88px] overflow-hidden rounded-xl bg-[#EEEAE4] ring-1 ring-inset ring-white/80 sm:h-28">
                        @if ($destination->image)
                            <img class="h-full w-full object-cover" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($destination->image) }}" alt="{{ $destination->name }}">
                        @else
                            <div class="grid h-full place-items-center text-xs text-[#7A817F]">Gambar belum tersedia</div>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h5 class="font-display text-lg font-semibold leading-tight text-[#142230] dark:text-[#F5F2EB] sm:text-xl">{{ $destination->name }}</h5>
                        <div class="mt-2 flex flex-wrap gap-1.5">
                            @foreach ($destination->categories as $category)
                                <span class="rounded-full bg-[#F7E6D9] px-3 py-1 text-xs font-semibold text-[#A95C40] dark:bg-[#49352D] dark:text-[#F0B49A]">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <form class="grid gap-4" method="POST" action="{{ route('user.destinations.reviews.store', $destination) }}" data-review-form data-review-store-url="{{ route('user.destinations.reviews.store', $destination) }}">
                    @csrf
                    <input type="hidden" name="_method" value="POST" data-review-method>
                    <fieldset class="m-0 min-w-0 border-0 p-0" data-review-field="rating">
                        <legend class="mb-2 text-sm font-semibold text-[#27343A] dark:text-[#E4E8E5]">Rating <span class="text-red-500">*</span></legend>
                        <div class="flex w-max flex-row-reverse justify-end gap-1 [&>label:has(input:checked)~label]:text-[#F2B900]" role="radiogroup" aria-label="Pilih rating dari 1 sampai 5 bintang">
                            @for ($rating = 5; $rating >= 1; $rating--)
                                <label class="group relative cursor-pointer text-3xl leading-none text-[#D8DADD] transition-colors hover:text-[#F2B900] has-[:checked]:text-[#F2B900] has-[:focus-visible]:outline-2 has-[:focus-visible]:outline-offset-2 has-[:focus-visible]:outline-[#123B35] dark:text-[#58635E] sm:text-4xl" title="{{ $rating }} dari 5 bintang">
                                    <input class="peer sr-only" type="radio" name="rating" value="{{ $rating }}" required>
                                    <span aria-hidden="true">★</span>
                                    <span class="sr-only">{{ $rating }} bintang</span>
                                </label>
                            @endfor
                        </div>
                        <p class="mt-1 text-xs text-[#A33D2E] dark:text-[#FF9A8B]" data-review-error="rating" role="alert" hidden></p>
                    </fieldset>

                    <label class="grid gap-2 text-sm font-semibold text-[#27343A] dark:text-[#E4E8E5]" data-review-field="review">
                        <span>Ulasan <span class="text-red-500">*</span></span>
                        <textarea class="min-h-32 w-full resize-y rounded-xl border border-[#D9D2C8] bg-white/70 px-3 py-3 text-sm font-normal text-[#17232A] outline-none transition placeholder:text-[#858B8E] focus:border-[#123B35] focus:ring-2 focus:ring-[#123B35]/15 dark:border-white/15 dark:bg-white/[.06] dark:text-[#F5F2EB] dark:placeholder:text-[#AAB4B0] dark:focus:border-[#9AC7B8]" name="review" rows="5" maxlength="2000" required placeholder="Ceritakan pengalaman Anda di destinasi ini..." data-review-textarea></textarea>
                        <span class="text-right text-[11px] font-normal text-[#737B7E] dark:text-[#AAB4B0]" data-review-counter>0/2000</span>
                        <p class="mt-0.5 text-xs font-normal text-[#A33D2E] dark:text-[#FF9A8B]" data-review-error="review" role="alert" hidden></p>
                    </label>

                    <p class="text-xs text-[#A33D2E] dark:text-[#FF9A8B]" data-review-form-error role="alert" hidden></p>
                    <div class="flex justify-end gap-3 border-t border-[#E7DED3] pt-4 dark:border-white/10">
                        <button type="button" class="inline-flex min-h-11 min-w-28 items-center justify-center rounded-xl border border-[#D7D1C9] bg-white/45 px-5 text-sm font-semibold text-[#27343A] backdrop-blur-md transition hover:bg-white/75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#17443D] dark:border-white/15 dark:bg-white/[.05] dark:text-[#E4E8E5] dark:hover:bg-white/10" data-review-editor-close>Batal</button>
                        <button type="submit" class="inline-flex min-h-11 min-w-40 items-center justify-center rounded-xl border border-white/15 bg-[#123B35] px-5 text-sm font-semibold text-white shadow-[0_8px_20px_rgba(18,59,53,.18),inset_0_1px_0_rgba(255,255,255,.18)] transition duration-200 hover:-translate-y-0.5 hover:bg-[#0C302B] hover:shadow-lg focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#17443D] disabled:cursor-wait disabled:opacity-70 motion-reduce:transition-none dark:bg-[#0B2823]">
                            <span data-review-submit-label>Kirim Ulasan</span>
                            <span data-review-submit-loading hidden>Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </section>
        </div>
    @elseif (! auth()->check())
        <p class="mt-3 rounded-lg bg-[#F2F7F3]/80 px-3 py-2 text-xs text-[#31564F] dark:bg-[#14211F] dark:text-[#B8DFD1]"><a class="font-semibold underline decoration-[#123B35]/30 underline-offset-2 hover:text-[#B96142] dark:decoration-[#9AC7B8]/40" href="{{ route('login') }}">Masuk untuk menulis ulasan.</a></p>
    @endif
</section>
