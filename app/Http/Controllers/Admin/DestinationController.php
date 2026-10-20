<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Destination::with('categories');
        $categories = \App\Models\Category::orderBy('name')->get();

        if (request()->filled('search')) {
            $search = request('search');

            $query->where('name', 'like', '%' . $search . '%');
        }

        if (request()->filled('category')) {
            $categoryId = request('category');

            $query->whereHas('categories', function ($categoryQuery) use ($categoryId) {
                $categoryQuery->where('categories.id', $categoryId);
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
        $categories = \App\Models\Category::all();
        return view('admin.destinations.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* laravel memeriksa data yang dikirim sebelum disimpan. */
        /* variabel $request digunakan untuk menerima informasi yang dikirim user (jadi dia menyediakan data yg dikirim pengguna).*/
        /* method validate() : dari laravel untuk memeriksa apakah data memenuhi aturan. */
        /* mime : multipurpose internet mail extensions, untuk mengidentifikasi jenis berkas. */
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'opening_hours' => 'nullable|json',
            'entrance_fee' => 'nullable|json',
            'average_spending' => 'nullable|json',
            'google_maps_url' => 'required|url|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|integer|distinct|exists:categories,id',
        ]);

        /* menyimpan file gambar ke  disk public di folder destinations (berada di folder projek)*/
        /* method hasFile() tersedia pada objek Request */
        if ($request->hasFile('image')){
            $validated['image'] = $request->file('image')->store('destinations', 'public');
        }

        $categoryIds = $validated['categories'];
        unset($validated['categories']);

        /* menyimpan data yang sudah divalidasi ke dalam tabel */
        $destination = Destination::create($validated);
        $destination->categories()->sync($categoryIds);

        /* kembali ke halaman index dan notifikasi sukses */
        return redirect() 
        ->route('admin.destinations.index') /* ubah rutenya ke halaman tambah destinasi */
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
        $categories = \App\Models\Category::all();

        $openingHours = json_decode($destination->opening_hours, true) ?? [];
        $entranceFee = json_decode($destination->entrance_fee, true) ?? [];
        $averageSpending = json_decode($destination->average_spending, true) ?? [];
        return view('admin.destinations.edit', compact('destination', 'categories', 'openingHours', 'entranceFee','averageSpending'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $destination = Destination::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'opening_hours' => 'nullable|string',
            'entrance_fee' => 'nullable|json',
            'average_spending' => 'nullable|json',
            'google_maps_url' => 'required|url|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|integer|distinct|exists:categories,id',
        ]);

        if ($request->hasFile('image')){
            $newImagePath = $request->file('image')->store('destinations', 'public');
            $oldImagePath = $destination->image;
            $validated['image'] = $newImagePath;
            $destination->update($validated);
            $destination->categories()->sync($request->input('categories'));
            if($oldImagePath){
                Storage::disk('public')->delete($oldImagePath);
            }
        } else {
            $destination->update($validated);
            $destination->categories()->sync($request->input('categories'));
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
}
