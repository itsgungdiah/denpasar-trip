<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'categories' => ['sometimes', 'array', 'max:5'],
            'categories.*' => ['string', 'distinct', Rule::in(Category::DESTINATION_NAMES)],
            'category_filter' => ['nullable', Rule::in(Category::DESTINATION_NAMES)],
            'min_spending' => ['nullable', 'numeric', 'min:0'],
            'max_spending' => ['nullable', 'numeric', 'min:0', Rule::when($request->filled('min_spending'), ['gte:min_spending'])],
            'min_rating' => ['nullable', 'numeric', 'between:1,5'],
            'sort' => ['nullable', Rule::in(['name_asc', 'name_desc', 'spending_asc', 'spending_desc', 'rating_desc'])],
        ]);

        $search = trim($validated['search'] ?? '');
        $selectedCategories = array_values(array_unique($validated['categories'] ?? []));
        $categoryFilter = $validated['category_filter'] ?? null;
        $minSpending = $validated['min_spending'] ?? null;
        $maxSpending = $validated['max_spending'] ?? null;
        $minRating = $validated['min_rating'] ?? null;
        $sort = $validated['sort'] ?? 'name_asc';
        $spendingMinimumExpression = "CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(average_spending, '$.amount')), 'null'), NULLIF(JSON_UNQUOTE(JSON_EXTRACT(average_spending, '$.min')), 'null')) AS DECIMAL(12,2))";
        $spendingMaximumExpression = "CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(average_spending, '$.amount')), 'null'), NULLIF(JSON_UNQUOTE(JSON_EXTRACT(average_spending, '$.max')), 'null')) AS DECIMAL(12,2))";
        $spendingSortExpression = "CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(average_spending, '$.amount')), 'null'), NULLIF(JSON_UNQUOTE(JSON_EXTRACT(average_spending, '$.min')), 'null'), NULLIF(JSON_UNQUOTE(JSON_EXTRACT(average_spending, '$.max')), 'null')) AS DECIMAL(12,2))";

        $query = Destination::query()
            ->with(['categories' => fn ($query) => $query->whereIn('name', Category::DESTINATION_NAMES)])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->when($search !== '', fn ($query) => $query->where('name', 'like', '%' . $search . '%'))
            ->when($selectedCategories !== [], fn ($query) => $query->whereHas(
                'categories',
                fn ($categoryQuery) => $categoryQuery->whereIn('categories.name', $selectedCategories)
            ))
            ->when($categoryFilter, fn ($query) => $query->whereHas(
                'categories',
                fn ($categoryQuery) => $categoryQuery->where('categories.name', $categoryFilter)
            ));

        if ($minSpending !== null) {
            $query->whereRaw("{$spendingMaximumExpression} >= ?", [$minSpending]);
        }

        if ($maxSpending !== null) {
            $query->whereRaw("{$spendingMinimumExpression} <= ?", [$maxSpending]);
        }

        if ($minRating !== null) {
            $query->whereRaw('(SELECT AVG(reviews.rating) FROM reviews WHERE reviews.destination_id = destinations.id) >= ?', [$minRating]);
        }

        if ($sort === 'rating_desc') {
            $query->orderByRaw('(SELECT AVG(reviews.rating) FROM reviews WHERE reviews.destination_id = destinations.id) DESC');
        } elseif (str_starts_with($sort, 'spending_')) {
            $direction = $sort === 'spending_desc' ? 'DESC' : 'ASC';
            $query->orderByRaw("{$spendingSortExpression} {$direction}");
        } else {
            $query->orderBy('name', $sort === 'name_desc' ? 'desc' : 'asc');
        }

        $destinations = $query->orderBy('id')->paginate(16)->withQueryString();

        return view('user.explore', compact('destinations', 'search', 'selectedCategories', 'categoryFilter', 'minSpending', 'maxSpending', 'minRating', 'sort'));
    }
}
