<div class="grid gap-3">
    @forelse ($reviews as $review)
        @php
            $reviewerName = $review->user?->name;
            $initials = collect(preg_split('/\s+/', trim((string) $reviewerName)))
                ->filter()
                ->take(2)
                ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                ->join('');
            $rating = min(5, max(0, (int) $review->rating));
        @endphp
        <article class="grid min-w-0 grid-cols-[2rem_minmax(0,1fr)] items-start gap-2.5">
            <div class="grid h-8 w-8 place-items-center rounded-full bg-[#DCE6F7] text-[11px] font-semibold text-[#435D89] dark:bg-[#2B3B55] dark:text-[#C5D5F5]" aria-hidden="true">{{ $initials ?: '•' }}</div>
            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px]">
                    <strong class="font-semibold text-[#26363A] dark:text-[#E4E8E5]">{{ $reviewerName ?: 'Pengguna tidak tersedia' }}</strong>
                    <span class="inline-flex gap-px" aria-label="{{ $rating }} dari 5 bintang">
                        @for ($star = 1; $star <= 5; $star++)
                            <svg viewBox="0 0 20 20" aria-hidden="true" class="h-3 w-3 {{ $star <= $rating ? 'fill-[#F2C500]' : 'fill-[#D8D8D8] dark:fill-[#53605B]' }}"><path d="m10 1.7 2.5 5.1 5.6.8-4.1 4 .9 5.6-4.9-2.6-5 2.6 1-5.6-4.1-4 5.6-.8L10 1.7Z"></path></svg>
                        @endfor
                    </span>
                    @if ($review->created_at)
                        <time class="text-[10px] text-[#8A8D8D] dark:text-[#AAB4B0]" datetime="{{ $review->created_at->toDateString() }}">{{ $review->created_at->locale('id')->translatedFormat('j M Y') }}</time>
                    @endif
                </div>
                <div class="mt-1 flex items-start justify-between gap-3">
                    <p class="min-w-0 whitespace-pre-line break-words text-xs leading-relaxed text-[#5D6063] dark:text-[#C5CBC8]">{{ $review->review }}</p>
                    @if (auth()->user()?->role === 'user' && auth()->id() === (int) $review->user_id)
                        <button type="button" class="inline-flex shrink-0 items-center gap-1 rounded-md px-1.5 py-1 text-[10px] font-semibold text-[#31564F] transition hover:bg-white/70 hover:text-[#123B35] focus-visible:outline-2 focus-visible:outline-offset-1 focus-visible:outline-[#17443D] dark:text-[#B8DFD1] dark:hover:bg-white/10" data-review-edit data-review-id="{{ $review->id }}" data-review-rating="{{ $rating }}" data-review-text="{{ $review->review }}" data-review-edit-url="{{ route('user.destinations.reviews.update', [$review->destination_id, $review->id]) }}" aria-label="Edit ulasan Anda"><svg class="h-3 w-3" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M11.5 3.5H5.75A1.75 1.75 0 0 0 4 5.25v9A1.75 1.75 0 0 0 5.75 16h8.5A1.75 1.75 0 0 0 16 14.25V9.5M8 12l2.5-.5L17 4.5 15 2.5l-6.5 6.5L8 12Z"/></svg>Edit</button>
                    @endif
                </div>
            </div>
        </article>
    @empty
        <p class="rounded-lg border border-[#E9E2D9] bg-[#F8F6F2]/80 px-3 py-2.5 text-xs text-[#727575] dark:border-[#354541] dark:bg-[#14211F] dark:text-[#C5CBC8]">Belum ada ulasan untuk destinasi ini.</p>
    @endforelse
</div>

@if (method_exists($reviews, 'links') && $reviews->hasPages())
    <div class="mt-3 flex justify-center text-xs [&_nav]:flex [&_nav]:justify-center" data-review-pagination>{{ $reviews->links() }}</div>
@endif
