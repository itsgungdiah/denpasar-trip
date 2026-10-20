<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDestinations = Destination::count();
        $totalCategories = Category::count();

        $latestDestinations = Destination::with('categories')
            ->latest()
            ->take(5)
            ->get();

        $categoryStats = Category::withCount('destinations')
            ->orderBy('name')
            ->get();

        return view('admin.dashboard', compact(
            'totalDestinations',
            'totalCategories',
            'latestDestinations',
            'categoryStats'
        ));
    }
}