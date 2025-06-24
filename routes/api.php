<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/points', [ApiController::class, 'points'])->name('api.points');
Route::get('/point/{id}', [ApiController::class, 'point'])->name('api.point');
Route::get('/polylines', [ApiController::class, 'polylines'])->name('api.polylines');
Route::get('/polylines/{id}', [ApiController::class, 'polyline'])->name('api.polyline');
Route::get('/polygons', [ApiController::class, 'polygons'])->name('api.polygons');
Route::get('/polygon/{id}', [ApiController::class, 'polygon'])->name('api.polygon');
Route::get('/hotels', [HotelsController::class, 'getHotels'])->name('api.hotels');
Route::get('/hotels/{id}', [HotelsController::class, 'getHotelById'])->name('api.hotels.show');
Route::post('/hotels/{id}/review', [HotelsController::class, 'submitReview']);
Route::put('/hotels/{id}/review/edit', [HotelsController::class, 'editReview']);
Route::delete('/hotels/{id}/review', [HotelsController::class, 'deleteReview']);
Route::post('/hotels/{id}/upload-foto', [HotelsController::class, 'uploadFoto']);
Route::post('/hotels/{id}/review-foto', [HotelsController::class, 'reviewFoto']);

