<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ExploreController;
use App\Http\Controllers\User\DestinationDetailController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TripController;

Route::get('/', function () {
    return redirect()->route('user.dashboard');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/destinations', [DestinationController::class, 'index'])->name('admin.destinations.index');
    Route::get('/admin/destinations/create', [DestinationController::class, 'create'])->name('admin.destinations.create');
    Route::post('/admin/destinations', [DestinationController::class, 'store'])->name('admin.destinations.store');
    Route::get('/admin/destinations/{destination}/edit', [DestinationController::class, 'edit'])->name('admin.destinations.edit');
    Route::put('/admin/destinations/{destination}', [DestinationController::class, 'update'])->name('admin.destinations.update');
    Route::delete('/admin/destinations/{destination}', [DestinationController::class, 'destroy'])->name('admin.destinations.destroy');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});
Route::get('/auth/{provider}/redirect', [AuthController::class, 'redirectToProvider'])
    ->whereIn('provider', ['google', 'apple'])
    ->name('oauth.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleProviderCallback'])
    ->defaults('provider', 'google')
    ->name('oauth.callback.google');
Route::post('/auth/apple/callback', [AuthController::class, 'handleProviderCallback'])
    ->defaults('provider', 'apple')
    ->name('oauth.callback.apple');

Route::get('/user/dashboard', [HomeController::class, 'index'])->name('user.dashboard');
Route::get('/user/explore', [ExploreController::class, 'index'])->name('explore.index');
Route::get('/user/destinations/{destination}/detail', [DestinationDetailController::class, 'show'])
    ->whereNumber('destination')
    ->name('user.destinations.detail');
Route::get('/user/destinations/{destination}/reviews', [DestinationDetailController::class, 'reviews'])
    ->whereNumber('destination')
    ->name('user.destinations.reviews');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/user/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/trip-planner', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trip-planner', [TripController::class, 'store'])->name('trips.store');
    Route::get('/trip-planner/{trip}/edit', [TripController::class, 'edit'])->whereNumber('trip')->name('trips.edit');
    Route::put('/trip-planner/{trip}', [TripController::class, 'update'])->whereNumber('trip')->name('trips.update');
    Route::get('/trip-planner/{trip}/preferences', [TripController::class, 'editPreferences'])->name('trips.preferences.edit');
    Route::put('/trip-planner/{trip}/preferences', [TripController::class, 'updatePreferences'])->name('trips.preferences.update');
    Route::get('/trip-planner/{trip}/discover', [TripController::class, 'discover'])->name('trips.discover');
    Route::post('/trip-planner/{trip}/itineraries', [TripController::class, 'storeItinerary'])->name('trips.itineraries.store');
    Route::put('/trip-planner/{trip}/itineraries/{itinerary}', [TripController::class, 'updateItinerary'])->whereNumber('itinerary')->name('trips.itineraries.update');
    Route::delete('/trip-planner/{trip}/itineraries/{itinerary}', [TripController::class, 'destroyItinerary'])->whereNumber('itinerary')->name('trips.itineraries.destroy');
    Route::put('/trip-planner/{trip}/itineraries/order', [TripController::class, 'reorderItineraries'])->name('trips.itineraries.reorder');

    Route::get('/my-trips', [TripController::class, 'index'])->name('my-trips.index');
    Route::get('/my-trips/{trip}', [TripController::class, 'show'])->whereNumber('trip')->name('my-trips.show');
    Route::delete('/my-trips/{trip}', [TripController::class, 'destroy'])->whereNumber('trip')->name('my-trips.destroy');

    Route::post('/user/destinations/{destination}/reviews', [DestinationDetailController::class, 'storeReview'])
        ->whereNumber('destination')
        ->name('user.destinations.reviews.store');
    Route::put('/user/destinations/{destination}/reviews/{reviewId}', [DestinationDetailController::class, 'updateReview'])
        ->whereNumber('destination')
        ->whereNumber('reviewId')
        ->name('user.destinations.reviews.update');
});


