<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\productuser;
use App\Http\Controllers\productController;
use App\Http\Controllers\kriteriaController;
use App\Http\Controllers\alternatifController;

Route::get('/dashboard', function () {
    return view('LandingPage.landingPage');
})->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/Products', productController::class);
    Route::resource('/Kriteria', kriteriaController::class);
    Route::resource('/Alternatif', alternatifController::class)->except(['show']);
    Route::get('/Alternatif/view', [alternatifController::class, 'view'])->name('Alternatif.view');
});

Route::resource('/userProduct', productuser::class);
// Route::view('/kriteria', 'Admin.Kriteria.view')->name('kriteria');
Route::get('/alternatif/moora', [alternatifController::class, 'moora'])->name('alternatif.moora');
Route::post('/alternatif/moora', [alternatifController::class, 'moora'])->name('alternatif.moora.post');
Route::get('/alternatif/rekomendasi', [alternatifController::class, 'rekomendasi'])->name('alternatif.rekomendasi');

require __DIR__ . '/auth.php';
