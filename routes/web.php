<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PolylinesController;

// =======================
// ✅ LANDING PAGE
// =======================
Route::get('/', [HotelsController::class, 'carouselFoto'])->name('home');

// =======================
// ✅ DASHBOARD (AUTH ONLY)
// =======================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =======================
// ✅ AUTH PAGES (PROFILE, ETC.)
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ MAP DAN TABEL HANYA UNTUK LOGIN
    Route::get('/map', [PointsController::class, 'index'])->name('map');
    Route::get('/table', [TableController::class, 'index'])->name('table');
});

// =======================
// ✅ CRUD DATA SPASIAL
// =======================
Route::resource('points', PointsController::class);
Route::resource('polylines', PolylinesController::class);
Route::resource('polygons', PolygonsController::class);

// =======================
// ✅ FITUR HOTEL (API & INTERAKSI)
// =======================
Route::get('/api/hotels', [HotelsController::class, 'getHotels'])->name('hotels.geojson');
Route::get('/api/hotels/search', [HotelsController::class, 'search'])->name('hotels.search.api');
Route::get('/search', [HotelsController::class, 'search'])->name('hotels.search.web');

Route::post('/hotels/{id}/review-foto', [HotelsController::class, 'reviewFoto']);
Route::post('/api/hotels/{id}/upload-foto', [HotelsController::class, 'uploadFoto']);
Route::delete('/hotels/{id}/review', [HotelsController::class, 'deleteReview']);

// =======================
// ✅ AUTHENTIKASI (LOGIN, REGISTER)
// =======================
require __DIR__.'/auth.php';
