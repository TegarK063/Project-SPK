<?php

use App\Http\Controllers\kriteriaController;
use App\Http\Controllers\productController;
use App\Http\Controllers\productuser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('LandingPage.landingPage');
});

Route::resource('/Products', productController::class);
Route::resource('/userProduct', productuser::class);
Route::resource('/Kriteria', kriteriaController::class);
// Route::view('/kriteria', 'Admin.Kriteria.view')->name('kriteria');