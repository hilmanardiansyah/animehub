<?php

use App\Http\Controllers\{HomeController,BrowseController,AnimeController,ReviewController,WatchlistController};
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/browse', [BrowseController::class,'index'])->name('browse');
Route::get('/anime/{slug}', [AnimeController::class,'show'])->name('anime.show');

Route::middleware('auth')->group(function () {
    Route::post('/anime/{anime}/review', [ReviewController::class,'store'])->name('review.store');
    Route::post('/anime/{anime}/watchlist', [WatchlistController::class,'toggle'])->name('watchlist.toggle');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';
