<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnuncioController;
use App\Http\Controllers\AnnuncioImmagineController;
use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'homepage'])->name('welcome');
Route::get('/chi-siamo', [PublicController::class, 'chiSiamo'])->name('chi-siamo');
Route::get('/contatti', [PublicController::class, 'contact'])->name('contact');

Route::get('/dashboard', [PublicController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ROTTE ANNUNCI

// route protette — solo admin e owner
Route::middleware(['auth', 'is.owner'])->group(function () {
    Route::get('annunci/create', [AnnuncioController::class, 'create'])->name('annunci.create');
    Route::post('annunci', [AnnuncioController::class, 'store'])->name('annunci.store');
    Route::get('annunci/{annuncio}/edit', [AnnuncioController::class, 'edit'])->name('annunci.edit');
    Route::put('annunci/{annuncio}', [AnnuncioController::class, 'update'])->name('annunci.update');
    Route::delete('annunci/{annuncio}', [AnnuncioController::class, 'destroy'])->name('annunci.destroy');
    Route::patch('annunci/{annuncio}/venduto', [AnnuncioController::class, 'venduto'])->name('annunci.venduto');
    Route::delete('annunci/immagine/{immagine}', [AnnuncioImmagineController::class, 'destroy'])->name('annunci.immagine.destroy');
});

// route pubbliche — dopo quelle protette
Route::resource('annunci', AnnuncioController::class)
    ->only(['index', 'show'])
    ->parameters(['annunci' => 'annuncio']);