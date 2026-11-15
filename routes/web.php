<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnuncioController;
use App\Http\Controllers\AnnuncioImmagineController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;

Route::get('/', [PublicController::class, 'homepage'])->name('welcome');
Route::get('/chi-siamo', [PublicController::class, 'chiSiamo'])->name('chi-siamo');
Route::get('/contatti', [PublicController::class, 'contact'])->name('contact');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('gallery');
Route::view('/privacy-e-cookie', 'privacy')->name('privacy');

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
    Route::patch('annunci/{annuncio}/disponibile', [AnnuncioController::class, 'disponibile'])->name('annunci.disponibile');
    Route::delete('annunci/{annuncio}/definitivo', [AnnuncioController::class, 'forceDestroy'])->withTrashed()->name('annunci.forceDestroy');
    Route::delete('annunci/immagine/{immagine}', [AnnuncioImmagineController::class, 'destroy'])->name('annunci.immagine.destroy');
    Route::patch('annunci/immagine/{immagine}/sposta', [AnnuncioImmagineController::class, 'sposta'])->name('annunci.immagine.sposta');
    Route::patch('annunci/{annuncio}/evidenza', [AnnuncioController::class, 'evidenza'])->name('annunci.evidenza');
});

// PERSONALIZZA HOME — slide della hero e loghi dei brand (solo admin e owner)
Route::middleware(['auth', 'is.owner'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('home', [AdminHomeController::class, 'edit'])->name('home');
    Route::put('home/slide/{slide}', [AdminHomeController::class, 'aggiornaSlide'])->name('slide.update');
    Route::patch('home/slide/{slide}/sposta', [AdminHomeController::class, 'spostaSlide'])->name('slide.sposta');
    Route::post('loghi', [AdminHomeController::class, 'aggiungiLogo'])->name('loghi.store');
    Route::delete('loghi/{logo}', [AdminHomeController::class, 'eliminaLogo'])->name('loghi.destroy');
    Route::patch('loghi/{logo}/sposta', [AdminHomeController::class, 'spostaLogo'])->name('loghi.sposta');
});

// route pubbliche — dopo quelle protette
Route::resource('annunci', AnnuncioController::class)
    ->only(['index', 'show'])
    ->parameters(['annunci' => 'annuncio']);