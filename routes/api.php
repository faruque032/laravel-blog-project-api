<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Blog API routes
Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('blogs', [BlogApiController::class, 'index']);
    Route::get('blogs/{id}', [BlogApiController::class, 'show']);
    
    // Admin routes (you can add authentication middleware later)
    Route::prefix('admin')->group(function () {
        Route::get('blogs', [BlogApiController::class, 'adminIndex']);
        Route::post('blogs', [BlogApiController::class, 'store']);
        Route::put('blogs/{id}', [BlogApiController::class, 'update']);
        Route::delete('blogs/{id}', [BlogApiController::class, 'destroy']);
    });
});
