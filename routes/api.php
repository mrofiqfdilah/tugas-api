<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\ArtisController;
use App\Http\Controllers\Api\MusicController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth Endpoint
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/logout', [AuthController::class, 'logout'])->middleware(['check.token']);

// Category Endpoint
Route::get('category/index', [KategoriController::class, 'index'])->middleware(['check.token']);
Route::post('category/store', [KategoriController::class, 'store'])->middleware(['check.token']);

// Artist Endpoint
Route::get('artist/index', [ArtisController::class, 'index'])->middleware(['check.token']);
Route::post('artist/store', [ArtisController::class, 'store'])->middleware(['check.token']);

Route::post('music/{kategoriid}/store/{artisid}', [MusicController::class, 'store'])->middleware(['check.token']);
Route::get('music/index', [MusicController::class, 'index'])->middleware(['check.token']);
