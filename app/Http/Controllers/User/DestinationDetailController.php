<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationDetailController extends Controller
{
    public function show(Request $request, Destination $destination)
    {
        $destination->load([
            'categories' => fn ($query) => $query->whereIn('name', Category::DESTINATION_NAMES),
        ]);
        $destination->loadCount('reviews');
        $reviews = $destination->reviews()
            ->with('user:id,name')
            ->latest('created_at')
            ->latest('id')
            ->limit(2)
            ->get();
        return response()
            ->view('user.partials.destination-detail', compact('destination', 'reviews'))
            ->header('Cache-Control', 'private, no-store');
    }

    public function reviews(Request $request, Destination $destination)
    {
        $reviews = $destination->reviews()
            ->with('user:id,name')
            ->latest('created_at')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return response()
            ->view('user.partials.destination-reviews-list', compact('reviews'))
            ->header('Cache-Control', 'private, no-store');
    }

    public function storeReview(Request $request, Destination $destination)
    {
        abort_unless($request->user()?->role === 'user', 403);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'review' => ['required', 'string', 'max:2000'],
        ], [
            'rating.required' => 'Pilih rating bintang terlebih dahulu.',
            'rating.between' => 'Rating harus antara 1 sampai 5 bintang.',
            'review.required' => 'Isi ulasan terlebih dahulu.',
            'review.max' => 'Ulasan maksimal 2.000 karakter.',
        ]);

        $destination->reviews()->create([
            'user_id' => $request->user()->id,
            'rating' => $validated['rating'],
            'review' => trim($validated['review']),
        ]);

        $destination->loadCount('reviews');
        $reviews = $destination->reviews()
            ->with('user:id,name')
            ->latest('created_at')
            ->latest('id')
            ->limit(2)
            ->get();
        return response()->json([
            'html' => view('user.partials.destination-reviews-section', compact('destination', 'reviews'))->render(),
        ])->header('Cache-Control', 'private, no-store');
    }

    public function updateReview(Request $request, Destination $destination, int $reviewId)
    {
        abort_unless($request->user()?->role === 'user', 403);

        $review = $destination->reviews()
            ->whereKey($reviewId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'review' => ['required', 'string', 'max:2000'],
        ], [
            'rating.required' => 'Pilih rating bintang terlebih dahulu.',
            'rating.between' => 'Rating harus antara 1 sampai 5 bintang.',
            'review.required' => 'Isi ulasan terlebih dahulu.',
            'review.max' => 'Ulasan maksimal 2.000 karakter.',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'review' => trim($validated['review']),
        ]);

        $destination->loadCount('reviews');
        $reviews = $destination->reviews()
            ->with('user:id,name')
            ->latest('created_at')
            ->latest('id')
            ->limit(2)
            ->get();
        return response()->json([
            'html' => view('user.partials.destination-reviews-section', compact('destination', 'reviews'))->render(),
        ])->header('Cache-Control', 'private, no-store');
    }
}
