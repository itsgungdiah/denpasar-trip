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
        $totalCategories = Category::whereIn('name', Category::DESTINATION_NAMES)->count();

        $latestDestinations = Destination::with('categories')
            ->latest()
            ->take(5)
            ->get();

        $categoryStats = Category::withCount('destinations')
            ->whereIn('name', Category::DESTINATION_NAMES)
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
