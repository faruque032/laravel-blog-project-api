<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend blog routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [BlogController::class, 'adminList'])->name('list');
        Route::get('/create', [BlogController::class, 'adminCreate'])->name('create');
        Route::get('/{id}/edit', [BlogController::class, 'adminEdit'])->name('edit');
    });
});

// Default route redirect to blog
Route::get('/', function () {
    return redirect()->route('blog.index');
});
