<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private const POPULAR_DESTINATIONS = [
        'Monumen Bajra Sandhi',
        'Pantai Sanur',
        'Pasar Badung',
        'Museum Bali',
    ];

    private const DESTINATION_IMAGES = [
        'Monumen Bajra Sandhi' => 'bajra.jpe',
        'Pantai Sanur' => 'sanur.webp',
        'Pasar Badung' => 'pasar.jpg',
        'Museum Bali' => 'museum.jpg',
    ];

    public function index(Request $request)
    {
        $popularDestinations = Destination::query()
            ->with(['categories' => fn ($query) => $query->whereIn('name', Category::DESTINATION_NAMES)])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->whereIn('name', self::POPULAR_DESTINATIONS)
            ->get()
            ->sortBy(fn (Destination $destination) => array_search(
                $destination->name,
                self::POPULAR_DESTINATIONS,
                true
            ))
            ->values();

        $categoryCards = [
            [
                'name' => 'Nature',
                'image' => 'sanur.webp',
                'description' => 'Pantai, taman, dan mangrove.',
                'icon' => 'leaf',
            ],
            [
                'name' => 'Culture',
                'image' => 'bajra.jpe',
                'description' => 'Pura, situs bersejarah, dan budaya lokal.',
                'icon' => 'landmark',
            ],
            [
                'name' => 'Art',
                'image' => 'museum.jpg',
                'description' => 'Museum, galeri, dan seni budaya.',
                'icon' => 'building',
            ],
            [
                'name' => 'Culinary',
                'image' => 'pasar.jpg',
                'description' => 'Makanan lokal dan kuliner tradisional.',
                'icon' => 'utensils',
            ],
            [
                'name' => 'Shopping',
                'image' => 'living.jpe',
                'description' => 'Pasar tradisional, produk lokal, dan mal.',
                'icon' => 'shopping-bag',
            ],
        ];

        return view('user.dashboard', [
            'popularDestinations' => $popularDestinations,
            'categoryCards' => $categoryCards,
            'destinationImages' => self::DESTINATION_IMAGES,
        ]);
    }
}
