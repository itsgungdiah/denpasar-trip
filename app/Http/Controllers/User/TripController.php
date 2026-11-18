<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TripController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()?->role === 'user', 403);

        $trips = $request->user()->trips()
            ->whereHas('itineraries')
            ->withCount('itineraries')
            ->with(['itineraries' => fn ($query) => $query
                ->orderBy('date')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->with('destination:id,name,image,average_spending')])
            ->latest('updated_at')
            ->paginate(8);

        $trips->getCollection()->each(function (Trip $trip) {
            $byDate = $trip->itineraries->groupBy(fn ($item) => $item->date->toDateString());
            $days = collect();
            foreach ($trip->start_date->daysUntil($trip->end_date) as $index => $date) {
                $key = $date->toDateString();
                $days->push(['date' => $date, 'number' => $index + 1, 'items' => $byDate->get($key, collect())]);
            }
            $trip->setAttribute('itinerary_days', $days);
        });

        return view('user.my-trips.index', compact('trips'));
    }

    public function show(Request $request, Trip $trip)
    {
        $trip = $this->ownedTrip($request, $trip);
        $trip->load(['itineraries' => fn ($query) => $query
            ->orderBy('date')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->with(['destination.categories' => fn ($categories) => $categories->whereIn('name', Category::DESTINATION_NAMES)])]);

        return view('user.my-trips.show', compact('trip'));
    }

    public function destroy(Request $request, Trip $trip)
    {
        $trip = $this->ownedTrip($request, $trip);
        $trip->delete();

        return redirect()->route('my-trips.index')->with('success', 'Trip berhasil dihapus.');
    }

    public function create(Request $request)
    {
        abort_unless($request->user()?->role === 'user', 403);

        return view('user.trips.create');
    }

    public function edit(Request $request, Trip $trip)
    {
        $trip = $this->ownedTrip($request, $trip);
        return view('user.trips.create', compact('trip'));
    }

    public function update(Request $request, Trip $trip)
    {
        $trip = $this->ownedTrip($request, $trip);
        $validated = $request->validate([
            'trip_name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);
        if ($trip->itineraries()->where(fn ($query) => $query->whereDate('date', '<', $validated['start_date'])->orWhereDate('date', '>', $validated['end_date']))->exists()) {
            return back()->withErrors(['end_date' => 'Rentang tanggal tidak dapat melewati tanggal itinerary yang sudah disusun.'])->withInput();
        }
        $trip->update($validated);

        return redirect()->route('trips.preferences.edit', $trip);
    }

    public function store(Request $request)
    {
        abort_unless($request->user()?->role === 'user', 403);

        $validated = $request->validate([
            'trip_name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ], [
            'trip_name.required' => 'Nama trip wajib diisi.',
            'start_date.required' => 'Tanggal mulai wajib dipilih.',
            'end_date.required' => 'Tanggal selesai wajib dipilih.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        $trip = $request->user()->trips()->create($validated);

        return redirect()->route('trips.preferences.edit', $trip);
    }

    public function editPreferences(Request $request, Trip $trip)
    {
        $trip = $this->ownedTrip($request, $trip);
        $categories = Category::query()
            ->whereIn('name', Category::DESTINATION_NAMES)
            ->get()
            ->sortBy(fn (Category $category) => array_search($category->name, Category::DESTINATION_NAMES, true))
            ->values();
        $selectedCategoryIds = $trip->preferences()->pluck('category_id')->all();

        return view('user.trips.preferences', compact('trip', 'categories', 'selectedCategoryIds'));
    }

    public function updatePreferences(Request $request, Trip $trip)
    {
        $trip = $this->ownedTrip($request, $trip);
        $validated = $request->validate([
            'categories' => ['required', 'array', 'min:1', 'max:5'],
            'categories.*' => ['required', 'integer', 'distinct'],
        ], [
            'categories.required' => 'Pilih minimal satu kategori minat.',
            'categories.min' => 'Pilih minimal satu kategori minat.',
        ]);

        $categoryIds = Category::query()
            ->whereIn('name', Category::DESTINATION_NAMES)
            ->whereIn('id', $validated['categories'])
            ->pluck('id')
            ->all();

        if (count($categoryIds) !== count($validated['categories'])) {
            return back()->withErrors(['categories' => 'Kategori yang dipilih tidak tersedia.'])->withInput();
        }

        $trip->preferences()->whereNotIn('category_id', $categoryIds)->delete();
        foreach ($categoryIds as $categoryId) {
            $trip->preferences()->firstOrCreate(['category_id' => $categoryId]);
        }

        return redirect()->route('trips.discover', $trip);
    }

    public function discover(Request $request, Trip $trip)
    {
        $trip = $this->ownedTrip($request, $trip);
        $preferenceIds = $trip->preferences()->pluck('category_id');

        if ($preferenceIds->isEmpty()) {
            return redirect()->route('trips.preferences.edit', $trip)
                ->withErrors(['categories' => 'Pilih kategori minat sebelum melihat destinasi.']);
        }

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'categories' => ['sometimes', 'array', 'max:5'],
            'categories.*' => ['integer', 'distinct'],
            'filter_categories' => ['sometimes', 'boolean'],
            'min_rating' => ['nullable', Rule::in(['3', '4', '4.5', '5'])],
            'sort' => ['nullable', Rule::in(['name_asc', 'name_desc', 'price_asc', 'price_desc'])],
        ]);
        $categories = Category::query()
            ->whereIn('name', Category::DESTINATION_NAMES)
            ->get()
            ->sortBy(fn (Category $category) => array_search($category->name, Category::DESTINATION_NAMES, true))
            ->values();
        $defaultSelectedIds = $preferenceIds->all();
        $selectedCategoryIds = $request->boolean('filter_categories')
            ? collect($validated['categories'] ?? [])->map(fn ($id) => (int) $id)->all()
            : $defaultSelectedIds;
        $allowedIds = $categories->whereIn('id', $selectedCategoryIds)->pluck('id')->values();
        $selectedCategoryIds = $allowedIds->all();
        $sort = $validated['sort'] ?? 'name_asc';
        $minimumRating = isset($validated['min_rating']) ? (float) $validated['min_rating'] : null;

        $destinations = Destination::query()
            ->with(['categories' => fn ($query) => $query->whereIn('name', Category::DESTINATION_NAMES)])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->when(! $request->boolean('filter_categories') || $selectedCategoryIds !== [], fn ($query) => $query->whereHas('categories', fn ($query) => $query->whereIn('categories.id', $allowedIds)))
            ->when(trim($validated['search'] ?? '') !== '', fn ($query) => $query->where('name', 'like', '%' . trim($validated['search']) . '%'))
            ->when($minimumRating !== null, fn ($query) => $query->whereIn('destinations.id', DB::table('reviews')
                ->select('destination_id')
                ->groupBy('destination_id')
                ->havingRaw('AVG(rating) >= ?', [$minimumRating])))
            ->when(Str::startsWith($sort, 'price_'), function ($query) use ($sort) {
                $driver = DB::connection()->getDriverName();
                $priceExpression = $driver === 'sqlite'
                    ? "CASE WHEN json_extract(entrance_fee, '$.type') = 'free' THEN 0 ELSE CAST(COALESCE(json_extract(entrance_fee, '$.amount'), json_extract(entrance_fee, '$.min')) AS REAL) END"
                    : "CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(entrance_fee, '$.type')) = 'free' THEN 0 ELSE CAST(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(entrance_fee, '$.amount')), JSON_UNQUOTE(JSON_EXTRACT(entrance_fee, '$.min'))) AS DECIMAL(12,2)) END";

                $query->orderByRaw($priceExpression . ($sort === 'price_desc' ? ' DESC' : ' ASC'));
            }, fn ($query) => $query->orderBy('name', $sort === 'name_desc' ? 'desc' : 'asc'))
            ->paginate(8)
            ->withQueryString();
        $itineraries = $trip->itineraries()
            ->with(['destination:id,name,image', 'destination.categories' => fn ($query) => $query->whereIn('name', Category::DESTINATION_NAMES)])
            ->orderBy('date')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
        $itinerariesByDate = $itineraries->groupBy(fn ($item) => $item->date->toDateString());
        $days = collect();
        foreach (Carbon::parse($trip->start_date)->startOfDay()->daysUntil(Carbon::parse($trip->end_date)->startOfDay()) as $index => $date) {
            $key = $date->toDateString();
            $days->push(['date' => $date, 'number' => $index + 1, 'items' => $itinerariesByDate->get($key, collect())]);
        }

        return view('user.trips.discover', compact('trip', 'destinations', 'itineraries', 'days', 'categories', 'selectedCategoryIds'));
    }

    public function storeItinerary(Request $request, Trip $trip)
    {
        $trip = $this->ownedTrip($request, $trip);
        $validated = $request->validate([
            'destination_id' => ['required', 'integer', Rule::exists('destinations', 'id')],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:' . $trip->start_date->toDateString(), 'before_or_equal:' . $trip->end_date->toDateString()],
            'start_time' => ['required', 'date_format:H:i'],
            'duration' => ['required', 'integer', 'min:1', 'max:1440'],
            'sort_order' => ['required', 'integer', 'min:1', 'max:100'],
            'note' => ['nullable', 'string', 'max:2000'],
        ], [
            'date.after_or_equal' => 'Tanggal kunjungan harus berada dalam rentang tanggal trip.',
            'date.before_or_equal' => 'Tanggal kunjungan harus berada dalam rentang tanggal trip.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'duration.required' => 'Durasi kunjungan wajib diisi.',
            'sort_order.required' => 'Tentukan urutan destinasi.',
        ]);

        $matchesCategory = Destination::query()
            ->whereKey($validated['destination_id'])
            ->whereHas('categories', fn ($query) => $query->whereIn('categories.name', Category::DESTINATION_NAMES))
            ->exists();

        if (! $matchesCategory) {
            return back()->withErrors(['destination_id' => 'Destinasi ini tidak memiliki kategori yang tersedia.']);
        }

        $this->assertVisitDoesNotPassMidnight($validated['start_time'], $validated['duration']);
        $itinerary = DB::transaction(function () use ($trip, $validated) {
            $dayItems = $trip->itineraries()
                ->whereDate('date', $validated['date'])
                ->lockForUpdate();

            if ((clone $dayItems)->where('destination_id', $validated['destination_id'])->exists()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'destination_id' => 'Destinasi ini sudah ada pada hari tersebut.',
                ]);
            }

            $this->assertNoScheduleConflict($trip, $validated['date'], $validated['start_time'], $validated['duration']);
            $validated['sort_order'] = ((clone $dayItems)->max('sort_order') ?? 0) + 1;

            return $trip->itineraries()->create($validated);
        });

        $message = 'Destinasi berhasil ditambahkan ke itinerary.';
        if ($request->expectsJson()) {
            $request->session()->flash('success', $message);

            return response()->json(['message' => $message, 'itinerary_id' => $itinerary->id], 201);
        }

        return redirect()->route('trips.discover', $trip)->with('success', $message);
    }

    public function updateItinerary(Request $request, Trip $trip, int $itinerary)
    {
        $trip = $this->ownedTrip($request, $trip);
        $item = $trip->itineraries()->whereKey($itinerary)->firstOrFail();
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:' . $trip->start_date->toDateString(), 'before_or_equal:' . $trip->end_date->toDateString()],
            'start_time' => ['required', 'date_format:H:i'],
            'duration' => ['required', 'integer', 'min:1', 'max:1440'],
            'sort_order' => ['required', 'integer', 'min:1', 'max:100'],
            'note' => ['nullable', 'string', 'max:2000'],
        ]);
        $this->assertVisitDoesNotPassMidnight($validated['start_time'], $validated['duration']);
        DB::transaction(function () use ($trip, $item, $validated) {
            $this->assertNoScheduleConflict($trip, $validated['date'], $validated['start_time'], $validated['duration'], $item->id);
            $item->update($validated);
        });

        $message = 'Detail kunjungan diperbarui.';
        if ($request->expectsJson()) {
            $request->session()->flash('success', $message);

            return response()->json(['message' => $message, 'itinerary_id' => $item->id]);
        }

        return redirect()->route('trips.discover', $trip)->with('success', $message);
    }

    public function destroyItinerary(Request $request, Trip $trip, int $itinerary)
    {
        $trip = $this->ownedTrip($request, $trip);
        $trip->itineraries()->whereKey($itinerary)->firstOrFail()->delete();

        return back()->with('success', 'Destinasi dihapus dari itinerary.');
    }

    public function reorderItineraries(Request $request, Trip $trip)
    {
        $trip = $this->ownedTrip($request, $trip);
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:' . $trip->start_date->toDateString(), 'before_or_equal:' . $trip->end_date->toDateString()],
            'itinerary_ids' => ['required', 'array', 'min:1'],
            'itinerary_ids.*' => ['required', 'integer', 'distinct'],
        ]);
        $items = $trip->itineraries()->whereDate('date', $validated['date'])->get()->keyBy('id');
        $ids = collect($validated['itinerary_ids'])->map(fn ($id) => (int) $id);
        abort_unless($items->count() === $ids->count() && $ids->every(fn ($id) => $items->has($id)), 422);

        DB::transaction(function () use ($trip, $validated, $ids) {
            foreach ($ids->values() as $position => $id) {
                $trip->itineraries()->whereKey($id)->whereDate('date', $validated['date'])->update(['sort_order' => $position + 1]);
            }
        });

        return back()->with('success', 'Urutan itinerary diperbarui.');
    }

    private function ownedTrip(Request $request, Trip $trip): Trip
    {
        abort_unless($request->user()?->role === 'user', 403);

        return $request->user()->trips()->whereKey($trip->getKey())->firstOrFail();
    }

    private function assertVisitDoesNotPassMidnight(string $startTime, int $duration): void
    {
        $start = Carbon::createFromFormat('H:i', $startTime);

        if ($start->copy()->addMinutes($duration)->greaterThan(Carbon::createFromTime(23, 59, 59))) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'duration' => 'Waktu kunjungan tidak boleh melewati tengah malam.',
            ]);
        }
    }

    private function assertNoScheduleConflict(Trip $trip, string $date, string $startTime, int $duration, ?int $exceptId = null): void
    {
        $start = Carbon::createFromFormat('H:i', $startTime);
        $startMinute = ((int) $start->format('H')) * 60 + (int) $start->format('i');
        $endMinute = $startMinute + $duration;

        $overlaps = $trip->itineraries()
            ->whereDate('date', $date)
            ->when($exceptId, fn ($query) => $query->whereKeyNot($exceptId))
            ->whereNotNull('start_time')
            ->whereNotNull('duration')
            ->get(['id', 'start_time', 'duration'])
            ->contains(function ($visit) use ($startMinute, $endMinute) {
                $otherStart = Carbon::parse($visit->start_time);
                $otherStartMinute = ((int) $otherStart->format('H')) * 60 + (int) $otherStart->format('i');
                $otherEndMinute = $otherStartMinute + (int) $visit->duration;

                return $startMinute < $otherEndMinute && $endMinute > $otherStartMinute;
            });

        if ($overlaps) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'start_time' => 'Jadwal bertumpang tindih dengan destinasi lain. Sesuaikan waktu kunjungan sebelum menyimpan.',
            ]);
        }
    }
}
