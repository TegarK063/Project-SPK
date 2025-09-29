<?php

use App\Http\Controllers\productuser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController;
use App\Http\Controllers\kriteriaController;
use App\Http\Controllers\alternatifController;

Route::get('/', function () {
    return view('LandingPage.landingPage');
});

Route::resource('/Products', productController::class);
Route::resource('/userProduct', productuser::class);
Route::resource('/Kriteria', kriteriaController::class);
Route::resource('/Alternatif', alternatifController::class)->except(['show']);
Route::get('/Alternatif/view', [alternatifController::class, 'view'])->name('Alternatif.view');
// Route::view('/kriteria', 'Admin.Kriteria.view')->name('kriteria');
Route::get('/alternatif/moora', [alternatifController::class, 'moora'])->name('alternatif.moora');
Route::post('/alternatif/moora', [alternatifController::class, 'moora'])->name('alternatif.moora.post');
Route::get('/alternatif/rekomendasi', [alternatifController::class, 'rekomendasi'])->name('alternatif.rekomendasi');
