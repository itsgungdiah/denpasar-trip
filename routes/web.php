<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
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

Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', function () {
        abort_unless(auth()->user()->role === 'user', 403);
        return view('user.dashboard');
    })->name('user.dashboard');
});


