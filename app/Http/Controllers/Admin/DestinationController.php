<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Destination::with('categories');
        $categories = Category::whereIn('name', Category::DESTINATION_NAMES)
            ->orderBy('name')
            ->get();

        if (request()->filled('search')) {
            $search = request('search');

            $query->where('name', 'like', '%' . $search . '%');
        }

        if (request()->filled('category')) {
            $categoryId = request('category');

            $query->whereHas('categories', function ($categoryQuery) use ($categoryId) {
                $categoryQuery
                    ->whereIn('categories.name', Category::DESTINATION_NAMES)
                    ->where('categories.id', $categoryId);
            });
        }

        $destinations = $query->oldest()->paginate(10)->withQueryString();

        return view('admin.destinations.index', compact('destinations', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereIn('name', Category::DESTINATION_NAMES)
            ->orderBy('name')
            ->get();
        return view('admin.destinations.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateDestination($request);

        if ($request->hasFile('image')){
            $validated['image'] = $request->file('image')->store('destinations', 'public');
        }

        $categoryIds = $validated['categories'];
        unset($validated['categories']);

        $destination = Destination::create($validated);
        $destination->categories()->sync($categoryIds);

        return redirect() 
        ->route('admin.destinations.index')
        ->with('success', 'Destinasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $destination = Destination::with('categories')->findOrFail($id); /* mencari destinasi berdasarkan id di database */
        $categories = Category::whereIn('name', Category::DESTINATION_NAMES)
            ->orderBy('name')
            ->get();

        $openingHours = $this->decodeStoredJson($destination->opening_hours);
        $entranceFee = $this->decodeStoredJson($destination->entrance_fee);
        $averageSpending = $this->decodeStoredJson($destination->average_spending);
        return view('admin.destinations.edit', compact('destination', 'categories', 'openingHours', 'entranceFee','averageSpending'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $destination = Destination::findOrFail($id);

        $validated = $this->validateDestination($request);

        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('destinations', 'public');
            $oldImagePath = $destination->image;
            $validated['image'] = $newImagePath;
        }

        $categoryIds = $validated['categories'];
        unset($validated['categories']);

        $destination->update($validated);
        $destination->categories()->sync($categoryIds);

        if (isset($oldImagePath) && $oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect() 
        ->route('admin.destinations.index') 
        ->with('success', 'Destinasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destination = Destination::findOrFail($id);
        if ($destination->image) {
            Storage::disk('public')->delete($destination->image);
        }
        $destination->delete();
        return redirect() 
        ->route('admin.destinations.index') 
        ->with('success', 'Destinasi berhasil dihapus.');
    }

    private function validateDestination(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'opening_hours' => ['required', 'json'],
            'entrance_fee' => ['required', 'json'],
            'average_spending' => ['required', 'json'],
            'google_maps_url' => ['nullable', 'url', 'max:255'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['required','integer', 'distinct',
                Rule::exists('categories', 'id')->where(
                    fn (Builder $query) => $query->whereIn('name', Category::DESTINATION_NAMES)
                ),
            ],
        ]);

        $openingHours = json_decode($validated['opening_hours'], true, flags: JSON_THROW_ON_ERROR);
        $entranceFee = json_decode($validated['entrance_fee'], true, flags: JSON_THROW_ON_ERROR);
        $averageSpending = json_decode($validated['average_spending'], true, flags: JSON_THROW_ON_ERROR);

        Validator::make([
            'opening_hours' => $openingHours,
            'entrance_fee' => $entranceFee,
            'average_spending' => $averageSpending,
        ], [
            'opening_hours' => ['required', 'array'],
            'opening_hours.schedules' => ['required', 'array', 'min:1'],
            'opening_hours.schedules.*.days' => ['required', 'array', 'min:1'],
            'opening_hours.schedules.*.days.*' => [
                'required',
                'distinct',
                Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']),
            ],
            'opening_hours.schedules.*.hours' => ['required', 'string', 'max:100'],
            'opening_hours.notes' => ['nullable', 'string', 'max:1000'],
            'entrance_fee' => ['required', 'array'],
            'entrance_fee.type' => ['required', Rule::in(['free', 'fixed', 'range'])],
            'entrance_fee.amount' => ['nullable', 'required_if:entrance_fee.type,fixed', 'integer', 'min:0', 'prohibited_unless:entrance_fee.type,fixed'],
            'entrance_fee.min' => ['nullable', 'required_if:entrance_fee.type,range', 'integer', 'min:0', 'prohibited_unless:entrance_fee.type,range'],
            'entrance_fee.max' => ['nullable', 'required_if:entrance_fee.type,range', 'integer', 'gte:entrance_fee.min', 'prohibited_unless:entrance_fee.type,range'],
            'entrance_fee.notes' => ['nullable', 'string', 'max:1000'],
            'average_spending' => ['required', 'array'],
            'average_spending.type' => ['nullable', Rule::in(['fixed', 'range'])],
            'average_spending.amount' => ['nullable', 'required_if:average_spending.type,fixed', 'integer', 'min:0', 'prohibited_unless:average_spending.type,fixed'],
            'average_spending.min' => ['nullable', 'required_if:average_spending.type,range', 'integer', 'min:0', 'prohibited_unless:average_spending.type,range'],
            'average_spending.max' => ['nullable', 'required_if:average_spending.type,range', 'integer', 'gte:average_spending.min', 'prohibited_unless:average_spending.type,range'],
            'average_spending.notes' => ['nullable', 'string', 'max:1000'],
        ])->validate();

        // Eloquent casts persist these arrays as JSON text in the existing TEXT columns.
        $validated['opening_hours'] = $openingHours;
        $validated['entrance_fee'] = $entranceFee;
        $validated['average_spending'] = $averageSpending;

        return $validated;
    }

    private function decodeStoredJson(mixed $value): array
    {
        for ($attempt = 0; $attempt < 2 && is_string($value); $attempt++) {
            $decoded = json_decode($value, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [];
            }

            $value = $decoded;
        }

        return is_array($value) ? $value : [];
    }
}
